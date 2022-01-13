$(document).ready(function() {
  fetch_data(1)
})

function fetch_data(page=1) {
  var id_role = $('#role').val();
  $.ajax({
    url: base_url + "/menu-user/fetch-data",
    type: 'POST',
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
