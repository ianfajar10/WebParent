<?php

namespace App\Repositories\Interface;

use Illuminate\Http\Request;

interface KelasRepositoryInterface
{
    public function getAllKelas();
    public function getCheckKelas($nisn);
    public function getCheckKelasSiswa($nisn);
    public function getNilaiKelas($nisn);
    public function getNilaiSmester($nisn);
    public function getCheckWaliKelasSiswa($kelas);
}
