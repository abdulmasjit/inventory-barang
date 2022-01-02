@extends('layouts.main')
@section('content')
<div class="card">
  <div class="card-header">
    Tambah User
  </div>
  <div class="card-body">
    <?php
    $disabled = isset($data) ? "readonly='readonly'" : " ";
    ?>
    <form id="formData" method="POST">
    <input type="hidden" name="id" id="id" value="{{ isset($data) ? $data['id'] : '' }}" />
      
            <div class="mb-3">
              <label for="name" class="form-label">Nama</label>
              <input type="text" id="name" name="name" class="form-control" placeholder="Nama" value="{{ isset($data) ? $data['name'] : '' }}" required>
            </div>
            <div class="mb-3">
              <label for="username" class="form-label">Username</label>
              <input type="text" id="username" name="username" class="form-control" placeholder="Username" value="{{ isset($data) ? $data['username'] : '' }}" <?php echo $disabled; ?> required>
            </div>
            <div class="mb-3">
              <label for="email" class="form-label">Email</label>
              <input type="text" id="email" name="email" class="form-control" placeholder="Email" value="{{ isset($data) ? $data['email'] : '' }}" required>
            </div>
            <div class="mb-3">
              <label for="password" class="form-label">Password</label>
              <input type="password" name="password" id="password" class="form-control" placeholder="Password" value="{{ isset($data) ? $data['password'] : '' }}" <?php echo $disabled; ?> required>
            </div>
            <div class="mb-3">
            <label for="id_role">ID Role</label>
            <select id="id_role" name="id_role" class="form-control" required>
              <option value="0" disabled="true" selected="true">Pilih ID Role</option>
              @foreach ($dataRoles as $dataRole)
              @if(isset($data))
              <option value="{{ $dataRole->id_role }}" <?php if ($dataRole->id_role == $data['id_role']) : ?> selected="selected" <?php endif; ?>>{{ $dataRole->nama }}</option>
              @else
              <option value="{{ $dataRole->id_role }}">{{ $dataRole->nama }}</option>
              @endif
              @endforeach
            </select>
          </div>
        <div class="d-flex justify-content-end mt-2">
          <a href="/setting/user" class="btn btn-secondary mr-3">Batal</a>
          <button class="btn btn-primary float-end" type="submit">Simpan</button>
        </div>
    </form>
  </div>
</div>
@endsection
@section('js')
<script src="{{ asset('assets/js/pages/user.js') }}"></script>
@endsection