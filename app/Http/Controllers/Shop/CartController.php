<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cart = Cart::firstOrCreate(
            ['user_id' => auth()->id(), 'status' => 'ACTIVE'],
            ['user_id' => auth()->id(), 'status' => 'ACTIVE']
        );

        $cart->load(['items.product.category']);

        $subtotal = $cart->items->sum(fn($i) => $i->price * $i->qty);

        return view('pages.shop.cart.index', compact('cart', 'subtotal'));
    }

    // tombol dari product show -> masuk cart lalu redirect ke cart
    public function add(Request $request, $productId)
    {
        $request->validate([
            'qty' => 'nullable|integer|min:1',
        ]);

        $qty = (int) ($request->qty ?? 1);

        $product = Product::findOrFail($productId);

        if ((int)$product->stock <= 0) {
            return back()->with('error', 'Stok produk habis.');
        }

        $cart = Cart::firstOrCreate(
            ['user_id' => auth()->id(), 'status' => 'ACTIVE'],
            ['user_id' => auth()->id(), 'status' => 'ACTIVE']
        );

        $item = CartItem::where('cart_id', $cart->id)
            ->where('product_id', $product->id)
            ->first();

        // batas qty biar tidak melebihi stok
        $newQty = $qty + ($item?->qty ?? 0);
        if ($newQty > (int)$product->stock) {
            $newQty = (int)$product->stock;
        }

        if ($item) {
            $item->update([
                'qty' => $newQty,
                'price' => $product->price,
                'size' => $product->size,
            ]);
        } else {
            CartItem::create([
                'cart_id' => $cart->id,
                'product_id' => $product->id,
                'qty' => $newQty,
                'price' => $product->price,
                'size' => $product->size,
            ]);
        }

        return redirect()->route('shop.cart.index')->with('success', 'Produk ditambahkan ke keranjang.');
    }

    public function updateQty(Request $request, $itemId)
    {
        $request->validate([
            'qty' => 'required|integer|min:1',
        ]);

        $item = CartItem::with('product', 'cart')
            ->findOrFail($itemId);

        // pastikan item ini milik user yg login
        abort_if($item->cart->user_id !== auth()->id(), 403);

        $qty = (int) $request->qty;
        if ($qty > (int)$item->product->stock) {
            $qty = (int)$item->product->stock;
        }

        $item->update(['qty' => $qty]);

        return back()->with('success', 'Qty diperbarui.');
    }

    public function remove($itemId)
    {
        $item = CartItem::with('cart')->findOrFail($itemId);
        abort_if($item->cart->user_id !== auth()->id(), 403);

        $item->delete();

        return back()->with('success', 'Item dihapus dari keranjang.');
    }
}
