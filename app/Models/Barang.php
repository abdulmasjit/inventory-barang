<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Barang extends Model
{
    use HasFactory;
    protected $table = "barang";
    protected $primaryKey = 'id_barang';

    function getReportStokAllBarang($tanggal_awal, $tanggal_akhir)
    {
      $q = "
          SELECT b.id_barang, b.kode AS kode_barang, b.nama AS nama_barang, s.nama AS satuan, coalesce(b.stok_minimum, 0) AS stok_minimum,
          COALESCE(bht.stok_awal, 0) AS stok_awal, COALESCE(bht.masuk, 0) AS masuk, COALESCE(bht.keluar, 0) AS keluar, 
          COALESCE(bht.rusak_hilang, 0) AS rusak_hilang, COALESCE(bht.stok_akhir, 0) AS stok_akhir
          FROM barang b
          LEFT JOIN satuan s ON b.id_satuan = s.id
          LEFT JOIN (
            SELECT bhs.*, (stok_awal+masuk+keluar+rusak_hilang) AS stok_akhir FROM (
              SELECT bhs.id_barang, 
              COALESCE((
                SELECT sum(qty) AS stok_awal FROM barang_history
                WHERE id_barang = bhs.id_barang
                AND sumber IN ('TBM', 'MS')
                AND tanggal < '$tanggal_awal'
              ), 0) AS stok_awal,
              SUM(CASE WHEN bhs.qty > 0 then bhs.qty ELSE 0 END) AS masuk,
              SUM(CASE WHEN bhs.qty < 0 AND bhs.sumber NOT IN ('MBH', 'MBR') then bhs.qty ELSE 0 END) AS keluar,
              SUM(CASE WHEN bhs.sumber IN ('MBH', 'MBR') then bhs.qty ELSE 0 END) AS rusak_hilang
              FROM barang_history bhs	  
              WHERE bhs.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
              GROUP BY bhs.id_barang
            ) bhs
          ) bht ON bht.id_barang = b.id_barang
          ORDER BY b.nama ASC
      ";

      $result = DB::select($q);
      return $result;
    }

    function getReportStokPerbarang($tanggal_awal, $tanggal_akhir, $id_barang="")
    {
      $q = "
          SELECT bht.id, bht.tanggal, bht.keterangan, bht.sumber, bht.qty, bht.id_transaksi, bht.id_barang FROM barang_history bht
          WHERE bht.id_barang = '$id_barang'
          AND bht.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
          ORDER BY bht.tanggal asc
      ";

      $result = DB::select($q);
      return $result;
    }
}
