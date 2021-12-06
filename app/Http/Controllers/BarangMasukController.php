<?php

namespace App\Http\Controllers;

use Validator;
use App\Models\BarangMasuk;
use App\Models\BarangMasukDetail;
use App\Models\MainModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Ramsey\Uuid\Uuid;

class BarangMasukController extends Controller
{
    public function __construct()
    {
      $this->m_main = new MainModel();
      $this->m_barang_masuk = new BarangMasuk();
    }

    public function index(Request $request)
    {   
        $data = [];
        return view('barang_masuk.index', compact('data'));
    }

    public function create(Request $request)
    {    
        $supplier = DB::table('supplier')->select('id', 'kode', 'nama')->orderBy('nama', 'asc')->get();
        $kode = $this->m_main->getNomorTransaksi('TR', 'nomor_transaksi', 'barang_masuk');
        $data['supplier'] = $supplier;
        $data['nomor_transaksi'] = $kode;
        return view('barang_masuk.create', $data);
    }

    public function edit($id)
    {   
        $data = [];
        return view('barang_masuk.create', compact('data'));
    }

    public function fetch_data(Request $request)
    {
        $limit = $request->get('limit');
        $sortBy = $request->get('sortby');
        $sortType = $request->get('sorttype');
        $q = $request->get('q');
        $q = str_replace(" ", "%", $q);

        $getList = $this->m_barang_masuk->getListBarangMasuk($q, $sortBy, $sortType);
        $data = $this->m_barang_masuk->arrayPaginator($getList, $request);            
        return view('barang_masuk.list_data', compact('data'));
    }

    public function save(Request $request)
    {
      try {
          // Request Array Detail Barang Masuk
          $barang = $request->barang;
          $qty = $request->qty;
          $ket = $request->keterangan_barang;

          date_default_timezone_set('Asia/Jakarta');
          $id_barang_masuk = Uuid::uuid4()->toString();
          $BarangMasuk = new BarangMasuk();
          $BarangMasuk->id              = $id_barang_masuk;
          $BarangMasuk->nomor_transaksi = $request->nomor_transaksi; 
          $BarangMasuk->tanggal         = date('Y-m-d');
          $BarangMasuk->id_supplier     = $request->supplier;
          $BarangMasuk->id_user         = Auth::user()->id;
          $BarangMasuk->keterangan      = $request->keterangan;
          $BarangMasuk->status          = '1';
          $BarangMasuk->save();
          
          // Save Detail
          $BarangMasukDetail = new BarangMasukDetail();
          $jml = count($barang);
          for ($i=0; $i < $jml; $i++) { 
            $dataDetail = array(
                'id'              => Uuid::uuid4()->toString(),
                'id_barang_masuk' => $id_barang_masuk, 
                'id_barang'       => $barang[$i],
                'jumlah'          => $qty[$i],
                'keterangan'      => $ket[$i],
                'created_at'      => date('Y-m-d H:i:s'),
                'updated_at'      => date('Y-m-d H:i:s'),
            );
            $BarangMasukDetail->insert($dataDetail);
          }
          
          $response['success'] = true;
          $response['message'] = "Data berhasil disimpan";
          return response()->json($response);
      } catch (Exception $e) {
          $response['success'] = false;
          $response['message'] = "Data gagal disimpan";
          return response()->json($response);
      }
    }

    public function update(Request $request)
    {
      try {
          $response['success'] = true;
          $response['message'] = "Data berhasil diubah";
          return response()->json($response);
      } catch (Exception $e) {
          $response['success'] = false;
          $response['message'] = "Data gagal disimpan";
          return response()->json($response);
      }
    }

    public function delete($id)
    { 
        BarangMasuk::where("id", $id)->delete();
        $response['success'] = true;
        $response['message'] = "Data berhasil dihapus";
        return response()->json($response);
    }

    // Sementara nanti dipindah
    public function lookup_barang(Request $request)
    {
        $barang = DB::table('barang')->orderBy('nama', 'asc')->get();
        $data['barang'] = $barang;
        return view('lookup.lookup_barang', $data);
    }

    public function fetch_lookup_barang(Request $request)
    {
        $limit = $request->get('limit');
        $sortBy = $request->get('sortby');
        $sortType = $request->get('sorttype');
        $q = $request->get('q');
        $q = str_replace(" ", "%", $q);

        $data = DB::table('barang')
                    ->select('id_barang', 'nama', 'kode')
                    ->where('nama', 'like', '%'.$q.'%')
                    ->orderBy($sortBy, $sortType)
                    ->paginate($limit);            

        $data->appends($request->all());
        return view('lookup.list_data_barang', compact('data'));
    }
}
