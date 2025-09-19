<nav class="sidebar sidebar-offcanvas" id="sidebar">
          <ul class="nav">
            <li class="nav-item">
              <a class="nav-link" href="{{ route('admin.dashboard') }}">
                <i class="mdi mdi-grid-large menu-icon"></i>
                <span class="menu-title">Dashboard</span>
              </a>
            </li>
            <hr class="m-0 text-light-emphasis">
            <li class="nav-item">
              <a class="nav-link" href="{{ route('admin.orders.index') }}">
                <i class="menu-icon mdi mdi-card-text-outline"></i>
                <span class="menu-title">Pesanan</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{ route('admin.packages.index') }}">
                <i class="menu-icon mdi mdi-table"></i>
                <span class="menu-title">Packages</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{ route('admin.categories.index') }}">
                <i class="menu-icon mdi mdi-layers-outline"></i>
                <span class="menu-title">Kategori</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">
                <i class="menu-icon mdi mdi-account-circle-outline"></i>
                <span class="menu-title">Data User</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">
                <i class="menu-icon mdi mdi-account-circle-outline"></i>
                <span class="menu-title">Data Admin</span>
              </a>
            </li>
            <li class="nav-item">
              <hr class="mb-0">
              <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="nav-link text-danger border-0 text-center">
                    <i class="mdi mdi-power text-danger me-2"></i>
                    Keluar
                </button>
              </form>
            </li>
          </ul>
        </nav>