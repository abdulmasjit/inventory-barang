@extends('layouts.main')
@section('content')
<div>
  <div class="row">
    <div class="col-md-3">
      <div class="small-box bg-dashboard-blue">
        <div class="inner">
          <h3>{{ $total_barang }}</h3>
          <p>Total Barang</p>
        </div>
        <div class="icon">
          <i class="fa fa-copy"></i>
        </div>
        <a href="javascript:void(0)" class="small-box-footer"
          >Lihat
          <i class="fa fa-arrow-right"></i>
        </a>
      </div>
    </div>
    <div class="col-md-3">
      <div class="small-box bg-dashboard-yellow">
        <div class="inner">
          <h3>{{ $total_supplier }}</h3>
          <p>Total Supplier</p>
        </div>
        <div class="icon">
          <i class="fa fa-copy"></i>
        </div>
        <a href="javascript:void(0)" class="small-box-footer"
          >Lihat
          <i class="fa fa-arrow-right"></i>
        </a>
      </div>
    </div>
    <div class="col-md-3">
      <div class="small-box bg-dashboard-red">
        <div class="inner">
          <h3>{{ $total_penjualan }}</h3>
          <p>Total Penjualan</p>
        </div>
        <div class="icon">
          <i class="fa fa-copy"></i>
        </div>
        <a href="javascript:void(0)" class="small-box-footer"
          >Lihat
          <i class="fa fa-arrow-right"></i>
        </a>
      </div>
    </div>
    <div class="col-md-3">
      <div class="small-box bg-dashboard-green">
        <div class="inner">
          <h3>{{ $total_pembelian }}</h3>
          <p>Total Pembelian</p>
        </div>
        <div class="icon">
          <i class="fa fa-copy"></i>
        </div>
        <a href="javascript:void(0)" class="small-box-footer"
          >Lihat
          <i class="fa fa-arrow-right"></i>
        </a>
      </div>
    </div>

  </div>
  <div class="row mt-1">
    <div class="col-md-12">
      <div class="card">
        <div class="card-body">
          <div class="row">
            <div class="col-md-7 col-sm-12"></div>
            <div class="col-md-2 col-sm-12">
              <p class="text-right" style="color:#000; font-size:14px; margin-top:9px; margin-bottom:0px !important;"><strong>Tahun
                  :</strong></p>
            </div>
            <div class="col-md-3 col-sm-12">
              <input id="tahun" name="tahun" type="number" value="<?= date('Y') ?>" class="form-control">
            </div>
          </div>
          <hr>
          <div id="data-chart" style="width:100%; height:400px;"></div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
@section('js')
<script>
  $(document).ready(function() {
    load_chart()
  });

  $('#tahun').on('change', function(e) {
    load_chart()
  });

  function load_chart() {
    var tahun = $('#tahun').val()
    $.ajax({
      url: base_url + "/dashboard/persediaan-barang",
      type: 'GET',
      dataType: 'html',
      data: {
        tahun: tahun
      },
      beforeSend: function() {},
      success: function(result) {
        $('#data-chart').html(result);
      }
    });
  }
</script>
@endsection