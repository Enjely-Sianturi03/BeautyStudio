<?php

namespace App\Http\Controllers;

use App\Models\Tip;
use Illuminate\Http\Request;

class TipController extends Controller
{
    /**
     * Menampilkan daftar Beauty Tips & Videos
     */
    public function index(Request $request)
    {
        // Daftar kategori
        $categories = [
            'all'       => 'Semua',
            'skincare'  => 'Skincare',
            'haircare'  => 'Haircare',
            'makeup'    => 'Makeup',
            'treatment' => 'Body Treatment',
            'video'     => 'Video Tutorial'
        ];

        // Ambil kategori dari request, default 'all'
        $category = $request->get('category', 'all');

        // Query tips berdasarkan kategori
        $tips = Tip::when($category !== 'all', function ($query) use ($category) {
                    $query->where('category', $category);
                })
                ->latest()
                ->paginate(12);

        // Kirim ke view tips.index
        return view('tips.index', compact('tips', 'categories'));
    }

    /**
     * Menampilkan detail tip berdasarkan ID
     */
    public function show($id)
    {
        $tip = Tip::findOrFail($id);

        return view('tips.show', compact('tip'));
    }
}
