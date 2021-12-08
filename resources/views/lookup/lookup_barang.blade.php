<style>
  .modal-fullscreen{
    min-width: 85% !important;
  }
</style>
<div class="modal fade" id="lookup_barang" tabindex="-1" role="dialog" aria-labelledby="formModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-fullscreen" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="formModalLabel">Lookup Barang</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row" style="padding-top:12px;">
          <div class="col-md-2">
            <select class="form-control" name="limit" id="limit" onchange="fetch_data(1)">
              <option value="10" selected>10 Baris</option>
              <option value="15">15 Baris</option>
              <option value="25">25 Baris</option>
            </select>
          </div>
          <div class="col-md-6"></div>
          <div class="col-md-4">
            <div class="input-group">
              <input type="text" id="cari" name="cari" class="form-control" placeholder="Cari <Tekan Enter>">
              <div class="input-group-append">
                <span class="input-group-text">
                  <i class="ti-search"></i>
                </span>
              </div>
            </div>
          </div>
        </div>
        <br>
        <div id="list-lookup"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
</div>
<input type="hidden" name="lookup_id_th" id="lookup_id_th" value="#column_nama">
<input type="hidden" name="lookup_page" id="lookup_page" value="1">
<input type="hidden" name="lookup_column_name" id="lookup_column_name" value="nama">
<input type="hidden" name="lookup_sort_type" id="lookup_sort_type" value="desc">
<script src="{{ asset('assets/js/pages/lookup-barang.js') }}"></script>
<script>
  $(document).ready(function() {
    fetch_data(1)
  })

  $('#cari').on('keypress', function(e) {
    if (e.which == 13) {
      fetch_data(1);
    }
  });
</script>