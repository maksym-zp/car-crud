<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Brand;

class CarModelsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('car_models')->insert([
            ['name' => '3 Series',       'brand_id' => Brand::BMW],
            ['name' => '5 Series',       'brand_id' => Brand::BMW],
            ['name' => '7 Series',       'brand_id' => Brand::BMW],
            ['name' => 'C class',        'brand_id' => Brand::MERCEDES],
            ['name' => 'E class',        'brand_id' => Brand::MERCEDES],
            ['name' => 'S class',        'brand_id' => Brand::MERCEDES],
            ['name' => 'Wrangler',       'brand_id' => Brand::JEEP],
            ['name' => 'Cherokee',       'brand_id' => Brand::JEEP],
            ['name' => 'Grand Cherokee', 'brand_id' => Brand::JEEP]
        ]);
    }
}

