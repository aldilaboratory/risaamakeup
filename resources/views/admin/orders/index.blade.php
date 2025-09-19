@extends('components.admin.layout')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
  <h4>Pesanan Booking</h4>
  <div class="d-flex gap-2">
    <select class="form-select" id="statusFilter" style="width: auto;">
      <option value="">Semua Status</option>
      <option value="pending">Pending</option>
      <option value="approved">Disetujui</option>
      <option value="rejected">Ditolak</option>
      <option value="completed">Selesai</option>
      <option value="cancelled">Dibatalkan</option>
    </select>
  </div>
</div>

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
  {{ session('success') }}
  <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

<div class="card">
  <div class="card-body p-0">
    <div class="table-responsive">
      <table class="table table-striped align-middle mb-0">
        <thead>
          <tr>
            <th style="width: 60px;">#</th>
            <th>Nama Customer</th>
            <th>Package</th>
            <th>Tanggal Acara</th>
            <th>Lokasi</th>
            <th>Total</th>
            <th>Status Booking</th>
            <th>Status Pembayaran</th>
            <th>Tanggal Order</th>
            <th style="width: 200px;">Aksi</th>
          </tr>
        </thead>
        <tbody>
          @forelse($bookings as $i => $booking)
          <tr data-booking-id="{{ $booking->id }}">
            <td>{{ $bookings->firstItem() + $i }}</td>
            <td>
              <div class="fw-semibold">{{ $booking->name }}</div>
              <small class="text-muted">{{ $booking->phone }}</small>
            </td>
            <td>
              <div class="fw-semibold">{{ $booking->package?->title ?? '-' }}</div>
              <small class="text-muted">{{ $booking->category?->name ?? '-' }}</small>
            </td>
            <td>
              <div>{{ \Carbon\Carbon::parse($booking->event_date)->format('d/m/Y') }}</div>
              <small class="text-muted">{{ $booking->event_time }}</small>
            </td>
            <td>
              <div>{{ $booking->location }}</div>
              @if($booking->city)
                <small class="text-muted">{{ $booking->city }}</small>
              @endif
            </td>
            <td>
              <div class="fw-semibold">Rp {{ number_format($booking->pay_now, 0, ',', '.') }}</div>
            </td>
            <td>
              @php
                $statusColors = [
                  'pending' => 'warning',
                  'confirmed' => 'success', 
                  'canceled' => 'danger',
                  'done' => 'primary'
                ];
                $statusLabels = [
                  'pending' => 'Pending',
                  'confirmed' => 'Disetujui',
                  'canceled' => 'Ditolak', 
                  'done' => 'Selesai'
                ];
              @endphp
              <span class="badge status-badge bg-{{ $statusColors[$booking->status] ?? 'secondary' }}">
                {{ $statusLabels[$booking->status] ?? ucfirst($booking->status) }}
              </span>
            </td>
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
              <span class="badge bg-{{ $paymentColors[$booking->payment_status] ?? 'secondary' }}">
                {{ $paymentLabels[$booking->payment_status] ?? ucfirst($booking->payment_status) }}
              </span>
            </td>
            <td>
              <div>{{ $booking->created_at->format('d/m/Y') }}</div>
              <small class="text-muted">{{ $booking->created_at->format('H:i') }}</small>
            </td>
            <td>
              <div class="action-buttons btn-group-vertical gap-1" style="width: 100%;">
                @if($booking->payment_status === 'paid' && $booking->status === 'pending')
                  <button type="button" class="btn btn-sm btn-success" onclick="approveBooking({{ $booking->id }})">
                    ✓ Setujui
                  </button>
                  <button type="button" class="btn btn-sm btn-danger" onclick="rejectBooking({{ $booking->id }})">
                    ✗ Tolak
                  </button>
                @endif
                
                {{-- Tombol Detail untuk semua booking yang sudah dibayar --}}
                @if($booking->payment_status === 'paid')
                  <a href="{{ route('admin.orders.show', $booking) }}" class="btn btn-sm btn-info">
                    👁 Detail
                  </a>
                @endif
              </div>
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="10" class="text-center py-4">
              <div class="text-muted">Belum ada pesanan booking</div>
            </td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>

<div class="d-flex justify-content-center mt-4">
  {{ $bookings->links() }}
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
let currentBookingId = null;

function approveBooking(bookingId) {
  currentBookingId = bookingId;
  new bootstrap.Modal(document.getElementById('approveModal')).show();
}

function rejectBooking(bookingId) {
  currentBookingId = bookingId;
  new bootstrap.Modal(document.getElementById('rejectModal')).show();
}

