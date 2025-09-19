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
                <i class="fab fa-whatsapp"></i> Chat
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
                  'cancelled' => 'secondary'
                ];
                $statusLabels = [
                  'pending' => 'Menunggu',
                  'approved' => 'Disetujui',
                  'rejected' => 'Ditolak', 
                  'completed' => 'Selesai',
                  'cancelled' => 'Dibatalkan'
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
            <td class="fw-bold">Rp {{ number_format($booking->pay_now, 0, ',', '.') }}</td>
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

<!-- Aksi -->
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
          <select class="form-select" id="statusSelect" style="max-width: 200px;">
            <option value="">Ubah Status</option>
            <option value="pending" {{ $booking->status === 'pending' ? 'selected' : '' }}>Menunggu</option>
            <option value="approved" {{ $booking->status === 'approved' ? 'selected' : '' }}>Disetujui</option>
            <option value="rejected" {{ $booking->status === 'rejected' ? 'selected' : '' }}>Ditolak</option>
            <option value="completed" {{ $booking->status === 'completed' ? 'selected' : '' }}>Selesai</option>
            <option value="cancelled" {{ $booking->status === 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
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
</div>

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
<script>
function approveBooking(bookingId) {
  const form = document.getElementById('approveForm');
  form.action = `/admin/orders/${bookingId}/approve`;
  new bootstrap.Modal(document.getElementById('approveModal')).show();
}

function rejectBooking(bookingId) {
  const form = document.getElementById('rejectForm');
  form.action = `/admin/orders/${bookingId}/reject`;
  new bootstrap.Modal(document.getElementById('rejectModal')).show();
}

function updateStatus() {
  const status = document.getElementById('statusSelect').value;
  if (!status) return;
  
  const form = document.createElement('form');
  form.method = 'POST';
  form.action = `/admin/orders/{{ $booking->id }}/status`;
  
  const csrfToken = document.createElement('input');
  csrfToken.type = 'hidden';
  csrfToken.name = '_token';
  csrfToken.value = '{{ csrf_token() }}';
  
  const methodField = document.createElement('input');
  methodField.type = 'hidden';
  methodField.name = '_method';
  methodField.value = 'PATCH';
  
  const statusField = document.createElement('input');
  statusField.type = 'hidden';
  statusField.name = 'status';
  statusField.value = status;
  
  form.appendChild(csrfToken);
  form.appendChild(methodField);
  form.appendChild(statusField);
  
  document.body.appendChild(form);
  form.submit();
}
</script>

<style>
.timeline {
  position: relative;
  padding-left: 30px;
}

.timeline-item {
  position: relative;
  margin-bottom: 20px;
}

.timeline-marker {
  position: absolute;
  left: -35px;
  top: 5px;
  width: 12px;
  height: 12px;
  border-radius: 50%;
}

.timeline-item:not(:last-child)::before {
  content: '';
  position: absolute;
  left: -30px;
  top: 17px;
  width: 2px;
  height: calc(100% + 5px);
  background-color: #dee2e6;
}

.timeline-title {
  margin-bottom: 5px;
  font-size: 14px;
}

.timeline-text {
  margin-bottom: 0;
  font-size: 13px;
  color: #6c757d;
}
</style>
@endsection