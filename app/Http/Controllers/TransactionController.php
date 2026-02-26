<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Midtrans\Config;
use Midtrans\Snap;
use App\Models\User;

class TransactionController extends Controller
{
  private function midtransConfig(): void
  {
    Config::$serverKey = config('services.midtrans.server_key');
    Config::$isProduction = config('services.midtrans.is_production');
    Config::$isSanitized = config('services.midtrans.is_sanitized');
    Config::$is3ds = config('services.midtrans.is_3ds');
  }

  public function index(Request $request)
  {
    $items = Transaction::where('user_id', $request->user()->id)
      ->latest('id')->paginate(12);

    return view('pages.transactions.index', compact('items'));
  }

  public function checkout(Request $request)
  {
    $cart = Cart::with('items.product')
      ->where('user_id', $request->user()->id)
      ->latest('id')->first();

    if (!$cart || $cart->items->count() === 0) {
      return redirect()->route('shop.cart.index')->with('error', 'Keranjang masih kosong.');
    }

    $subtotal = $cart->items->sum(fn($i) => $i->price * $i->qty);

    return view('pages.transactions.checkout', compact('cart', 'subtotal'));
  }

  public function store(Request $request)
  {
    $request->validate([
      'customer_name' => 'required|string|max:255',
      'customer_phone' => 'required|string|max:50',
      'shipping_address' => 'required|string',
      'notes' => 'nullable|string',
    ]);

    $user = $request->user();

    $cart = Cart::with('items.product')
      ->where('user_id', $user->id)
      ->latest('id')->first();

    if (!$cart || $cart->items->count() === 0) {
      return back()->with('error', 'Keranjang kosong.');
    }

    // hitung total + validasi stok
    $subtotal = 0;
    foreach ($cart->items as $item) {
      $p = $item->product;
      if (!$p || $p->stock < $item->qty) {
        return back()->with('error', "Stok tidak cukup untuk produk: {$p->name}");
      }
      $subtotal += ($item->price * $item->qty);
    }

    $shipping = 0;
    $grandTotal = $subtotal + $shipping;

    $orderId = 'TRX-' . now()->format('YmdHis') . '-' . Str::upper(Str::random(6));

    $trx = DB::transaction(function () use ($user, $request, $cart, $subtotal, $shipping, $grandTotal, $orderId) {

      $transaction = Transaction::create([
        'user_id' => $user->id,
        'order_id' => $orderId,
        'subtotal' => $subtotal,
        'shipping_cost' => $shipping,
        'grand_total' => $grandTotal,

        'customer_name' => $request->customer_name,
        'customer_phone' => $request->customer_phone,
        'customer_email' => $user->email,
        'shipping_address' => $request->shipping_address,
        'notes' => $request->notes,
        'status' => 'pending',
        'transaction_status' => 'pending',
      ]);

      foreach ($cart->items as $item) {
        $p = $item->product;

        TransactionItem::create([
          'transaction_id' => $transaction->id,
          'product_id' => $p->id,
          'product_name' => $p->name,
          'size' => $item->size,
          'price' => $item->price,
          'qty' => $item->qty,
          'subtotal' => $item->price * $item->qty,
        ]);
      }

      return $transaction;
    });

    // === Midtrans Snap ===
    $this->midtransConfig();

    $itemDetails = $trx->items->map(function ($i) {
      return [
        'id' => (string) $i->product_id,
        'price' => (int) $i->price,
        'quantity' => (int) $i->qty,
        'name' => Str::limit($i->product_name . ($i->size ? " ({$i->size})" : ''), 50, ''),
      ];
    })->values()->all();

    if ($shipping > 0) {
      $itemDetails[] = [
        'id' => 'SHIP',
        'price' => (int) $shipping,
        'quantity' => 1,
        'name' => 'Shipping',
      ];
    }

    $params = [
      'transaction_details' => [
        'order_id' => $trx->order_id,
        'gross_amount' => (int) $trx->grand_total,
      ],
      'customer_details' => [
        'first_name' => $trx->customer_name,
        'email' => $trx->customer_email,
        'phone' => $trx->customer_phone,
        'shipping_address' => [
          'address' => $trx->shipping_address,
        ],
      ],
      'item_details' => $itemDetails,
      'callbacks' => [
        'finish' => route('transactions.finish'),
      ],
    ];

    $snapToken = Snap::getSnapToken($params);

    $trx->update(['snap_token' => $snapToken]);

    // arahkan ke halaman show yang ada tombol bayar (snap)
    return redirect()->route('transactions.show', $trx->id);
  }

