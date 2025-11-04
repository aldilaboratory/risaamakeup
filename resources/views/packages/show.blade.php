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
          <a href="{{ route('booking.create', ['category' => $category ?? $package->category, 'package' => $package]) }}"
            class="btn btn-primary-pink" style="background-color: var(--primary-pink); color: white;">
            Booking
        </a>
          <span class="mx-3">atau</span>
          <a href="https://wa.me/6283116035639?text={{ urlencode('Halo, saya minat paket: '.$package->title.' '.$package->category?->name) }}"
             class="btn btn-outline-success rounded-pill btn-lg">
            <small>Konsultasi via WhatsApp</small>
          </a>
        </div>
      </div>
    </div>
    </div>
  </div>
</section>

</x-user>