<?php

use App\Models\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::updateOrCreate(['name' => 'test-admin'], [
            'name' => 'test-admin',
            'email' => 'test-admin@test.com',
            'password' => bcrypt('123456'),
        ]);
    }
}
