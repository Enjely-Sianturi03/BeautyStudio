<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Stylist;

class StylistSeeder extends Seeder
{
    public function run(): void
    {
        Stylist::create([
            'name' => 'Lisa',
            'experience_years' => 5,
            'is_active' => true,
        ]);

        Stylist::create([
            'name' => 'Nana',
            'experience_years' => 3,
            'is_active' => true,
        ]);

        Stylist::create([
            'name' => 'Sinta',
            'experience_years' => 4,
            'is_active' => true,
        ]);
    }
}
