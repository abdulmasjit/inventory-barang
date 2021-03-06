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
    url: base_url + "/user/fetch-data",
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
$(document).on('click', '.btn-ubah', function(event) {
  event.preventDefault();
  var id = $(this).attr('data-id');
  location.href = base_url + `/setting/user-edit/${id}`
});
$(document).on('click', '.btn-hapus', function(e) {
  var id = $(this).attr('data-id');
  var title = $(this).attr('data-name');
  var page = $('#hidden_page').val();

  Swal.fire({
    title: 'Hapus User',
    text: "Apakah Anda yakin menghapus data ?",
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
          url: base_url + "/user/delete/" + id,
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
  if ($('#id').val() !== '') {
    var url = "/user/update";
  } else {
    var url = "/user/add";
  }

  $.ajax({
    url: base_url + url,
    method: 'POST',
    dataType: 'json',
    data: new FormData($('#formData')[0]),
    async: true,
    processData: false,
    contentType: false,
    success: function(data) {
      console.log('after ', data)
      if (data.success == true) {
        Toast.fire({
          icon: 'success',
          title: data.message
        });
        // $('#formModal').modal('hide');
        // fetch_data(1);
        location.href = base_url + `/setting/user`
      } else {
        Swal.fire({
          icon: 'error',
          title: 'Oops...',
          text: data.message
        });
      }
    },
    fail: function(event) {
      alert(event);
    }
  });
});
