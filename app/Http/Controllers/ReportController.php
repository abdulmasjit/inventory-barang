<?php

namespace App\Http\Controllers;

use Validator;
use App\Models\BarangMasuk;
use App\Models\BarangKeluar;
use App\Models\Barang;
use App\Models\MutasiStok;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDF;

class ReportController extends Controller
{
    public function __construct()
    {
      $this->m_barang_masuk = new BarangMasuk();
      $this->m_barang_keluar = new BarangKeluar();
      $this->m_barang = new Barang();
      $this->m_mutasi = new MutasiStok();
    }

    public function index(Request $request)
    {   
        $barang = DB::table('barang')
                      ->select('id_barang', 'kode', 'nama')
                      ->where('status', '1')
                      ->orderBy('nama', 'asc')->get();
        $data['barang'] = $barang;
        return view('report.index', $data);
    }

    public function report_barang_masuk(Request $request)
    {   
        $tanggal_awal = $request->get('tanggal_awal');
        $tanggal_akhir = $request->get('tanggal_akhir');
        $data['tanggal'] = $this->format_date($tanggal_awal, 'd/m/Y') . " - " . $this->format_date($tanggal_akhir, 'd/m/Y'); 
        $data['data'] = $this->m_barang_masuk->getReportBarangMasuk($tanggal_awal, $tanggal_akhir);
        $pdf = PDF::loadview('report.laporan_barang_masuk', $data)->setPaper('A4','potrait');
        return $pdf->stream();
    }

    public function report_barang_keluar(Request $request)
    {   
        $tanggal_awal = $request->get('tanggal_awal');
        $tanggal_akhir = $request->get('tanggal_akhir');
        $data['tanggal'] = $this->format_date($tanggal_awal, 'd/m/Y') . " - " . $this->format_date($tanggal_akhir, 'd/m/Y'); 
        $data['data'] = $this->m_barang_keluar->getReportBarangKeluar($tanggal_awal, $tanggal_akhir);
        $pdf = PDF::loadview('report.laporan_barang_keluar', $data)->setPaper('A4','potrait');
        return $pdf->stream();
    }

    public function report_kartu_stok(Request $request)
    {   
        $tanggal_awal = $request->get('tanggal_awal');
        $tanggal_akhir = $request->get('tanggal_akhir');
        $id_barang = $request->get('id_barang');
        $data['tanggal'] = $this->format_date($tanggal_awal, 'd/m/Y') . " - " . $this->format_date($tanggal_akhir, 'd/m/Y'); 

        if(isset($id_barang)){
          $data['barang'] = Barang::find($id_barang);
          $data['data'] = $this->m_barang->getReportStokPerbarang($tanggal_awal, $tanggal_akhir, $id_barang);
          $pdf = PDF::loadview('report.kartu_stok_perbarang', $data)->setPaper('A4','potrait');
        }else{
          $data['data'] = $this->m_barang->getReportStokAllBarang($tanggal_awal, $tanggal_akhir);
          $pdf = PDF::loadview('report.kartu_stok', $data)->setPaper('A4','landscape');
        }
      
        return $pdf->stream();
    }

    public function report_mutasi_stok(Request $request)
    {   
        $tanggal_awal = $request->get('tanggal_awal');
        $tanggal_akhir = $request->get('tanggal_akhir');
        $data['tanggal'] = $this->format_date($tanggal_awal, 'd/m/Y') . " - " . $this->format_date($tanggal_akhir, 'd/m/Y'); 
        $data['data'] = $this->m_mutasi->getReportMutasiStok($tanggal_awal, $tanggal_akhir);
        $pdf = PDF::loadview('report.laporan_mutasi_stok', $data)->setPaper('A4','potrait');
        return $pdf->stream();
    }

    public function report_pembelian(Request $request)
    {   
        $tanggal_awal = $request->get('tanggal_awal');
        $tanggal_akhir = $request->get('tanggal_akhir');
        $data['tanggal'] = $this->format_date($tanggal_awal, 'd/m/Y') . " - " . $this->format_date($tanggal_akhir, 'd/m/Y'); 
        $data['data'] = $this->m_barang_masuk->getReportPembelian($tanggal_awal, $tanggal_akhir);
        $pdf = PDF::loadview('report.laporan_pembelian', $data)->setPaper('A4','potrait');
        return $pdf->stream();
    }

    public function report_penjualan(Request $request)
    {   
        $tanggal_awal = $request->get('tanggal_awal');
        $tanggal_akhir = $request->get('tanggal_akhir');
        $data['tanggal'] = $this->format_date($tanggal_awal, 'd/m/Y') . " - " . $this->format_date($tanggal_akhir, 'd/m/Y'); 
        $data['data'] = $this->m_barang_keluar->getReportPenjualan($tanggal_awal, $tanggal_akhir);
        $pdf = PDF::loadview('report.laporan_penjualan', $data)->setPaper('A4','potrait');
        return $pdf->stream();
    }

    function format_date($val, $format){
      $time = strtotime($val);
      $tanggal = date($format, $time);
      return $tanggal;
    }
}
