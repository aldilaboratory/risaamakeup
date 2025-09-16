<x-user.layout>

{{-- HERO / BREADCRUMB --}}
<section class="py-5 bg-light border-bottom">
  <div class="container-fluid align-items-center d-flex rounded-4 mt-5" style="
    height:25vh;
    background-image: url({{ asset('images/background.jpg') }});
    background-repeat: no-repeat; background-size: cover; background-position: center;">
    <div class="hero-content container text-center">
      <h4>{{ $category->name ?? $package->category?->name }}</h4>
      <h2 class="display-2 fw-bold text-body text-capitalize mb-1">{{ $package->title }}</h2>
    </div>
  </div>
</section>

{{-- PRODUCT SECTION --}}
<section class="py-5">
  <div class="container">
    <div class="row g-5 align-items-start">

      {{-- LEFT: IMAGE --}}
      <div class="col-lg-5">
        <div class="ratio ratio-1x1 rounded-3 overflow-hidden border">
          @if($package->cover_image)
            <img src="{{ asset('storage/'.$package->cover_image) }}"
                 alt="{{ $package->title }}" class="w-100 h-100 object-fit-cover">
          @else
            <div class="w-100 h-100 d-flex align-items-center justify-content-center bg-light text-muted">
              Tidak ada foto
            </div>
          @endif
        </div>
      </div>

      {{-- RIGHT: INFO --}}
      <div class="col-lg-7">
        <p class="mb-2 fs-5">{{ $package->title }}</p>

        <div class="mb-3">
          <span class="price fs-2">
            Rp {{ number_format($package->price, 0, ',', '.') }}
          </span>
        </div>

        @if(!empty($package->description_bullets))
          <p class="text-muted">Termasuk layanan berikut:</p>
          <ul class="mb-4">
            @foreach($package->description_bullets as $line)
              <li>{{ $line }}</li>
            @endforeach
          </ul>
        @elseif(!empty($package->description))
          <p class="text-muted">{{ $package->description }}</p>
        @endif

        <div class="row g-3 mb-4">
          @if(!empty($package->duration_minutes))
            <div class="col-auto">
              <span class="badge bg-secondary-subtle border text-secondary">
                Durasi ± {{ $package->duration_minutes }} menit
              </span>
            </div>
          @endif
          <div class="col-auto">
            <span class="badge bg-secondary-subtle border text-secondary">
              Kategori: {{ $category->name ?? $package->category?->name }}
            </span>
          </div>
        </div>

        <div class="">
          <a href="#" class="btn btn-primary-pink" style="background-color: var(--primary-pink); color: white;">Pesan Sekarang</a>
          <span class="mx-3">atau</span>
          <a href="https://wa.me/6281234567890?text={{ urlencode('Halo, saya minat paket: '.$package->title.' '.$package->category?->name) }}"
             class="btn btn-outline-success rounded-pill btn-lg">
            <small>Konsultasi via WhatsApp</small>
          </a>
        </div>
      </div>
    </div>

    {{-- TABS --}}
    <div class="mt-5">
      <ul class="nav nav-tabs" id="detailTabs" role="tablist">
        <li class="nav-item" role="presentation">
          <button class="nav-link active" id="details-tab" data-bs-toggle="tab"
                  data-bs-target="#details" type="button" role="tab" aria-controls="details" aria-selected="true">
            Details
          </button>
        </li>
        <li class="nav-item" role="presentation">
          <button class="nav-link" id="howto-tab" data-bs-toggle="tab"
                  data-bs-target="#howto" type="button" role="tab" aria-controls="howto" aria-selected="false">
            How To Use
          </button>
        </li>
        <li class="nav-item" role="presentation">
          <button class="nav-link" id="shipping-tab" data-bs-toggle="tab"
                  data-bs-target="#shipping" type="button" role="tab" aria-controls="shipping" aria-selected="false">
            Shipping & Return
          </button>
        </li>
        <li class="nav-item" role="presentation">
          <button class="nav-link" id="reviews-tab" data-bs-toggle="tab"
                  data-bs-target="#reviews" type="button" role="tab" aria-controls="reviews" aria-selected="false">
            Reviews
          </button>
        </li>
      </ul>

      <div class="tab-content border border-top-0 p-4 rounded-bottom" id="detailTabsContent">
        {{-- DETAILS --}}
        <div class="tab-pane fade show active" id="details" role="tabpanel" aria-labelledby="details-tab">
          <h5 class="mb-3">Deskripsi Paket</h5>
          @if(!empty($package->description_bullets))
            <ul class="mb-3">
              @foreach($package->description_bullets as $line)
                <li>{{ $line }}</li>
              @endforeach
            </ul>
          @elseif(!empty($package->description))
            <p>{{ $package->description }}</p>
          @else
            <p class="text-muted mb-0">Belum ada deskripsi.</p>
          @endif
        </div>

        {{-- HOW TO USE (opsional) --}}
        <div class="tab-pane fade" id="howto" role="tabpanel" aria-labelledby="howto-tab">
          <h5 class="mb-3">Cara Pemakaian / Alur Layanan</h5>
          <ol class="mb-0">
            <li>Konsultasi singkat via WhatsApp/telepon.</li>
            <li>Konfirmasi jadwal & lokasi.</li>
            <li>Datang on-site sesuai jam yang disepakati.</li>
            <li>Touch-up ringan (jika termasuk paket).</li>
          </ol>
        </div>

        {{-- SHIPPING & RETURN (opsional) --}}
        <div class="tab-pane fade" id="shipping" role="tabpanel" aria-labelledby="shipping-tab">
          <h5 class="mb-3">Kebijakan</h5>
          <ul class="mb-0">
            <li>Reservasi minimal H-7 atau sesuai ketersediaan.</li>
            <li>DP/booking fee diperlukan untuk mengunci jadwal.</li>
            <li>Biaya transport on-site menyesuaikan lokasi.</li>
          </ul>
        </div>

        {{-- REVIEWS (placeholder) --}}
        <div class="tab-pane fade" id="reviews" role="tabpanel" aria-labelledby="reviews-tab">
          <h5 class="mb-3">Ulasan Pelanggan</h5>
          <p class="text-muted mb-0">Belum ada ulasan.</p>
        </div>
      </div>
    </div>
  </div>
</section>

</x-user>