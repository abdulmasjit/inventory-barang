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
        return view('barang_masuk.index');
    }

    public function create(Request $request)
    {    
        $supplier = DB::table('supplier')->select('id', 'kode', 'nama')->orderBy('nama', 'asc')->get();
        $kode = $this->m_main->getNomorTransaksi('TR', 'nomor_transaksi', 'barang_masuk');
        $data['supplier'] = $supplier;
        $data['nomor_transaksi'] = $kode;
        $data['modeform'] = 'ADD';
        return view('barang_masuk.form_barang_masuk', $data);
    }

    public function edit($id)
    {   
        $supplier = DB::table('supplier')->select('id', 'kode', 'nama')->orderBy('nama', 'asc')->get();
        $kode = $this->m_main->getNomorTransaksi('TR', 'nomor_transaksi', 'barang_masuk');
        $dataDetail = DB::table('barang_masuk_detail as bmd')
                          ->select('bmd.*', 'b.kode as kode_barang', 'b.nama as nama_barang')
                          ->leftJoin('barang as b', 'bmd.id_barang', '=', 'b.id_barang')
                          ->where('bmd.id_barang_masuk', $id)->get();

        $data['supplier'] = $supplier;
        $data['nomor_transaksi'] = $kode;
        $data['modeform'] = 'UPDATE';
        $data['data'] = BarangMasuk::find($id);	
        $data['data_detail'] = $dataDetail;
        return view('barang_masuk.form_barang_masuk', $data);
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
          // Format Tanggal
          $tanggal = $request->tanggal;
          $time = strtotime($tanggal);
          $tanggal = date('Y-m-d', $time);

          date_default_timezone_set('Asia/Jakarta');
          if(isset($barang)){
              $id_barang_masuk = Uuid::uuid4()->toString();
              $BarangMasuk = new BarangMasuk();
              $BarangMasuk->id              = $id_barang_masuk;
              $BarangMasuk->nomor_transaksi = $request->nomor_transaksi; 
              $BarangMasuk->tanggal         = $tanggal;
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
          }else{
              $response['success'] = false;
              $response['message'] = "Rincian transaksi tidak boleh kosong !";
              return response()->json($response);
          }
      } catch (Exception $e) {
          $response['success'] = false;
          $response['message'] = "Data gagal disimpan";
          return response()->json($response);
      }
    }

    public function update(Request $request)
    {
      try {
        // Request Array Detail Barang Masuk
        $id = $request->id;
        $barang = $request->barang;
        $qty = $request->qty;
        $ket = $request->keterangan_barang;
        // Format Tanggal
        $tanggal = $request->tanggal;
        $time = strtotime($tanggal);
        $tanggal = date('Y-m-d', $time);

        date_default_timezone_set('Asia/Jakarta');
        if(isset($barang)){
            BarangMasuk::where('id', $id)->update([
                'tanggal' => $tanggal,
                'id_supplier' => $request->supplier,
                'id_user' => Auth::user()->id,
                'keterangan' => $request->keterangan,
            ]);

            // Delete Data
            BarangMasukDetail::where("id_barang_masuk", $id)->delete();
            // Save Detail
            $BarangMasukDetail = new BarangMasukDetail();    
            $jml = count($barang);
            for ($i=0; $i < $jml; $i++) { 
              $dataDetail = array(
                  'id'              => Uuid::uuid4()->toString(),
                  'id_barang_masuk' => $id, 
                  'id_barang'       => $barang[$i],
                  'jumlah'          => $qty[$i],
                  'keterangan'      => $ket[$i],
                  'created_at'      => date('Y-m-d H:i:s'),
                  'updated_at'      => date('Y-m-d H:i:s'),
              );
              $BarangMasukDetail->insert($dataDetail);
            }
            
            $response['success'] = true;
            $response['message'] = "Data berhasil diubah";
            return response()->json($response);
        }
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
}