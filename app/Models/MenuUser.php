<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MenuUser extends Model
{
    use HasFactory;
    protected $table = "menu_user";
    protected $primaryKey = 'id_menu_user';
    
    // public function getWilayah($level = null, $nama = null)
    // {	
    //   $sql = "  ";
    //   $data = DB::select($sql);
    // 	return $data;
    // }
}
