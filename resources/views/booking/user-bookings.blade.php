<x-user.layout>

@section('title', 'Pesanan Saya')

<div class="container py-5" style="margin-top: 50px">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="mb-0">
                    <i class="fas fa-list-alt me-2 text-primary"></i>
                    Pesanan Saya
                </h2>
                <a href="{{ url('/') }}" class="btn btn-outline-primary">
                    <i class="fas fa-home me-1"></i>Kembali ke Beranda
                </a>
            </div>

            @if($bookings->count() > 0)
                <div class="row">
                    @foreach($bookings as $booking)
                        <div class="col-md-6 mb-4">
                            <div class="card shadow-sm h-100">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h6 class="mb-0 fw-bold">{{ $booking->package->title }}</h6>
                                    <span class="badge 
                                        @if($booking->payment_status === 'paid') bg-success
                                        @elseif($booking->payment_status === 'pending') bg-warning
                                        @elseif($booking->payment_status === 'failed') bg-danger
                                        @elseif($booking->payment_status === 'expired') bg-secondary
                                        @else bg-info
                                        @endif">
                                        @if($booking->payment_status === 'paid') Lunas
                                        @elseif($booking->payment_status === 'pending') Menunggu Pembayaran
                                        @elseif($booking->payment_status === 'failed') Gagal
                                        @elseif($booking->payment_status === 'expired') Kadaluarsa
                                        @else {{ ucfirst($booking->payment_status) }}
                                        @endif
                                    </span>
                                </div>
                                <div class="card-body">
                                    <div class="row mb-3">
                                        <div class="col-sm-4">
                                            <small class="text-muted">Kategori:</small>
                                            <div class="fw-semibold">{{ ucfirst($booking->category->name) }}</div>
                                        </div>
                                        <div class="col-sm-4">
                                            <small class="text-muted">Tanggal Acara:</small>
                                            <div class="fw-semibold">{{ \Carbon\Carbon::parse($booking->event_date)->format('d M Y') }}</div>
                                        </div>
                                        <div class="col-sm-4">
                                            <small class="text-muted">Waktu:</small>
                                            <div class="fw-semibold">{{ $booking->event_time }}</div>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <small class="text-muted">Lokasi:</small>
                                        <div class="fw-semibold">{{ $booking->location }}</div>
                                        @if($booking->city)
                                            <small class="text-muted">{{ $booking->city }}</small>
                                        @endif
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-sm-4">
                                            <small class="text-muted">Nama:</small>
                                            <div class="fw-semibold">{{ $booking->name }}</div>
                                        </div>
                                        <div class="col-sm-4">
                                            <small class="text-muted">Telepon:</small>
                                            <div class="fw-semibold">{{ $booking->phone }}</div>
                                        </div>
                                        <div class="col-sm-4">
                                            <small class="text-muted">Booking ID:</small>
                                            <div class="fw-semibold">#{{ $booking->id }}</div>
                                        </div>
                                    </div>

                                    @if($booking->notes)
                                        <div class="mb-3">
                                            <small class="text-muted">Catatan:</small>
                                            <div class="fw-semibold">{{ $booking->notes }}</div>
                                        </div>
                                    @endif

                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <small class="text-muted">Total:</small>
                                            <div class="h5 text-primary mb-0">Rp {{ number_format($booking->subtotal, 0, ',', '.') }}</div>
                                        </div>
                                        <div class="text-end">
                                        @if($booking->payment_status === 'paid')
  <a href="{{ route('booking.invoice', $booking) }}"
     class="btn btn-sm btn-outline-primary mt-2" target="_blank">Invoice</a>

  @if($booking->testimonial)
    {{-- EDIT testimoni (pakai data-api) --}}
    <button
      type="button"
      class="btn btn-sm btn-outline-success mt-2"
      data-bs-toggle="modal"
      data-bs-target="#testimonialModal"
      {{-- data untuk prefilling --}}
      data-mode="edit"
      data-action="{{ route('booking.testimonial.update', $booking) }}"
      data-rating="{{ $booking->testimonial->rating ?? 5 }}"
      data-comment='@json($booking->testimonial->comment ?? "")'
    >
      Edit Testimoni
    </button>
  @else
    {{-- TAMBAH testimoni (pakai data-api) --}}
    <button
      type="button"
      class="btn btn-sm btn-outline-primary mt-2"
      data-bs-toggle="modal"
      data-bs-target="#testimonialModal"
      data-mode="add"
      data-action="{{ route('booking.testimonial.store', $booking) }}"
      data-rating="5"
      data-comment=""
    >
      + Tambah Testimoni
    </button>
  @endif
