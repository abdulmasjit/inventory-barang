<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Dashboard extends Model
{
    use HasFactory;

    function getDashboardTahunan($tahun){
      $q = DB::select("
            SELECT 
              x.jenis,
              sum(case when EXTRACT(MONTH FROM x.tanggal) = '1' then x.jumlah else 0 end) as jan,
              sum(case when EXTRACT(MONTH FROM x.tanggal) = '2' then x.jumlah else 0 end) as feb,
              sum(case when EXTRACT(MONTH FROM x.tanggal) = '3' then x.jumlah else 0 end) as mar,
              sum(case when EXTRACT(MONTH FROM x.tanggal) = '4' then x.jumlah else 0 end) as apr,
              sum(case when EXTRACT(MONTH FROM x.tanggal) = '5' then x.jumlah else 0 end) as may,
              sum(case when EXTRACT(MONTH FROM x.tanggal) = '6' then x.jumlah else 0 end) as jun,
              sum(case when EXTRACT(MONTH FROM x.tanggal) = '7' then x.jumlah else 0 end) as jul,
              sum(case when EXTRACT(MONTH FROM x.tanggal) = '8' then x.jumlah else 0 end) as aug,
              sum(case when EXTRACT(MONTH FROM x.tanggal) = '9' then x.jumlah else 0 end) as sep,
              sum(case when EXTRACT(MONTH FROM x.tanggal) = '10' then x.jumlah else 0 end) as oct,
              sum(case when EXTRACT(MONTH FROM x.tanggal) = '11' then x.jumlah else 0 end) as nov,
              sum(case when EXTRACT(MONTH FROM x.tanggal) = '12' then x.jumlah else 0 end) as des
            FROM ( 
            SELECT 'Barang Masuk' AS jenis, bm.tanggal, sum(bmd.jumlah) AS jumlah FROM barang_masuk bm
            LEFT JOIN barang_masuk_detail bmd ON bm.id = bmd.id_barang_masuk
            where 
                EXTRACT(YEAR FROM bm.tanggal) = '$tahun'
                AND bm.status = '1'
            GROUP BY bm.tanggal
            UNION ALL
            SELECT 'Barang Keluar' AS jenis, bm.tanggal, sum(bmd.jumlah) AS jumlah FROM barang_keluar bm
            LEFT JOIN barang_keluar_detail bmd ON bm.id = bmd.id_barang_keluar
            where 
                EXTRACT(YEAR FROM bm.tanggal) = '$tahun'
                AND bm.status = '1'
            GROUP BY bm.tanggal
          )x
          GROUP BY x.jenis
      ");
      return $q;
    }
}
