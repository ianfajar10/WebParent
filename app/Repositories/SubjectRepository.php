<?php

namespace App\Repositories;

use App\Repositories\Interface\SubjectRepositoryInterface;
use Illuminate\Support\Facades\DB;

class SubjectRepository implements SubjectRepositoryInterface
{
    public function getAllPelajaran()
    {
        return DB::table('subjects')
            ->select()
            ->get();
    }
}
