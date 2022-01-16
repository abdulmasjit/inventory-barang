$(document).ready(function() {
  fetch_data(1)
})

function fetch_data(page=1) {
  var id_role = $('#role').val();
  $.ajax({
    url: base_url + "/menu-user/fetch-data",
    type: 'GET',
    dataType: 'html',
    data: {
      id_role : id_role
    },
    beforeSend: function() {},
    success: function(result) {
        $('#list').html(result);
    }
  });
}

$('#btn-add').on('click', function() {
    $.ajax({
        url: base_url + "/menu-user/load-modal",
        type: 'GET',
        data : {},
        dataType: 'html',
        beforeSend: function() {},
        success: function(result) {
            $('#div_modal').html(result);
            $('#modeform').val('ADD');
            $('#formModal').modal('show');
        }
    });
});	

$(document).on('change', '#level', function(event) {
  var posisi=$(this).val();
    if(posisi=='1'){
      document.getElementById("parent").style.display = "block";
      document.getElementById("sub").style.display = "none";
    }else if(posisi=='2'){
      document.getElementById("sub").style.display = "block";    
      document.getElementById("parent").style.display = "block";
    }
});

$(document).on('change', '#parent_menu', function(event) {
    var parent_menu = $(this).val();
    $('#spinner_menu').addClass("fa fa-spin fa-spinner");
    $('#div-notif-menu').hide()
    $('#div-select-menu').show()
    $('#spinner_menu').removeClass();
});

$(document).on('submit', '#formData', function(event) {
  event.preventDefault();
  const modeform = $('#modeform').val();

  $.ajax({
      url: base_url + '/menu-user/save',
      method: 'POST',
      dataType: 'json',	
      data: new FormData($('#formData')[0]),
      async: true,
      processData: false,
      contentType: false,
      success: function (data) {
        if (data.success == true) {
            Toast.fire({
                icon: 'success',
                title: data.message
            });
            $('#formModal').modal('hide');
            fetch_data(1);
        } else {
            Swal.fire({icon: 'error',title: 'Oops...',text: data.message});
        }
      },
      fail: function (event) {
          alert(event);
      }
  });
});

$(document).on('click', '.btn-hapus', function(e) {
  var id = $(this).attr('data-id');
  var title = $(this).attr('data-name');
  var page = $('#hidden_page').val();

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
    preConfirm: function () {
      return new Promise(function (resolve) {
        $.ajax({
          method: 'GET',
          dataType: 'json',
          url: base_url + "/menu-user/delete/" + id,
          data: {},
          success: function (data) {
            if (data.success === true) {
              Toast.fire({
                icon: 'success',
                title: data.message
              });
              swal.hideLoading()
              fetch_data(page);
            } else {
              Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: data.message
              });
            }
          },
          fail: function (e) {
            alert(e);
          }
        });
      });
    },
    allowOutsideClick: false
  });
  e.preventDefault();
});

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
        fetch_data(1);
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