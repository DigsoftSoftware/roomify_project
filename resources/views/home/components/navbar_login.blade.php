<div class="container-fluid container-xl position-relative d-flex align-items-center">
  <a href="{{ route('home_login') }}" class="d-flex align-items-center me-auto">
    <img src="{{ asset('/home/img/icon_full.png') }}" width="120" alt="Logo">
  </a>

  <nav id="navmenu" class="navmenu">
    <ul>
      <li><a href="{{ route('home_login') }}">Home</a></li>
      <li><a href="{{ route('hotel.daftar') }}">Daftar Hotel</a></li>
      <li><a href="{{ route('mybooking.index') }}">My Bookings</a></li>
      <li><a href="{{ route('home_about') }}">About</a></li>
    </ul>
    <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
  </nav>

  <!-- Hidden Logout Form -->
  <form id="logout-form" action="{{ route('users.logout') }}" method="POST" style="display: none;">
    @csrf
  </form>

  <!-- Dropdown for user -->
  <div class="dropdown ms-3">
    <a class="btn btn-outline-success dropdown-toggle d-flex align-items-center" href="#" role="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
        @php
                          $photo = session('users_photo') ?? asset('admin/images/profile/user-1.jpg');
                      @endphp

                      @if ($photo && file_exists(public_path('storage/' . $photo)))
                          <img src="{{ asset('storage/' . $photo) }}" alt="User" width="40" height="40" class="rounded-circle me-2">
                      @else
                          <img src="{{ asset('admin/images/profile/user-1.jpg') }}" alt="User" width="40" height="40" class="rounded-circle me-2">
                      @endif  
              
      {{ session('users_username') }}
    </a>

    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
      <li>
        <a class="dropdown-item" href="{{ route('home.profile.edit', session('users_id')) }}"><i class="bi bi-person me-2"></i> Profil Saya</a>
      </li>
      <li>
        <a class="dropdown-item" href="#" id="btnLogout" >
          <i class="bi bi-box-arrow-right me-2"></i> Logout
        </a>
      </li>
    </ul>
  </div>


</div>
