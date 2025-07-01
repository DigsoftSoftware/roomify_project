@extends('auth.main.app')

@section('title', 'Daftar Akun Hotel Owner')

@section('content_register_hotels_onwer')
<body>
  <!--  Body Wrapper -->
  <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
    data-sidebar-position="fixed" data-header-position="fixed">
    <div
      class="position-relative overflow-hidden radial-gradient min-vh-100 d-flex align-items-center justify-content-center">
      <div class="d-flex align-items-center justify-content-center w-100">
        <div class="row justify-content-center w-100">
          <div class="col-md-8 col-lg-6 col-xxl-3">
            <div class="card mb-0">
              <div class="card-body">
                <a href="./index.html" class="text-nowrap logo-img text-center d-block py-3 w-100">
                  <img src="{{asset('/admin/images/logos/icon_full.png')}}" width="180" alt="">
                </a>
                <p class="text-center">Selamat datang di Login Roomify</p>
                    <form id="formRegister">
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control" id="username" name="username" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama Lengkap</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="mb-4">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <button type="submit" class="btn btn-success w-100 py-8 fs-4 mb-4 rounded-2">Daftar</button>
                        <div class="d-flex align-items-center justify-content-center">
                            <p class="fs-4 mb-0 fw-bold">Sudah punya akun?</p>
                            <a class="text-success fw-bold ms-2" href="{{ route('login') }}">Login</a>
                        </div>
                    </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  @endsection

  @push('scripts')
  <script>
    $(document).ready(function () {
        $('#formRegister').submit(function (e) {
        e.preventDefault();

        $.ajax({
            url: "{{ route('hotelowner.register.submit') }}", 
            type: "POST",
            data: {
            name: $('#name').val(),
            username: $('#username').val(),
            email: $('#email').val(),
            password: $('#password').val(),
            _token: '{{ csrf_token() }}'
            },
            success: function (response) {
            Swal.fire({
                icon: 'success',
                title: 'Pendaftaran Berhasil!',
                text: response.message,
                timer: 1500,
                showConfirmButton: false
            }).then(() => {
                window.location.href = response.redirect;
            });
            },
            error: function (xhr) {
            let errors = xhr.responseJSON.errors;
            let messages = '';

            if (errors) {
                $.each(errors, function (key, value) {
                messages += value + '<br>';
                });
            } else {
                messages = xhr.responseJSON.message;
            }

            Swal.fire({
                icon: 'error',
                title: 'Gagal Mendaftar!',
                html: messages
            });
            }
        });
        });
    });
  </script>
  @endpush

