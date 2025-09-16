@extends('components.admin.layout')

@section('content')
<h4>Tambah Kategori</h4>
<form method="POST" action="{{ route('admin.categories.store') }}" class="mt-3">
  @csrf
  <div class="mb-3">
    <label class="form-label">Nama Kategori</label>
    <input type="text" name="name" class="form-control" required value="{{ old('name') }}">
  </div>
  <button class="btn btn-primary">Simpan</button>
</form>
@endsection
