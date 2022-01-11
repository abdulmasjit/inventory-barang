<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Models\Supplier;
use App\Models\Barang;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $query1 = DB::select("SELECT COUNT(*) AS jml FROM users");
        $query2 = DB::select("SELECT COUNT(*) AS jml FROM barang");
        $query3 = DB::select("SELECT COUNT(*) AS jml FROM supplier");

        $data = array(
            'total_user' => $query1[0]->jml,
            'total_barang' => $query2[0]->jml,
            'total_supplier' => $query3[0]->jml
        );
        return view('dashboard/dashboard', compact('data'));
    }
}
