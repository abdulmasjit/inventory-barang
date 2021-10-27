<?php 
  $role = Auth::user()->id_role;
  $menu1 = DB::select("
      select m.* from menu_user mu
      join menu m on mu.id_menu = m.id_menu
      where mu.id_role = '$role' and  level = 1 
      order by mu.urutan asc
  ");
?>

<nav class="sidebar sidebar-offcanvas" id="sidebar">
  <ul class="nav">
    @foreach ($menu1 as $m1)
      <?php
         $id_menu_level_1 = $m1->id_menu;
         $menu2 = DB::select(" 
              select m.* from menu_user mu
              join menu m on mu.id_menu = m.id_menu
              where mu.id_role = '$role' and level = 2 and id_parent_menu = '$id_menu_level_1' 
              order by mu.urutan asc
         ");

         $jml_sub = count($menu2);
      ?>

      @if ($jml_sub>0)
        <li class="nav-item">
          <a class="nav-link" data-toggle="collapse" href="#ui-basic" aria-expanded="false" aria-controls="ui-basic">
            <i class="icon-layout menu-icon"></i>
            <span class="menu-title">{{ $m1->nama_menu }}</span>
            <i class="menu-arrow"></i>
          </a>
          <div class="collapse" id="ui-basic">
            <ul class="nav flex-column sub-menu">
              @foreach ($menu2 as $m2)
                <li class="nav-item"> <a class="nav-link" href="{{ $m2->link_menu }}">{{ $m2->nama_menu }}</a></li>
              @endforeach
            </ul>
          </div>
        </li>
      @else
        <li class="nav-item">
          <a class="nav-link" href="{{ $m1->link_menu }}">
            <i class="icon-grid menu-icon"></i>
            <span class="menu-title">{{ $m1->nama_menu }}</span>
          </a>
        </li>
      @endif
    @endforeach
  </ul>
</nav>