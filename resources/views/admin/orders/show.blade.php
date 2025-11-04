@extends('components.admin.layout')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
  <h4>Detail Pesanan #{{ $booking->id }}</h4>
  <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">← Kembali</a>
</div>

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
  {{ session('success') }}
  <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

<div class="row">
  <!-- Informasi Customer -->
  <div class="col-md-6">
    <div class="card mb-4">
      <div class="card-header">
        <h5 class="card-title mb-0">Informasi Customer</h5>
      </div>
      <div class="card-body">
        <table class="table table-borderless">
          <tr>
            <td class="fw-semibold" style="width: 120px;">Nama:</td>
            <td>{{ $booking->name }}</td>
          </tr>
          <tr>
            <td class="fw-semibold">No. WhatsApp:</td>
            <td>
              {{ $booking->phone }}
              <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $booking->phone) }}" target="_blank" class="btn btn-sm btn-success ms-2">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" width="16" height="16" fill="currentColor"><path d="M380.9 97.1c-41.9-42-97.7-65.1-157-65.1-122.4 0-222 99.6-222 222 0 39.1 10.2 77.3 29.6 111L0 480 117.7 449.1c32.4 17.7 68.9 27 106.1 27l.1 0c122.3 0 224.1-99.6 224.1-222 0-59.3-25.2-115-67.1-157zm-157 341.6c-33.2 0-65.7-8.9-94-25.7l-6.7-4-69.8 18.3 18.6-68.1-4.4-7c-18.5-29.4-28.2-63.3-28.2-98.2 0-101.7 82.8-184.5 184.6-184.5 49.3 0 95.6 19.2 130.4 54.1s56.2 81.2 56.1 130.5c0 101.8-84.9 184.6-186.6 184.6zM325.1 300.5c-5.5-2.8-32.8-16.2-37.9-18-5.1-1.9-8.8-2.8-12.5 2.8s-14.3 18-17.6 21.8c-3.2 3.7-6.5 4.2-12 1.4-32.6-16.3-54-29.1-75.5-66-5.7-9.8 5.7-9.1 16.3-30.3 1.8-3.7 .9-6.9-.5-9.7s-12.5-30.1-17.1-41.2c-4.5-10.8-9.1-9.3-12.5-9.5-3.2-.2-6.9-.2-10.6-.2s-9.7 1.4-14.8 6.9c-5.1 5.6-19.4 19-19.4 46.3s19.9 53.7 22.6 57.4c2.8 3.7 39.1 59.7 94.8 83.8 35.2 15.2 49 16.5 66.6 13.9 10.7-1.6 32.8-13.4 37.4-26.4s4.6-24.1 3.2-26.4c-1.3-2.5-5-3.9-10.5-6.6z"/></svg>
              </a>
            </td>
          </tr>
          <tr>
            <td class="fw-semibold">Kota:</td>
            <td>{{ $booking->city ?? '-' }}</td>
          </tr>
          <tr>
            <td class="fw-semibold">Lokasi Acara:</td>
            <td>{{ $booking->location }}</td>
          </tr>
        </table>
      </div>
    </div>
  </div>

  <!-- Informasi Acara -->
  <div class="col-md-6">
    <div class="card mb-4">
      <div class="card-header">
        <h5 class="card-title mb-0">Informasi Acara</h5>
      </div>
      <div class="card-body">
        <table class="table table-borderless">
          <tr>
            <td class="fw-semibold" style="width: 120px;">Tanggal:</td>
            <td>{{ \Carbon\Carbon::parse($booking->event_date)->format('d F Y') }}</td>
          </tr>
          <tr>
            <td class="fw-semibold">Waktu:</td>
            <td>{{ $booking->event_time }}</td>
          </tr>
          <tr>
            <td class="fw-semibold">Package:</td>
            <td>
              <div class="fw-semibold">{{ $booking->package?->title ?? '-' }}</div>
              <small class="text-muted">{{ $booking->category?->name ?? '-' }}</small>
            </td>
          </tr>
        </table>
      </div>
    </div>
  </div>
</div>

