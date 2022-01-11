<!DOCTYPE html>
<html>
<head>    
<title>Kartu Stok Barang</title>	
<link rel="icon" sizes="16x16" href="">
<style>
    .table {
      border-collapse: collapse;
      border-color: #333;
      font-family: TimesNewRoman,Times New Roman,Times,Baskerville,Georgia,serif; 
      width:100%;
    }
    .head-table th{
      padding: 8px;
      border: 1px solid #333;
      font-family: Arial, Helvetica, sans-serif; 
      font-size:11px;
    }
    .body-table td,th{
      padding: 3px;
      border: 1px solid #333;
      font-family: Arial, Helvetica, sans-serif; 
      font-size:11px;
    }
    .head-lap td{
      padding: 1px;
      font-family: Arial, Helvetica, sans-serif; 
    }
    .text-center{
        text-align:center;
    }
    .text-left{
        text-align:left;
    }
    .text-right{
        text-align:right;
    }
    .line-title {
        border: 0;
        border-style: inset;
        border-top: 2px solid #333;
    }
    .line-title-child {
        border: 0;
        margin-top: -7px;
        border-top: 1px solid #333;
    }
    .page_break { page-break-before: always; }
    @page { margin: 0.8cm; }
</style>
</head>
<body>
<table class="table" style="text-align:left;" >
    <tbody class="head-lap">
    <tr>
        <td width="100%" class="text-center" style="padding-left:5px;"> 
            <span style="font-size:13px"><strong>KARTU STOK BARANG</strong></span> <br>
            <span style="font-size:13px">{{ $tanggal }}</span> <br>
        </td>
    </tr>
    </tbody>
</table>
<hr class="line-title">
<hr class="line-title-child" style="margin-bottom:15px;">
<table class="table">
    <thead class="head-table">
        <tr>
            <th rowspan="2" width="2%" class="text-center">NO.</th>
            <th rowspan="2" width="10%" class="text-center">Kode Barang</th>
            <th rowspan="2" width="20%" class="text-left">Nama Barang</th>
            <th width="25%" colspan="6" class="text-center">Stok</th>
            <th width="10%" class="text-center">Level Stok</th>
        </tr>
        <tr>
            <th width="5%" class="text-center">Satuan</th>
            <th width="5%" class="text-center">Awal</th>
            <th width="5%" class="text-center">Masuk</th>
            <th width="5%" class="text-center">Keluar</th>
            <th width="5%" class="text-center">Rusak/Hilang</th>
            <th width="5%" class="text-center">Akhir</th>
            <th width="5%" class="text-center">Minimum</th>
        </tr>
    </thead>
    <tbody class="body-table">
        <?php 
          $no = 0; 
          $total = 0;
        ?>
        @foreach ($data as $row)
          <?php $no++; ?>
          <tr>
              <td class="text-center">{{ $no }}.</td>
              <td class="text-center">{{ $row->kode_barang }}</td>
              <td>{{ $row->nama_barang }}</td>
              <td class="text-center">{{ $row->satuan }}</td>
              <td class="text-center">{{ $row->stok_awal }}</td>
              <td class="text-center">{{ $row->masuk }}</td>
              <td class="text-center">{{ abs($row->keluar) }}</td>
              <td class="text-center">{{ abs($row->rusak_hilang) }}</td>
              <td class="text-center">{{ $row->stok_akhir }}</td>
              <td class="text-center">{{ $row->stok_minimum }}</td>
          </tr>
        @endforeach
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
    </tbody>
</table>
</body>
</html>