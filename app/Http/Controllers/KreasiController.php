<?php

namespace App\Http\Controllers;

use App\Models\Kreasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KreasiController extends Controller
{
    // Menampilkan semua data kreasi (umum)
    public function index()
    {
        // Ambil semua kreasi, diurutkan berdasarkan tanggal dibuat
        $kreasis = Kreasi::orderBy('created_at', 'desc')->get();

        return view('Kreasi.kreasi', compact('kreasis'));
    }

    // Menampilkan semua kreasi pengguna yang sedang login

    // Menampilkan detail satu kreasi berdasarkan ID
    public function show($id)
    {
        // Ambil kreasi berdasarkan ID
        $kreasi = Kreasi::find($id);

        // Jika data tidak ditemukan
        if (!$kreasi) {
            return redirect()->route('kreasi')->with('error', 'Kreasi tidak ditemukan.');
        }

        // Ambil kreasi serupa berdasarkan kategori
        $kreasiSerupa = Kreasi::where('kategori_kreasi', $kreasi->kategori_kreasi)
            ->where('id', '!=', $kreasi->id)
            ->take(4)
            ->get();

        // Kirim data ke view
        return view('Kreasi.artikelkreasi', compact('kreasi', 'kreasiSerupa'));
    }

}