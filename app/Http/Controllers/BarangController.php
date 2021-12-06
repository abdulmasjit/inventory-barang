<?php

namespace App\Http\Controllers;

use Validator;
use App\Models\Barang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BarangController extends Controller
{
    public function index(Request $request)
    {
        $data = [];
        $q = $request->get('q');
        return view('barang.index', compact('data', 'q'));
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
        $dataTypeItems = $this->fecth_list_jenis_barang();
        $dataUnits = $this->fecth_list_satuan();   
        return view('barang.form_barang', compact('dataTypeItems', 'dataUnits'));
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

    public function add(Request $request)
    {
        try {
            $input = [
                'kode' => $request->input('kode'),
                'nama' => $request->input('nama'),
                'id_jenis_barang' => $request->input('id_jenis_barang'),
                'id_satuan' => $request->input('id_satuan'),
                'harga_jual' => $request->input('harga_jual'),
                'harga_beli' => $request->input('harga_beli'),
                'stok' => $request->input('stok'),
                'deskripsi' => $request->input('deskripsi'),
            ];
            $rules = [
                'kode' => 'required',
                'nama' => 'required',
                'id_jenis_barang' => 'required',
                'id_satuan' => 'required',
                'harga_jual' => 'required',
                'harga_beli' => 'required',
                'stok' => 'required',
                'deskripsi' => 'required',
            ];
            $messages = [
                'kode.required' => 'Kode wajib diisi',
                'nama.required' => 'Nama wajib diisi',
                'id_jenis_barang.required' => 'Jenis Barang wajib diisi',
                'id_satuan.required' => 'Satuan wajib diisi',
                'harga_beli.required' => 'Harga Beli wajib diisi',
                'harga_jual.required' => 'Harga Jual barang wajib diisi',
                'stok.required' => 'Stok wajib diisi',
                'deskripsi.required' => 'Deskripsi barang wajib diisi',
            ];

            $validator = Validator::make($input, $rules, $messages);
            if ($validator->fails()) {
                $response['success'] = false;
                $response['message'] = "Harap lengkapi isian dengan benar";
                return response()->json($response);
            }

            // Handle Save
            $data = new Barang();
            $data->kode = $request->kode;
            $data->nama = $request->nama;
            $data->id_jenis_barang = $request->id_jenis_barang;
            $data->id_satuan = $request->id_satuan;
            $data->stok = $request->stok;
            $data->deskripsi = $request->deskripsi;
            $data->harga_beli = $request->harga_beli;
            $data->harga_jual = $request->harga_jual;
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
                'kode' => $request->input('kode'),
                'nama' => $request->input('nama'),
                'id_jenis_barang' => $request->input('id_jenis_barang'),
                'id_satuan' => $request->input('id_satuan'),
                'harga_jual' => $request->input('harga_jual'),
                'harga_beli' => $request->input('harga_beli'),
                'stok' => $request->input('stok'),
                'deskripsi' => $request->input('deskripsi'),
            ];
            $rules = [
                'kode' => 'required',
                'nama' => 'required',
                'id_jenis_barang' => 'required',
                'id_satuan' => 'required',
                'harga_jual' => 'required',
                'harga_beli' => 'required',
                'stok' => 'required',
                'deskripsi' => 'required',
            ];
            $messages = [
                'kode.required' => 'Kode wajib diisi',
                'nama.required' => 'Nama wajib diisi',
                'id_jenis_barang.required' => 'Jenis Barang wajib diisi',
                'id_satuan.required' => 'Satuan wajib diisi',
                'harga_beli.required' => 'Harga Beli wajib diisi',
                'harga_jual.required' => 'Harga Jual barang wajib diisi',
                'stok.required' => 'Stok wajib diisi',
                'deskripsi.required' => 'Deskripsi barang wajib diisi',
            ];

            $validator = Validator::make($input, $rules, $messages);
            if ($validator->fails()) {
                $response['success'] = false;
                $response['message'] = "Harap lengkapi isian dengan benar";
                return response()->json($response);
            }

            $id = $request->id_barang;
            $data = Barang::find($id)
                // JenisBarang::where('id', $id)
                ->update([
                    'kode' => $request->kode,
                    'nama' => $request->nama,
                    'id_jenis_barang' => $request->id_jenis_barang,
                    'id_satuan' => $request->id_satuan,
                    'stok' => $request->stok,
                    'deskripsi' => $request->deskripsi,
                    'harga_beli' => $request->harga_beli,
                    'harga_jual' => $request->harga_jual,
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
        Barang::where("id_barang", $id)->delete();
        $response['success'] = true;
        $response['message'] = "Data berhasil dihapus";
        return response()->json($response);
    }

    // Lookup Barang
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

        $data = DB::table('barang as b')
                    ->select('b.id_barang', 'b.nama', 'b.kode', 'jb.nama as jenis_barang')
                    ->leftJoin('jenis_barang as jb', 'b.id_jenis_barang', '=', 'jb.id')
                    ->where(DB::raw("concat(b.id_barang, b.nama, b.kode, jb.nama)"), 'like', '%'.$q.'%')
                    ->orderBy($sortBy, $sortType)
                    ->paginate($limit);            

        $data->appends($request->all());
        return view('lookup.list_data_barang', compact('data'));
    }
}
