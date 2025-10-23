@extends('components.admin.layout')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
  <h4 class="mb-0">Data User (Customer)</h4>
  <form class="d-flex" method="get" action="{{ route('admin.users.index') }}">
    <input type="text" class="form-control form-control-sm me-2" name="q"
           value="{{ $search }}" placeholder="Cari nama/email/telepon">
    <button class="btn btn-sm btn-primary">Cari</button>
  </form>
</div>

<div class="card">
  <div class="card-body p-0">
    <div class="table-responsive">
      <table class="table table-striped align-middle mb-0">
        <thead>
          <tr>
            <th style="width: 60px;">#</th>
            <th>Nama</th>
            <th>Email</th>
            <th>Telepon</th>
            <th>Total Booking</th>
            <th>Terdaftar</th>
            <th style="width:120px;">Aksi</th>
          </tr>
        </thead>
        <tbody>
          @forelse($users as $i => $u)
          <tr>
            <td>{{ $users->firstItem() + $i }}</td>
            <td>{{ $u->name }}</td>
            <td>{{ $u->email }}</td>
            <td>{{ $u->phone ?? '-' }}</td>
            <td><span class="badge bg-info">{{ $u->bookings_count }}</span></td>
            <td>{{ $u->created_at?->format('d M Y') }}</td>
            <td>
              <a href="{{ route('admin.users.show', $u) }}" class="btn btn-sm btn-outline-primary">Detail</a>
            </td>
          </tr>
          @empty
          <tr><td colspan="7" class="text-center py-4 text-muted">Belum ada data.</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
  @if($users instanceof \Illuminate\Pagination\AbstractPaginator)
    <div class="card-footer">{{ $users->links() }}</div>
  @endif
</div>
@endsection
