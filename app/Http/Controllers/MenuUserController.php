<?php

namespace App\Http\Controllers;

use Validator;
use App\Models\MenuUser;
use App\Models\JenisBarang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MenuUserController extends Controller
{
    public function __construct()
    {
      $this->m_menu_user = new MenuUser();
    }

    public function index(Request $request)
    {   
        $data['role'] = $this->m_menu_user->getRoles();
        return view('menu_user.index', $data);
    }

    public function fetch_data(Request $request)
    {
        $id_role = $request->post('id_role');
        $menu = ($id_role!="") ? $this->m_menu_user->getDataMenuUser($id_role) : [];
        $data['menu'] = $menu;
        return view("menu_user/list_data", $data);
    }
}
