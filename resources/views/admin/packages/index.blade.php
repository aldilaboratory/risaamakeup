@extends('components.admin.layout')

@section('content')
<div>
  <h4>Packages</h4>
  <a href="{{ route('admin.packages.create') }}" class="btn btn-primary my-3">+ Tambah Package</a>
</div>

<div class="card">
  <div class="card-body p-0">
    <div class="table-responsive">
      <table class="table table-striped align-middle mb-0">
        <thead>
          <tr>
            <th style="width: 60px;">#</th>
            <th style="width: 88px;">Cover</th>
            <th>Judul</th>
            <th>Kategori</th>
            <th>Deskripsi</th>
            <th>Harga</th>
            <th>Status</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          @forelse($packages as $i => $p)
          <tr>
            <td>{{ $packages->firstItem() + $i }}</td>
            <td>
              @if($p->cover_image)
                <img src="{{ asset('storage/'.$p->cover_image) }}" class="rounded" style="width:70px;height:50px;object-fit:cover" alt="cover">
              @else
                <div class="bg-light border rounded d-inline-flex align-items-center justify-content-center" style="width:70px;height:50px;">-</div>
              @endif
            </td>
            <td class="fw-semibold">
              {{ $p->title }}<br>
            </td>
            <td>{{ $p->category?->name ?? '-' }}</td>
            <td class="text-wrap" style="max-width: 350px;">
              {{ $p->description ?? '-' }}
            </td>
            <td>Rp {{ number_format($p->price, 0, ',', '.') }}</td>
            <td>
              <span class="badge {{ $p->status === 'active' ? 'bg-success' : 'bg-secondary' }}">
                {{ ucfirst($p->status) }}
              </span>
            </td>
            <td>
              <a href="{{ route('admin.packages.edit', $p) }}" class="btn btn-sm btn-info">Edit</a>
              {{-- Tautan lihat halaman publik bila ada --}}
              {{-- @if(Route::has('packages.public.show'))
                <a href="{{ route('packages.public.show', $p->slug) }}" target="_blank" class="btn btn-sm btn-outline-primary">Lihat</a>
              @endif --}}
              <form action="{{ route('admin.packages.destroy', $p) }}" method="POST" class="d-inline delete-form">
                @csrf @method('DELETE')
                <button type="button" class="btn btn-sm btn-outline-danger btn-delete">Hapus</button>
              </form>
            </td>
          </tr>
          @empty
          <tr><td colspan="7" class="text-center py-4">Belum ada package.</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
  @if($packages instanceof \Illuminate\Pagination\AbstractPaginator)
    <div class="card-footer">{{ $packages->links() }}</div>
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
