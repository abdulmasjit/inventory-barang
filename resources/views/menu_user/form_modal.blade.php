<div class="modal fade" id="formModal" tabindex="-1" role="dialog" aria-labelledby="formModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="formModalLabel">Tambah Menu</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
        <form id="formData" action="" method="POST">
          @csrf
          <div class="modal-body">
            <input type="hidden" name="modeform" id="modeform">
            <input type="hidden" name="id" id="id">
            <div class="form-group">
                <label for="provinsi">Hak Akses<span style="color:red;">*</span></label>
                <select class="form-control" id="hak_akses" name="hak_akses" required>
                    <option value="">Pilih Hak Akses</option>
                    <?php  foreach ($role as $r) { ?>
                        <option value="<?= $r->id_role ?>"><?= $r->nama ?></option>    
                    <?php } ?>
                </select>
            </div>
            <div class="form-group" id="levels">
                <label for="level">Level Menu<span style="color:red;">*</span></label>
                <select class="form-control" id="level" name="level" required>
                    <option value="">Pilih Level Menu</option>
                    <option value="1">Level 1</option>
                    <option value="2">Level 2</option>    
                </select>
            </div>
            <div class="form-group" id="parent" style="display:none;">
                <label for="provinsi">Parent Menu<span style="color:red;">*</span></label>
                <select class="form-control" id="parent_menu" name="parent_menu" required>
                    <option value="">Pilih Parent Menu</option>
                    <?php  foreach ($parent_menu as $pm) { ?>
                        <option value="<?= $pm->id_menu ?>"><?= $pm->nama_menu ?></option>    
                    <?php } ?>
                </select>
            </div>
            <!-- Sub Menu -->
            <div id="sub" style="display:none;">
              <fieldset class="scheduler-border">
                <legend class="scheduler-border"><h5><i id="spinner_menu"></i> Pilih Sub Menu</h5></legend>
                <div class="row">
                  <div class="col-md-12" id="div-notif-menu">
                    <div class="alert alert-info">
                      <h6>Harap <b>Pilih Parent Menu</b> untuk menampilkan sub menu !</h6>
                    </div>
                  </div>
                  <div class="col-md-12" id="div-select-menu" style="display:none;">
                    <div class="form-group">
                      <select style="height:250px !important;" class="form-control select-box menu" id="menu" multiple="multiple" name="menu[]">  
                        <?php  foreach ($sub_menu as $sm) { ?>
                          <option style="padding-bottom:5px;" value="<?= $sm->id_menu ?>"><?= $sm->nama_menu ?> 
                          <?php  echo ($sm->keterangan != "" || $sm->keterangan != NULL) ? ' - '.$sm->keterangan : ""; ?>
                          </option>    
                        <?php } ?>
                      </select>
                    </div>
                  </div>
                </div>
              </fieldset>
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
<script>
  var selectbox = $('.select-box').bootstrapDualListbox();
</script>
