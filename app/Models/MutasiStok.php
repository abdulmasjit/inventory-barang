<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\LengthAwarePaginator;

class MutasiStok extends Model
{
    use HasFactory;
    protected $table = "mutasi_stok";
    protected $primaryKey = 'id';
    public $incrementing = false;
}
