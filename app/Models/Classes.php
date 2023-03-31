<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Classes extends Model
{
    use HasFactory;
    public function create($table, $data)
    {
        DB::table($table)->insert([
            $data
        ]);
    }
}
