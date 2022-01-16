<?php

namespace App\Http\Controllers;

use Validator;
use App\Models\MenuUser;
use App\Models\JenisBarang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;
date_default_timezone_set('Asia/Jakarta');

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

    public function load_modal(Request $request)
    {
      $id = $request->id;
      $data['role'] = $this->m_menu_user->getRoles();	
      $data['parent_menu'] = DB::table('menu')->where('is_parent', '1')->get();
      $data['sub_menu'] = DB::table('menu')->where('is_parent', '2')->get();

      if ($id != "") {
        $data['mode'] = "UPDATE";
        $data['data'] = "";	
      } else {
        $data['mode'] = "ADD";
      }
      return view('menu_user/form_modal', $data);
    }

    public function fetch_data(Request $request)
    {
        $id_role = $request->post('id_role');
        $menu = ($id_role!="") ? $this->m_menu_user->getDataMenuUser($id_role) : [];
        $data['menu'] = $menu;
        return view("menu_user/list_data", $data);
    }

    public function save(Request $request)
	  {
      try {
        $id_role = $request->hak_akses;
        $id_posisi = $request->posisi;
        $parent_menu = $request->parent_menu;
        $level = $request->level;

        if($level=='1'){ 
          $max_menu = $this->m_menu_user->get_menu_max_level1($id_role);
          $urutan = intval($max_menu[0]->urutan) + 1;
          $data_object = array( 
              'id_menu'       => $parent_menu,
              'id_role'       => $id_role,
              'id_posisi'     => '1',
              'urutan'        => $urutan,
              'level'         => $level,
              'created_at'    => date('Y-m-d H:i:s'),
              'updated_at'    => date('Y-m-d H:i:s'),
          );
          $this->m_menu_user->insert($data_object);
          $response['success'] = TRUE;
          $response['message'] = "Data menu berhasil disimpan";
        }else{
          // Sub Menu
          $sub_menu = $request->menu;
          if($sub_menu==""){
            $response['success'] = FALSE;
            $response['message'] = "Harap pilih sub menu !";        
          }else{
            $max_menu = $this->m_menu_user->get_menu_max_level2($id_role, $parent_menu);
            $urutan = intval($max_menu[0]->urutan) +1;
            foreach($sub_menu as $menu){
                $dataMenu[] = array( 
                    'id_menu'         => $menu,
                    'id_role'         => $id_role,
                    'id_posisi'       => '1',
                    'urutan'          => $urutan,
                    'id_parent_menu'  => $parent_menu,
                    'level'           => $level,
                    'created_at'      => date('Y-m-d H:i:s'),
                    'updated_at'      => date('Y-m-d H:i:s'),
                );
                $urutan++;
            }

            $this->m_menu_user->insert($dataMenu);   
            $response['success'] = TRUE;
            $response['message'] = "Data menu berhasil disimpan";         
          }
        } 

        return response()->json($response);
      } catch (Exception $e) {
        $response['success'] = false;
        $response['message'] = "Data gagal disimpan";
        return response()->json($response);
      }
    }

    public function delete($id)
    { 
        DB::table('menu_user')->where('id_menu_user', $id)->delete();
        $response['success'] = true;
        $response['message'] = "Data berhasil dihapus";
        return response()->json($response);
    }

    public function reorder_menu(Request $request)
    {
      try {
        $id_current_menu = $request->current_menu;
        $data_current_menu = $this->m_menu_user->find($id_current_menu);
        
        $id_change_menu = $request->change_menu;
        $data_change_menu = $this->m_menu_user->find($id_change_menu);

        // current menu
        $object_current_menu = array(
            'urutan'=>$data_change_menu['urutan'],
        );
        $this->m_menu_user->where('id_menu_user', $id_current_menu)->update($object_current_menu);

        // change menu
        $object_change_menu = array(
            'urutan'=>$data_current_menu['urutan'],
        );
        $this->m_menu_user->where('id_menu_user', $id_change_menu)->update($object_change_menu);

        $response['message'] = "Berhasil mengurutkan menu";            
        $response['success'] = TRUE;
        return response()->json($response);
      } catch (Exception $e) {
        $response['success'] = false;
        $response['message'] = "Gagal mengurutkan menu";
        return response()->json($response);
      }
    }
}
