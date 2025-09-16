@extends('components.admin.layout')

@section('content')
<h4>Edit Package</h4>

@if($errors->any())
  <div class="alert alert-danger">
    <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
  </div>
@endif

<form method="POST" action="{{ route('admin.packages.update', $package) }}" enctype="multipart/form-data" class="mt-3">
  @csrf @method('PUT')

  <div class="row g-4">
    <div class="col-md-12">
      <div class="mb-3">
        <label class="form-label">Judul</label>
        <input type="text" name="title" class="form-control" required value="{{ old('title', $package->title) }}">
      </div>

      <div class="mb-3">
        <label class="form-label">Deskripsi</label>
        <textarea name="description" rows="5" class="form-control">{{ old('description', $package->description) }}</textarea>
      </div>
      <div class="mb-3">
        <label class="form-label">Kategori</label>
        <select name="category_id" class="form-select text-dark bg-white" required>
          <option value="" disabled>-- pilih --</option>
          @foreach($categories as $c)
            <option value="{{ $c->id }}" @selected(old('category_id', $package->category_id)==$c->id)>{{ $c->name }}</option>
          @endforeach
        </select>
      </div>

      <div class="mb-3">
        <label class="form-label">Harga (Rp)</label>
        <input type="number" name="price" min="0" class="form-control" required value="{{ old('price', $package->price) }}">
      </div>

      <div class="mb-3">
        <label class="form-label">Durasi (menit)</label>
        <input type="number" name="duration_minutes" min="0" class="form-control" value="{{ old('duration_minutes', $package->duration_minutes) }}">
      </div>

      <div class="mb-3">
        <label class="form-label">Status</label>
        <select name="status" class="form-select text-black bg-white">
          <option value="active" @selected(old('status', $package->status) === 'active')>Active</option>
          <option value="inactive" @selected(old('status', $package->status) === 'inactive')>Inactive</option>
        </select>
      </div>

      <div class="mb-3">
        <label class="form-label d-block">Cover Image</label>
        @if($package->cover_image)
          <img src="{{ asset('storage/'.$package->cover_image) }}" class="rounded mb-2" style="max-width: 160px; height: 110px; object-fit: cover;" alt="cover">
        @endif
        <input type="file" name="cover_image" class="form-control">
        <div class="form-text">Maks 2MB. Biarkan kosong jika tidak diganti.</div>
      </div>
    </div>
  </div>

  <div class="d-flex gap-2">
    <button class="btn btn-primary">Simpan Perubahan</button>
    <a href="{{ route('admin.packages.index') }}" class="btn btn-light">Kembali</a>
  </div>
</form>
@endsection
