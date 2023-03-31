<?php

namespace App\Repositories\Interface;

use Illuminate\Http\Request;

interface SiswaRepositoryInterface
{
    public function getAllKelas($nisn);
    public function getAllSiswa($param);
    public function getAllSiswaPerClass($nisn);
    public function getSiswa($nisn);
    public function getCountSiswa();
}
