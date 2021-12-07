@extends('layouts.main')
@section('content')
<div class="row">
  <div class="col-12">
    <div class="card flat">
      <div class="card-header card-header-blue">
          <span class="card-title">Transaksi Barang Keluar</span>
      </div>
      <div class="card-body">
        <form id="formData">
          @csrf
          <input type="hidden" name="id" id="id" value="{{ (isset($data)) ?  $data['id'] : '' }}">
          <input type="hidden" name="modeform" id="modeform" value="{{ $modeform }}">
          <div class="row mb-1">
            <label for="nomor_transaksi" class="col-sm-2 col-form-label">No Transaksi</label>
            <div class="col-sm-4">
              <input type="text" class="form-control form-control-sm" name="nomor_transaksi" id="nomor_transaksi" value="{{ (isset($data)) ?  $data['nomor_transaksi'] : $nomor_transaksi }}" readonly>
            </div>
          </div>
          <div class="row mb-1">
            <label for="tanggal" class="col-sm-2 col-form-label">Tanggal</label>
            <div class="col-sm-4">
              <input class="form-control  form-control-sm date-picker" id="tanggal" name="tanggal" data-date-format='dd-mm-yyyy' autocomplete="off" onkeypress="return false;"
              value="<?php
                      if(isset($data)){
                        $time = strtotime($data['tanggal']);
                        $tgl = date('d-m-Y', $time);
                        echo $tgl;
                      }else {
                        echo date('d-m-Y'); 
                      }?>" required>
            </div>
          </div>
          <div class="row mb-1">
            <label for="keterangan" class="col-sm-2 col-form-label">Keterangan</label>
            <div class="col-sm-8">
              <input type="text" class="form-control form-control-sm" name="keterangan" id="keterangan" placeholder="Keterangan" 
              value="{{ (isset($data)) ?  $data['keterangan'] : '' }}">
            </div>
          </div>
          <hr>
          <div id="list_detail">
            <h6>Rincian Transaksi</h6>
            <table class="table table-bordered" id="dataTableTransaksi" style="border:1px solid #ddd;">
              <thead class="tr-head">
                <th style="width:30%;">Nama Barang </th>
                <th style="width:10%;">Qty </th>
                <th style="width:20%;">Keterangan </th>
                <th style="width:5%;" class="text-center">Aksi </th>
              </thead>
              <tbody>
                {{-- Edit Rincian --}}
                @if (isset($data_detail))
                  @foreach ($data_detail as $row)
                    <tr>
                      <td><input type='hidden' name='barang[]' class='form-control form-control-sm' value='{{ $row->id_barang }}'><b>[{{ $row->kode_barang }}]</b> {{ $row->nama_barang }}</td>
                      <td><input type='text' name='qty[]' class='form-control form-control-sm' placeholder='Qty' value="{{ $row->jumlah }}" required></td>
                      <td><input type='text' name='keterangan_barang[]' class='form-control form-control-sm' value="{{ $row->keterangan }}" placeholder='Keterangan'></td>
                      <td class='text-center'><a href='javascript:;' onclick='deleteRow(this)' class='btn btn-sm btn-danger'><i class='fa fa-times-circle'></i></a></td>
                    </tr>
                  @endforeach
                @endif
              </tbody>
            </table>
            <a href="javascript:;" id="btn-add" class="btn btn-success"><i class="fa fa-plus-circle"></i> Tambah</a>           
            <input type="hidden" id="jumlah-row" value="0">
          </div>
          <hr>
          <div class="text-right">
            <a href="{{ url('/barang-keluar') }}" class="btn btn-secondary">Batal</a>           
            <button id="btn-save" type="submit" class="btn btn-primary"><i id="loading" class=""></i> Simpan</button>           
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

  function validateRow(val){
    let table = document.getElementById("dataTableTransaksi");
    let count = table.rows.length;
    let result = false;
    for (let i = 0; i < count; i++) {
      if(i!=0){
        const el = table.rows[i].cells[0];
        let input = el.getElementsByTagName('input')[0].value;
        if(input==val){
          result = true;
          break;
        }
      }
    }
    return result;
  }

  function addRows(val){
    let found = validateRow(val.id_barang);
    if(found){
      Swal.fire({icon: 'warning',title: 'Maaf',text: 'Barang sudah tersedia dalam item transaksi!'});
    }else{
      let jumlah = parseInt($("#jumlah-row").val()) + 1;
      let data = "<tr>"
        + "<td><input type='hidden' name='barang[]' class='form-control form-control-sm' value='" + val.id_barang + "'>" + "<b>[" + val.kode + "]</b> " + val.nama + "</td>"
        + "<td><input type='text' name='qty[]' class='form-control form-control-sm' placeholder='Qty' required></td>"
        + "<td><input type='text' name='keterangan_barang[]' class='form-control form-control-sm' placeholder='Keterangan'></td>"
        + "<td class='text-center'><a href='javascript:;' onclick='deleteRow(this)' class='btn btn-sm btn-danger'><i class='fa fa-times-circle'></i></a></td>"
        + "</tr>"; 
      $('#dataTableTransaksi').append(data);
      $("#jumlah-row").val(jumlah);
      $('#lookup_barang').modal('hide');
    }
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
    let url = (modeform=='ADD') ? '/barang-keluar/save' : '/barang-keluar/update';

    $("#loading").addClass("fa fa-spinner fa-spin");
    $('#btn-save').prop('disabled', true)
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
              setTimeout(function(){
                  Toast.fire({
                      icon: 'success',
                      title: data.message
                  });
                  
                  $("#loading").removeClass("fa fa-spinner fa-spin");
                  $('#btn-save').prop('disabled', false)
                  window.location.href = "{{ url('/barang-keluar') }}";
              }, 1000);
          } else {
              $("#loading").removeClass("fa fa-spinner fa-spin");
              $('#btn-save').prop('disabled', false)
              Swal.fire({icon: 'error',title: 'Maaf',text: data.message});
          }
        },
        fail: function (event) {
            alert(event);
        }
    });
  });
</script>
@endsection
