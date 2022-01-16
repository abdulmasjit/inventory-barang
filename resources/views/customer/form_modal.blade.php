<div class="modal fade" id="formModal" tabindex="-1" role="dialog" aria-labelledby="formModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="formModalLabel">Tambah Customer</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="formData" action="" method="POST">
        @csrf
        <div class="modal-body">
          <input type="hidden" name="modeform" id="modeform">
          <input type="hidden" class="form-control" id="id" name="id" value="{{ isset($data) ? $data['id'] : '' }}"></input>
          <div class="form-group">
            <label for="kategori">Kode</label>
            <input type="text" class="form-control" id="kode" name="kode" placeholder="Kode . . ." value="{{ isset($data) ? $data['kode'] : $kode }}" readonly>
          </div>
          <div class="form-group">
            <label for="nama">Nama</label>
            <input type="text" class="form-control" id="nama" name="nama" placeholder="Nama Customer . . ." value="{{ isset($data) ? $data['nama'] : '' }}" required>
          </div>
          <div class="form-group">
            <label for="no_telp">No Telepon</label>
            <input type="number" class="form-control" id="no_telp" name="no_telp" placeholder="No Telepon . . ." value="{{ isset($data) ? $data['no_telp'] : '' }}" required>
          </div>
          <div class="form-group">
            <label for="alamat">Alamat</label>
            <textarea class="form-control" id="alamat" name="alamat" placeholder="Alamat . . ." required><?= (isset($data)) ? $data['alamat'] : '' ?></textarea>
          </div>
          <div class="form-group">
            <label for="keterangan">Keterangan</label>
            <textarea class="form-control" id="keterangan" name="keterangan" placeholder="Keterangan . . ."><?= (isset($data)) ? $data['keterangan'] : '' ?></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>