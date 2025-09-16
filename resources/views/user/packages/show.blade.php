@extends('layouts.app')

@section('content')
<section id="hero">
  <div class="container-fluid align-items-center d-flex rounded-4" style="
    height:50vh;
    background-image: url({{ asset('images/background.jpg') }});
    background-repeat: no-repeat; background-size: cover; background-position: center;">
    <div class="hero-content container text-center">
      <h2 class="display-2 fw-bold text-body text-capitalize mb-1">{{ $package['title'] }}</h2>
      <span class="item"><a href="{{ url('/') }}" class="text-body">Home /</a></span>
      <span class="item"><a href="{{ route('packages.public.index') }}" class="text-body">Packages /</a></span>
      <span class="item">{{ $package['title'] }}</span>
    </div>
  </div>
</section>

<section id="selling-product" class="my-lg-7">
  <div class="container-lg">
    <div class="row">
      <div class="col-lg-6">
        <div class="row">
          <div class="col-md-3 d-none d-md-flex">
            <div class="swiper product-thumbnail-slider swiper-vertical swiper-thumbs">
              <div class="swiper-wrapper">
                @foreach($package['images'] as $img)
                  <div class="swiper-slide">
                    <img src="{{ asset($img) }}" alt="thumb" class="thumb-image img-fluid">
                  </div>
                @endforeach
              </div>
            </div>
          </div>
          <div class="col-md-9">
            <div class="swiper product-large-slider swiper-fade">
              <div class="swiper-wrapper">
                @foreach($package['images'] as $img)
                  <div class="swiper-slide">
                    <img src="{{ asset($img) }}" alt="large" class="img-fluid">
                  </div>
                @endforeach
              </div>
            </div>
          </div>
        </div> <!-- /row -->
      </div>

      <div class="col-lg-6 mt-5 mt-lg-0">
        <div class="product-info">
          <div class="element-header">
            <h2 class="display-6 fw-bold mt-0 mb-3">{{ $package['title'] }}</h2>
            <div class="rating-container d-flex gap-0 align-items-center">
              <span class="rating secondary-font">5.0</span>
            </div>
          </div>

          <div class="product-price pt-3 pb-3">
            <strong class="text-primary display-6 fw-semibold">Rp {{ number_format($package['price'],0,',','.') }}</strong>
          </div>

          <p>{{ $package['description'] }}</p>

          <ul class="mb-3">
            @foreach($package['features'] as $f)
              <li>{{ $f }}</li>
            @endforeach
          </ul>

          <div class="meta-product pt-3">
            <div class="meta-item d-flex align-items-baseline">
              <h6 class="item-title fw-bold no-margin pe-2">SKU:</h6>
              <ul class="select-list list-unstyled d-flex"><li>{{ $package['sku'] }}</li></ul>
            </div>
            <div class="meta-item d-flex align-items-baseline">
              <h6 class="item-title fw-bold no-margin pe-2">Category:</h6>
              <ul class="select-list list-unstyled d-flex">
                @foreach($package['categories'] as $c)
                  <li class="me-2"><a href="#">{{ $c }}@if(!$loop->last),@endif</a></li>
                @endforeach
              </ul>
            </div>
            <div class="meta-item d-flex align-items-baseline">
              <h6 class="item-title fw-bold no-margin pe-2">Tags:</h6>
              <ul class="select-list list-unstyled d-flex">
                @foreach($package['tags'] as $t)
                  <li class="me-2"><a href="#">{{ $t }}@if(!$loop->last),@endif</a></li>
                @endforeach
              </ul>
            </div>
          </div>

          <div class="mt-3">
            <a href="https://wa.me/6281234567890?text=Saya%20minat%20{{ urlencode($package['title']) }}" class="btn btn-primary">
              Booking via WhatsApp
            </a>
          </div>
        </div>
      </div>
    </div>

    {{-- Tabs bagian bawah tetap bisa kamu pakai; isi dengan data dinamis bila perlu --}}
  </div>
</section>
@endsection
