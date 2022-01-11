@extends('layouts.main')
@section('content')
<div class="row">
  <div class="col-12">
    <div class="card flat">
      <div class="card-header card-header-blue">
          <span class="card-title">Transaksi Mutasi Stok</span>
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
              value="{{ (isset($data)) ?  $data['keterangan'] : '' }}" required>
            </div>
          </div>
          <div class="row mb-1">
            <label for="barang" class="col-sm-2 col-form-label">Barang</label>
            <div class="col-sm-5">
              <select class="form-control form-control-sm" name="barang" id="barang" required>
                <option value="">Pilih Barang</option>
                @foreach ($barang as $b)
                  <option 
                    @if (isset($data))
                      @if ($data['id_barang'] == $b->id_barang)
                        {{ 'selected ' }}
                      @endif
                    @endif
                  value="{{ $b->id_barang }}">[{{ $b->kode }}] {{ $b->nama }}</option>  
                @endforeach
              </select>
            </div>
          </div>
          <div class="row mb-1">
            <label for="jenis_mutasi" class="col-sm-2 col-form-label">Jenis</label>
            <div class="col-sm-5">
              <select class="form-control form-control-sm" name="jenis_mutasi" id="jenis_mutasi" required>
                <option value="">Pilih Jenis</option>
                <?php 
                $array_jenis=array(
                    '1' => 'MUTASI STOK',
                    '2' => 'BARANG RUSAK',
                    '3' => 'BARANG HILANG'
                );
                ?>
                @foreach ($array_jenis as $key => $value)
                    <option 
                    @if (isset($data))
                      @if ($data['jenis'] == $key)
                        {{ 'selected ' }}
                      @endif
                    @endif
                    value="{{ $key }}">{{ $value }}</option>    
                @endforeach
              </select>
            </div>
          </div>
          <div class="row mb-1">
            <label for="qty" class="col-sm-2 col-form-label">Jumlah</label>
            <div class="col-sm-3">
              <input type="number" class="form-control form-control-sm" name="qty" id="qty" placeholder="Jumlah" 
              value="{{ (isset($data)) ?  $data['qty'] : '' }}" required>
            </div>
          </div>
          
          <hr>
          <div class="text-right">
            <a href="{{ url('/mutasi-stok') }}" class="btn btn-secondary">Batal</a>           
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

  $(document).on('submit', '#formData', function(event) {
    event.preventDefault();
    const modeform = $('#modeform').val();
    let url = (modeform=='ADD') ? '/mutasi-stok/save' : '/mutasi-stok/update';

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
                  window.location.href = "{{ url('/mutasi-stok') }}";
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