@endif
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer bg-light">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <small class="text-muted">
                                            Dibuat: {{ $booking->created_at->format('d M Y, H:i') }}
                                        </small>
                                        @if(in_array($booking->payment_status, ['pending', 'unpaid']))
                                            @php
                                                $isExpired = $booking->expires_at && now()->greaterThan($booking->expires_at);
                                            @endphp
                                            @if($isExpired)
                                                <span class="text-danger">
                                                    <i class="fas fa-clock me-1"></i>Waktu Pembayaran Habis
                                                </span>
                                            @elseif($booking->midtrans_snap_token)
                                                <button class="btn btn-warning btn-sm" onclick="regenerateSnapToken({{ $booking->id }})" title="Membuat token pembayaran baru dan melanjutkan pembayaran">
                                                    <i class="fas fa-redo me-1"></i>Lanjutkan Pembayaran
                                                </button>
                                                @if($booking->expires_at)
                                                    <small class="text-muted d-block mt-1">
                                                        Berlaku sampai: {{ $booking->expires_at->format('d M Y, H:i') }}
                                                    </small>
                                                @endif
                                            @else
                                                <a href="{{ route('booking.pay.page', $booking) }}" class="btn btn-primary btn-sm">
                                                    <i class="fas fa-credit-card me-1"></i>Bayar Sekarang
                                                </a>
                                            @endif
                                        @elseif($booking->payment_status === 'paid')
                                            <span class="text-success">
                                                <i class="fas fa-check-circle me-1"></i>Pembayaran Berhasil
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-5">
                    <div class="mb-4">
                        <i class="fas fa-inbox fa-4x text-muted"></i>
                    </div>
                    <h4 class="text-muted mb-3">Belum Ada Pesanan</h4>
                    <p class="text-muted mb-4">Anda belum memiliki pesanan apapun. Mulai booking sekarang!</p>
                    <a href="{{ url('/#pricing') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-1"></i>Buat Pesanan Baru
                    </a>
                </div>
            @endif

            <!-- Modal Testimoni -->
            <div class="modal fade" id="testimonialModal" tabindex="-1" aria-labelledby="testimonialModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <form id="testimonialForm" method="POST" class="modal-content">
                    @csrf
                    <input type="hidden" name="_method" id="testimonialMethod" value="POST">
                    <div class="modal-header">
                        <h5 class="modal-title" id="testimonialModalLabel">Tambah Testimoni</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                        <label class="form-label">Rating</label>
                        <select class="form-select" name="rating" id="testimonialRating" required>
                            <option value="5">★★★★★ - Sangat Puas</option>
                            <option value="4">★★★★☆ - Puas</option>
                            <option value="3">★★★☆☆ - Cukup</option>
                            <option value="2">★★☆☆☆ - Kurang</option>
                            <option value="1">★☆☆☆☆ - Buruk</option>
                        </select>
                        </div>
                        <div class="mb-3">
                        <label class="form-label">Komentar (opsional)</label>
                        <textarea class="form-control" name="comment" id="testimonialComment" rows="4" placeholder="Ceritakan pengalamanmu..."></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Batal</button>
                        <button class="btn btn-primary" type="submit" id="testimonialSubmit">Simpan</button>
                    </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- Midtrans Snap JS -->
<script src="https://app.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>

<script>
function payWithSnapToken(snapToken, bookingId = null) {
    snap.pay(snapToken, {
        onSuccess: function(result) {
            console.log('Payment success:', result);
            // Reload halaman untuk update status
            window.location.reload();
        },
        onPending: function(result) {
            console.log('Payment pending:', result);
            alert('Pembayaran sedang diproses. Silakan cek status pembayaran Anda.');
        },
        onError: function(result) {
            console.log('Payment error:', result);
            
            // Jika error karena snap token expired/invalid dan ada booking ID
            if (bookingId) {
                const errorMessage = result.status_message || result.message || '';
                const isTokenError = errorMessage.includes('tidak ditemukan') || 
                                   errorMessage.includes('expired') || 
                                   errorMessage.includes('invalid') ||
                                   result.status_code === '404' ||
                                   result.status_code === 404;
                
                if (isTokenError) {
                    if (confirm('Token pembayaran sudah expired atau tidak valid. Apakah Anda ingin membuat token baru?')) {
                        regenerateSnapToken(bookingId);
                        return;
                    }
                }
            }
            
            // Error handling tanpa alert - user sudah mendapat feedback dari confirm dialog
        },
        onClose: function() {
            console.log('Payment popup closed');
        }
    });
}

function regenerateSnapToken(bookingId) {
    // Tampilkan loading pada tombol lanjutkan pembayaran
    const button = document.querySelector(`button[onclick="regenerateSnapToken(${bookingId})"]`);
    const originalText = button.innerHTML;
    button.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>Memproses...';
    button.disabled = true;
    
    fetch(`/booking/${bookingId}/regenerate-token`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        button.innerHTML = originalText;
        button.disabled = false;
        
        if (data.success) {
            // Gunakan snap token baru
            payWithSnapToken(data.snap_token, bookingId);
        } else {
            const errorMsg = data.error || 'Gagal membuat token pembayaran baru';
            if (confirm(errorMsg + '\n\nApakah Anda ingin mencoba melalui halaman pembayaran?')) {
                window.location.href = `/booking/${bookingId}/pay`;
            }
        }
    })
    .catch(error => {
        button.innerHTML = originalText;
        button.disabled = false;
        console.error('Error:', error);
        if (confirm('Terjadi kesalahan saat membuat token baru.\n\nApakah Anda ingin mencoba melalui halaman pembayaran?')) {
            window.location.href = `/booking/${bookingId}/pay`;
        }
    });
}
</script>

