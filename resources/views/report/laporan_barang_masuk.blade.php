<!DOCTYPE html>
<html>
<head>    
<title>Laporan Barang Masuk</title>	
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
      border-top: 1px solid #333;
      border-bottom: 1px solid #333;
      font-family: Arial, Helvetica, sans-serif; 
      font-size:11px;
    }
    .body-table td,th{
      padding: 4px;
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
            <span style="font-size:13px"><strong>LAPORAN BARANG MASUK</strong></span> <br>
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
            <th width="2%" class="text-center">NO.</th>
            <th width="5%" class="text-center">Tanggal</th>
            <th width="7%" class="text-center">Nomor</th>
            <th width="7%" class="text-center">Kode</th>
            <th width="20%" class="text-left">Nama Barang</th>
            <th width="5%" class="text-center">Satuan</th>
            <th width="5%" class="text-right">Jumlah</th>
        </tr>
    </thead>
    <tbody class="body-table">
        <?php 
          $no = 0; 
          $total = 0;
        ?>
        @foreach ($data as $row)
          <?php 
            $no++;
            $total += $row->jumlah;
          ?>
          <tr>
              <td class="text-center">{{ $no }}.</td>
              <td class="text-center">{{ $row->tanggal }}</td>
              <td class="text-center">{{ $row->nomor_transaksi }}</td>
              <td class="text-center">{{ $row->kode_barang }}</td>
              <td>{{ $row->nama_barang }}</td>
              <td class="text-center">{{ $row->satuan }}</td>
              <td class="text-right">{{ $row->jumlah }}</td>
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
        </tr>
        <tr>
            <td colspan="5" class="text-right" style="border-top: 1px solid #333; border-bottom: 1px solid #333;"><strong>Total</strong></td>
            <td colspan="2" class="text-right" style="border-top: 1px solid #333; border-bottom: 1px solid #333;">{{ $total }}</td>
        </tr>
    </tbody>
</table>
</body>
</html>