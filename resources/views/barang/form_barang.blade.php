@extends('layouts.main')
@section('content')
<div class="card">
  <div class="card-header">
    Tambah Barang
  </div>
  <div class="card-body">
    <form class="" id="formData" method="POST">
      <input type="hidden" name="id_barang" id="id_barang" value="{{ isset($data) ? $data['id_barang'] : '' }}" />
      <div class="row gap-3">
        <div class="col-lg-6">
          <div class="mb-3">
            <label for="kode" class="form-label">Kode</label>
            <input id="kode" name="kode" class="form-control" type="text" class="w-full" value="{{ isset($data) ? $data['kode'] : '' }}" required />
          </div>
          <div class="mb-3">
            <label for="nama" class="form-label">Nama</label>
            <input id="nama" name="nama" class="form-control" type="text" class="w-full" value="{{ isset($data) ? $data['nama'] : '' }}" required />
          </div>
          <div class="mb-3">
            <label for="id_jenis_barang">Jenis Barang</label>
            <select id="id_jenis_barang" name="id_jenis_barang" class="form-control" required>
              <option value="0" disabled="true" selected="true">Pilih Jenis Barang</option>
              @foreach ($dataTypeItems as $dataTypeItem)
              @if(isset($data))
              <option value="{{ $dataTypeItem->id }}" <?php if ($dataTypeItem->id == $data['id_jenis_barang']) : ?> selected="selected" <?php endif; ?>>{{ $dataTypeItem->nama }}</option>
              @else
              <option value="{{ $dataTypeItem->id }}">{{ $dataTypeItem->nama }}</option>
              @endif
              @endforeach
            </select>
          </div>
          <div class="mb-3">
            <label for="id_satuan">Satuan Barang</label>
            <select id="id_satuan" name="id_satuan" class="form-control" required>
              <option value="0" disabled="true" selected="true">Pilih Satuan Barang</option>
              @foreach ($dataUnits as $dataUnit)
              @if(isset($data))
              <option value="{{ $dataUnit->id }}" <?php if ($dataUnit->id == $data['id_satuan']) : ?> selected="selected" <?php endif; ?>>{{ $dataUnit->nama }}</option>
              @else
              <option value="{{ $dataUnit->id }}">{{ $dataUnit->nama }}</option>
              @endif
              @endforeach
            </select>
          </div>
        </div>
        <div class="col-lg-6">
          <div class="mb-3">
            <label for="harga_jual" class="form-label">Harga Jual</label>
            <input id="harga_jual" name="harga_jual" class="form-control" type="number" class="w-full" value="{{ isset($data) ? $data['harga_jual'] : '' }}" required />
          </div>
          <div class="mb-3">
            <label for="harga_beli" class="form-label">Harga Beli</label>
            <input id="harga_beli" name="harga_beli" class="form-control" type="number" class="w-full" value="{{ isset($data) ? $data['harga_beli'] : '' }}" required />
          </div>
          <div class="mb-3">
            <label for="stok" class="form-label">Stok</label>
            <input id="stok" name="stok" class="form-control" type="number" class="w-full" value="{{ isset($data) ? $data['stok'] : '' }}" required />
          </div>
          <div class="mb-3">
            <label for="deskripsi" class="form-label">Deskripsi</label>
            <textarea id="deskripsi" name="deskripsi" class="form-control" class="w-full" value="{{ isset($data) ? $data['deskripsi'] : null }}" required />
            </textarea>
          </div>
        </div>
      </div>
      <div class="d-flex justify-content-end mt-2">
        <a href="/master/barang" class="btn btn-secondary mr-3">Batal</a>
        <button class="btn btn-primary float-end" type="submit">Simpan</button>
      </div>
    </form>
  </div>
</div>
@endsection
@section('js')
<script>
  $(document).ready(function() {
    // fetch_data(1)
    $(document).on('change', '#id_jenis_barang', function() {
      var air_id = $('#id_jenis_barang').val();
    })
  })
  $(document).on('submit', '#formData', function(event) {
    event.preventDefault();
    const modeform = $('#modeform').val();
    if ($('#id_barang').val() !== '') {
      var url = "/barang/update";
    } else {
      var url = "/barang/add";
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
          location.href = base_url + `/master/barang`
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
</script>
@endsection