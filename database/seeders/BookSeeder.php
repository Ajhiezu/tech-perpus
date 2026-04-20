<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = \App\Models\Category::all();
        $locations = \App\Models\Location::all();

        \App\Models\Book::factory(30)->create([
            'category_id' => fn() => $categories->random()->id,
            'location_id' => fn() => $locations->random()->id,
        ]);
    }
}
