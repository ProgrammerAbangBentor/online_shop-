<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $start = $request->start_date ?? now()->startOfMonth()->format('Y-m-d');
        $end   = $request->end_date ?? now()->format('Y-m-d');

        // base query (cloneable)
        $base = Transaction::query()
            ->whereBetween('created_at', [
                $start . ' 00:00:00',
                $end . ' 23:59:59'
            ]);

        // data tabel (paginate)
        $transactions = (clone $base)->latest()->paginate(10)->withQueryString();

        // ✅ hitung ringkasan
        $totalPesanan = (clone $base)->count();

        // ✅ pendapatan hanya yang sukses bayar (midtrans settlement / capture)
        $totalPendapatan = (clone $base)
            ->whereIn('transaction_status', ['settlement', 'capture'])
            ->sum('grand_total');

        // ✅ total produk terjual dari items (lebih akurat dari qty item)
        $produkTerjual = \App\Models\TransactionItem::query()
            ->whereHas('transaction', function ($q) use ($start, $end) {
                $q->whereBetween('created_at', [
                    $start . ' 00:00:00',
                    $end . ' 23:59:59'
                ])->whereIn('transaction_status', ['settlement', 'capture']);
            })
            ->sum('qty');

        // ✅ jumlah pelanggan unik (user_id)
        $jumlahPelanggan = (clone $base)
            ->whereNotNull('user_id')
            ->distinct('user_id')
            ->count('user_id');

        return view('pages.laporan.index', compact(
            'transactions',
            'start',
            'end',
            'totalPesanan',
            'totalPendapatan',
            'produkTerjual',
            'jumlahPelanggan'
        ));
    }
}
