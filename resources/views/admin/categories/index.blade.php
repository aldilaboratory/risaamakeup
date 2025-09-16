@extends('components.admin.layout')

@section('content')
<div>
  <h4>Kategori</h4>
  <a href="{{ route('admin.categories.create') }}" class="btn btn-primary my-3">+ Tambah Kategori</a>
</div>

<div class="card">
  <div class="card-body p-0">
    <div class="table-responsive">
      <table class="table table-striped align-middle mb-0">
        <thead>
          <tr>
            <th style="width: 60px;">#</th>
            <th>Nama</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          @forelse($categories as $i => $c)
          <tr>
            <td>{{ $categories->firstItem() + $i }}</td>
            <td>{{ $c->name }}</td>
            <td>
              <a href="{{ route('admin.categories.edit', $c) }}" class="btn btn-sm btn-info">Edit</a>
              <form action="{{ route('admin.categories.destroy', $c) }}" method="POST" class="d-inline">
                @csrf @method('DELETE')
                <button type="button" class="btn btn-sm btn-outline-danger btn-delete">Hapus</button>
              </form>
            </td>
          </tr>
          @empty
          <tr><td colspan="4" class="text-center py-4">Belum ada kategori.</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
  @if($categories instanceof \Illuminate\Pagination\AbstractPaginator)
    <div class="card-footer">{{ $categories->links() }}</div>
  @endif
</div>

<script>
document.querySelectorAll('.btn-delete').forEach(btn => {
  btn.addEventListener('click', function () {
    const form = this.closest('form');
    Swal.fire({
      title: 'Hapus data?',
      text: 'Tindakan ini tidak bisa dibatalkan.',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Ya, hapus',
      cancelButtonText: 'Batal'
    }).then((result) => {
      if (result.isConfirmed) form.submit();
    });
  });
});
</script>
@endsection
