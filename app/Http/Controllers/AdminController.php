<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
{
    // Menampilkan halaman dashboard admin
    return view('admin.dashboard');
}
}
