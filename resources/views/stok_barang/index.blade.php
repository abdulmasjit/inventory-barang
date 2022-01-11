@extends('layouts.main')
@section('content')
<div class="row">
  <div class="col-12">
    <div class="card flat">
      <div class="card-header card-header-blue">
          <span class="card-title">Stok Barang</span>
      </div>
      <div class="card-body">
        <div class="row" style="padding-top:12px;">
          <div class="col-md-2">
            <select class="form-control" name="limit" id="limit" onchange="fetch_data(1)">
              <option value="10" selected>10 Baris</option>
              <option value="25">25 Baris</option>
              <option value="50">50 Baris</option>
              <option value="100">100 Baris</option>
            </select>
          </div>
          <div class="col-md-6"></div>
          <div class="col-md-4">
            <div class="input-group">
              <input type="text" id="cari" name="cari" class="form-control" placeholder="Cari <Tekan Enter>">
              <div class="input-group-append">
                <span class="input-group-text">
                  <i class="ti-search"></i>
                </span>
              </div>
            </div>
          </div>
        </div>
        <br>
        <div id="list"></div>
      </div>
    </div>
  </div>
</div>

<!-- DATA SORT -->
<input type="hidden" name="hidden_id_th" id="hidden_id_th" value="#column_nama">
<input type="hidden" name="hidden_page" id="hidden_page" value="1">
<input type="hidden" name="hidden_column_name" id="hidden_column_name" value="b.nama">
<input type="hidden" name="hidden_sort_type" id="hidden_sort_type" value="asc">
<div id="div_modal"></div>
@endsection
@section('js')
<script src="{{ asset('assets/js/pages/stok-barang.js') }}"></script>
@endsection