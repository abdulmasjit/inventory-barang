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
          WHERE CONCAT(bm.nomor_transaksi, bm.tanggal, s.nama) LIKE '%$keyword%'
          AND bm.status = '1'
          ORDER BY $sortby $sorttype
      ");
      return $q;
    }

    function getListDetailBarang($id){
      $q = DB::table('barang_masuk_detail as bmd')
          ->select('bmd.*', 'b.kode as kode_barang', 'b.nama as nama_barang', 's.nama as nama_satuan')
          ->leftJoin('barang as b', 'bmd.id_barang', '=', 'b.id_barang')
          ->leftJoin('satuan as s', 'b.id_satuan', '=', 's.id')
          ->where('bmd.id_barang_masuk', $id)->get();
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

    function getReportBarangMasuk($tanggal_awal, $tanggal_akhir){
      $q = DB::select("
          SELECT bm.id, bm.nomor_transaksi, bm.tanggal, b.kode as kode_barang, b.nama AS nama_barang, bmd.jumlah, st.nama as satuan, coalesce(bmd.harga, 0) AS harga, bm.id_supplier, bm.id_user, bm.keterangan, bm.status, s.nama AS nama_supplier FROM barang_masuk bm
          LEFT JOIN barang_masuk_detail bmd ON bm.id = bmd.id_barang_masuk
          LEFT JOIN barang b ON bmd.id_barang = b.id_barang
          LEFT JOIN satuan st ON b.id_satuan = st.id
          LEFT JOIN supplier s ON bm.id_supplier = s.id
          WHERE bm.status = '1'
          AND bm.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
          ORDER BY bm.tanggal asc
      ");
      return $q;
    }

    function getReportPembelian($tanggal_awal, $tanggal_akhir){
      $q = DB::select("
          SELECT bm.id, bm.nomor_transaksi, bm.tanggal, bm.id_supplier, bm.id_user, bm.keterangan, bm.status, s.nama AS nama_supplier FROM barang_masuk bm
          LEFT JOIN supplier s ON bm.id_supplier = s.id
          WHERE bm.status = '1'
          AND bm.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
          ORDER BY bm.created_at asc
      ");

      $data = [];
      foreach ($q as $row) {
        $id = $row->id;
        $details = $this->getListDetailBarang($id);
        
        $data [] = array(
          'id' => $row->id,
          'nomor_transaksi' => $row->nomor_transaksi,
          'tanggal'         => $row->tanggal,
          'id_supplier'     => $row->id_supplier,
          'nama_supplier'   => $row->nama_supplier,
          'keterangan'      => $row->keterangan,
          'detail'          => $details
        );
      }

      return $data;
    }
}
