<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\LengthAwarePaginator;

class BarangMasuk extends Model
{
    use HasFactory;
    protected $table = "barang_masuk";
    protected $primaryKey = 'id';
    public $incrementing = false;

    function getListBarangMasuk($keyword="", $sortby="", $sorttype=""){
      $q = DB::select("
          SELECT bm.id, bm.nomor_transaksi, bm.tanggal, bm.id_supplier, bm.id_user, bm.keterangan, bm.status, s.nama AS nama_supplier FROM barang_masuk bm
          LEFT JOIN supplier s ON bm.id_supplier = s.id
          WHERE CONCAT(bm.nomor_transaksi, bm.tanggal, bm.keterangan, S.nama) LIKE '%$keyword%'
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
