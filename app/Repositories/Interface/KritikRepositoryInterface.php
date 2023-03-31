<?php

namespace App\Repositories\Interface;

use Illuminate\Http\Request;

interface KritikRepositoryInterface
{
    public function getAllKritik($nisn);
    public function getCountKritik();
    public function getCountKritikTotal();
}
