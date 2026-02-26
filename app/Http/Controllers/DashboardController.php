<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // ====== PRODUK ======
        $totalProduk = Product::count();

        // stok menipis & habis (samakan nama kolom stok kamu: stock / stok)
        $stokMenipis = Product::where('stock', '>', 0)
            ->where('stock', '<=', 5)
            ->latest('id')
            ->take(6)
            ->get();

        $stokHabis = Product::where('stock', 0)
            ->latest('id')
            ->take(6)
            ->get();

        // ====== TRANSAKSI ======
        // definisi "pesanan masuk": semua transaksi yang ada
        $totalPesanan = Transaction::count();

        // total penjualan: jumlah grand_total yang sudah "dibayar"
        // (sesuaikan kolom status kamu: status / transaction_status)
        $totalPenjualan = Transaction::where(function ($q) {
                $q->where('status', 'paid')
                  ->orWhere('transaction_status', 'settlement')
                  ->orWhere('transaction_status', 'capture');
            })
            ->sum('grand_total');

        // pesanan terbaru untuk tabel
        $pesananTerbaru = Transaction::with('user')
            ->latest('id')
            ->take(8)
            ->get();

        // ====== PELANGGAN ======
        // kalau kamu punya role, filter "customer" aja.
        // kalau tidak, minimal: user yang pernah transaksi
        $totalPelanggan = Transaction::distinct('user_id')->count('user_id');

        return view('pages.dashboard', compact(
            'totalProduk',
            'totalPesanan',
            'totalPelanggan',
            'totalPenjualan',
            'pesananTerbaru',
            'stokMenipis',
            'stokHabis'
        ));
    }
}
