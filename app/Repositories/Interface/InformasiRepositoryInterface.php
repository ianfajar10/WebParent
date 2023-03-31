<?php

namespace App\Repositories\Interface;

use Illuminate\Http\Request;

interface InformasiRepositoryInterface
{
    public function getAllInformasi();
    public function detailInformasi($id);
}
