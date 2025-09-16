@extends('components.admin.layout')

@section('content')
<h4>Tambah Package</h4>
<form method="POST" action="{{ route('admin.packages.store') }}" enctype="multipart/form-data" class="mt-3">
  @csrf
  <div class="mb-3">
    <label class="form-label">Judul</label>
    <input type="text" name="title" class="form-control" required value="{{ old('title') }}">
  </div>
  <div class="mb-3">
    <label class="form-label">Kategori</label>
    <select name="category_id" class="form-select text-black bg-white" required>
      <option value="" disabled>-- pilih --</option>
      @foreach($categories as $c)
        <option value="{{ $c->id }}" @selected(old('category_id')==$c->id)>{{ $c->name }}</option>
      @endforeach
    </select>
  </div>
  <div class="mb-3">
    <label class="form-label">Harga (Rp)</label>
    <input type="number" name="price" min="0" class="form-control" required value="{{ old('price') }}">
  </div>
  <div class="mb-3">
    <label class="form-label">Durasi (menit)</label>
    <input type="number" name="duration_minutes" min="0" class="form-control" value="{{ old('duration_minutes') }}">
  </div>
  <div class="mb-3">
    <label class="form-label">Deskripsi (satu baris = satu bullet)</label>
    <textarea name="description" rows="6" class="form-control" style="height: 100px"
      placeholder="Contoh:
        • Bridal makeup & hair styling
        • 2.5 jam sesi
        • Touch-up kit
        • Photo ready finish">{{ old('description', isset($package)
        ? implode("\n", $package->description_bullets)
        : '') }}</textarea>
    <div class="form-text">Tulis setiap poin di baris baru. Simbol • opsional.</div>
  </div>
  <div class="mb-3">
    <label class="form-label">Cover Image</label>
    <input type="file" name="cover_image" class="form-control">
  </div>
  <div class="mb-3">
    <label class="form-label">Status</label>
    <select name="status" class="form-select text-black bg-white">
      <option value="active">Active</option>
      <option value="inactive">Inactive</option>
    </select>
  </div>
  <button class="btn btn-primary">Simpan</button>
</form>
@endsection
