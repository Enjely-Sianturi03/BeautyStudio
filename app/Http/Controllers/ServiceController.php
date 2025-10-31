<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    /**
     * Display a listing of services.
     */
    public function index()
    {
        $services = Service::active()
            ->orderBy('category')
            ->orderBy('name')
            ->get()
            ->groupBy('category');

        $categories = [
            'haircut' => 'Haircuts',
            'color' => 'Hair Coloring',
            'treatment' => 'Hair Treatments',
            'styling' => 'Hair Styling',
            'other' => 'Other Services'
        ];

        return view('services.index', compact('services', 'categories'));
    }

    /**
     * Display the specified service.
     */
    public function show(Service $service)
    {
        if (!$service->is_active) {
            abort(404);
        }

        $relatedServices = Service::active()
            ->where('category', $service->category)
            ->where('id', '!=', $service->id)
            ->take(3)
            ->get();

        return view('services.show', compact('service', 'relatedServices'));
    }
}