<div class="row">
  <!-- Status & Pembayaran -->
  <div class="col-md-6">
    <div class="card mb-4">
      <div class="card-header">
        <h5 class="card-title mb-0">Status & Pembayaran</h5>
      </div>
      <div class="card-body">
        <table class="table table-borderless">
          <tr>
            <td class="fw-semibold" style="width: 140px;">Status Booking:</td>
            <td>
              @php
                $statusColors = [
                  'pending' => 'warning',
                  'approved' => 'success',
                  'rejected' => 'danger',
                  'completed' => 'primary',
                  'cancelled' => 'secondary',
                  // kompatibel enum lama (jika kebetulan ada)
                  'confirmed' => 'success',
                  'canceled'  => 'danger',
                  'done'      => 'primary',
                ];
                $statusLabels = [
                  'pending' => 'Menunggu',
                  'approved' => 'Disetujui',
                  'rejected' => 'Ditolak',
                  'completed' => 'Selesai',
                  'cancelled' => 'Dibatalkan',
                  'confirmed' => 'Disetujui',
                  'canceled'  => 'Ditolak',
                  'done'      => 'Selesai',
                ];
              @endphp
              <span class="badge bg-{{ $statusColors[$booking->status] ?? 'secondary' }} fs-6">
                {{ $statusLabels[$booking->status] ?? ucfirst($booking->status) }}
              </span>
            </td>
          </tr>
          <tr>
            <td class="fw-semibold">Status Pembayaran:</td>
            <td>
              @php
                $paymentColors = [
                  'paid' => 'success',
                  'pending' => 'warning',
                  'unpaid' => 'secondary',
                  'failed' => 'danger',
                  'expired' => 'dark',
                  'cancel' => 'secondary'
                ];
                $paymentLabels = [
                  'paid' => 'Lunas',
                  'pending' => 'Pending',
                  'unpaid' => 'Belum Bayar',
                  'failed' => 'Gagal',
                  'expired' => 'Expired',
                  'cancel' => 'Dibatalkan'
                ];
              @endphp
              <span class="badge bg-{{ $paymentColors[$booking->payment_status] ?? 'secondary' }} fs-6">
                {{ $paymentLabels[$booking->payment_status] ?? ucfirst($booking->payment_status) }}
              </span>
            </td>
          </tr>
          <tr>
            <td class="fw-semibold">Subtotal:</td>
            <td>Rp {{ number_format($booking->subtotal, 0, ',', '.') }}</td>
          </tr>
          <tr>
            <td class="fw-semibold">Total Bayar:</td>
            <td class="fw-bold">Rp {{ number_format($booking->subtotal, 0, ',', '.') }}</td>
          </tr>
          @if($booking->midtrans_order_id)
          <tr>
            <td class="fw-semibold">Order ID:</td>
            <td><code>{{ $booking->midtrans_order_id }}</code></td>
          </tr>
          @endif
        </table>
      </div>
    </div>
  </div>

  <!-- Catatan -->
  <div class="col-md-6">
    <div class="card mb-4">
      <div class="card-header">
        <h5 class="card-title mb-0">Catatan</h5>
      </div>
      <div class="card-body">
        @if($booking->notes)
          <p class="mb-0">{{ $booking->notes }}</p>
        @else
          <p class="text-muted mb-0">Tidak ada catatan</p>
        @endif
      </div>
    </div>
  </div>
</div>

{{-- <!-- Aksi -->
<div class="card">
  <div class="card-header">
    <h5 class="card-title mb-0">Aksi</h5>
  </div>
  <div class="card-body">
    <div class="row">
      @if($booking->status === 'pending')
      <div class="col-md-6">
          <button type="button" class="btn btn-success me-2" onclick="approveBooking({{ $booking->id }})">
            ✓ Setujui Booking
          </button>
          <button type="button" class="btn btn-danger" onclick="rejectBooking({{ $booking->id }})">
            ✗ Tolak Booking
          </button>
      </div>
      @endif
      <div class="col-md-6">
        <div class="d-flex gap-2">
          @php
            $supportsNew = \App\Models\Booking::whereIn('status',['approved','rejected','completed','cancelled'])->exists();
            $options = $supportsNew
              ? ['pending'=>'Menunggu','approved'=>'Disetujui','rejected'=>'Ditolak','completed'=>'Selesai','cancelled'=>'Dibatalkan']
              : ['pending'=>'Menunggu','confirmed'=>'Disetujui','canceled'=>'Ditolak','done'=>'Selesai'];
          @endphp

          <select class="form-select" id="statusSelect" style="max-width: 200px;">
            <option value="">Ubah Status</option>
            @foreach($options as $value => $label)
              <option value="{{ $value }}" {{ $booking->status === $value ? 'selected' : '' }}>{{ $label }}</option>
            @endforeach
          </select>
          <button type="button" class="btn btn-primary" onclick="updateStatus()">Update</button>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Timeline -->
<div class="card mt-4">
  <div class="card-header">
    <h5 class="card-title mb-0">Timeline</h5>
  </div>
  <div class="card-body">
    <div class="timeline">
      <div class="timeline-item">
        <div class="timeline-marker bg-primary"></div>
        <div class="timeline-content">
          <h6 class="timeline-title">Booking Dibuat</h6>
          <p class="timeline-text">{{ $booking->created_at->format('d F Y, H:i') }}</p>
        </div>
      </div>
      @if($booking->updated_at != $booking->created_at)
      <div class="timeline-item">
        <div class="timeline-marker bg-info"></div>
        <div class="timeline-content">
          <h6 class="timeline-title">Terakhir Diupdate</h6>
          <p class="timeline-text">{{ $booking->updated_at->format('d F Y, H:i') }}</p>
        </div>
      </div>
      @endif
    </div>
  </div>
</div> --}}

