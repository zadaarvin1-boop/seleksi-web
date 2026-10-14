<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Transaksi;

class DashboardController extends Controller
{
    public function index()
    {
        $jumlahBarang = Barang::count();
        $jumlahTransaksi = Transaksi::count();
        $totalPendapatan = Transaksi::sum('total');
        $stokMenipis = Barang::where('stok', '<=', 5)->get();

        return view('dashboard', compact('jumlahBarang', 'jumlahTransaksi', 'totalPendapatan', 'stokMenipis'));
    }
}
