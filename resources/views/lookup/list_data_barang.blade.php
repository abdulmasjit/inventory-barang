<div class="table-responsive">
  <table class="table table-bordered">
    <thead class="tr-head">
      <tr>
        <th width="5%" class="text-center" data-sort="">No </th>
        <th width="15%" class="sortable" id="column_kode" data-sort="" onclick="sort_table('#column_kode','kode')">Kode </th>
        <th width="60%" class="sortable" id="column_nama" data-sort="asc" onclick="sort_table('#column_nama','nama')">Nama </th>
        <th width="10%">Jenis Barang </th>
        <th class="text-center" width="10%">Aksi</th>
      </tr>
      </thead>
      <tbody>
        <?php $no = $data->firstItem() ?>
        @if (count($data) > 0)
          @foreach($data as $row)
          <tr>
            <td class="text-center">{{ $no++ }}.</td>
            <td>{{ $row->kode }}</td>
            <td>{{ $row->nama }}</td>
            <td>{{ $row->jenis_barang }}</td>
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
    <div style="float:right;" class="pagination-lookup">  
      {{ $data->links() }}
    </div>
  </div>
</div>
@endif