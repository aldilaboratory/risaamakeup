<nav class="navbar navbar-expand-lg fixed-top">
  <div class="container">
    <a class="navbar-brand" href="#home">Risaa Makeup</a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav mx-auto">
        <li class="nav-item"><a class="nav-link" href="#home">Beranda</a></li>
        <li class="nav-item"><a class="nav-link" href="#services">Layanan</a></li>
        <li class="nav-item"><a class="nav-link" href="#pricing">Package</a></li>
        <li class="nav-item"><a class="nav-link" href="#gallery">Galeri</a></li>
      </ul>

      <div class="navbar-actions d-flex align-items-center gap-2">
        <!-- Cart selalu tampil -->
        <!-- <a href="#" class="nav-icon-btn me-2" title="Shopping Cart">
          <i class="fas fa-shopping-bag"></i>
          <span class="cart-count">0</span>
        </a> -->

        @guest
          <!-- Guest: sembunyikan ikon profil, tampilkan tombol Register -->
          <a href="{{ route('login') }}" class="btn btn-primary btn-sm">
            Login
          </a>
        @endguest

        @auth 
          <!-- Logged in: tombol pesanan + ikon profil + dropdown -->
          <a href="{{ route('user.bookings') }}" class="btn btn-outline-primary btn-sm me-2">
            <i class="fas fa-list-alt me-1"></i>Pesanan Saya
          </a>
          
          <div class="dropdown">
            <a
              href="#"
              class="nav-icon-btn d-inline-flex align-items-center"
              id="profileDropdown"
              data-bs-toggle="dropdown"
              aria-expanded="false"
              title="User Menu"
            >
              <i class="fas fa-user"></i>
            </a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown">
              <li>
                <a class="dropdown-item" href="{{ route('profile.edit') }}">Profile</a>
              </li>
              <li><hr class="dropdown-divider"></li>
              <li>
                <form method="POST" action="{{ route('logout') }}">
                  @csrf
                  <button type="submit" class="dropdown-item">Logout</button>
                </form>
              </li>
            </ul>
          </div>
        @endauth
      </div>
    </div>
  </div>
</nav>
