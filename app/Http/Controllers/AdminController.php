<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        // Menampilkan halaman admin utama
        return view('admin.admin'); // pastikan file ini ada di resources/views/admin/admin.blade.php
    }
}
