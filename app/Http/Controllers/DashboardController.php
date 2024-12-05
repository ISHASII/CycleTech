<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Artikel;

class DashboardController extends Controller
{
    /**
     * Menampilkan halaman dashboard dengan daftar artikel.
     */
    public function index()
    {
        // Ambil 6 artikel terbaru
        $articles = Artikel::latest()->take(6)->get();

        // Kirim data artikel ke view
        return view('Dashboard.dashboard', compact('articles'));
    }

    /**
     * Menampilkan halaman detail artikel.
     */
    public function showArticleDetail($id)
    {
        // Ambil artikel berdasarkan ID
        $article = Artikel::findOrFail($id);

        // Kirim data artikel ke view
        return view('Dashboard.detailartikel', compact('article'));
    }
}