<script>
  // Perbaiki bug kecil di fungsi kamu (selector & template string)
  function regenerateSnapToken(bookingId) {
      const button = document.querySelector(`button[onclick="regenerateSnapToken(${bookingId})"]`);
      const originalText = button ? button.innerHTML : '';
      if (button) { button.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>Memproses...'; button.disabled = true; }

      fetch(`/booking/${bookingId}/regenerate-token`, {
          method: 'POST',
          headers: {
              'Content-Type': 'application/json',
              'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
          }
      })
      .then(r => r.json())
      .then(data => {
          if (button) { button.innerHTML = originalText; button.disabled = false; }
          if (data.success) {
              payWithSnapToken(data.snap_token, bookingId);
          } else {
              const errorMsg = data.error || 'Gagal membuat token pembayaran baru';
              if (confirm(errorMsg + '\n\nApakah Anda ingin mencoba melalui halaman pembayaran?')) {
                  window.location.href = `/booking/${bookingId}/pay`;
              }
          }
      })
      .catch(err => {
          console.error(err);
          if (button) { button.innerHTML = originalText; button.disabled = false; }
          if (confirm('Terjadi kesalahan saat membuat token baru.\n\nApakah Anda ingin mencoba melalui halaman pembayaran?')) {
              window.location.href = `/booking/${bookingId}/pay`;
          }
      });
  }

  // ===== Testimoni =====
  let testimonialForm, testimonialMethod, testimonialRating, testimonialComment, testimonialSubmit;

  document.addEventListener('DOMContentLoaded', () => {
    testimonialForm    = document.getElementById('testimonialForm');
    testimonialMethod  = document.getElementById('testimonialMethod');
    testimonialRating  = document.getElementById('testimonialRating');
    testimonialComment = document.getElementById('testimonialComment');
    testimonialSubmit  = document.getElementById('testimonialSubmit');

    // 1) Prefill modal saat akan ditampilkan (sama untuk "Tambah" & "Edit")
    const modalEl = document.getElementById('testimonialModal');
    modalEl.addEventListener('show.bs.modal', (event) => {
      const btn = event.relatedTarget; // tombol pemicu
      if (!btn) return;

      const mode    = btn.getAttribute('data-mode');          // 'add' | 'edit'
      const action  = btn.getAttribute('data-action');        // URL action
      const rating  = btn.getAttribute('data-rating') || '5'; // default 5
      // data-comment bisa berupa JSON quoted string → parse aman
      let commentRaw = btn.getAttribute('data-comment') || '';
      try { commentRaw = JSON.parse(commentRaw); } catch(e) {}

      // Set form
      testimonialForm.setAttribute('action', action);
      testimonialRating.value  = rating;
      testimonialComment.value = commentRaw || '';

      const label = document.getElementById('testimonialModalLabel');
      if (mode === 'edit') {
        testimonialMethod.value = 'PUT';
        label.textContent = 'Edit Testimoni';
        testimonialSubmit.textContent = 'Update';
      } else {
        testimonialMethod.value = 'POST';
        label.textContent = 'Tambah Testimoni';
        testimonialSubmit.textContent = 'Simpan';
      }
    });

    // 2) Submit AJAX (punyamu)
    testimonialForm.addEventListener('submit', submitTestimonialAjax);
  });

  async function submitTestimonialAjax(e){
    e.preventDefault();
    const btn = testimonialSubmit;
    const original = btn.textContent;
    btn.disabled = true; btn.textContent = 'Menyimpan...';

    try {
      const res = await fetch(this.action, {
        method: 'POST',
        headers: {
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
          'X-Requested-With': 'XMLHttpRequest',
          'Accept': 'application/json',
        },
        body: new FormData(this)
      });

      const ct = res.headers.get('content-type') || '';
      const data = ct.includes('application/json') ? await res.json() : { success: res.ok };

      if (!res.ok || !data.success) {
        alert(data.message || 'Gagal menyimpan testimoni');
      } else {
        // Tutup modal dan reload halaman list
        const modalEl = document.getElementById('testimonialModal');
        const modal   = window.bootstrap?.Modal.getOrCreateInstance(modalEl);
        modal?.hide();
        window.location.href = "{{ route('user.bookings') }}";
      }
    } catch (err) {
      console.error(err);
      alert('Gagal menyimpan testimoni');
    } finally {
      btn.disabled = false; btn.textContent = original;
    }
  }
</script>


</x-user>