  public function show(Request $request, Transaction $transaction)
  {
    abort_if($transaction->user_id !== $request->user()->id, 403);

    $transaction->load('items');

    return view('pages.transactions.show', compact('transaction'));
  }


public function finish(Request $request)
{
    $orderId = $request->get('order_id');

    if (! $orderId) {
        return redirect()->route('transactions.index')
            ->with('error', 'Order ID tidak ditemukan.');
    }

    $trx = Transaction::with('items')->where('order_id', $orderId)->first();

    if (! $trx) {
        return redirect()->route('transactions.index')
            ->with('error', 'Transaksi tidak ditemukan.');
    }

    // ✅ ambil admin pertama
    $admin = User::where('roles', 'ADMIN')->first();

    // format nomor admin ke format wa (hapus +, spasi, dll)
    $adminPhone = $admin
        ? preg_replace('/[^0-9]/', '', $admin->phone)
        : null;

    return view('pages.transactions.finish', [
        'trx' => $trx,
        'order_id' => $orderId,
        'transaction_status' => $trx->transaction_status,
        'status_code' => $request->get('status_code') ?? '-',
        'status' => $trx->status,
        'grand_total' => $trx->grand_total,
        'payment_type' => $trx->payment_type,
        'adminPhone' => $adminPhone, // kirim ke view
    ]);
}

  public function midtransCallback(Request $request)
  {
    $this->midtransConfig();

    $payload = $request->all();

    // Validasi signature key
    $orderId = $payload['order_id'] ?? null;
    $statusCode = $payload['status_code'] ?? null;
    $grossAmount = $payload['gross_amount'] ?? null;
    $signatureKey = $payload['signature_key'] ?? null;

    if (!$orderId || !$statusCode || !$grossAmount || !$signatureKey) {
      return response()->json(['message' => 'Invalid payload'], 400);
    }

    $serverKey = config('services.midtrans.server_key');
    $expectedSignature = hash('sha512', $orderId.$statusCode.$grossAmount.$serverKey);

    if (!hash_equals($expectedSignature, $signatureKey)) {
      return response()->json(['message' => 'Invalid signature'], 401);
    }

    $trxStatus = $payload['transaction_status'] ?? 'pending';
    $paymentType = $payload['payment_type'] ?? null;
    $fraudStatus = $payload['fraud_status'] ?? null;

    $trx = Transaction::where('order_id', $orderId)->first();
    if (!$trx) return response()->json(['message' => 'Transaction not found'], 404);

    DB::transaction(function () use ($trx, $payload, $trxStatus, $paymentType, $fraudStatus) {
      $update = [
        'transaction_status' => $trxStatus,
        'payment_type' => $paymentType,
        'fraud_status' => $fraudStatus,
        'midtrans_payload' => $payload,
      ];

      // mapping status internal
      if (in_array($trxStatus, ['capture','settlement'])) {
        // paid
        if ($trx->status !== 'paid') {
          // kurangi stok sekali saja
          $trx->load('items.product');
          foreach ($trx->items as $item) {
            $p = $item->product;
            if ($p) {
              $p->decrement('stock', $item->qty);
              if ($p->stock <= 0) {
                $p->update(['is_available' => 0]);
              }
            }
          }
        }

        $update['status'] = 'paid';
        $update['paid_at'] = now();
      } elseif ($trxStatus === 'pending') {
        $update['status'] = 'pending';
      } elseif ($trxStatus === 'expire') {
        $update['status'] = 'expired';
      } elseif (in_array($trxStatus, ['deny','cancel'])) {
        $update['status'] = 'failed';
      }

      $trx->update($update);
    });

    return response()->json(['message' => 'OK']);
  }
}
