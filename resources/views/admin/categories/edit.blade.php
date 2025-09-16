@extends('components.admin.layout')

@section('content')
<h4>Edit Kategori</h4>

@if($errors->any())
  <div class="alert alert-danger">
    <ul class="mb-0">
      @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
    </ul>
  </div>
@endif

<form method="POST" action="{{ route('admin.categories.update', $category) }}" class="mt-3">
  @csrf @method('PUT')

  <div class="mb-3">
    <label class="form-label">Nama</label>
    <input type="text" name="name" class="form-control" required value="{{ old('name', $category->name) }}">
  </div>

  <div class="d-flex gap-2">
    <button class="btn btn-primary">Simpan Perubahan</button>
    <a href="{{ route('admin.categories.index') }}" class="btn btn-light">Kembali</a>
  </div>
</form>
@endsection