<!-- Modal Approve -->
<div class="modal fade" id="approveModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Konfirmasi Persetujuan</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <p>Apakah Anda yakin ingin menyetujui booking ini?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        <form id="approveForm" method="POST" style="display: inline;">
          @csrf
          @method('PATCH')
          <button type="submit" class="btn btn-success">Ya, Setujui</button>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Modal Reject -->
<div class="modal fade" id="rejectModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Konfirmasi Penolakan</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <form id="rejectForm" method="POST">
        @csrf
        @method('PATCH')
        <div class="modal-body">
          <p>Apakah Anda yakin ingin menolak booking ini?</p>
          <div class="mb-3">
            <label for="rejection_reason" class="form-label">Alasan Penolakan (Opsional)</label>
            <textarea class="form-control" id="rejection_reason" name="rejection_reason" rows="3" placeholder="Masukkan alasan penolakan..."></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-danger">Ya, Tolak</button>
        </div>
      </form>
    </div>
  </div>
</div>

@endsection

@section('scripts')

<style>
.timeline { position: relative; padding-left: 30px; }
.timeline-item { position: relative; margin-bottom: 20px; }
.timeline-marker { position: absolute; left: -35px; top: 5px; width: 12px; height: 12px; border-radius: 50%; }
.timeline-item:not(:last-child)::before {
  content: ''; position: absolute; left: -30px; top: 17px; width: 2px; height: calc(100% + 5px); background-color: #dee2e6;
}
.timeline-title { margin-bottom: 5px; font-size: 14px; }
.timeline-text { margin-bottom: 0; font-size: 13px; color: #6c757d; }
</style>

<script>
// helper aman JSON (kalau server balikin HTML/redirect)
async function fetchJsonSafe(url, options = {}) {
  const res = await fetch(url, options);
  const ok = res.ok;
  const ct = res.headers.get('content-type') || '';
  if (ct.includes('application/json')) {
    const data = await res.json();
    if (!ok) throw new Error(data?.message || 'HTTP ' + res.status);
    return data;
  } else {
    if (!ok) throw new Error('HTTP ' + res.status);
    return { success: true };
  }
}

function approveBooking(bookingId) {
  const form = document.getElementById('approveForm');
  form.onsubmit = async function(e) {
    e.preventDefault();
    const btn = form.querySelector('button[type="submit"]');
    const txt = btn.textContent; btn.disabled = true; btn.textContent='Memproses...';
    const fd = new FormData(); fd.append('_method','PATCH');
    try {
      const data = await fetchJsonSafe(`/admin/orders/${bookingId}/approve`, {
        method: 'POST',
        headers: {
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
          'Accept': 'application/json',
          'X-Requested-With': 'XMLHttpRequest',
        },
        body: fd
      });
      if (data.success) location.reload(); else alert(data.message || 'Gagal menyetujui');
    } catch(e){ alert('Gagal menyetujui'); }
    finally { btn.disabled=false; btn.textContent=txt; }
  };
  new bootstrap.Modal(document.getElementById('approveModal')).show();
}

function rejectBooking(bookingId) {
  const form = document.getElementById('rejectForm');
  form.onsubmit = async function(e) {
    e.preventDefault();
    const btn = form.querySelector('button[type="submit"]');
    const txt = btn.textContent; btn.disabled = true; btn.textContent='Memproses...';
    const fd = new FormData(form); fd.append('_method','PATCH');
    try {
      const data = await fetchJsonSafe(`/admin/orders/${bookingId}/reject`, {
        method: 'POST',
        headers: {
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
          'Accept': 'application/json',
          'X-Requested-With': 'XMLHttpRequest',
        },
        body: fd
      });
      if (data.success) location.reload(); else alert(data.message || 'Gagal menolak');
    } catch(e){ alert('Gagal menolak'); }
    finally { btn.disabled=false; btn.textContent=txt; }
  };
  new bootstrap.Modal(document.getElementById('rejectModal')).show();
}

async function updateStatus() {
  const status = document.getElementById('statusSelect').value;
  if (!status) return;

  const fd = new FormData();
  fd.append('_method', 'PATCH');
  fd.append('status', status);

  try {
    const data = await fetchJsonSafe(`/admin/orders/{{ $booking->id }}/status`, {
      method: 'POST',
      headers: {
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        'Accept': 'application/json',
        'X-Requested-With': 'XMLHttpRequest',
      },
      body: fd
    });

    if (data.success) {
      location.reload();
    } else {
      alert(data.message || 'Gagal update status');
    }
  } catch (e) {
    console.error(e);
    alert('Gagal update status');
  }
}
</script>

@endsection
