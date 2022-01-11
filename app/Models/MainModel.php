<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class MainModel extends Model
{
    use HasFactory;
    function getNomorTransaksi($awal, $clm, $table){
        $tanggal = date('Ymd');
        $tanggal2 = date('Y-m-d');
        $q = DB::select("
            SELECT MAX(RIGHT($clm, 3)) AS idmax FROM $table 
            WHERE CAST(created_at AS DATE) = '$tanggal2'  
        ");
        
        $kd = "";
        $idmax = $q[0]->idmax;
        if($idmax!==null){
          $tmp = ((int)$idmax)+1;
          $kd = sprintf("%03s", $tmp);  
        }else{
          $kd = "001";
        }

        $kodemax = $awal.$tanggal.$kd;
        return $kodemax;
    }

    function generateKode($awal, $clm, $table){
        $q = DB::select("SELECT MAX(RIGHT($clm, 5)) AS idmax FROM $table ");
        $kd = "";
        $idmax = $q[0]->idmax;
        if($idmax!==null){
          $tmp = ((int)$idmax)+1;
          $kd = sprintf("%05s", $tmp);  
        }else{
          $kd = "00001";
        }
        
        $kodemax =  $awal.$kd;
        return $kodemax;
    }
}
