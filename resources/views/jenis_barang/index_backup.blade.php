@extends('layouts.main')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card flat">
                <div class="card-header card-header-blue">
                    <span class="card-title"><i class="fa fa-bars"></i>Jenis Barang</span>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        @include('layouts.notif')
                        <div class="row" style="padding-top:12px;">
                            <div class="col-md-6">
                                <a href="javascript:;" class="btn btn-success mr-1 mb-1" id="btn-tambah"><i
                                class="fa fa-plus-circle"></i> &nbsp;Tambah</a>
                            </div>
                            <div class="col-md-2">
                                <select class="form-control" name="limit" id="limit" onchange="fetch_data(1)">
                                    <option value="10" selected>10 Baris</option>
                                    <option value="25">25 Baris</option>
                                    <option value="50">50 Baris</option>
                                    <option value="100">100 Baris</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                {{-- <form action="{{ url('master/jenis-barang') }}" method="GET"> --}}
                                  <div class="input-group">
                                      <input type="text" id="cari" name="q" class="form-control"
                                          placeholder="Cari . . .">
                                      <div class="input-group-append">
                                          <span class="input-group-text">
                                              <i class="ti-search"></i>
                                          </span>
                                      </div>
                                  </div>
                                {{-- </form> --}}
                            </div>
                        </div>
                        <br>
                        <div id="list">
                            {{-- @include('jenis_barang.list_data') --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="formModal" tabindex="-1" role="dialog" aria-labelledby="formModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="formModalLabel">Tambah Jenis Barang</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="formData" action="" method="POST">
                    <div class="modal-body">
                        <input type="hidden" class="form-control" id="id" name="id"></input>
                        <div class="form-group">
                            <label for="kategori">Kode</label>
                            <input type="text" class="form-control" id="kode" name="kode" placeholder="Kode . . ."
                                required></input>
                        </div>
                        <div class="form-group">
                            <label for="kategori">Nama Jenis Barang</label>
                            <input type="text" class="form-control" id="nama" name="nama"
                                placeholder="Nama Jenis Barang . . ." required></input>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- DATA SORT -->
    <div id="div_modal"></div>
@endsection
@section('js')
<script>
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
        fetch_data(page);
    });

    function fetch_data(page) {
        var cari = $('#cari').val();
        // var column_name = $('#hidden_column_name').val();
        // var sort_type = $('#hidden_sort_type').val();
        $.ajax({
          // url: "/jenis-barang/fetch_data?page=" + page + "&q=" + cari,
          url: "/jenis-barang/fetch_data",
          type: 'GET',
          dataType: 'html',
          data: {
            page : page,
            q : cari
          },
          beforeSend: function() {},
          success: function(result) {
              $('#list').html(result);
          }
        });
    }
    
    $('#btn-tambah').on('click', function() {
        $("#formModal").modal('show');
    })
</script>
@endsection
