<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Models\Dashboard;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function __construct()
    {
      $this->m_dashboard = new Dashboard();
    }

    public function index(Request $request)
    {
        $query1 = DB::select("SELECT COUNT(*) AS jml FROM barang");
        $query2 = DB::select("SELECT COUNT(*) AS jml FROM supplier");
        $query3 = DB::select("SELECT COUNT(*) AS jml FROM barang_keluar where status = '1'");
        $query4 = DB::select("SELECT COUNT(*) AS jml FROM barang_masuk where status = '1'");

        $data = array(
          'total_barang' => $query1[0]->jml,
          'total_supplier' => $query2[0]->jml,
          'total_pembelian' => $query3[0]->jml,
          'total_penjualan' => $query4[0]->jml,
        );
        return view('dashboard/dashboard', $data);
    }

  public function getDashboardInvBarang(Request $request)
	{
    $tahun = $request->get('tahun');
    // Olah data chart
    $chart = $this->m_dashboard->getDashboardTahunan($tahun);
    $totalArr = array(0,0,0,0,0,0,0,0,0,0,0,0);
    $arrayList = [
      array(
        'name' => 'Barang Masuk',
        'data' => $totalArr
      ),
      array(
        'name' => 'Barang Keluar',
        'data' => $totalArr
      ),
    ];
    foreach ($chart as $row) {
      for ($i=0; $i < count($arrayList); $i++) { 
        if($arrayList[$i]['name'] == $row->jenis){
          $dataBln = array(
            $row->jan, $row->feb, $row->mar, $row->apr, $row->may, $row->jun, $row->jul, $row->aug, $row->sep, $row->oct, $row->nov, $row->des,
          );
          $arrayList[$i]['data'] = $dataBln;
        }
      }
    }

    $data['chart'] = $arrayList; 
    $data['tahun'] = $tahun; 
    return view('dashboard/data_chart', $data);
	}
}
