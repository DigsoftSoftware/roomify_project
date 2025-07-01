<div class="container-fluid container-xl position-relative d-flex align-items-center">
      <a href="/" class=" d-flex align-items-center me-auto">
        <img src="{{ asset('/home/img/icon_full.png') }}"  width="120"></img>
      </a>
      <nav id="navmenu" class="navmenu">
        <ul>
            <li><a href="/">Home</a></li>
            <li><a href="{{ route('hotel.daftar') }}">Daftar Hotel</a></li>
            <li><a href="{{ route('mybooking.index') }}">My Bookings</a></li>
            <li><a href="{{ route('home_about') }}">About</a></li>
        </ul>
        <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
      </nav>
      <a class="btn-getstarted" href="/login">Login</a>
</div>