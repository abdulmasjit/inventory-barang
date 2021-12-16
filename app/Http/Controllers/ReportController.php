<?php

namespace App\Http\Controllers;

use Validator;
use App\Models\BarangMasuk;
use App\Models\BarangKeluar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDF;

class ReportController extends Controller
{
    public function __construct()
    {
      $this->m_barang_masuk = new BarangMasuk();
      $this->m_barang_keluar = new BarangKeluar();
    }

    public function index(Request $request)
    {   
        return view('report.index');
    }

    public function report_barang_masuk(Request $request)
    {   
        $data['data'] = $this->m_barang_masuk->getReportBarangMasuk("", "");
        $pdf = PDF::loadview('report.laporan_barang_masuk', $data)->setPaper('A4','potrait');
        return $pdf->stream();
    }

    public function report_barang_keluar(Request $request)
    {   
        $data['data'] = $this->m_barang_keluar->getReportBarangKeluar("", "");
        $pdf = PDF::loadview('report.laporan_barang_keluar', $data)->setPaper('A4','potrait');
        return $pdf->stream();
    }

    public function report_kartu_stok(Request $request)
    {   
        $data['data'] = $this->m_barang_keluar->getReportBarangKeluar("", "");
        $pdf = PDF::loadview('report.kartu_stok', $data)->setPaper('A4','landscape');
        return $pdf->stream();
    }

    public function report_kartu_stok_perbarang(Request $request)
    {   
        $data['data'] = $this->m_barang_keluar->getReportBarangKeluar("", "");
        $pdf = PDF::loadview('report.kartu_stok_perbarang', $data)->setPaper('A4','potrait');
        return $pdf->stream();
    }
}
