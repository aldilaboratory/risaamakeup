<x-user.layout>

<section class="py-4" style="margin-top: 100px;">
  <div class="container">

    {{-- Header Paket --}}
    <div class="d-flex align-items-center gap-3 mb-4">
      <div class="rounded overflow-hidden border" style="width:120px;height:90px;">
        @if($package->cover_image)
          <img src="{{ asset('storage/'.$package->cover_image) }}" class="w-100 h-100 object-fit-cover" alt="{{ $package->title }}">
        @else
          <div class="w-100 h-100 d-flex align-items-center justify-content-center bg-light text-muted">No Image</div>
        @endif
      </div>
      <div>
        <div class="text-muted small">{{ $category->name }}</div>
        <h3 class="mb-1">{{ $package->title }}</h3>
        <div class="h5 m-0 text-primary">Rp {{ number_format($package->price,0,',','.') }}</div>
      </div>
    </div>

    <form method="POST" action="{{ route('booking.store', ['category' => $category, 'package' => $package]) }}" class="row g-4">
      @csrf

      {{-- Kolom kiri: pilihan/opsi --}}
      <div class="col-lg-7">

      <div class="mt-3">
          <label class="form-label">Nama</label>
          <input type="text" name="name" value="{{ old('name') }}" class="form-control @error('name') is-invalid @enderror" required>
          @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="mt-3">
          <label class="form-label">No. WhatsApp</label>
          <input type="text" name="phone" value="{{ old('phone') }}" class="form-control @error('phone') is-invalid @enderror" placeholder="08xxxxxxxxxx" required>
          @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3">
          <label class="form-label">Kota (opsional)</label>
          <select name="city" class="form-select">
            <option value="">Pilih kota</option>
            <option value="Denpasar" @selected(old('city')==='Denpasar')>Denpasar</option>
            <option value="Karangasem" @selected(old('city')==='Karangasem')>Karangasem</option>
            <option value="Badung" @selected(old('city')==='Badung')>Badung</option>
          </select>
        </div>

        <div class="row g-3">
          <div class="col-6">
            <label class="form-label">Tanggal Acara</label>
            <input type="date" name="event_date" value="{{ old('event_date') }}" class="form-control @error('event_date') is-invalid @enderror" required>
            @error('event_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>
          <div class="col-6">
            <label class="form-label">Waktu</label>
            <input type="time" name="event_time" value="{{ old('event_time') }}" class="form-control @error('event_time') is-invalid @enderror" required>
            @error('event_time')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>
        </div>

        <div class="mt-3">
          <label class="form-label">Lokasi / Alamat</label>
          <input type="text" name="location" value="{{ old('location') }}" class="form-control @error('location') is-invalid @enderror" placeholder="Hotel/rumah/venue..." required>
          @error('location')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <!-- <div class="row g-3 mt-1">
          <div class="col-6">
            <label class="form-label">Jumlah orang</label>
            <div class="input-group">
              <button type="button" class="btn btn-outline-secondary" id="btn-minus">–</button>
              <input type="number" id="qty" name="qty" value="{{ old('qty',1) }}" min="1" class="form-control text-center">
              <button type="button" class="btn btn-outline-secondary" id="btn-plus">+</button>
            </div>
            @error('qty')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
          </div>

          <div class="col-6">
            <label class="form-label">Down Payment</label>
            <div class="input-group">
              <select name="dp_percent" id="dp_percent" class="form-select">
                <option value="100" @selected(old('dp_percent',100)==100)>100%</option>
                <option value="50"  @selected(old('dp_percent')==50)>50%</option>
                <option value="0"   @selected(old('dp_percent')==0)>0%</option>
              </select>
              <span class="input-group-text">dibayar sekarang</span>
            </div>
          </div>
        </div> -->

        

        <div class="mt-3">
          <label class="form-label">Keterangan (opsional)</label>
          <textarea name="notes" rows="3" class="form-control">{{ old('notes') }}</textarea>
        </div>

      </div>

      {{-- Kolom kanan: ringkasan & submit --}}
      <div class="col-lg-5">
        <div class="card shadow-sm">
          <div class="card-header bg-white">
            <strong>Rincian Harga</strong>
          </div>
          <div class="card-body">
            <dl class="row mb-2">
              <!-- <dt class="col-6">Harga Paket</dt>
              <dd class="col-6 text-end" id="price_fmt">Rp {{ number_format($package->price,0,',','.') }}</dd> -->

              <!-- <dt class="col-6">Qty</dt>
              <dd class="col-6 text-end"><span id="qty_view">{{ old('qty',1) }}</span>x</dd> -->

              <dt class="col-6">Total</dt>
              <dd class="col-6 text-end" id="total_fmt">Rp {{ number_format($package->price * (int)old('qty',1),0,',','.') }}</dd>

              <!-- <dt class="col-6">Pembayaran Saat Ini</dt>
              <dd class="col-6 text-end fw-semibold text-primary" id="paynow_fmt">Rp {{ number_format($package->price * (int)old('qty',1),0,',','.') }}</dd> -->
            </dl>

            <!-- <div class="form-check mt-3">
              <input class="form-check-input" type="checkbox" value="1" id="agree" name="agree" required>
              <label class="form-check-label" for="agree">
                Saya menyetujui <a href="#" class="text-decoration-underline">Syarat & Ketentuan</a>
              </label>
              @error('agree')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
            </div> -->

            <button class="btn btn-primary w-100 mt-3">BOOKING SEKARANG</button>
          </div>
        </div>
      </div>
    </form>
  </div>
</section>

{{-- JS hitung total --}}
<script>
(function(){
  const unitPrice = {{ (int)$package->price }};
  const qtyInput  = document.getElementById('qty');
  const dpSel     = document.getElementById('dp_percent');
  const qtyView   = document.getElementById('qty_view');
  const totalFmt  = document.getElementById('total_fmt');
  const payFmt    = document.getElementById('paynow_fmt');

  function fmt(n){
    return new Intl.NumberFormat('id-ID').format(n);
  }
  function calc(){
    const qty = Math.max(1, parseInt(qtyInput.value || '1', 10));
    const dp  = parseInt(dpSel.value || '100', 10);
    const total = unitPrice * qty;
    const pay   = Math.round(total * dp / 100);
    qtyView.textContent = qty;
    totalFmt.textContent = 'Rp ' + fmt(total);
    payFmt.textContent   = 'Rp ' + fmt(pay);
  }
  qtyInput.addEventListener('input', calc);
  dpSel.addEventListener('change', calc);
  document.getElementById('btn-minus')?.addEventListener('click', () => { qtyInput.stepDown(); qtyInput.dispatchEvent(new Event('input')); });
  document.getElementById('btn-plus')?.addEventListener('click', () => { qtyInput.stepUp();   qtyInput.dispatchEvent(new Event('input')); });
  calc();
})();
</script>
</x-user>
