<?php

namespace App\Http\Controllers;

use Validator;
use App\Models\Supplier;
use App\Models\MainModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SupplierController extends Controller
{
  public function __construct()
  {
    $this->m_main = new MainModel();
  }
  
  public function index(Request $request)
  {
    return view('supplier.index');
  }

  public function fetch_data(Request $request)
  {
    $limit = $request->get('limit');
    $sortBy = $request->get('sortby');
    $sortType = $request->get('sorttype');
    $q = $request->get('q');
    $q = str_replace(" ", "%", $q);

    $data = DB::table('supplier')
      ->where('nama', 'like', '%' . $q . '%')
      ->orderBy($sortBy, $sortType)
      ->paginate($limit);

    $data->appends($request->all());
    return view('supplier.list_data', compact('data'));
  }

  public function load_modal(Request $request)
  {
    $id = $request->id;
    $kode = $this->m_main->generateKode('SP', 'kode', 'supplier');
    $data['kode'] = $kode;
    if ($id != "") {
      $data['mode'] = "UPDATE";
      $data['data'] = Supplier::find($id);
    } else {
      $data['mode'] = "ADD";
    }
    return view('supplier.form_modal', $data);
  }

  public function save(Request $request)
  {
    try {
      $input = [
        'nama' => $request->input('nama'),
        'no_telp' => $request->input('no_telp'),
        'alamat' => $request->input('alamat'),
      ];
      $rules = [
        'nama' => 'required',
        'no_telp' => 'required',
        'alamat' => 'required',
      ];
      $messages = [
        'nama.required' => 'Jenis barang wajib diisi',
        'no_telp.required' => 'No Telephone wajib diisi',
        'alamat.required' => 'Alamat wajib diisi'
      ];

      $validator = Validator::make($input, $rules, $messages);
      if ($validator->fails()) {
        $response['success'] = false;
        $response['message'] = "Harap lengkapi isian dengan benar";
        return response()->json($response);
      }

      $kode = $this->m_main->generateKode('SP', 'kode', 'supplier');
      // Handle Save
      $data = new Supplier();
      $data->nama = $request->nama;
      $data->kode = $kode;
      $data->no_telp = $request->no_telp;
      $data->alamat = $request->alamat;
      $data->keterangan = $request->keterangan;
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
        'no_telp' => $request->input('no_telp'),
        'alamat' => $request->input('alamat'),
      ];
      $rules = [
        'nama' => 'required',
        'no_telp' => 'required',
        'alamat' => 'required',
      ];
      $messages = [
        'nama.required' => 'Jenis barang wajib diisi',
        'no_telp.required' => 'No Telephone wajib diisi',
        'alamat.required' => 'Alamat wajib diisi'
      ];

      $validator = Validator::make($input, $rules, $messages);
      if ($validator->fails()) {
        $response['success'] = false;
        $response['message'] = "Harap lengkapi isian dengan benar";
        return response()->json($response);
      }

      $id = $request->id;
      $data = Supplier::where('id', $id)
        ->update([
          'nama' => $request->nama,
          'no_telp' => $request->no_telp,
          'alamat' => $request->alamat,
          'keterangan' => $request->keterangan
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
      Supplier::where("id", $id)->delete();
      $response['success'] = true;
      $response['message'] = "Data berhasil dihapus";
      return response()->json($response);
    } catch (Exception $e) {
      $response['success'] = false;
      $response['message'] = "Hapus data gagal";
      return response()->json($response);
    }
  }
}