// Handle approve form submission
document.getElementById('approveForm').addEventListener('submit', function(e) {
  e.preventDefault();
  
  if (!currentBookingId) return;
  
  const submitBtn = this.querySelector('button[type="submit"]');
  const originalText = submitBtn.textContent;
  submitBtn.disabled = true;
  submitBtn.textContent = 'Memproses...';
  
  const formData = new FormData();
  formData.append('_method', 'PATCH');
  
  fetch(`/admin/orders/${currentBookingId}/approve`, {
    method: 'POST',
    headers: {
      'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
    },
    body: formData
  })
  .then(response => response.json())
  .then(data => {
    if (data.success) {
      // Update status badge in table
      updateStatusBadge(currentBookingId, data.status);
      // Hide action buttons for this row
      hideActionButtons(currentBookingId);
      // Show success message
      showAlert('success', data.message);
      // Hide modal
      bootstrap.Modal.getInstance(document.getElementById('approveModal')).hide();
    } else {
      showAlert('danger', 'Terjadi kesalahan saat menyetujui booking');
    }
  })
  .catch(error => {
    console.error('Error:', error);
    showAlert('danger', 'Terjadi kesalahan saat menyetujui booking');
  })
  .finally(() => {
    submitBtn.disabled = false;
    submitBtn.textContent = originalText;
  });
});

// Handle reject form submission
document.getElementById('rejectForm').addEventListener('submit', function(e) {
  e.preventDefault();
  
  if (!currentBookingId) return;
  
  const submitBtn = this.querySelector('button[type="submit"]');
  const originalText = submitBtn.textContent;
  submitBtn.disabled = true;
  submitBtn.textContent = 'Memproses...';
  
  const formData = new FormData(this);
  formData.append('_method', 'PATCH');
  
  fetch(`/admin/orders/${currentBookingId}/reject`, {
    method: 'POST',
    headers: {
      'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
    },
    body: formData
  })
  .then(response => response.json())
  .then(data => {
    if (data.success) {
      // Update status badge in table
      updateStatusBadge(currentBookingId, data.status);
      // Hide action buttons for this row
      hideActionButtons(currentBookingId);
      // Show success message
      showAlert('success', data.message);
      // Hide modal
      bootstrap.Modal.getInstance(document.getElementById('rejectModal')).hide();
      // Clear form
      this.reset();
    } else {
      showAlert('danger', 'Terjadi kesalahan saat menolak booking');
    }
  })
  .catch(error => {
    console.error('Error:', error);
    showAlert('danger', 'Terjadi kesalahan saat menolak booking');
  })
  .finally(() => {
    submitBtn.disabled = false;
    submitBtn.textContent = originalText;
  });
});

function updateStatusBadge(bookingId, status) {
  const row = document.querySelector(`tr[data-booking-id="${bookingId}"]`);
  if (row) {
    const statusBadge = row.querySelector('.status-badge');
    if (statusBadge) {
      // Remove old classes
      statusBadge.classList.remove('bg-warning', 'bg-success', 'bg-danger', 'bg-primary');
      
      // Add new class and text based on status
      switch(status) {
        case 'pending':
          statusBadge.classList.add('bg-warning');
          statusBadge.textContent = 'Pending';
          break;
        case 'confirmed':
          statusBadge.classList.add('bg-success');
          statusBadge.textContent = 'Disetujui';
          break;
        case 'canceled':
          statusBadge.classList.add('bg-danger');
          statusBadge.textContent = 'Ditolak';
          break;
        case 'done':
          statusBadge.classList.add('bg-primary');
          statusBadge.textContent = 'Selesai';
          break;
      }
    }
  }
}

function hideActionButtons(bookingId) {
  const row = document.querySelector(`tr[data-booking-id="${bookingId}"]`);
  if (row) {
    const actionButtons = row.querySelector('.action-buttons');
    if (actionButtons) {
      actionButtons.innerHTML = '<span class="text-muted">-</span>';
    }
  }
}

function showAlert(type, message) {
  // Remove existing alerts
  const existingAlerts = document.querySelectorAll('.alert-auto-dismiss');
  existingAlerts.forEach(alert => alert.remove());
  
  // Create new alert
  const alertDiv = document.createElement('div');
  alertDiv.className = `alert alert-${type} alert-dismissible fade show alert-auto-dismiss`;
  alertDiv.innerHTML = `
    ${message}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
  `;
  
  // Insert at top of content
  const contentWrapper = document.querySelector('.content-wrapper');
  contentWrapper.insertBefore(alertDiv, contentWrapper.firstChild);
  
  // Auto dismiss after 5 seconds
  setTimeout(() => {
    if (alertDiv.parentNode) {
      alertDiv.remove();
    }
  }, 5000);
}

// Filter by status
document.getElementById('statusFilter').addEventListener('change', function() {
  const status = this.value;
  const url = new URL(window.location);
  if (status) {
    url.searchParams.set('status', status);
  } else {
    url.searchParams.delete('status');
  }
  window.location = url;
});

// Set current filter value
const urlParams = new URLSearchParams(window.location.search);
const currentStatus = urlParams.get('status');
if (currentStatus) {
  document.getElementById('statusFilter').value = currentStatus;
}
</script>
@endsection