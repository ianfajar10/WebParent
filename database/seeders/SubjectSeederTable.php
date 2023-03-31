<?php

namespace Database\Seeders;

use App\Models\Subjects;
use Illuminate\Database\Seeder;

class SubjectSeederTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $subject = new Subjects();
        $data = [
            [
                'id' => 'MP01',
                'name' => 'Pendidikan Agama',
            ],
            [
                'id' => 'MP02',
                'name' => 'Pendidikan Kewarganegaraan',
            ],
            [
                'id' => 'MP03',
                'name' => 'Bahasa Indonesia',
            ],
            [
                'id' => 'MP04',
                'name' => 'Matematika',
            ],
            [
                'id' => 'MP05',
                'name' => 'Bahasa Inggris',
            ],
            [
                'id' => 'MP06',
                'name' => 'Seni dan Prakarya',
            ],
            [
                'id' => 'MP07',
                'name' => 'Pendidikan Jasmani',
            ],
        ];
        for ($i=0; $i < 7; $i++) {
            $subject->create('subjects', $data[$i]);
        }
    }
}
