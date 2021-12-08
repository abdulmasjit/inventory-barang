@extends('layouts.main')
@section('content')
<div class="card">
  <div class="card-header">
    Tambah Barang
  </div>
  <div class="card-body">
    <form class="" id="formData" method="POST" enctype="multipart/form-data">
      <div class="center">
        <div class="form-input-container">
          <div class="d-flex justify-content-center">
            <input type="hidden" value="{{ isset($data) ? $data['foto'] : '' }}" id="img_preview" name="img_preview" style=" max-width: 300px; margin-bottom: 10px;">
            <div class="img-holder"></div>
          </div>
          <div class="form-input">
            <label for="product_image">Upload Image</label>
            <!-- <input type="file" id="file-ip-1" accept="image/*" onchange="showPreview(event);"> -->
            <input type="file" name="product_image" id="product_image" accept="image/*">

          </div>
        </div>
      </div>
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
  var img_preview = $('#img_preview');
  var img_holder = $('.img-holder');
  $(document).ready(function() {
    // fetch_data(1)
    $(document).on('change', '#id_jenis_barang', function() {
      var air_id = $('#id_jenis_barang').val();
    })
    // console.log('lklk', $('#img_preview'))
    if (img_preview.val()) {
      $('<img/>', {
        'src': `/storage/files/barang/${img_preview.val()}`,
        'class': 'img-fluid',
        'style': 'max-width:300px;margin-bottom:10px;'
      }).appendTo(img_holder);
      img_holder.show();
    }
  })
  //Reset input file
  $('input[type="file"][name="product_image"]').val('');
  //Image preview
  $('input[type="file"][name="product_image"]').on('change', function() {
    var img_path = $(this)[0].value;
    var img_holder = $('.img-holder');
    var img_preview = $('#img_preview');
    var extension = img_path.substring(img_path.lastIndexOf('.') + 1).toLowerCase();
    console.log(img_preview.val())
    if (extension == 'jpeg' || extension == 'jpg' || extension == 'png') {
      if (typeof(FileReader) != 'undefined') {
        img_holder.empty();
        var reader = new FileReader();
        reader.onload = function(e) {
          $('<img/>', {
            'src': e.target.result,
            'class': 'img-fluid',
            'style': 'max-width:300px;margin-bottom:10px;'
          }).appendTo(img_holder);
        }
        img_holder.show();
        $('input[name="img_preview"]').val('');
        reader.readAsDataURL($(this)[0].files[0]);
      } else {
        $(img_holder).html('This browser does not support FileReader');
      }
    } else {
      $(img_holder).empty();
    }
  });
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
          // location.href = base_url + `/master/barang`
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

<style>
  .center {
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;

  }

  .form-input-container {
    width: 350px;
    padding: 20px;
    background: #fff;
    box-shadow: -3px -3px 7px rgba(94, 104, 121, 0.377),
      3px 3px 7px rgba(94, 104, 121, 0.377);
  }

  .form-input input {
    display: none;

  }

  .form-input label {
    display: block;
    width: 45%;
    height: 45px;
    margin-left: 25%;
    line-height: 50px;
    text-align: center;
    background: #1172c2;

    color: #fff;
    font-size: 15px;
    text-transform: Uppercase;
    font-weight: 600;
    border-radius: 5px;
    cursor: pointer;
  }

  /* .img-holder {
    width: 100%;
    display: none;
    height: 200px;
    margin-bottom: 30px;
  } */
</style>