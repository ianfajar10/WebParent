<?php

namespace Database\Seeders;

use App\Models\Classes;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ClassSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $subject = new Classes();
        $data = [
            [
                'id' => '10A',
                'name' => '10 A',
                'nisn_guru' => '',
            ],
            [
                'id' => '10B',
                'name' => '10 B',
                'nisn_guru' => '',
            ],
            [
                'id' => '11A',
                'name' => '11 A',
                'nisn_guru' => '',
            ],
            [
                'id' => '11B',
                'name' => '11 B',
                'nisn_guru' => '',
            ],
            [
                'id' => '12A',
                'name' => '12 A',
                'nisn_guru' => '',
            ],
            [
                'id' => '12B',
                'name' => '12 B',
                'nisn_guru' => '',
            ],
        ];
        for ($i=0; $i < 6; $i++) {
            $subject->create('classes', $data[$i]);
        }
    }
}
