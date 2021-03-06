<div class="table-responsive">
  <table class="table table-bordered">
    <thead class="tr-head">
      <tr>
        <th width="5%" class="text-center sortable" id="column_created" data-sort="desc" onclick="sort_table('#column_created','bm.created_at')">No </th>
        <th width="10%" class="sortable" id="column_nomor_transaksi" data-sort="" onclick="sort_table('#column_nomor_transaksi','nomor_transaksi')">Nomor </th>
        <th width="10%" class="sortable" id="column_tanggal" data-sort="" onclick="sort_table('#column_tanggal','tanggal')">Tanggal </th>
        <th width="20%" class="sortable" id="column_nama_barang" data-sort="" onclick="sort_table('#column_nama_barang','nama')">Barang </th>
        <th width="20%">Keterangan</th>
        <th width="10%" class="text-center">Qty</th>
        <th class="text-center" width="10%">Aksi</th>
      </tr>
      </thead>
      <tbody>
        <?php $no = $data->firstItem() ?>
        @if (count($data) > 0)
          @foreach($data as $row)
          <tr>
            <td class="text-center">{{ $no++ }}.</td>
            <td>{{ $row->nomor_transaksi }}</td>
            <td>
              <?php $time = strtotime($row->tanggal); ?>
              {{ date('d-m-Y', $time) }}
            </td>
            <td>{{ $row->nama_barang }}</td>
            <td>{{ $row->keterangan }}</td>
            <td class="text-right">{{ $row->qty }}</td>
            <td class="text-center">
              <a href="{{ url('/mutasi-stok/edit/'.$row->id) }}" class="btn btn-sm btn-warning btn-ubah" data-toggle="tooltip" title="Edit Transaksi"><i style="color:#fff;" class="fa fa-edit"></i></a>
              <a href="javascript:;" data-id="<?=$row->id?>" data-name="<?=$row->nomor_transaksi?>" class="btn btn-sm btn-danger btn-hapus" data-toggle="tooltip" title="Hapus Transaksi"><i class="fa fa-trash"></i></a>	    
            </td>
          </tr>
          @endforeach
        @else 
        <tr>
          <td colspan="7">Data tidak ditemukan!</td>
        </tr>
        @endif
    </tbody>
  </table>
</div>
@if (count($data) > 0)
<div class="row">
  <br>
  <div class="col-xs-12 col-md-6" style="padding-top:5px; color:#333;">
  Menampilkan 
  {{ $data->firstItem().'-'.$data->lastItem().' dari total '.$data->total(); }}
  data
  </div>
  <br>
  <div class="col-xs-12 col-md-6">
    <div style="float:right;">  
      {{ $data->links() }}
    </div>
  </div>
</div>
@endif