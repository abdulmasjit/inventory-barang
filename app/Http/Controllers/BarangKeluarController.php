<?php
namespace App\Http\Controllers;

use Validator;
use App\Models\BarangKeluar;
use App\Models\BarangKeluarDetail;
use App\Models\BarangHistory;
use App\Models\MainModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Ramsey\Uuid\Uuid;
date_default_timezone_set('Asia/Jakarta');
        
class BarangKeluarController extends Controller
{
    public function __construct()
    {
      $this->m_main = new MainModel();
      $this->m_barang_keluar = new BarangKeluar();
    }

    public function index(Request $request)
    {   
        return view('barang_keluar.index');
    }

    public function create(Request $request)
    {    
        $kode = $this->m_main->getNomorTransaksi('TRK', 'nomor_transaksi', 'barang_keluar');
        $data['nomor_transaksi'] = $kode;
        $data['modeform'] = 'ADD';
        return view('barang_keluar.form_barang_keluar', $data);
    }

    public function edit($id)
    {   
        $kode = $this->m_main->getNomorTransaksi('TRK', 'nomor_transaksi', 'barang_keluar');
        $dataDetail = $this->m_barang_keluar->getListDetailBarang($id);

        $data['nomor_transaksi'] = $kode;
        $data['modeform'] = 'UPDATE';
        $data['data'] = BarangKeluar::find($id);	
        $data['data_detail'] = $dataDetail;
        return view('barang_keluar.form_barang_keluar', $data);
    }

    public function fetch_data(Request $request)
    {
        $limit = $request->get('limit');
        $sortBy = $request->get('sortby');
        $sortType = $request->get('sorttype');
        $q = $request->get('q');
        $q = str_replace(" ", "%", $q);

        $getList = $this->m_barang_keluar->getListBarangKeluar($q, $sortBy, $sortType);
        $data = $this->m_barang_keluar->arrayPaginator($getList, $request);            
        return view('barang_keluar.list_data', compact('data'));
    }

    public function save(Request $request)
    {
      try {
          // Request Array Detail Barang Keluar
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
              $id_barang_keluar = Uuid::uuid4()->toString();
              $jml = count($barang);

              for ($i=0; $i < $jml; $i++) {
                // Sum Total 
                $dis = ($diskon[$i]!="") ? $diskon[$i] : 0;
                $total += ($qty[$i] * $harga[$i]) - $dis;
                $dataDetail[] = array(
                    'id'               => Uuid::uuid4()->toString(),
                    'id_barang_keluar' => $id_barang_keluar, 
                    'id_barang'        => $barang[$i],
                    'jumlah'           => $qty[$i],
                    'harga'            => $harga[$i],
                    'diskon'           => $dis,
                    // 'keterangan'       => null,
                    'created_at'       => date('Y-m-d H:i:s'),
                    'updated_at'       => date('Y-m-d H:i:s'),
                );
                
                $casting_qty = intval('-' . $qty[$i]);
                $dataHistory[] = array(
                  'id'              => Uuid::uuid4()->toString(),
                  'tanggal'         => date('Y-m-d'), 
                  'id_barang'       => $barang[$i],
                  'keterangan'      => 'Barang Keluar',
                  'qty'             => $casting_qty,
                  'harga'           => $harga[$i],
                  'sumber'          => 'TBK', // Penjualan / Barang Keluar
                  'id_transaksi'    => $id_barang_keluar,
                  'created_at'      => date('Y-m-d H:i:s'),
                  'updated_at'      => date('Y-m-d H:i:s'),
                );
              }

              $BarangKeluar = new BarangKeluar();
              $BarangKeluar->id              = $id_barang_keluar;
              $BarangKeluar->nomor_transaksi = $request->nomor_transaksi; 
              $BarangKeluar->tanggal         = $tanggal;
              $BarangKeluar->customer        = $request->customer;
              $BarangKeluar->total           = $total;
              $BarangKeluar->id_user         = Auth::user()->id;
              $BarangKeluar->keterangan      = $request->keterangan;
              $BarangKeluar->status          = '1';
              $BarangKeluar->save();
              
              // Save Detail
              $BarangKeluarDetail = new BarangKeluarDetail();
              $BarangHistory = new BarangHistory();        
              $BarangKeluarDetail->insert($dataDetail);
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
                  'id'               => Uuid::uuid4()->toString(),
                  'id_barang_keluar' => $id, 
                  'id_barang'        => $barang[$i],
                  'jumlah'           => $qty[$i],
                  'harga'            => $harga[$i],
                  'diskon'           => $dis,
                  // 'keterangan'       => null,
                  'created_at'       => date('Y-m-d H:i:s'),
                  'updated_at'       => date('Y-m-d H:i:s'),
              );

              $casting_qty = intval('-' . $qty[$i]);
              $dataHistory[] = array(
                  'id'              => Uuid::uuid4()->toString(),
                  'tanggal'         => date('Y-m-d'), 
                  'id_barang'       => $barang[$i],
                  'keterangan'      => 'Barang Keluar',
                  'qty'             => $casting_qty,
                  'harga'           => $harga[$i],
                  'sumber'          => 'TBK', // Penjualan / Barang Keluar
                  'id_transaksi'    => $id,
                  'created_at'      => date('Y-m-d H:i:s'),
                  'updated_at'      => date('Y-m-d H:i:s'),
              );
            }

            BarangKeluar::where('id', $id)->update([
                'tanggal'     => $tanggal,
                'customer'    => $request->customer,
                'total'       => $total,
                'id_user'     => Auth::user()->id,
                'keterangan'  => $request->keterangan,
            ]);

            // Delete Data
            BarangKeluarDetail::where("id_barang_keluar", $id)->delete();
            BarangHistory::where("id_transaksi", $id)->delete();
            // Save Detail
            $BarangKeluarDetail = new BarangKeluarDetail();    
            $BarangHistory = new BarangHistory();
            $BarangKeluarDetail->insert($dataDetail);
            $BarangHistory->insert($dataHistory);
            
            $response['success'] = true;
            $response['message'] = "Data berhasil diubah";
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

    public function delete($id)
    { 
        BarangKeluar::where('id', $id)->update([
          'status'     => '0',
          'deleted_at' => date('Y-m-d H:i:s'),
        ]);
        $response['success'] = true;
        $response['message'] = "Data berhasil dihapus";
        return response()->json($response);
    }
}
