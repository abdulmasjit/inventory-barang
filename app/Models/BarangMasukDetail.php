<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BarangMasukDetail extends Model
{
    use HasFactory;
    protected $table = "barang_masuk_detail";
    protected $primaryKey = 'id';
    public $incrementing = false;
}
