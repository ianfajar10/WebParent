<?php

namespace App\Repositories\Interface;

use Illuminate\Http\Request;

interface NilaiRepositoryInterface
{
    public function getNilai($nisn,$kelas,$pelajaran,$smester);
    public function getAllNilaiPelajaran($nisn,$kelas,$smester);
}
