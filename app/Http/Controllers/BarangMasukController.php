<?php
namespace App\Http\Controllers;

use Validator;
use App\Models\BarangMasuk;
use App\Models\BarangMasukDetail;
use App\Models\BarangHistory;
use App\Models\MainModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Ramsey\Uuid\Uuid;
date_default_timezone_set('Asia/Jakarta');

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
        $kode = $this->m_main->getNomorTransaksi('TRM', 'nomor_transaksi', 'barang_masuk');
        $data['supplier'] = $supplier;
        $data['nomor_transaksi'] = $kode;
        $data['modeform'] = 'ADD';
        return view('barang_masuk.form_barang_masuk', $data);
    }

    public function edit($id)
    {   
        $supplier = DB::table('supplier')->select('id', 'kode', 'nama')->orderBy('nama', 'asc')->get();
        $kode = $this->m_main->getNomorTransaksi('TRM', 'nomor_transaksi', 'barang_masuk');
        $dataDetail = $this->m_barang_masuk->getListDetailBarang($id);

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
          $harga = $request->harga;
          $diskon = $request->diskon;
          // Format Tanggal
          $tanggal = $request->tanggal;
          $time = strtotime($tanggal);
          $tanggal = date('Y-m-d', $time);
          $total = 0;

          if(isset($barang)){
              $id_barang_masuk = Uuid::uuid4()->toString();
              $jml = count($barang);
              for ($i=0; $i < $jml; $i++) {
                // Sum Total 
                $dis = ($diskon[$i]!="") ? $diskon[$i] : 0;
                $total += ($qty[$i] * $harga[$i]) - $dis;
                $dataDetail[] = array(
                    'id'              => Uuid::uuid4()->toString(),
                    'id_barang_masuk' => $id_barang_masuk, 
                    'id_barang'       => $barang[$i],
                    'jumlah'          => $qty[$i],
                    'harga'           => $harga[$i],
                    'diskon'          => $dis,
                    // 'keterangan'      => null,
                    'created_at'      => date('Y-m-d H:i:s'),
                    'updated_at'      => date('Y-m-d H:i:s'),
                );

                $dataHistory[] = array(
                  'id'              => Uuid::uuid4()->toString(),
                  'tanggal'         => date('Y-m-d'), 
                  'id_barang'       => $barang[$i],
                  'keterangan'      => 'Barang Masuk',
                  'qty'             => $qty[$i],
                  'harga'           => $harga[$i],
                  'sumber'          => 'TBM', // Pembelian / Barang Masuk
                  'id_transaksi'    => $id_barang_masuk,
                  'created_at'      => date('Y-m-d H:i:s'),
                  'updated_at'      => date('Y-m-d H:i:s'),
                );
              }

              $BarangMasuk = new BarangMasuk();
              $BarangMasuk->id              = $id_barang_masuk;
              $BarangMasuk->nomor_transaksi = $request->nomor_transaksi; 
              $BarangMasuk->tanggal         = $tanggal;
              $BarangMasuk->id_supplier     = $request->supplier;
              $BarangMasuk->id_user         = Auth::user()->id;
              $BarangMasuk->total           = $total;
              $BarangMasuk->keterangan      = $request->keterangan;
              $BarangMasuk->status          = '1';
              $BarangMasuk->save();
              
              // Save Detail
              $BarangMasukDetail = new BarangMasukDetail();    
              $BarangHistory = new BarangHistory();    
              $BarangMasukDetail->insert($dataDetail);
              $BarangHistory->insert($dataHistory);
              
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
        $harga = $request->harga;
        $diskon = $request->diskon;
        // Format Tanggal
        $tanggal = $request->tanggal;
        $time = strtotime($tanggal);
        $tanggal = date('Y-m-d', $time);
        $total = 0;

        if(isset($barang)){
            $jml = count($barang);
            for ($i=0; $i < $jml; $i++) {
              // Sum Total 
              $dis = ($diskon[$i]!="") ? $diskon[$i] : 0;
              $total += ($qty[$i] * $harga[$i]) - $dis;
              $dataDetail[] = array(
                  'id'              => Uuid::uuid4()->toString(),
                  'id_barang_masuk' => $id, 
                  'id_barang'       => $barang[$i],
                  'jumlah'          => $qty[$i],
                  'harga'           => $harga[$i],
                  'diskon'          => $dis,
                  // 'keterangan'      => null,
                  'created_at'      => date('Y-m-d H:i:s'),
                  'updated_at'      => date('Y-m-d H:i:s'),
              );

              $dataHistory[] = array(
                'id'              => Uuid::uuid4()->toString(),
                'tanggal'         => date('Y-m-d'), 
                'id_barang'       => $barang[$i],
                'keterangan'      => 'Barang Masuk',
                'qty'             => $qty[$i],
                'harga'           => $harga[$i],
                'sumber'          => 'TBM', // Pembelian / Barang Masuk
                'id_transaksi'    => $id,
                'created_at'      => date('Y-m-d H:i:s'),
                'updated_at'      => date('Y-m-d H:i:s'),
              );
            }

            BarangMasuk::where('id', $id)->update([
                'tanggal'     => $tanggal,
                'id_supplier' => $request->supplier,
                'id_user'     => Auth::user()->id,
                'total'       => $total,
                'keterangan'  => $request->keterangan,
            ]);

            // Delete Data
            BarangMasukDetail::where("id_barang_masuk", $id)->delete();
            BarangHistory::where("id_transaksi", $id)->delete();
            // Save Detail
            $BarangMasukDetail = new BarangMasukDetail();
            $BarangHistory = new BarangHistory();     
            $BarangMasukDetail->insert($dataDetail);
            $BarangHistory->insert($dataHistory);
            
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
        BarangMasuk::where('id', $id)->update([
          'status'     => '0',
          'deleted_at' => date('Y-m-d H:i:s'),
        ]);
        $response['success'] = true;
        $response['message'] = "Data berhasil dihapus";
        return response()->json($response);
    }
}
