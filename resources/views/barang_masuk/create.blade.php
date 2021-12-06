@extends('layouts.main')
@section('content')
<div class="row">
  <div class="col-12">
    <div class="card flat">
      <div class="card-header card-header-blue">
          <span class="card-title">Barang Masuk</span>
      </div>
      <div class="card-body">
        <form id="formData">
          @csrf
          <div class="row mb-1">
            <label for="nomor_transaksi" class="col-sm-2 col-form-label">No Transaksi</label>
            <div class="col-sm-4">
              <input type="text" class="form-control form-control-sm" name="nomor_transaksi" id="nomor_transaksi" value="{{ $nomor_transaksi }}" readonly>
            </div>
          </div>
          <div class="row mb-1">
            <label for="tanggal" class="col-sm-2 col-form-label">Tanggal</label>
            <div class="col-sm-4">
              <input class="form-control  form-control-sm date-picker" id="tanggal" name="tanggal" data-date-format='dd-mm-yyyy' autocomplete="off" onkeypress="return false;"
              value="<?php echo date('d-m-Y'); ?>" required>
            </div>
          </div>
          <div class="row mb-1">
            <label for="supplier" class="col-sm-2 col-form-label">Supplier</label>
            <div class="col-sm-5">
              <select class="form-control form-control-sm" name="supplier" id="supplier" required>
                <option value="">Pilih Supplier</option>
                @foreach ($supplier as $s)
                  <option value="{{ $s->id }}">[{{ $s->kode }}] {{ $s->nama }}</option>  
                @endforeach
              </select>
            </div>
          </div>
          <div class="row mb-1">
            <label for="keterangan" class="col-sm-2 col-form-label">Keterangan</label>
            <div class="col-sm-8">
              <input type="text" class="form-control form-control-sm" name="keterangan" id="keterangan" placeholder="Keterangan">
            </div>
          </div>
          <hr>
          <div id="list_detail">
            <table class="table table-bordered" id="dataTableTransaksi" style="border:1px solid #ddd;">
              <thead class="tr-head">
                <th style="width:20%;">Nama Barang </th>
                <th style="width:10%;">Qty </th>
                <th style="width:20%;">Keterangan </th>
                <th style="width:5%;" class="text-center">Aksi </th>
              </thead>
              <tbody>
              </tbody>
            </table>
            <a href="javascript:;" id="btn-add" class="btn btn-success"><i class="fa fa-plus-circle"></i> Tambah</a>           
            <input type="hidden" id="jumlah-row" value="0">
          </div>
          <hr>
          <div class="text-right">
            <a href="{{ url('/barang-masuk') }}" class="btn btn-secondary">Batal</a>           
            <button type="submit" class="btn btn-primary">Simpan</button>           
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<div id="div_modal"></div>
@endsection
@section('js')
<script>
  $(document).ready(function() {
    
  })

  $('.date-picker').datepicker({
      autoclose: true,
  });

  function selectRow(payload){
    addRows(payload)
  }

  $('#btn-add').on('click', function() {
      $.ajax({
          url: base_url + "/lookup-barang",
          type: 'GET',
          data : {},
          dataType: 'html',
          beforeSend: function() {},
          success: function(result) {
              $('#div_modal').html(result);
              $('#lookup_barang').modal('show');
          }
      });
  });

  function addRows(val){
    let jumlah = parseInt($("#jumlah-row").val()) + 1;
    let data = "<tr>"
      + "<td><input type='hidden' name='barang[]' class='form-control form-control-sm' value='" + val.id_barang + "'>" + "<b>[" + val.kode + "]</b> " + val.nama + "</td>"
      + "<td><input type='text' name='qty[]' class='form-control form-control-sm' placeholder='Qty'></td>"
      + "<td><input type='text' name='keterangan_barang[]' class='form-control form-control-sm' placeholder='Keterangan'></td>"
      + "<td class='text-center'><a href='javascript:;' onclick='deleteRow(this)' class='btn btn-sm btn-danger'><i class='fa fa-times-circle'></i></a></td>"
      + "</tr>"; 
    $('#dataTableTransaksi').append(data);
    $("#jumlah-row").val(jumlah);
    $('#lookup_barang').modal('hide');
  }

  function deleteRow(r) {
    var jumlah = parseInt($("#jumlah-row").val()); 
    var moverow = jumlah - 1; 
    var i = r.parentNode.parentNode.rowIndex;
    document.getElementById("dataTableTransaksi").deleteRow(i);
    $("#jumlah-row").val(moverow);
  }

  $(document).on('submit', '#formData', function(event) {
    event.preventDefault();
    const modeform = $('#modeform').val();
    var url = "/barang-masuk/save";
  
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
              setTimeout(function(){
                  window.location.href = "{{ url('/barang-masuk') }}";
              }, 1000);
          } else {
              Swal.fire({icon: 'error',title: 'Oops...',text: data.message});
          }
        },
        fail: function (event) {
            alert(event);
        }
    });
  });
</script>
@endsection
