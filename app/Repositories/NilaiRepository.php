<?php

namespace App\Repositories;

use App\Repositories\Interface\NilaiRepositoryInterface;
use Illuminate\Support\Facades\DB;

class NilaiRepository implements NilaiRepositoryInterface
{
    public function getNilai($nisn,$kelas,$pelajaran,$smester)
    {
        return DB::table('nilais')
            ->select()
            ->where('nisn', '=', $nisn)
            ->where('id_class', '=', $kelas)
            ->where('id_subject', '=', $pelajaran)
            ->where('semester', '=', $smester)
            ->get();
    }

    public function getAllNilaiPelajaran($nisn,$kelas,$smester)
    {
        return DB::table('subjects')
            ->select(DB::raw('subjects.name, nilais.tugas, nilais.uts, nilais.uas'))
            ->leftJoin('nilais', 'nilais.id_subject', '=', 'subjects.id')
            ->leftJoin('users', 'users.nisn', '=', DB::raw('nilais.nisn AND nilais.nisn = ' . $nisn . ''))
            ->where('users.nisn', '=', $nisn)
            ->get();
    }
}
