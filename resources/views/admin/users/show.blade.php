@extends('components.admin.layout')

@section('content')
<h4 class="mb-3">Detail User</h4>

<div class="card mb-4">
  <div class="card-body">
    <div class="row g-3">
      <div class="col-md-4">
        <div class="border rounded p-3 h-100">
          <h6 class="text-muted">Profil</h6>
          <div><strong>Nama:</strong> {{ $user->name }}</div>
          <div><strong>Email:</strong> {{ $user->email }}</div>
          <div><strong>Telepon:</strong> {{ $user->phone ?? '-' }}</div>
          <div><strong>Role:</strong> {{ $user->role }}</div>
          <div><strong>Terdaftar:</strong> {{ $user->created_at?->format('d M Y H:i') }}</div>
          <div><strong>Total Booking:</strong> {{ $user->bookings_count }}</div>
        </div>
      </div>
      <div class="col-md-8">
        <div class="border rounded p-3 h-100">
          <h6 class="text-muted mb-3">Riwayat Booking Terbaru</h6>
          <div class="table-responsive">
            <table class="table table-sm align-middle">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Order ID</th>
                  <th>Paket</th>
                  <th>Tgl Acara</th>
                  <th>Status Bayar</th>
                  <th>Total</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
              @forelse($user->bookings as $i => $b)
                <tr>
                  <td>{{ $i+1 }}</td>
                  <td>{{ $b->midtrans_order_id ?? '-' }}</td>
                  <td>{{ $b->package?->title }}</td>
                  <td>{{ \Carbon\Carbon::parse($b->event_date)->format('d M Y') }} {{ $b->event_time }}</td>
                  <td>
                    @php
                      $map = ['paid'=>'success','pending'=>'warning','failed'=>'danger','expired'=>'dark','cancel'=>'danger'];
                      $bg = $map[$b->payment_status] ?? 'secondary';
                    @endphp
                    <span class="badge bg-{{ $bg }}">{{ ucfirst($b->payment_status ?? 'unpaid') }}</span>
                  </td>
                  <td>Rp {{ number_format($b->subtotal,0,',','.') }}</td>
                  <td><a href="{{ route('admin.orders.show', $b) }}" class="btn btn-sm btn-outline-primary">Detail</a></td>
                </tr>
              @empty
                <tr><td colspan="7" class="text-center text-muted">Tidak ada riwayat.</td></tr>
              @endforelse
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Kembali</a>
@endsection
