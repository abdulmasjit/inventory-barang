<div class="table-responsive">
  <table class="table table-bordered table-hover" style="font-size: 15px !important;">
    <thead class="tr-head">
      <tr>
        <th width="40%" class="text-left">Nama Menu </th>
        <th width="15%" class="text-center">Level Menu</th>
        <th width="10%" class="text-center">Urutan</th>
        <th width="10%" class="text-center">Aksi</th>
      </tr>
    </thead>
    <?php 
      $count_menu = count($menu);
      if($count_menu>0){
    ?>
    <tbody>
      <?php 
          $no=0; 
          $no_sebelumnya = 0;
          $no_selanjutnya = 0;
          $for_menu = $menu;
          foreach ($menu as $row) {
            $count_sub = count($row->sub_menu); 
            $sub_menu = $row->sub_menu; 
            $index_sebelumnya = $no_sebelumnya-1;
            $show_btn_sebelumnya = TRUE;
            if($index_sebelumnya<0){
                $index_sebelumnya ="";
                $show_btn_sebelumnya = FALSE;
            }

            $index_setelahnya = $no_selanjutnya+1;
            $show_btn_setelahnya = TRUE;
            if($count_menu <= $index_setelahnya){
                $index_setelahnya ="";
                $show_btn_setelahnya = FALSE;
            }  
          ?>
      <tr>
        <td><?= $row->nama_menu ?></td>
        <td style="text-align:center;">-</td>
        <td class="text-center"><?= $row->urutan ?></td>
        <td class="text-center">
          <?php if($show_btn_sebelumnya==TRUE){ ?>
            <a href="javascript:;" data-id="<?=$row->id_menu_user?>" data-name="<?=$row->nama_menu?>"
              onclick="reorderMenu('<?=$row->id_menu_user?>','<?=$for_menu[$index_sebelumnya]->id_menu_user?>')"
              class="btn btn-sm btn-icon btn-success waves-effect waves-light btn-up" data-toggle="tooltip"
              title="Up Menu"><i class="fa fa-arrow-up"></i></a>
          <?php } ?>
          <?php if($show_btn_setelahnya==TRUE){ ?>
            <a href="javascript:;" data-id="<?=$row->id_menu_user?>" data-name="<?=$row->nama_menu?>"
              onclick="reorderMenu('<?=$row->id_menu_user?>','<?=$for_menu[$index_setelahnya]->id_menu_user?>')"
              class="btn btn-sm btn-icon btn-success waves-effect waves-light btn-down" data-toggle="tooltip"
              title="Down Menu"><i class="fa fa-arrow-down"></i></a>
          <?php } ?>
          <?php if($count_sub==0){ ?>
            <a href="javascript:;" data-id="<?=$row->id_menu_user?>" data-name="<?=$row->nama_menu?>"
              class="btn btn-sm btn-icon btn-danger waves-effect waves-light btn-hapus" data-toggle="tooltip"
              title="Hapus Menu"><i class="fa fa-trash"></i></a>
          <?php } ?>
        </td>
      </tr>
      <?php   
        $nosub = 0;
        $no_sub_sebelumnya = 0;
        $no_sub_selanjutnya = 0; 
        if($count_sub>0){ 
          foreach ($sub_menu as $sub) { 
            $index_sub_sebelumnya = $no_sub_sebelumnya-1;
            $show_btnsub_sebelumnya = TRUE;
            if($index_sub_sebelumnya<0){
                $index_sub_sebelumnya ="";
                $show_btnsub_sebelumnya = FALSE;
            }

            $index_sub_setelahnya = $no_sub_selanjutnya+1;
            $show_btnsub_setelahnya = TRUE;
            if($count_sub <= $index_sub_setelahnya){
                $index_sub_setelahnya ="";
                $show_btnsub_setelahnya = FALSE;
            }     
      ?>
      <tr>
        <td style="padding-left:45px !important;"><?= $sub->nama_menu ?></td>
        <td style="text-align:center;">Sub Menu <?= $row->nama_menu ?></td>
        <td class="text-center"><?= $sub->urutan ?></td>
        <td class="text-center">
          <?php if($show_btnsub_sebelumnya==TRUE){ ?>
          <a href="javascript:;" data-id="<?=$row->id_menu_user?>" data-name="<?=$row->nama_menu?>"
            onclick="reorderMenu('<?=$sub->id_menu_user?>','<?= $sub_menu[$index_sub_sebelumnya]->id_menu_user?>')"
            class="btn btn-sm btn-icon btn-warning waves-effect waves-light btn-up" data-toggle="tooltip"
            title="Up Menu"><i class="fa fa-arrow-up"></i></a>
          <?php } ?>
          <?php if($show_btnsub_setelahnya==TRUE){ ?>
          <a href="javascript:;" data-id="<?=$row->id_menu_user?>" data-name="<?=$row->nama_menu?>"
            onclick="reorderMenu('<?=$sub->id_menu_user?>','<?= $sub_menu[$index_sub_setelahnya]->id_menu_user?>')"
            class="btn btn-sm btn-icon btn-warning waves-effect waves-light btn-down" data-toggle="tooltip"
            title="Down Menu"><i class="fa fa-arrow-down"></i></a>
          <?php } ?>
          <a href="javascript:;" data-id="<?=$sub->id_menu_user?>" data-name="<?=$sub->nama_menu?>"
            class="btn btn-sm btn-icon btn-danger waves-effect waves-light btn-hapus" data-toggle="tooltip"
            title="Hapus Menu"><i class="fa fa-trash"></i></a>
        </td>
      </tr>
      <?php 
                $nosub++;
                $no_sub_sebelumnya++;
                $no_sub_selanjutnya++;
              }
            }
        $no++;
        $no_sebelumnya++;
        $no_selanjutnya++;
        } 
      ?>
    </tbody>
    <?php }else{ ?>
    <tr>
      <td colspan="4">Data tidak ditemukan !</td>
    </tr>
    <?php } ?>
  </table>
</div>
<script>
function reorderMenu(menu_1, menu_2) {
  $.ajax({
    url: base_url + '/menu-user/reorder-menu',
    method: 'POST',
    dataType: 'json',
    data: {
      current_menu: menu_1,
      change_menu: menu_2,
    },
    success: function(data) {
      if (data.success == true) {
        Toast.fire({
          icon: 'success',
          title: data.message
        });
        pageLoad();
      } else {
        Swal.fire({
          icon: 'error',
          title: 'Oops...',
          text: data.message
        });
      }
    },
    fail: function(e) {
      alert(e);
    }
  });
}

$('.btn-hapus').click(function(e) {
  var id = $(this).attr('data-id');
  var title = $(this).attr('data-name');

  Swal.fire({
    title: 'Hapus Menu',
    text: "Apakah Anda yakin data ?",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#d33',
    cancelButtonColor: '#95a5a6',
    confirmButtonText: 'Hapus',
    cancelButtonText: 'Batal',
    showLoaderOnConfirm: true,
    preConfirm: function() {
      return new Promise(function(resolve) {
        $.ajax({
          method: 'POST',
          dataType: 'json',
          url: base_url + '/menu-user/delete',
          data: {
            id: id
          },
          success: function(data) {
            if (data.success === true) {
              Toast.fire({
                icon: 'success',
                title: data.message
              });
              swal.hideLoading()
              pageLoad(1);
            } else {
              Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: data.message
              });
            }
          },
          fail: function(e) {
            alert(e);
          }
        });
      });
    },
    allowOutsideClick: false
  });
  e.preventDefault();
});
</script>