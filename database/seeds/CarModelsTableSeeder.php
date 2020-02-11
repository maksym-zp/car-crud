<?php

use App\Models\CarModel;
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
            ['id' => CarModel::SERIES_3, 'name' => '3 Series',            'brand_id' => Brand::BMW],
            ['id' => CarModel::SERIES_5, 'name' => '5 Series',            'brand_id' => Brand::BMW],
            ['id' => CarModel::SERIES_7, 'name' => '7 Series',            'brand_id' => Brand::BMW],
            ['id' => CarModel::CCLASS, 'name' => 'C class',               'brand_id' => Brand::MERCEDES],
            ['id' => CarModel::ECLASS, 'name' => 'E class',               'brand_id' => Brand::MERCEDES],
            ['id' => CarModel::SCLASS, 'name' => 'S class',               'brand_id' => Brand::MERCEDES],
            ['id' => CarModel::WRANGLER, 'name' => 'Wrangler',            'brand_id' => Brand::JEEP],
            ['id' => CarModel::CHEROKEE, 'name' => 'Cherokee',            'brand_id' => Brand::JEEP],
            ['id' => CarModel::GRANDCHEROKEE, 'name' => 'Grand Cherokee', 'brand_id' => Brand::JEEP]
        ]);
    }
}

