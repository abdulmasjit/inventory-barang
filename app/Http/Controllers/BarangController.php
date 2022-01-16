<?php

namespace App\Http\Controllers;

use Validator;
use App\Models\Barang;
use App\Models\MainModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BarangController extends Controller
{
    public function __construct()
    {
      $this->m_main = new MainModel();
      $this->m_barang = new Barang();
    }

    public function index(Request $request)
    {
        return view('barang.index');
    }

    public function fetch_data(Request $request)
    {
        $limit = $request->get('limit');
        $sortBy = $request->get('sortby');
        $sortType = $request->get('sorttype');
        $q = $request->get('q');
        $q = str_replace(" ", "%", $q);

        $data = DB::table('barang AS b')
            ->where('b.nama', 'like', '%' . $q . '%')
            ->join('jenis_barang AS jb', 'b.id_jenis_barang', '=', 'jb.id')
            ->select('b.*', 'jb.nama AS nama_jenis_barang')
            ->orderBy($sortBy, $sortType)
            ->paginate($limit);

        $data->appends($request->all());

        return view('barang.list_data', compact('data'));
    }

    public function fecth_list_jenis_barang()
    {
        $data = DB::table('jenis_barang AS jb')
            ->where('jb.status', '1')
            ->get();
        return $data;
    }

    public function fecth_list_satuan()
    {
        $data = DB::table('satuan AS s')
            ->where('s.status', '1')
            ->get();
        return $data;
    }

    public function create(Request $request)
    {
        $id = $request->id;
        $kode = $this->m_main->generateKode('BRG', 'kode', 'barang');
        $dataTypeItems = $this->fecth_list_jenis_barang();
        $dataUnits = $this->fecth_list_satuan();
        return view('barang.form_barang', compact('dataTypeItems', 'dataUnits', 'kode'));
    }

    public function edit(Request $request)
    {
        $id = $request->id;
        $dataTypeItems = $this->fecth_list_jenis_barang();
        $dataUnits = $this->fecth_list_satuan();
        if ($id != "") {
            $data = Barang::find($id);
        }
        return view('barang.form_barang', compact('data', 'dataTypeItems', 'dataUnits'));
    }

    public function uploadPhoto($prams)
    {
        $path = 'assets/images/barang/';
        $file = $prams->file('product_image');
        $fileExist = $prams->img_preview;
        // echo(var_dump($request->file('product_image')));
        $file_name = $fileExist;
        if ($file) {
            $splitType = explode(".", $file->getClientOriginalName());
            $file_name = 'BRG_' . time() . '.' . $splitType[count($splitType) - 1];
            //    $upload = $file->storeAs($path, $file_name);
            $upload = $file->move($path, $file_name);
        }
        return $path . $file_name;
    }

    public function add(Request $request)
    {
        try {
            $input = [
                'nama' => $request->input('nama'),
                'id_jenis_barang' => $request->input('id_jenis_barang'),
                'id_satuan' => $request->input('id_satuan'),
                'harga_jual' => $request->input('harga_jual'),
                'harga_beli' => $request->input('harga_beli'),
                'deskripsi' => $request->input('deskripsi'),
            ];
            $rules = [
                'nama' => 'required',
                'id_jenis_barang' => 'required',
                'id_satuan' => 'required',
                'harga_jual' => 'required',
                'harga_beli' => 'required',
                'deskripsi' => 'required',
            ];
            $messages = [
                'nama.required' => 'Nama wajib diisi',
                'id_jenis_barang.required' => 'Jenis Barang wajib diisi',
                'id_satuan.required' => 'Satuan wajib diisi',
                'harga_beli.required' => 'Harga Beli wajib diisi',
                'harga_jual.required' => 'Harga Jual barang wajib diisi',
                'deskripsi.required' => 'Deskripsi barang wajib diisi',
            ];

            $validator = Validator::make($input, $rules, $messages);
            if ($validator->fails()) {
                $response['success'] = false;
                $response['message'] = "Harap lengkapi isian dengan benar";
                return response()->json($response);
            }

            $kode = $this->m_main->generateKode('BRG', 'kode', 'barang');
            // Handle Save
            $data = new Barang();
            $data->kode = $kode;
            $data->nama = $request->nama;
            $data->id_jenis_barang = $request->id_jenis_barang;
            $data->id_satuan = $request->id_satuan;
            $data->stok = 0;
            $data->foto = $this->uploadPhoto($request); // Cekking untuk upload file
            $data->deskripsi = $request->deskripsi;
            $data->harga_beli = $request->harga_beli;
            $data->harga_jual = $request->harga_jual;
            $data->stok_minimum = $request->stok_minimum;
            $data->status = '1';
            $data->save();

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
            $input = [
                'nama' => $request->input('nama'),
                'id_jenis_barang' => $request->input('id_jenis_barang'),
                'id_satuan' => $request->input('id_satuan'),
                'harga_jual' => $request->input('harga_jual'),
                'harga_beli' => $request->input('harga_beli'),
                'deskripsi' => $request->input('deskripsi'),
            ];
            $rules = [
                'nama' => 'required',
                'id_jenis_barang' => 'required',
                'id_satuan' => 'required',
                'harga_jual' => 'required',
                'harga_beli' => 'required',
                'deskripsi' => 'required',
            ];
            $messages = [
                'nama.required' => 'Nama wajib diisi',
                'id_jenis_barang.required' => 'Jenis Barang wajib diisi',
                'id_satuan.required' => 'Satuan wajib diisi',
                'harga_beli.required' => 'Harga Beli wajib diisi',
                'harga_jual.required' => 'Harga Jual barang wajib diisi',
                'deskripsi.required' => 'Deskripsi barang wajib diisi',
            ];

            $validator = Validator::make($input, $rules, $messages);
            if ($validator->fails()) {
                $response['success'] = false;
                $response['message'] = "Harap lengkapi isian dengan benar";
                return response()->json($response);
            }

            $id = $request->id_barang;
            Barang::where('id_barang', $id)
                ->update([
                    'nama' => $request->nama,
                    'id_jenis_barang' => $request->id_jenis_barang,
                    'id_satuan' => $request->id_satuan,
                    'foto' => $this->uploadPhoto($request),
                    'deskripsi' => $request->deskripsi,
                    'harga_beli' => $request->harga_beli,
                    'harga_jual' => $request->harga_jual,
                    'stok_minimum' => $request->stok_minimum,
                ]);

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
        try {
          Barang::where("id_barang", $id)->delete();
          $response['success'] = true;
          $response['message'] = "Data berhasil dihapus";
          return response()->json($response);
        } catch (Exception $e) {
          $response['success'] = false;
          $response['message'] = "Hapus data gagal";
          return response()->json($response);
        }

    }

    // Lookup Barang
    public function lookup_barang(Request $request)
    {
        $barang = DB::table('barang')->orderBy('nama', 'asc')->get();
        $data['barang'] = $barang;
        return view('lookup.lookup_barang', $data);
    }

    /**
     * Lookup Barang
     * Digunakan untuk mengambil / mencari data barang dalam jumlah besar
     */

    public function fetch_lookup_barang(Request $request)
    {
        $limit = $request->get('limit');
        $sortBy = $request->get('sortby');
        $sortType = $request->get('sorttype');
        $q = $request->get('q');
        $q = str_replace(" ", "%", $q);

        $data = DB::table('barang as b')
            ->select('b.id_barang', 'b.nama', 'b.kode', 'jb.nama as jenis_barang', 'b.harga_jual', 'b.harga_beli')
            ->leftJoin('jenis_barang as jb', 'b.id_jenis_barang', '=', 'jb.id')
            ->where(DB::raw("concat(b.id_barang, b.nama, b.kode, jb.nama)"), 'like', '%' . $q . '%')
            ->orderBy($sortBy, $sortType)
            ->paginate($limit);

        $data->appends($request->all());
        return view('lookup.list_data_barang', compact('data'));
    }

    /**
     * Stok Barang
     * Digunakan untuk menampilkan data stok barang
     */

    public function stok_barang(Request $request)
    {
        return view('stok_barang.index');
    }

    public function list_stok_barang(Request $request)
    {
        $limit = $request->get('limit');
        $sortBy = $request->get('sortby');
        $sortType = $request->get('sorttype');
        $q = $request->get('q');
        $q = str_replace(" ", "%", $q);

        $getList = $this->m_barang->getListStokBarang($q, $sortBy, $sortType);
        $data = $this->m_barang->arrayPaginator($getList, $request);            
        return view('stok_barang.list_data', compact('data'));
    }
}
