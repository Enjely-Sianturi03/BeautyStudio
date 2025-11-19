<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Service;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        Service::create([
            'name' => 'Eyelash Extension',
            'description' => 'Natural and volume styles',
            'price' => 150000,
            'duration' => 60,
            'category' => 'Eyelash',
            'is_active' => true
        ]);

        Service::create([
            'name' => 'Hair Treatment',
            'description' => 'Repair and shine spa',
            'price' => 200000,
            'duration' => 90,
            'category' => 'Hair',
            'is_active' => true
        ]);

        Service::create([
            'name' => 'Nail Art',
            'description' => 'Creative nail polish design',
            'price' => 120000,
            'duration' => 45,
            'category' => 'Nail',
            'is_active' => true
        ]);
    }
}
