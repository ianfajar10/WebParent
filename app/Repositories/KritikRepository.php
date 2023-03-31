<?php

namespace App\Repositories;

use App\Repositories\Interface\KritikRepositoryInterface;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\DB;

class KritikRepository implements KritikRepositoryInterface
{
    public function getAllKritik($nisn)
    {
        if ($nisn) {
            return DB::table('critics')
            ->select(DB::raw('critics.kategori, users.name as name, critics.text, critics.text_answer, critics.created_at'))
            ->leftJoin('users', 'users.nisn', '=', 'critics.nisn')
            ->where('users.nisn', '=', $nisn)
            ->orderBy('critics.created_at', 'desc')
            ->get();
        } else {
            return DB::table('critics')
            ->select(DB::raw('critics.id, critics.kategori, users.name as name, users.parent_number, critics.text, critics.text_answer, critics.created_at'))
            ->leftJoin('users', 'users.nisn', '=', 'critics.nisn')
            ->orderBy('critics.created_at', 'desc')
            ->get();
        }
    }

    public function getCountKritik()
    {
        return DB::table('critics')
            ->select(DB::raw('kategori, count("kategori") as count_kritik'))
            ->where(DB::raw('TIMESTAMPDIFF(MONTH, created_at, SYSDATE())'), '<', '1')
            ->groupBy('kategori')
            ->get()
            ->toArray();
    }

    public function getCountKritikTotal()
    {
        return DB::table('critics')
            ->select(DB::raw('count("kategori") as count_kritik'))
            ->get();
    }
}
