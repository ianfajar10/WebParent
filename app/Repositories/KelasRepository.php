<?php

namespace App\Repositories;

use App\Repositories\Interface\KelasRepositoryInterface;
use App\Models\Classes;
use Illuminate\Support\Facades\DB;

class KelasRepository implements KelasRepositoryInterface
{
    public function getAllKelas()
    {
        return DB::table('classes')
            ->select('classes.id', 'classes.name', DB::raw('users.name as guru'), 'users.nisn')
            ->leftJoin('users', 'users.nisn', '=', 'classes.nisn_guru')
            ->orderBy('classes.id')
            ->get();
    }

    public function getCheckKelas($nisn)
    {
        return DB::table('classes')
            ->select('id')
            ->where('nisn_guru', '=', $nisn)
            ->get();
    }

    public function getCheckKelasSiswa($nisn)
    {
        return DB::table('users')
            ->select('id_class')
            ->where('nisn', '=', $nisn)
            ->get();
    }

    public function getNilaiKelas($nisn)
    {
        return DB::table('nilais')
            ->select(DB::raw('distinct(id_class) as id'))
            ->where('nisn', '=', $nisn)
            ->get();
    }

    public function getNilaiSmester($nisn)
    {
        return DB::table('nilais')
            ->select(DB::raw('distinct(semester) as id'))
            ->where('nisn', '=', $nisn)
            ->get();
    }

    public function getCheckWaliKelasSiswa($kelas)
    {
        return DB::table('classes')
            ->select('users.name')
            ->leftJoin('users', 'users.nisn', '=', 'classes.nisn_guru')
            ->where('classes.id', '=', $kelas)
            ->get();
    }

}
