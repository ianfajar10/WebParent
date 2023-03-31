<?php

namespace App\Repositories\Interface;

use Illuminate\Http\Request;

interface GuruRepositoryInterface
{
    public function getAllGuru($param);
    public function getGuru($nisn);
}
