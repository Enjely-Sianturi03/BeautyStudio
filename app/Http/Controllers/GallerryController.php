<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    /**
     * Display a listing of gallery images.
     */
    public function index(Request $request)
    {
        $query = Gallery::ordered();

        if ($request->has('category') && $request->category !== 'all') {
            $query->byCategory($request->category);
        }

        $galleries = $query->paginate(12);

        $categories = [
            'all' => 'All',
            'haircut' => 'Haircuts',
            'color' => 'Hair Coloring',
            'styling' => 'Hair Styling',
            'treatment' => 'Treatments',
            'salon' => 'Salon'
        ];

        return view('gallery.index', compact('galleries', 'categories'));
    }
}
