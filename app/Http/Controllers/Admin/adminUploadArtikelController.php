<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class adminUploadArtikelController extends Controller
{
    //
    public function index()
    {
        return view('admin.artikel.upload');
    }
}
