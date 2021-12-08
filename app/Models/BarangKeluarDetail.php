<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BarangKeluarDetail extends Model
{
    use HasFactory;
    protected $table = "barang_keluar_detail";
    protected $primaryKey = 'id';
    public $incrementing = false;
}
