<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class adminEditCategoriesController extends Controller
{
    //
    public function index()
    {
        return view('admin.categories.edit');
    }
}
