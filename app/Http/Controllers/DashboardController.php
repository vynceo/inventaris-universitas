<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Kategori;
use App\Models\Transaksi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $totalBarang = Barang::count();
        $totalKategori = Kategori::count();
        $barangDipinjam = Transaksi::where('status', 'dipinjam')->count();
        $barangTersedia = Barang::sum('jumlah');
        $totalUser = User::count();

        $queryTransaksi = Transaksi::with(['user', 'barang']);
        if (Auth::check() && Auth::user()->role === 'staff') {
            $queryTransaksi->where('user_id', Auth::id());
        }
        $transaksiTerbaru = $queryTransaksi->latest()->take(5)->get();

        $barangStokMenipis = Barang::where('jumlah', '<', 5)->with('kategori')->take(5)->get();

        return view('dashboard', compact(
            'totalBarang',
            'totalKategori',
            'barangDipinjam',
            'barangTersedia',
            'totalUser',
            'transaksiTerbaru',
            'barangStokMenipis'
        ));
    }
}
