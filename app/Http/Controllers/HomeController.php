<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Gallery;
use App\Models\Stylist;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Display the home page.
     */
    public function index()
    {
        $featuredGalleries = Gallery::featured()
            ->ordered()
            ->take(3)
            ->get();
        
        $services = Service::active()
            ->orderBy('category')
            ->take(6)
            ->get();
        
        $stylists = Stylist::active()
            ->take(4)
            ->get();

        return view('home', compact('featuredGalleries', 'services', 'stylists'));
    }
}