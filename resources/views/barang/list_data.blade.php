<div class="table-responsive">
  <table class="table table-bordered">
    <thead class="tr-head">
      <tr>
        <th width="5%" class="text-center sortable" id="column_created" data-sort="desc" onclick="sort_table('#column_created','created_at')">No </th>
        <th width="20%" class="sortable" id="column_kode" data-sort="" onclick="sort_table('#column_kode','kode')">Kode </th>
        <th width="20%" class="sortable" id="column_nama" data-sort="" onclick="sort_table('#column_nama','nama')">Nama </th>
        <th width="15%" class="sortable" id="column_kode" data-sort="" onclick="sort_table('#column_kode','nama_jenis_barang')">Jenis Barang </th>
        <th width="15%" class="sortable" id="column_nama" data-sort="" onclick="sort_table('#column_nama','harga_beli')">Harga Beli </th>
        <th width="15%" class="sortable" id="column_nama" data-sort="" onclick="sort_table('#column_nama','harga_jual')">Harga Jual </th>
        <th class="text-center" width="10%">Aksi</th>
      </tr>
    </thead>
    <tbody>
      <?php $no = $data->firstItem();
      $fmt = new NumberFormatter('id_ID', NumberFormatter::CURRENCY); ?>
      @if (count($data) > 0)
      @foreach($data as $row)
      <tr>
        <td class="text-center">{{ $no++ }}.</td>
        <td>{{ $row->kode }}</td>
        <td>{{ $row->nama }}</td>
        <td>{{ $row->nama_jenis_barang }}</td>
        <td>{{ $fmt->formatCurrency($row->harga_jual, 'IDR') }}</td>
        <td>{{ $fmt->formatCurrency($row->harga_beli, 'IDR') }}</td>
        <td class="text-center">
          <a href="javascript:;" data-id="<?= $row->id_barang ?>" data-name="<?= $row->nama ?>" class="btn btn-sm btn-warning btn-ubah" data-toggle="tooltip" title="Edit Barang"><i style="color:#fff;" class="fa fa-edit"></i></a>
          <a href="javascript:;" data-id="<?= $row->id_barang ?>" data-name="<?= $row->nama ?>" class="btn btn-sm btn-danger btn-hapus" data-toggle="tooltip" title="Hapus Barang"><i class="fa fa-trash"></i></a>
        </td>
      </tr>
      @endforeach
      @else
      <tr>
        <td colspan="4">Data tidak ditemukan!</td>
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