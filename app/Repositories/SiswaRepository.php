<?php

namespace App\Repositories;

use App\Repositories\Interface\SiswaRepositoryInterface;
use App\Models\User;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\DB;

class SiswaRepository implements SiswaRepositoryInterface
{
    public function getAllSiswa($param)
    {
        if ($param === "OK") {
            return DB::table('users')
            ->where('nisn','NOT LIKE','%GU%')
            ->where('nisn', '!=', 'admin')
            ->whereNull('id_class')
            ->get();
        } else {
            return DB::table('users')
            ->where('nisn','NOT LIKE','%GU%')
            ->where('nisn', '!=', 'admin')
            ->get();
        }
    }

    public function getAllSiswaPerClass($nisn)
    {
        return DB::table('users')
            ->select(DB::raw('users.nisn, users.name, users.gender, users.telp'))
            ->leftJoin('classes', 'classes.id', '=', 'users.id_class')
            ->where('classes.nisn_guru', '=', $nisn)
            ->get();
    }

    public function getSiswa($nisn)
    {
        return DB::table('users')
            ->select()
            ->where('nisn', '=', $nisn)
            ->get();
    }

    public function getCountSiswa()
    {
        return DB::table('users')
            ->select(DB::raw('count("nisn") as count_siswa'))
            ->where('nisn', '!=', 'admin')
            ->where('nisn','NOT LIKE','%GU%')
            ->get();
    }

    public function getAllKelas($nisn)
    {
        return DB::table('classes')
            ->select(DB::raw('classes.id, classes.name'))
            ->leftJoin('nilais','nilais.id_class', '=', 'classes.id')
            ->where('nisn', '=', $nisn)
            ->groupBy(DB::raw('classes.id, classes.name'))
            ->get();
    }

}
