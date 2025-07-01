@extends('auth.main.app')

@section('title', 'Pilihan Akun')

<style>
  .card-role {
    transition: all 0.3s ease;
    border: 1px solid #e0e0e0;
    border-radius: 16px;
    background-color: #ffffff;
    text-align: center;
    padding: 30px 20px;
    min-height: 220px;
  }

  .card-role:hover {
    transform: translateY(-6px);
    box-shadow: 0 12px 24px rgba(0, 0, 0, 0.1);
    border-color: #d0d0d0;
  }

  .card-role i {
    font-size: 48px;
    margin-bottom: 15px;
    transition: transform 0.3s ease;
  }

  .card-role:hover i {
    transform: scale(1.1);
  }

  .card-role h5 {
    font-size: 20px;
    font-weight: 600;
  }

  .divider {
    margin: 40px 0;
    font-size: 18px;
    font-weight: bold;
    text-align: center;
    color: #333;
  }

  .logo-wrapper img {
    max-width: 180px;
  }
</style>

@section('content_pilihan_register')


<div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6"
  data-sidebartype="full" data-sidebar-position="fixed" data-header-position="fixed">

  <div class="position-relative overflow-hidden radial-gradient min-vh-100 d-flex align-items-center justify-content-center">

    <div class="container">
      <div class="row justify-content-center">
        <div class="col-md-10 col-lg-8 col-xxl-6">
          <div class="card shadow-sm border-0">
            <div class="card-body text-center p-5">

              <!-- Logo -->
              <div class="logo-wrapper mb-4">
                <a href="{{ route('pilihan.register') }}">
                  <img src="{{ asset('/admin/images/logos/icon_full.png') }}" alt="Roomify Logo">
                </a>
              </div>

              <!-- Judul -->
              <h3 class="mb-4 fw-bold">Daftar Sebagai</h3>

              <!-- Pilihan Card -->
              <div class="row g-4 justify-content-center">
                <!-- Hotel Owner -->
                <div class="col-12 col-md-6">
                  <a href="{{ route('hotelowner.register') }}" class="text-decoration-none d-block h-100">
                    <div class="card-role">
                      <i class="fas fa-hotel text-primary"></i>
                      <h5 class="text-primary">Hotel Owner</h5>
                    </div>
                  </a>
                </div>

                <!-- User -->
                <div class="col-12 col-md-6">
                  <a href="{{ route('users.register') }}" class="text-decoration-none d-block h-100">
                    <div class="card-role">
                      <i class="fas fa-user text-success"></i>
                      <h5 class="text-success">User</h5>
                    </div>
                  </a>
                </div>
              </div>

              <!-- Login link -->
              <div class="mt-5">
                <p class="fs-6 fw-bold mb-0">
                  Sudah punya akun?
                  <a class="text-success fw-bold ms-1" href="{{ route('login') }}">Login</a>
                </p>
              </div>

            </div>
          </div>
        </div>
      </div>
    </div>

  </div>
</div>

@endsection
