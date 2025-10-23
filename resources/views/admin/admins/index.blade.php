@extends('components.admin.layout')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
  <h4 class="mb-0">Data Admin</h4>
  <div class="d-flex">
    <form method="get" class="d-flex me-2">
      <input type="text" name="q" value="{{ $q }}" class="form-control form-control-sm" placeholder="Cari nama/email/telepon">
      <button class="btn btn-sm btn-primary ms-2">Cari</button>
    </form>
    <a href="{{ route('admin.admins.create') }}" class="btn btn-sm btn-success">+ Tambah Admin</a>
  </div>
</div>

@if(session('success'))
  <div class="alert alert-success">{{ session('success') }}</div>
@endif
@if(session('error'))
  <div class="alert alert-danger">{{ session('error') }}</div>
@endif

<div class="card">
  <div class="card-body p-0">
    <div class="table-responsive">
      <table class="table table-striped align-middle mb-0">
        <thead>
          <tr>
            <th style="width:60px;">#</th>
            <th>Nama</th>
            <th>Email</th>
            <th>Telepon</th>
            <th>Terdaftar</th>
            <th style="width:140px;">Aksi</th>
          </tr>
        </thead>
        <tbody>
          @forelse($admins as $i => $a)
            <tr>
              <td>{{ $admins->firstItem() + $i }}</td>
              <td>{{ $a->name }}</td>
              <td>{{ $a->email }}</td>
              <td>{{ $a->phone ?? '-' }}</td>
              <td>{{ $a->created_at?->format('d M Y') }}</td>
              <td>
                <a href="{{ route('admin.admins.edit', $a) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                <form action="{{ route('admin.admins.destroy', $a) }}" method="POST" class="d-inline">
                  @csrf @method('DELETE')
                  <button type="submit" class="btn btn-sm btn-outline-danger btn-delete">Hapus</button>
                </form>
              </td>
            </tr>
          @empty
            <tr><td colspan="6" class="text-center py-4 text-muted">Belum ada admin.</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
  @if($admins instanceof \Illuminate\Pagination\AbstractPaginator)
    <div class="card-footer">{{ $admins->links() }}</div>
  @endif
</div>

<script>
document.querySelectorAll('.btn-delete').forEach(btn => {
  btn.addEventListener('click', function(e){
    if(!confirm('Hapus admin ini?')) e.preventDefault();
  });
});
</script>
@endsection
