@extends('layouts.main')
@section('content')
<div class="row">
  <div class="col-12">
    <div class="card flat">
      <div class="card-header card-header-blue">
          <span class="card-title">Menu User</span>
      </div>
      <div class="card-body">
        <div class="row" style="padding-top:12px;">
          <div class="col-md-4">
            <select class="form-control" name="role" id="role" onchange="fetch_data()">
                <option value="">Pilih Role</option>
                <?php foreach ($role as $row) { ?>
                    <option value="<?= $row->id_role ?>"><?= $row->nama ?></option>
                <?php } ?>  
            </select>
          </div>
          <div class="col-md-3">
              <a href="javascript:;" class="btn btn-success mr-1 mb-1" id="btn-add"><i class="fa fa-plus-circle"></i> &nbsp;Tambah</a>
          </div>
        </div>
        <br>
        <div id="list"></div>
      </div>
    </div>
  </div>
</div>

<!-- DATA SORT -->
<input type="hidden" name="hidden_id_th" id="hidden_id_th" value="#column_created">
<input type="hidden" name="hidden_page" id="hidden_page" value="1">
<input type="hidden" name="hidden_column_name" id="hidden_column_name" value="created_at">
<input type="hidden" name="hidden_sort_type" id="hidden_sort_type" value="desc">
<div id="div_modal"></div>
@endsection
@section('js')
<script src="{{ asset('assets/js/pages/menu-user.js') }}"></script>
@endsection
