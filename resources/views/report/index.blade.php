@extends('layouts.main')
@section('css')
<style>
   .datepicker {z-index:1200 !important;}  
</style>    
@endsection
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
          <div class="col-sm-6">
            <select name="jenis_laporan" id="jenis_laporan" onchange="changeReportType()" class="form-control">
              <option value="1">Laporan Pembelian</option>
              <option value="2">Laporan Penjualan</option>
              <option value="3">Laporan Barang Masuk</option>
              <option value="4">Laporan Barang Keluar</option>
              <option value="5">Laporan Stok Barang</option>
              <option value="6">Laporan Mutasi Stok</option>
            </select>
          </div>
        </div>
        <div id="select-barang" style="display: none;" class="row mb-1">
          <label for="barang" class="col-sm-2 col-form-label">Barang</label>
          <div class="col-sm-6">
            <select name="barang" id="barang" class="form-control">
              <option value="">Semua Barang</option>
              @foreach ($barang as $row)
                <option value="{{ $row->id_barang }}">[{{ $row->kode }}] {{ $row->nama }}</option>
              @endforeach
            </select>
          </div>
        </div>

        <hr>
        <h6 class="mb-3">Periode Laporan</h6>
        <div class="row mb-3">
          <div class="col-sm-2">
            <div class="form-check">
              <input class="form-check-input check-mode" type="radio" name="periode" id="byTanggal" value="by_tanggal">
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
              <input class="form-check-input check-mode" type="radio" name="periode" id="byBulan" value="by_bulan">
              <label class="form-check-label" for="byBulan">
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
              <input class="form-check-input check-mode" type="radio" name="periode" id="byTahun" value="by_tahun">
              <label class="form-check-label" for="byTahun">
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
          <a href="javascript:;" onclick="printReport()" class="btn btn-success"><i class="fa fa-print"></i>&nbsp; Cetak PDF</a>
          {{-- <a href="javascript:;" class="btn btn-success"><i class="fa fa-file-excel-o"></i>&nbsp; Export Excel</a> --}}
          <a href="javascript:;" onclick="reset()" class="btn btn-warning"><i class="fa fa-refresh"></i>&nbsp; Reset</a>
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
      orientation: "bottom"
  })
  $('.date-picker').datepicker('setDate', new Date());

  function changeReportType(){
    const jenis_lap = $('#jenis_laporan').val();
    if(jenis_lap=='5'){
      $('#select-barang').show()
    }else{
      $('#select-barang').hide();
    }
  }

  function printReport(){
    var periode = $('.check-mode:checked').val();
    var tahun = $('#tahun').val();
    const bulan = $('#bulan').val();
    const tahunan = $('#tahunan').val();
    const jenis_lap = $('#jenis_laporan').val();
    const barang = $('#barang').val();
    var link = ""

    if(jenis_lap!=""){
      if(periode!==undefined){
          tahun = (periode == 'by_tahun') ? tahunan : tahun;
          var rentangTanggal = getDateReport(periode, bulan, tahun);
          // Report
          if(jenis_lap=='1'){
            link = "{{ url('report/pembelian') }}" + "?tanggal_awal="+ rentangTanggal.tglAwal +"&tanggal_akhir="+ rentangTanggal.tglAkhir;
          }else if(jenis_lap=='2'){
            link = "{{ url('report/penjualan') }}" + "?tanggal_awal="+ rentangTanggal.tglAwal +"&tanggal_akhir="+ rentangTanggal.tglAkhir;
          }else if(jenis_lap=='3'){
            link = "{{ url('report/barang-masuk') }}" + "?tanggal_awal="+ rentangTanggal.tglAwal +"&tanggal_akhir="+ rentangTanggal.tglAkhir;
          }else if(jenis_lap=='4'){
            link = "{{ url('report/barang-keluar') }}" + "?tanggal_awal="+ rentangTanggal.tglAwal +"&tanggal_akhir="+ rentangTanggal.tglAkhir;
          }else if(jenis_lap=='5'){
            link = "{{ url('report/kartu-stok') }}" + "?tanggal_awal="+ rentangTanggal.tglAwal +"&tanggal_akhir="+ rentangTanggal.tglAkhir+"&id_barang="+barang;
          }else if(jenis_lap=='6'){
            link = "{{ url('report/mutasi-stok') }}" + "?tanggal_awal="+ rentangTanggal.tglAwal +"&tanggal_akhir="+ rentangTanggal.tglAkhir;
          }else{
            link = "";
          }              
          window.open(link, '_blank', 'width=1024, height=768')
      }else{
        Swal.fire({icon: 'warning',title: 'Maaf',text: 'Harap pilih periode laporan !'});
      }
    }else{
      Swal.fire({icon: 'warning',title: 'Maaf',text: 'Harap pilih jenis laporan !'});
    }
  }

  function reset(){
    $('.date-picker').datepicker('setDate', new Date());   
    $('#barang').val(""); 
  }

  function formatDate(date){
    let s = date.split("-");
    return s[2] + '-' + s[1] + '-' + s[0]
  }

  function getDateReport (periode, bulan, tahun) {
      var tgl_awal = $('#tgl_awal').val();
      var tgl_akhir = $('#tgl_akhir').val();

      if (periode == undefined) {
        return {
          success: false,
          tglAwal: '',
          tglAkhir: '',
        }
      } else {
        var parseDate = ''
        var firstDate = ''
        var lastDate = ''

        if(periode == 'by_tanggal'){
          firstDate = formatDate(tgl_awal)
          lastDate = formatDate(tgl_akhir)
        } else if (periode == 'by_tahun') {
          firstDate = tahun + '-01-01'
          lastDate = new Date(tahun, 12, 0).getDate();
          lastDate = tahun + '-12-' + lastDate 
        } else if (periode == 'by_bulan') {
          firstDate = tahun + '-' + bulan + '-01'
          lastDate = new Date(tahun, bulan, 0).getDate();
          lastDate = tahun + '-' + bulan + '-' + lastDate
        } else {
          firstDate = ''
          lastDate = ''
        }

        return {
          success: true,
          tglAwal: firstDate,
          tglAkhir: lastDate,
        }
      }
    }
</script>
  
@endsection
