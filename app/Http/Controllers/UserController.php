<?php

namespace App\Http\Controllers;

use Validator;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $data = [];
        $q = $request->get('q');
        return view('user.index', compact('data', 'q'));
    }

    public function fetch_data(Request $request)
    {
        $limit = $request->get('limit');
        $sortBy = $request->get('sortby');
        $sortType = $request->get('sorttype');
        $q = $request->get('q');
        $q = str_replace(" ", "%", $q);

        $data = DB::table('users')
        ->where('name', 'like', '%'.$q.'%')
        // ->join('jenis_user AS jb', 'b.id_jenis_user', '=', 'jb.id')
            // ->select('b.*', 'jb.nama AS nama_jenis_user')
            ->orderBy($sortBy, $sortType)
            ->paginate($limit);

        $data->appends($request->all());

        return view('user.list_data', compact('data'));
    }

    public function fecth_list_roles()
    {
        $data = DB::table('roles AS r')
            ->get();
        return $data;
    }

    public function create(Request $request)
    {
        $id = $request->id;
        $dataRoles = $this->fecth_list_roles();
        return view('user.form_user', compact('dataRoles'));
    }

    public function edit(Request $request)
    {
        $id = $request->id;
        $dataRoles = $this->fecth_list_roles();
        if ($id != "") {
            $data = User::find($id);
        }
        return view('user.form_user', compact('data', 'dataRoles'));
    }

    // public function uploadPhoto($prams)
    // {
    //     $path = 'assets/images/barang/';
    //     $file = $prams->file('product_image');
    //     $fileExist = $prams->img_preview;
    //     // echo(var_dump($request->file('product_image')));
    //     $file_name = $fileExist;
    //     if ($file) {
    //         $splitType = explode(".", $file->getClientOriginalName());
    //         $file_name = 'BRG_' . time() . '.' . $splitType[count($splitType) - 1];
    //         //    $upload = $file->storeAs($path, $file_name);
    //         $upload = $file->move($path, $file_name);
    //     }
    //     return $path . $file_name;
    // }

    public function add(Request $request)
    {
        try {
            $input = [
                'name' => $request->input('name'),
                'username' => $request->input('username'),
                'email' => $request->input('email'),
                'password' => $request->input('password'),
                'id_role' => $request->input('id_role'),
            ];
            $rules = [
                'name' => 'required',
                'username' => 'required',
                'email' => 'required',
                'password' => 'required',
                'id_role' => 'required',
            ];
            $messages = [
                'name.required' => 'Nama wajib diisi',
                'username.required' => 'Username wajib diisi',
                'email.required' => 'Email wajib diisi',
                'password.required' => 'Password wajib diisi',
                'id_role.required' => 'Role wajib diisi',
            ];

            $validator = Validator::make($input, $rules, $messages);
            if ($validator->fails()) {
                $response['success'] = false;
                $response['message'] = "Harap lengkapi isian dengan benar";
                return response()->json($response);
            }

            $password = $request->password;
            $hash_pass = Hash::make($password);
            // Handle Save
            $data = new User();
            $data->name = $request->name;
            $data->username = $request->username;
            $data->email = $request->email;
            $data->password = $hash_pass;
            $data->id_role = $request->id_role;
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
                'name' => $request->input('name'),
                'username' => $request->input('username'),
                'email' => $request->input('email'),
                'password' => $request->input('password'),
                'id_role' => $request->input('id_role'),
            ];
            $rules = [
                'name' => 'required',
                'username' => 'required',
                'email' => 'required',
                'password' => 'required',
                'id_role' => 'required',
                
            ];
            $messages = [
                'name.required' => 'Nama wajib diisi',
                'username.required' => 'Username wajib diisi',
                'email.required' => 'Email wajib diisi',
                'password.required' => 'Password wajib diisi',
                'id_role.required' => 'Rule wajib diisi',
            ];

            $validator = Validator::make($input, $rules, $messages);
            if ($validator->fails()) {
                $response['success'] = false;
                $response['message'] = "Harap lengkapi isian dengan benar";
                return response()->json($response);
            }

            $id = $request->id;
            User::where('id', $id)
                ->update([
                    'name' => $request->name,
                    'username' => $request->username,
                    'email' => $request->email,
                    // 'password' => $request->password,
                    'id_role' => $request->id_role,
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
        User::where("id", $id)->delete();
        $response['success'] = true;
        $response['message'] = "Data berhasil dihapus";
        return response()->json($response);
    }

    // Lookup Barang
    // public function lookup_barang(Request $request)
    // {
    //     $barang = DB::table('barang')->orderBy('nama', 'asc')->get();
    //     $data['barang'] = $barang;
    //     return view('lookup.lookup_barang', $data);
    // }

    // public function fetch_lookup_barang(Request $request)
    // {
    //     $limit = $request->get('limit');
    //     $sortBy = $request->get('sortby');
    //     $sortType = $request->get('sorttype');
    //     $q = $request->get('q');
    //     $q = str_replace(" ", "%", $q);

    //     $data = DB::table('barang as b')
    //         ->select('b.id_barang', 'b.nama', 'b.kode', 'jb.nama as jenis_barang')
    //         ->leftJoin('jenis_barang as jb', 'b.id_jenis_barang', '=', 'jb.id')
    //         ->where(DB::raw("concat(b.id_barang, b.nama, b.kode, jb.nama)"), 'like', '%' . $q . '%')
    //         ->orderBy($sortBy, $sortType)
    //         ->paginate($limit);

    //     $data->appends($request->all());
    //     return view('lookup.list_data_barang', compact('data'));
    // }
}
