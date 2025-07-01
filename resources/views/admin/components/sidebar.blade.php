<aside class="left-sidebar">
  <div>
    <div class="brand-logo d-flex align-items-center justify-content-between" style="padding-left: 50px;">
      <a href="/dashboard/{{ Session::get('users_role') }}" class="logo-img"><br>
        <img src="{{ asset('/admin/images/logos/icon_full.png') }}" width="150" alt="">
      </a>
      <div class="close-btn d-xl-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
        <i class="ti ti-x fs-8"></i>
      </div>
    </div>

    <nav class="sidebar-nav scroll-sidebar" data-simplebar="">
      <ul id="sidebarnav" style="list-style: none; padding: 0;">
        <li class="nav-small-cap">
          <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
          <span class="hide-menu">Home</span>
        </li>

        <li class="sidebar-item">
          <a class="sidebar-link" href="/dashboard/{{ Session::get('users_role') }}">
            <i class="ti ti-layout-dashboard" style="margin-right: 10px;"></i>
            <span class="hide-menu">Dashboard</span>
          </a>
        </li>

        <li class="nav-small-cap">
          <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
          <span class="hide-menu">Menu</span>
        </li>
        
        @if(Session::get('users_role') === 'admin')
        <li class="sidebar-item">
          <a class="sidebar-link" href="/admin/view">
            <i class="ti ti-shield-lock" style="margin-right: 10px;"></i>
            <span class="hide-menu">Admin</span>
          </a>
        </li>

        <li class="sidebar-item">
          <a class="sidebar-link" href="/users/view">
            <i class="ti ti-user" style="margin-right: 10px;"></i>
            <span class="hide-menu">Users</span>
          </a>
        </li>

        <li class="sidebar-item">
          <a class="sidebar-link" href="/owners/view">
            <i class="ti ti-users" style="margin-right: 10px;"></i>
            <span class="hide-menu">Pemilik Hotel</span>
          </a>
        </li>
        @endif

        @if(Session::get('users_role') === 'hotel_owner')
        <li class="sidebar-item">
          <a class="sidebar-link" href="{{ route('hotels.profile', ['id' => Session::get('users_id')]) }}">
            <i class="ti ti-edit" style="margin-right: 10px;"></i>
            <span class="hide-menu">Edit Profil</span>
          </a>
        </li>
        @endif

        @if(Session::get('users_role') === 'admin' || Session::get('users_role') === 'hotel_owner')
        <li class="sidebar-item">
          <a class="sidebar-link" href="/hotels/view">
            <i class="ti ti-building" style="margin-right: 10px;"></i>
            <span class="hide-menu">Hotel Saya</span>
          </a>
        </li>

        <li class="sidebar-item">
          <a class="sidebar-link" href="/room/view">
            <i class="ti ti-bed" style="margin-right: 10px;"></i>
            <span class="hide-menu">Ruangan</span>
          </a>
        </li>

        <li class="sidebar-item">
          <a class="sidebar-link" href="/booking/view">
            <i class="ti ti-calendar-event" style="margin-right: 10px;"></i>
            <span class="hide-menu">Booking</span>
          </a>
        </li>

        <li class="sidebar-item">
          <a class="sidebar-link" href="/payment/view">
            <i class="ti ti-credit-card" style="margin-right: 10px;"></i>
            <span class="hide-menu">Pembayaran</span>
          </a>
        </li>
        @endif

        <li class="nav-small-cap">
          <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
          <span class="hide-menu">Dokumen</span>
        </li>

        <li class="sidebar-item">
          <a class="sidebar-link" href="/laporan/view">
            <i class="ti ti-file-text" style="margin-right: 10px;"></i>
            <span class="hide-menu">Laporan</span>
          </a>
        </li>
      </ul>

      <div class="hide-menu bg-light position-relative mb-7 mt-5">
        <div class="d-flex">
        </div>
      </div>
    </nav>
  </div>
</aside>
