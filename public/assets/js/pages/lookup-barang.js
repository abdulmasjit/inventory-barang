$(document).on('click', '.pagination-lookup a', function(event) {
  event.preventDefault();
  var page = $(this).attr('href').split('page=')[1];
  $('#lookup_page').val(page);
  fetch_data(page);
});

function fetch_data(page) {
  var cari = $('#cari').val();
  var limit = $('#limit').val();
  var id_th = $('#lookup_id_th').val();
  var column_name = $('#lookup_column_name').val();
  var sort_type = $('#lookup_sort_type').val();
  $.ajax({
    url: base_url + "/lookup-barang/fetch-data",
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
        $('#list-lookup').html(result);
        sort_finish(id_th,sort_type);
    }
  });
}

function sort_table(id, column){
  var sort = $(id).attr("data-sort");
  $('#lookup_id_th').val(id);
  $('#lookup_column_name').val(column);
  
  if(sort=="asc"){
      sort = 'desc';
  }else if(sort=="desc"){
      sort = 'asc';
  }else{
      sort = 'asc';
  }
  $('#lookup_sort_type').val(sort);
  $('#lookup_page').val(1);
  fetch_data(1);
}