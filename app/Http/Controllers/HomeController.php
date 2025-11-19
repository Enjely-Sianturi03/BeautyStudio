<?php

namespace App\Http\Controllers;

use App\Models\Layanan;
use App\Models\Service;
use App\Models\Tip;
use App\Models\Stylist;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;


class HomeController extends Controller
{
    /**
     * Display the home page.
     */
    public function index()
    {
        // Ambil 3 tips terbaru sebagai featured
        $featuredTips = Tip::latest()->take(3)->get();
        
        // Ambil 6 layanan aktif
        $services = Service::active()
            ->orderBy('created_at', 'desc') 
            ->take(6)
            ->get();
        
        // Ambil 4 stylist aktif
        $stylists = Stylist::active()
            ->take(4)
            ->get();

        // Ambil 6 ulasan yang sudah disetujui admin
        // $reviews = Review::where('is_approved', true)
        //     ->latest()
        //     ->take(6)
        //     ->get();
        if (Schema::hasColumn('reviews', 'is_approved')) {
        $reviews = Review::where('is_approved', true)
        ->latest()
        ->take(6)
        ->get();
        } else {
        $reviews = Review::latest()
        ->take(6)
        ->get();
}


        // Return hanya sekali saja, lengkap
        return view('home', compact('featuredTips', 'services', 'stylists', 'reviews'));
    }
}
