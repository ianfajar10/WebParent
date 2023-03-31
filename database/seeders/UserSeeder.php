<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'nisn' => 'admin',
            'name' => 'admin',
            'password' => '$2y$10$RarF4KU8uHpbiMAezr.qvuzHcp35QJgQfLPqSIcOfBMifTmzIgL5C',
        ]);
    }
}
