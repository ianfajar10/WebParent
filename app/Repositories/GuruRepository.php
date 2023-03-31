<?php

namespace App\Repositories;

use App\Repositories\Interface\GuruRepositoryInterface;
use Illuminate\Support\Facades\DB;

class GuruRepository implements GuruRepositoryInterface
{
    public function getAllGuru($param)
    {
        if ($param === 'OK') {
            return DB::table('users')
            ->select(DB::raw('nisn, users.name, count(classes.nisn_guru)'))
            ->leftJoin('classes','classes.nisn_guru', '=', 'users.nisn')
            ->where('nisn','LIKE','%GU%')
            ->groupBy(DB::raw('nisn, users.name'))
            ->having(DB::raw('count(nisn_guru)'), '<', 1)
            ->get();
        } else {
            return DB::table('users')->where('nisn','LIKE','%GU%')->get();
        }
    }

    public function getGuru($nisn)
    {
        return DB::table('users')
            ->select()
            ->where('nisn', '=', $nisn)
            ->get();
    }
}
