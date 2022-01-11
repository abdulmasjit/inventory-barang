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

    function getReportMutasiStok($tanggal_awal, $tanggal_akhir){
      $q = DB::select("
          SELECT mt.id, mt.nomor_transaksi, mt.tanggal, mt.id_user, mt.keterangan, mt.status, mt.qty, b.nama as nama_barang, s.nama as satuan FROM mutasi_stok mt
          LEFT JOIN barang b ON mt.id_barang = b.id_barang
          LEFT JOIN satuan s ON b.id_satuan = s.id
          WHERE mt.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
          AND mt.status = '1'
          ORDER BY mt.tanggal asc
      ");
      return $q;
    }

    function getListMutasiStok($keyword="", $sortby="", $sorttype=""){
      $q = DB::select("
          SELECT mt.id, mt.nomor_transaksi, mt.tanggal, mt.id_user, mt.keterangan, mt.status, mt.qty, b.nama as nama_barang FROM mutasi_stok mt
          LEFT JOIN barang b ON mt.id_barang = b.id_barang
          WHERE CONCAT(mt.nomor_transaksi, b.nama, mt.tanggal) LIKE '%$keyword%'
          AND mt.status = '1'
          ORDER BY $sortby $sorttype
      ");
      return $q;
    }

    function arrayPaginator($array, $request) {
      $page = (int) $request->get('page', 1);
      $perPage = (int) $request->get('limit');
      $offset = ($page * $perPage) - $perPage;

      return new LengthAwarePaginator(
          array_slice(
              $array,
              $offset,
              $perPage,
              true
          ),
          count($array),
          $perPage,
          $page,
          ['path' => $request->url(), 'query' => $request->query()]
      );
    }
}
