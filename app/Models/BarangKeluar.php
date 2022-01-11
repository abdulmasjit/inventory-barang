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
          SELECT bk.id, bk.nomor_transaksi, bk.tanggal, bk.id_user, bk.keterangan, bk.status, bk.total FROM barang_keluar bk
          WHERE CONCAT(bk.nomor_transaksi, bk.tanggal) LIKE '%$keyword%'
          AND bk.status = '1'
          ORDER BY $sortby $sorttype
      ");
      return $q;
    }

    function getListDetailBarang($id){
      $q = DB::table('barang_keluar_detail as bkd')
            ->select('bkd.*', 'b.kode as kode_barang', 'b.nama as nama_barang', 's.nama as nama_satuan')
            ->leftJoin('barang as b', 'bkd.id_barang', '=', 'b.id_barang')
            ->leftJoin('satuan as s', 'b.id_satuan', '=', 's.id')
            ->where('bkd.id_barang_keluar', $id)->get();
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

    function getReportBarangKeluar($tanggal_awal, $tanggal_akhir){
      $q = DB::select("
          SELECT bk.id, bk.nomor_transaksi, bk.tanggal, b.kode AS kode_barang, b.nama AS nama_barang, bkd.jumlah, st.nama as satuan, coalesce(bkd.harga, 0) AS harga, bk.id_user, bk.keterangan, bk.status FROM barang_keluar bk
          LEFT JOIN barang_keluar_detail bkd ON bk.id = bkd.id_barang_keluar
          LEFT JOIN barang b ON bkd.id_barang = b.id_barang
          LEFT JOIN satuan st ON b.id_satuan = st.id
          WHERE bk.status = '1'
          AND bk.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
          ORDER BY bk.tanggal asc
      ");
      return $q;
    }

    function getReportPenjualan($tanggal_awal, $tanggal_akhir){
      $q = DB::select("
          SELECT bk.id, bk.nomor_transaksi, bk.tanggal, bk.id_user, bk.keterangan, bk.status, bk.customer FROM barang_keluar bk
          WHERE bk.status = '1'
          AND bk.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
          ORDER BY bk.created_at asc
      ");

      $data = [];
      foreach ($q as $row) {
        $id = $row->id;
        $details = $this->getListDetailBarang($id);
        
        $data [] = array(
          'id' => $row->id,
          'nomor_transaksi' => $row->nomor_transaksi,
          'tanggal'         => $row->tanggal,
          'customer'        => $row->customer,
          'keterangan'      => $row->keterangan,
          'detail'          => $details
        );
      }

      return $data;
    }
}
