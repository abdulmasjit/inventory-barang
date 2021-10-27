$(document).ready(function() {
  fetch_data(1)
})

$('#cari').on('keypress', function(e) {
  if (e.which == 13) {
    fetch_data(1);
  }
});

$(document).on('click', '.pagination a', function(event) {
  event.preventDefault();
  var page = $(this).attr('href').split('page=')[1];
  $('#hidden_page').val(page);
  fetch_data(page);
});

function fetch_data(page) {
  var cari = $('#cari').val();
  var limit = $('#limit').val();
  var id_th = $('#hidden_id_th').val();
  var column_name = $('#hidden_column_name').val();
  var sort_type = $('#hidden_sort_type').val();
  $.ajax({
    url: base_url + "/jenis-barang/fetch-data",
    type: 'GET',
    dataType: 'html',
    data: {
      page : page,
      sortby : column_name,
      sorttype : sort_type,
      limit : limit,
      q : cari,
    },
    beforeSend: function() {},
    success: function(result) {
        $('#list').html(result);
        sort_finish(id_th,sort_type);
    }
  });
}

function sort_table(id, column){
  var sort = $(id).attr("data-sort");
  $('#hidden_id_th').val(id);
  $('#hidden_column_name').val(column);
  
  if(sort=="asc"){
      sort = 'desc';
  }else if(sort=="desc"){
      sort = 'asc';
  }else{
      sort = 'asc';
  }
  $('#hidden_sort_type').val(sort);
  $('#hidden_page').val(1);
  fetch_data(1);
}

$('#btn-tambah').on('click', function() {
    $.ajax({
        url: base_url + "/jenis-barang/load-modal",
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

$(document).on('click', '.btn-ubah', function(event) {
  event.preventDefault();
  var id = $(this).attr('data-id');
  $.ajax({
    url: base_url + "/jenis-barang/load-modal",
    type: 'get',
    dataType: 'html',
    data:{id:id},
    beforeSend: function () {},
    success: function (result) {    
      $('#div_modal').html(result);
      $('#modeform').val('UPDATE');
      $('#formModal').modal('show');
    }
  });
});

$(document).on('click', '.btn-hapus', function(e) {
  var id = $(this).attr('data-id');
  var title = $(this).attr('data-name');
  var page = $('#hidden_page').val();

  Swal.fire({
    title: 'Hapus Jenis Barang',
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
          url: base_url + "/jenis-barang/delete/" + id,
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

$(document).on('submit', '#formData', function(event) {
  event.preventDefault();
  const modeform = $('#modeform').val();
  if(modeform=='ADD'){
    var url = "/jenis-barang/save";
  }else{
    var url = "/jenis-barang/update";
  }

  $.ajax({
      url: base_url + url,
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