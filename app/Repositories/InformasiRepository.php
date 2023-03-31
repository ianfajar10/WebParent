<?php

namespace App\Repositories;

use App\Repositories\Interface\InformasiRepositoryInterface;
use App\Models\Informations;
use Illuminate\Support\Facades\DB;

class InformasiRepository implements InformasiRepositoryInterface
{
    public function getAllInformasi()
    {
        return DB::table('informations')
            ->select()
            ->orderBy('updated_at', 'desc')
            ->get();
    }
    public function detailInformasi($id)
    {
        return DB::table('informations')
            ->select()
            ->where('id', '=', $id)
            ->get();
    }
}
