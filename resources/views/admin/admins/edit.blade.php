@extends('components.admin.layout')

@section('content')
<h4 class="mb-3">Edit Admin</h4>

@if($errors->any())
  <div class="alert alert-danger">
    <ul class="mb-0">
      @foreach($errors->all() as $err) <li>{{ $err }}</li> @endforeach
    </ul>
  </div>
@endif

<form method="POST" action="{{ route('admin.admins.update', $admin) }}" class="card">
  @csrf @method('PUT')
  <div class="card-body">
    <div class="row g-3">
      <div class="col-md-6">
        <label class="form-label">Nama</label>
        <input type="text" name="name" class="form-control" required value="{{ old('name',$admin->name) }}">
      </div>
      <div class="col-md-6">
        <label class="form-label">Email</label>
        <input type="email" name="email" class="form-control" required value="{{ old('email',$admin->email) }}">
      </div>
      <div class="col-md-6">
        <label class="form-label">Telepon (opsional)</label>
        <input type="text" name="phone" class="form-control" value="{{ old('phone',$admin->phone) }}">
      </div>
      <div class="col-md-6"></div>
      <div class="col-md-6">
        <label class="form-label">Password Baru (opsional)</label>
        <input type="password" name="password" class="form-control" placeholder="Kosongkan jika tidak diubah">
      </div>
      <div class="col-md-6">
        <label class="form-label">Konfirmasi Password Baru</label>
        <input type="password" name="password_confirmation" class="form-control" placeholder="Kosongkan jika tidak diubah">
      </div>
    </div>
  </div>
  <div class="card-footer d-flex justify-content-end gap-2">
    <a href="{{ route('admin.admins.index') }}" class="btn btn-secondary">Kembali</a>
    <button class="btn btn-primary">Update</button>
  </div>
</form>
@endsection
