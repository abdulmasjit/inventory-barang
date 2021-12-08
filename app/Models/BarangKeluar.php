<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\LengthAwarePaginator;

class BarangKeluar extends Model
{
    use HasFactory;
    protected $table = "barang_keluar";
    protected $primaryKey = 'id';
    public $incrementing = false;

    function getListBarangKeluar($keyword="", $sortby="", $sorttype=""){
      $q = DB::select("
          SELECT bk.id, bk.nomor_transaksi, bk.tanggal, bk.id_user, bk.keterangan, bk.status FROM barang_keluar bk
          WHERE CONCAT(bk.nomor_transaksi, bk.tanggal) LIKE '%$keyword%'
          AND bk.status = '1'
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
