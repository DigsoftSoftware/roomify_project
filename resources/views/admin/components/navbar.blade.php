<header class="app-header">
  <nav class="navbar navbar-expand-lg navbar-light">
    <ul class="navbar-nav">
        <li class="nav-item d-block d-xl-none">
          <a class="nav-link sidebartoggler nav-icon-hover" id="headerCollapse" href="javascript:void(0)">
            <i class="ti ti-menu-2"></i>
          </a>
        </li>

        <li class="nav-item me-3">
          <a class="d-flex align-items-center border rounded p-2 shadow-sm bg-white">
            @php
                $photo = session('users_photo') ?? asset('admin/images/profile/user-1.jpg');
            @endphp

            @if ($photo && file_exists(public_path('storage/' . $photo)))
                <img src="{{ asset('storage/' . $photo) }}" alt="User" width="40" height="40" class="rounded-circle me-2">
            @else
                <img src="{{ asset('admin/images/profile/user-1.jpg') }}" alt="User" width="40" height="40" class="rounded-circle me-2">
            @endif  

              <div>
                  <div class="fw-bold mb-0">{{ session('users_name') }}</div>
                  <small class="text-muted">
                      {{ session('users_role') == 'hotel_owner' ? 'Hotel Owner' : (session('users_role') == 'admin' ? 'Admin' : ucfirst(str_replace('_', ' ', session('users_role')))) }}
                  </small>
              </div>
            </a>
        </li>
      </ul>

     <div class="navbar-collapse justify-content-end px-0" id="navbarNav">
            <ul class="navbar-nav flex-row ms-auto align-items-center justify-content-end">
                
                <li class="nav-item">
                  <button type="button" id="btnLogout" class="btn btn-outline-danger d-flex align-items-center">
                      <i class="fas fa-sign-out-alt me-1"></i> Logout
                  </button>
                </li>
            </ul>
        </div>

  </nav>
</header>



