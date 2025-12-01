<?php

namespace App\Http\Controllers;

use App\Models\Tip;
use Illuminate\Http\Request;

class TipController extends Controller
{
    public function index(Request $request)
    {
        // Mapping slug URL ke nama kategori di database
        $categoryMap = [
            'skincare'  => 'Kesehatan Kulit',
            'haircare'  => 'Perawatan Rambut',
            'makeup'    => 'Makeup',
            'treatment' => 'Body Treatment',
            'all'       => 'all'
        ];

        // Ambil kategori dari request
        $categorySlug = $request->get('category', 'all');
        $categoryName = $categoryMap[$categorySlug] ?? null;

        // Query tips (article & video)
        $tips = Tip::query()
                    ->when($categoryName && $categoryName !== 'all', function($query) use ($categoryName) {
                        $query->where('category', $categoryName);
                    })
                    ->latest()
                    ->paginate(12)
                    ->withQueryString();

        return view('tips.index', [
            'tips' => $tips,
            'currentCategory' => $categorySlug
        ]);
    }
}
