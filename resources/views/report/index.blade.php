@extends('layouts.main')
@section('content')
<div class="row">
  <div class="col-12">
    <div class="card flat">
      <div class="card-header card-header-blue">
          <span class="card-title">Laporan</span>
      </div>
      <div class="card-body">
        <div class="row mb-1">
          <label for="nomor_transaksi" class="col-sm-2 col-form-label">Jenis Laporan</label>
          <div class="col-sm-5">
            <select name="jenis_laporan" id="jenis_laporan" class="form-control">
              <option value="">Laporan Barang Masuk</option>
              <option value="">Laporan Barang Keluar</option>
              <option value="">Laporan Stok Barang</option>
            </select>
          </div>
        </div>

        <hr>
        <h6 class="mb-3">Periode Laporan</h6>
        <div class="row mb-3">
          <div class="col-sm-2">
            <div class="form-check">
              <input class="form-check-input" type="radio" name="periode" id="byTanggal">
              <label class="form-check-label" for="byTanggal">
                Pertanggal
              </label>
            </div>
          </div>
          <div class="col-sm-2">
            <input class="form-control date-picker" id="tgl_awal" name="tgl_awal" data-date-format='dd-mm-yyyy' autocomplete="off" onkeypress="return false;"
              value="<?= date('d-m-Y') ?>"
            >
          </div>
          <div class="col-sm-1" style="text-align:center; padding:0px !important;">s/d</div>
          <div class="col-sm-2">
            <input class="form-control date-picker" id="tgl_akhir" name="tgl_akhir" data-date-format='dd-mm-yyyy' autocomplete="off" onkeypress="return false;"
              value="<?= date('d-m-Y') ?>"
            >
          </div>
        </div>
        <div class="row mb-3">
          <div class="col-sm-2">
            <div class="form-check">
              <input class="form-check-input" type="radio" name="periode" id="byTanggal">
              <label class="form-check-label" for="byTanggal">
                Perbulan
              </label>
            </div>
          </div>
          <div class="col-sm-3">
            <select class="form-control" id="bulan" name="bulan" required>
              <option value="">Pilih Bulan</option>
              <?php 
              $bulan = date('m');
              $array_bulan=array(
                  '01'=>'Januari',
                  '02'=>'Februari',
                  '03'=>'Maret',
                  '04'=>'April',
                  '05'=>'Mei',
                  '06'=>'Juni',
                  '07'=>'Juli',
                  '08'=>'Agustus',
                  '09'=>'September',
                  '10'=>'Oktober',
                  '11'=>'November',
                  '12'=>'Desember'
              );
              foreach ($array_bulan as $key => $value) { ?>
                  <option 
                  <?php if($bulan==$key){
                      echo " selected";
                  } ?> 
                  value="<?= $key ?>"><?= $value ?></option>    
              <?php } ?>
            </select>
          </div>
          <div class="col-sm-2">
            <input type="number" class="form-control" name="tahun" id="tahun" value="<?= date('Y') ?>">
          </div>
        </div>
        <div class="row mb-2">
          <div class="col-sm-2">
            <div class="form-check">
              <input class="form-check-input" type="radio" name="periode" id="byTanggal">
              <label class="form-check-label" for="byTanggal">
                Pertahun
              </label>
            </div>
          </div>
          <div class="col-sm-5">
            <input type="number" class="form-control" name="tahunan" id="tahunan" value="<?= date('Y') ?>">
          </div>
        </div>
        <hr class="mt-4">
        <div>
          <a href="javascript:;" class="btn btn-success"><i class="fa fa-print"></i>&nbsp; Cetak</a>
          <a href="javascript:;" class="btn btn-warning"><i class="fa fa-refresh"></i>&nbsp; Reset</a>
        </div>
      </div>
    </div>
  </div>
</div>

<div id="div_modal"></div>
@endsection
@section('js')
  <script>    
    $('.date-picker').datepicker({
        autoclose: true,
    });
  </script>
@endsection
