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



        

        <div class="mt-3">
          <label class="form-label">Keterangan (opsional)</label>
          <textarea name="notes" rows="3" class="form-control">{{ old('notes') }}</textarea>
        </div>

      </div>

      {{-- Kolom kanan: ringkasan & submit --}}
      <div class="col-lg-5">
        <div class="card shadow-sm">
          <div class="card-header bg-white">
            <strong>Harga Paket</strong>
          </div>
          <div class="card-body">
            <div class="text-center mb-4">
              <div class="h3 text-primary fw-bold">Rp {{ number_format($package->price,0,',','.') }}</div>
              <small class="text-muted">Harga sudah termasuk semua layanan</small>
            </div>

            <div class="form-check mt-3">
              <input class="form-check-input" type="checkbox" value="1" id="agree" name="agree" required>
              <label class="form-check-label" for="agree">
                Saya menyetujui <a href="#" class="text-decoration-underline">Syarat & Ketentuan</a>
              </label>
              @error('agree')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
            </div>

            <button class="btn btn-primary w-100 mt-3">BOOKING SEKARANG</button>
          </div>
        </div>
      </div>
    </form>
  </div>
</section>


</x-user>
