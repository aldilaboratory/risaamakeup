<x-user.layout>

<section class="py-5" style="margin-top: 100px;">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-8">
        <!-- <div class="text-center mb-5">
          <div class="mb-4">
            <svg width="80" height="80" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
              <circle cx="12" cy="12" r="10" fill="#28a745"/>
              <path d="M9 12l2 2 4-4" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
          </div>
          <h1 class="h2 text-success mb-3">Terima Kasih!</h1>
          <p class="lead text-muted">Pembayaran Anda telah berhasil diproses</p>
        </div> -->

        <div class="card shadow-sm">
          <div class="card-header bg-light">
            <h5 class="mb-0">Detail Booking</h5>
          </div>
          <div class="card-body">
            <div class="row g-3">
              <div class="col-md-6">
                <strong>Nama:</strong><br>
                <span class="text-muted">{{ $booking->name }}</span>
              </div>
              <div class="col-md-6">
                <strong>No. WhatsApp:</strong><br>
                <span class="text-muted">{{ $booking->phone }}</span>
              </div>
              <div class="col-md-6">
                <strong>Paket:</strong><br>
                <span class="text-muted">{{ $booking->package->title }}</span>
              </div>
              <div class="col-md-6">
                <strong>Kategori:</strong><br>
                <span class="text-muted">{{ $booking->category->name }}</span>
              </div>
              <div class="col-md-6">
                <strong>Tanggal Acara:</strong><br>
                <span class="text-muted">{{ \Carbon\Carbon::parse($booking->event_date)->format('d F Y') }}</span>
              </div>
              <div class="col-md-6">
                <strong>Waktu:</strong><br>
                <span class="text-muted">{{ \Carbon\Carbon::parse($booking->event_time)->format('H:i') }}</span>
              </div>
              <div class="col-12">
                <strong>Lokasi:</strong><br>
                <span class="text-muted">{{ $booking->location }}</span>
                @if($booking->city)
                  <br><small class="text-muted">{{ $booking->city }}</small>
                @endif
              </div>
              @if($booking->notes)
              <div class="col-12">
                <strong>Keterangan:</strong><br>
                <span class="text-muted">{{ $booking->notes }}</span>
              </div>
              @endif
              <div class="col-12">
                <hr>
                <div class="d-flex justify-content-between align-items-center mb-3">
                  <strong>Total Pembayaran:</strong>
                  <span class="h5 text-success mb-0">Rp {{ number_format($booking->subtotal, 0, ',', '.') }}</span>
                </div>
                <div class="d-flex justify-content-between align-items-center">
                  <strong>Status Pembayaran:</strong>
                  @if($booking->payment_status === 'paid')
                    <span class="badge bg-success fs-6">✓ Lunas</span>
                  @elseif($booking->payment_status === 'pending')
                    <span class="badge bg-warning fs-6">⏳ Menunggu Pembayaran</span>
                  @else
                    <span class="badge bg-secondary fs-6">{{ ucfirst($booking->payment_status) }}</span>
                  @endif
                </div>
                @if($booking->midtrans_order_id)
                <div class="d-flex justify-content-between align-items-center mt-2">
                  <strong>ID Transaksi:</strong>
                  <span class="text-muted">{{ $booking->midtrans_order_id }}</span>
                </div>
                @endif
              </div>
            </div>
          </div>
        </div>

        <div class="alert alert-info mt-4">
          <h6 class="alert-heading">Informasi Penting:</h6>
          <ul class="mb-0">
            <li>Tim kami akan menghubungi Anda melalui WhatsApp dalam 1x24 jam untuk konfirmasi detail acara</li>
            <li>Pastikan nomor WhatsApp yang Anda berikan aktif dan dapat dihubungi</li>
            <li>Jika ada perubahan jadwal, harap hubungi kami minimal 3 hari sebelum acara</li>
          </ul>
        </div>

        <div class="text-center mt-4">
          <!-- <a href="{{ route('packages.public.index') }}" class="btn btn-primary me-3">Lihat Paket Lainnya</a> -->
          <a href="https://wa.me/6281234567890?text={{ urlencode('Halo, saya sudah melakukan booking dengan ID: ' . $booking->id . '. Mohon konfirmasi untuk detail acara.') }}" 
             class="btn btn-success" target="_blank">
            <i class="fab fa-whatsapp me-2"></i>Hubungi via WhatsApp
          </a>
        </div>
      </div>
    </div>
  </div>
</section>

</x-user.layout>