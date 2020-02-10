<?php

use App\Models\Brand;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BrandsTableSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('brands')->insert([
          ['id' => Brand::BMW, 'name' => 'BMW'],
          ['id' => Brand::MERCEDES, 'name' => 'Mercedes'],
          ['id' => Brand::JEEP, 'name' => 'Jeep']
        ]);
    }
}
