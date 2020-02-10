<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ColorsTableSeeder extends Seeder
{
    private $colors = [
        ['name' => 'white'],
        ['name' => 'silver'],
        ['name' => 'black'],
        ['name' => 'other'],
        ];
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('colors')->insert($this->colors);
    }
}
