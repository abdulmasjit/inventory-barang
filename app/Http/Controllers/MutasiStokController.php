<?php
namespace App\Http\Controllers;

use Validator;
use App\Models\MutasiStok;
use App\Models\BarangHistory;
use App\Models\MainModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Ramsey\Uuid\Uuid;
date_default_timezone_set('Asia/Jakarta');
        
class MutasiStokController extends Controller
{
    public function __construct()
    {
      $this->m_main = new MainModel();
      $this->m_mutasi = new MutasiStok();
    }

    public function index(Request $request)
    {   
        return view('mutasi_stok.index');
    }

    public function create(Request $request)
    {    
        $kode = $this->m_main->getNomorTransaksi('MUT', 'nomor_transaksi', 'mutasi_stok');
        $barang = DB::table('barang')
                      ->select('id_barang', 'kode', 'nama')
                      ->where('status', '1')
                      ->orderBy('nama', 'asc')->get();
        $data['nomor_transaksi'] = $kode;
        $data['barang'] = $barang;
        $data['modeform'] = 'ADD';
        return view('mutasi_stok.form_mutasi', $data);
    }

    public function edit($id)
    {   
        $kode = $this->m_main->getNomorTransaksi('MUT', 'nomor_transaksi', 'mutasi_stok');
        $barang = DB::table('barang')
                      ->select('id_barang', 'kode', 'nama')
                      ->where('status', '1')
                      ->orderBy('nama', 'asc')->get();
        $data['nomor_transaksi'] = $kode;
        $data['barang'] = $barang;
        $data['modeform'] = 'UPDATE';
        $data['data'] = MutasiStok::find($id);	
        return view('mutasi_stok.form_mutasi', $data);
    }

    public function fetch_data(Request $request)
    {
        $limit = $request->get('limit');
        $sortBy = $request->get('sortby');
        $sortType = $request->get('sorttype');
        $q = $request->get('q');
        $q = str_replace(" ", "%", $q);

        $getList = $this->m_mutasi->getListMutasiStok($q, $sortBy, $sortType);
        $data = $this->m_mutasi->arrayPaginator($getList, $request);            
        return view('mutasi_stok.list_data', compact('data'));
    }

    public function save(Request $request)
    {
      try {
          // Format Tanggal
          $tanggal = $request->tanggal;
          $time = strtotime($tanggal);
          $tanggal = date('Y-m-d', $time);
          $jenis = $request->jenis_mutasi;
          $qty = $request->qty;

          $id = Uuid::uuid4()->toString();
          $MutasiStok = new MutasiStok();
          $MutasiStok->id              = $id;
          $MutasiStok->nomor_transaksi = $request->nomor_transaksi; 
          $MutasiStok->tanggal         = $tanggal;
          $MutasiStok->id_barang       = $request->barang;
          $MutasiStok->keterangan      = $request->keterangan;
          $MutasiStok->qty             = $request->qty;
          $MutasiStok->jenis           = $request->jenis_mutasi;
          $MutasiStok->id_user         = Auth::user()->id;
          $MutasiStok->status          = '1';
          $MutasiStok->save();
              
          // Jenis Mutasi
          $sumber = '';
          if($jenis=='1'){
            $sumber = 'MS';
            $casting_qty = $qty;
          }else if($jenis=='2'){
            $sumber = 'MBR';
            $casting_qty = intval('-' . $qty);
          }else if($jenis=='3'){
            $sumber = 'MBH';
            $casting_qty = intval('-' . $qty);
          }else{
            $sumber = 'MS';
            $casting_qty = $qty;
          }

          $BarangHistory = new BarangHistory();    
          $dataHistory = array(
            'id'              => Uuid::uuid4()->toString(),
            'tanggal'         => $tanggal, 
            'id_barang'       => $request->barang,
            'keterangan'      => $request->keterangan,
            'qty'             => $casting_qty,
            'harga'           => null,
            'sumber'          => $sumber,
            'id_transaksi'    => $id,
            'created_at'      => date('Y-m-d H:i:s'),
            'updated_at'      => date('Y-m-d H:i:s'),
          );
          $BarangHistory->insert($dataHistory);
          
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
          $id = $request->id;
          $jenis = $request->jenis_mutasi;
          $qty = $request->qty;

          $tanggal = $request->tanggal;
          $time = strtotime($tanggal);
          $tanggal = date('Y-m-d', $time);

          MutasiStok::where('id', $id)->update([
            'tanggal'     => $tanggal,
            'id_barang'   => $request->barang,
            'keterangan'  => $request->keterangan,
            'qty'         => $request->qty,
            'jenis'       => $request->jenis_mutasi,
            'id_user'     => Auth::user()->id
          ]);
          
          // Jenis Mutasi
          $sumber = '';
          if($jenis=='1'){
            $sumber = 'MS';
            $casting_qty = $qty;
          }else if($jenis=='2'){
            $sumber = 'MBR';
            $casting_qty = intval('-' . $qty);
          }else if($jenis=='3'){
            $sumber = 'MBH';
            $casting_qty = intval('-' . $qty);
          }else{
            $sumber = 'MS';
            $casting_qty = $qty;
          }
              
          $dataHistory = array(
            'tanggal'         => $tanggal, 
            'id_barang'       => $request->barang,
            'keterangan'      => $request->keterangan,
            'qty'             => $casting_qty,
            'sumber'          => $sumber,
          );
          BarangHistory::where('id_transaksi', $id)->update($dataHistory);

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
        MutasiStok::where('id', $id)->update([
          'status'     => '0',
          // 'deleted_at' => date('Y-m-d H:i:s'),
        ]);
        $response['success'] = true;
        $response['message'] = "Data berhasil dihapus";
        return response()->json($response);
    }
}
