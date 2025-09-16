{{-- resources/views/packages/index.blade.php --}}
<section id="pricing" class="py-5">
  <div class="container">
    <h2 class="section-title text-center mb-4">Package Terbaik Dengan Harga Terbaik</h2>

    {{-- Tabs --}}
    <ul class="nav nav-pills justify-content-center mb-4" id="pricingTabs" role="tablist">
      @foreach($categories as $i => $cat)
        <li class="nav-item" role="presentation">
          <button class="nav-link text-white {{ $i===0 ? 'active' : '' }}"
                  id="{{ $cat->slug }}-tab" data-bs-toggle="tab"
                  data-bs-target="#tab-{{ $cat->slug }}" type="button" role="tab"
                  aria-controls="tab-{{ $cat->slug }}" aria-selected="{{ $i===0 ? 'true':'false' }}">
            {{ ucfirst($cat->name) }}
          </button>
        </li>
      @endforeach
    </ul>

    <div class="tab-content" id="pricingTabsContent">
      @foreach($categories as $i => $cat)
      <div class="tab-pane fade {{ $i===0 ? 'show active' : '' }}"
           id="tab-{{ $cat->slug }}" role="tabpanel" aria-labelledby="{{ $cat->slug }}-tab" tabindex="0">
        <div class="row g-4">
          @forelse($cat->packages as $p)
            <div class="col-lg-4">
              <div class="pricing-card {{ $loop->index===1 ? 'featured' : '' }}">
                <h5 class="mb-1">{{ $p->title }}</h5>
                <div class="price fs-2">{{ $p->price_formatted ?? 'Rp '.number_format($p->price,0,',','.') }}</div>
                <hr>
                @if($p->description)
                  <ul class="mb-0 small text-start ms-5">
                    @foreach($p->description_bullets as $i => $line)
                        <li>{{ $line }}</li>
                    @endforeach
                  </ul>
                @endif
                <a href="{{ route('packages.public.show', ['category' => $cat, 'package' => $p]) }}"
                   class="btn btn-primary-pink text-white mt-3">
                  Pilih Package
                </a>
              </div>
            </div>
          @empty
            <div class="col-12 text-center py-5 text-muted">Belum ada paket di kategori ini.</div>
          @endforelse
        </div>
      </div>
      @endforeach
    </div>
  </div>
</section>
