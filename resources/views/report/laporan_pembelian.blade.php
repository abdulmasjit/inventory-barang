<!DOCTYPE html>
<html>
<head>    
<title>Laporan Pembelian</title>	
<link rel="icon" sizes="16x16" href="">
<style>
    .table {
      border-collapse: collapse;
      font-family: TimesNewRoman,Times New Roman,Times,Baskerville,Georgia,serif; 
      width:100%;
    }
    .head-table th{
      padding: 8px;
      font-family: Arial, Helvetica, sans-serif; 
      font-size:11px;
    }
    .body-table td,th{
      padding: 3px;
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
            <span style="font-size:13px"><strong>LAPORAN PEMBELIAN BARANG</strong></span> <br>
            <span style="font-size:13px">{{ $tanggal }}</span> <br>
        </td>
    </tr>
    </tbody>
</table>
<hr class="line-title">
<hr class="line-title-child" style="margin-bottom:15px;">
  <div>
    @foreach ($data as $h)
      <table class="table" style="margin-bottom:5px;">
        <tbody class="body-table" style="border-top: 1px solid #333;">
          <tr>
            <td style="width:3%;"></td>
            <td style="width:2%;" class="text-center"></td>
            <td style="width:15%;"></td>
            <td style="width:4%;"></td>
            <td style="width:2%;" class="text-center"></td>
            <td style="width:30%;"></td>
          </tr>
          <tr>
            <td style="width:3%;">Tanggal</td>
            <td style="width:2%;" class="text-center">:</td>
            <td style="width:15%;">{{ $h['tanggal'] }}</td>
            <td style="width:4%;">Supplier </td>
            <td style="width:2%;" class="text-center">:</td>
            <td style="width:30%;">{{ $h['nama_supplier'] }}</td>
          </tr>
          <tr>
            <td>Nomor</td>
            <td class="text-center">:</td>
            <td>{{ $h['nomor_transaksi'] }}</td>
            <td>Keterangan </td>
            <td class="text-center">:</td>
            <td>{{ $h['keterangan'] }}</td>
          </tr>
        </tbody>
      </table>
      <table class="table" style="margin-bottom:28px;">
          <thead class="head-table" style="background-color: #dee2e6;">
              <tr>
                  <th width="2%" class="text-center">No.</th>
                  <th width="7%" class="text-center">Kode</th>
                  <th width="20%" class="text-left">Nama Barang</th>
                  <th width="5%" class="text-center">Qty</th>
                  <th width="5%" class="text-center">Satuan</th>
                  <th width="8%" class="text-right">Harga</th>
                  <th width="8%" class="text-right">Diskon</th>
                  <th width="8%" class="text-right">Sub Total</th>
              </tr>
          </thead>
          <tbody class="body-table">
              <?php 
                $no = 0; 
                $total = 0;
              ?>
              @foreach ($h['detail'] as $row)
                <?php 
                  $no++;
                  $subTotal = ($row->jumlah*$row->harga)-$row->diskon; 
                  $total += $subTotal;
                ?>
                <tr>
                    <td class="text-center">{{ $no }}.</td>
                    <td class="text-center">{{ $row->kode_barang }}</td>
                    <td>{{ $row->nama_barang }}</td>
                    <td class="text-center">{{ $row->jumlah }}</td>
                    <td class="text-center">{{ $row->nama_satuan }}</td>
                    <td class="text-right">@format_rupiah($row->harga)</td>
                    <td class="text-right">@format_rupiah($row->diskon)</td>
                    <td class="text-right">@format_rupiah($subTotal)</td>
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
              </tr>
              <tr>
                  <td style="border-top: 1px solid #333;" colspan="6" class="text-right"><strong>Total</strong></td>
                  <td style="border-top: 1px solid #333;" colspan="2" class="text-right">@format_rupiah($total)</td>
              </tr>
          </tbody>
      </table>
    @endforeach
  </div>  
</body>
</html>