<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;

class MenuUser extends Model
{
    use HasFactory;
    protected $table = "menu_user";
    protected $primaryKey = 'id_menu_user';

    function getRoles(){
      $query = DB::table('roles')->select('id_role', 'nama')->get();
      return $query;
    }

    function get_sub_menu($id_parent_menu){
      $query = DB::table('menu')->where('id_parent', $id_parent_menu)->get();
      return $query;
    }

    function get_menu_max_level1($id_role="", $level="1"){
      $query = DB::select("
            select coalesce(max(urutan),0) as urutan from menu_user where id_role = '$id_role' and level = '$level'
            order by urutan asc
      ");
      return $query;
    }

    function get_menu_max_level2($id_role="", $id_parent_menu="", $level="2"){
        $query = DB::select("
            select coalesce(max(urutan),0) as urutan from menu_user 
            where id_role = '$id_role' and id_parent_menu = '$id_parent_menu' and level = '$level'
            order by urutan asc
        ");
        return $query;
    }

    function getDataMenuUser($id_role){
      $menu1 = DB::select("
          select mu.id_menu_user, m.id_menu, m.nama_menu, mu.level, mu.urutan from menu_user mu
          join menu m on mu.id_menu = m.id_menu
          where mu.id_role = '$id_role' and  level = 1 
          order by mu.urutan asc
      ");
      
      $data = [];
      foreach ($menu1 as $row) {
          $id_menu_parent = $row->id_menu;
          $qmenu = DB::select("
              select mu.id_menu_user, m.id_menu, m.nama_menu, mu.level, mu.urutan from menu_user mu
              join menu m on mu.id_menu = m.id_menu
              where mu.id_role = '$id_role' and level = 2 and id_parent_menu = '$id_menu_parent' 
              order by mu.urutan asc"
          );

          $menu2 = (count($qmenu)>0) ? $qmenu : [];
          $data [] = array(
            'id_menu_user' => $row->id_menu_user,
            'id_menu' => $row->id_menu,
            'nama_menu' => $row->nama_menu,
            'level' => $row->level,
            'urutan' => $row->urutan,
            'sub_menu' => $menu2
          );
      }
      
      $ArrToObject = json_decode(json_encode($data), FALSE);
      return $ArrToObject;  
    }
}
