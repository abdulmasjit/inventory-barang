<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class BarangHistory extends Model
{
    use HasFactory;
    protected $table = "barang_history";
    protected $primaryKey = 'id';
    public $incrementing = false;
}
