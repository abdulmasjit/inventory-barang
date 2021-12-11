<div class="row g-4 align-items">
  <?php $no = $data->firstItem();
  $fmt = new NumberFormatter('id_ID', NumberFormatter::CURRENCY); ?>
  @if (count($data) > 0)
  @foreach($data as $row)
  <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4">
    <div class="card">
      <img src="{{url('').'/'.$row->foto}}" class="card-img-top" alt="..." style="min-height: 200px; max-height: 200px;">
      <div class="card-body">
        <h5 class="card-title">{{ $row->nama }}</h5>
        <div style="width: 100%;">
          <div class="d-flex" style="width: 100%;">
            <div style="width: 40%;">
              <p class="fw-normal">
                Jenis Barang
              </p>
            </div>
            <div>
              <p class="fw-normal">{{ $row->nama_jenis_barang }}</p>
            </div>
          </div>
          <div class="d-flex">
            <div style="width: 40%;">
              <p class="fw-normal">
                Harga Jual
              </p>
            </div>
            <div>
              <p class="fw-normal">{{ $fmt->formatCurrency($row->harga_jual, 'IDR') }}</p>
            </div>
          </div>
          <div class="d-flex">
            <div style="width: 40%;">
              <p class="fw-normal">
                Harga Beli
              </p>
            </div>
            <div>
              <p class="fw-normal">{{ $fmt->formatCurrency($row->harga_beli, 'IDR') }}</p>
            </div>
          </div>
        </div>
      </div>
      <div class="card-footer text-right bg-transparent">
        <a href="javascript:;" data-id="<?= $row->id_barang ?>" data-name="<?= $row->nama ?>" class="btn btn-sm btn-warning btn-ubah" data-toggle="tooltip" title="Edit Barang"><i style="color:#fff;" class="fa fa-edit"></i></a>
        <a href="javascript:;" data-id="<?= $row->id_barang ?>" data-name="<?= $row->nama ?>" class="btn btn-sm btn-danger btn-hapus" data-toggle="tooltip" title="Hapus Barang"><i class="fa fa-trash"></i></a>
      </div>
    </div>
  </div>
  @endforeach
  @else
  <span class="text-center">Data tidak ditemukan!</span>
  @endif
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