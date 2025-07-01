@extends('auth.main.app')

@section('title', 'Login Akun')

@section('content_login')
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
                  <form id="formLogin">
                    <div class="mb-3">
                      <label for="email" class="form-label">Email</label>
                      <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="mb-4">
                      <label for="password" class="form-label">Password</label>
                      <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <button type="submit" class="btn btn-success w-100 py-8 fs-4 mb-4 rounded-2">Login</button>
                    <div class="d-flex align-items-center justify-content-center">
                      <p class="fs-4 mb-0 fw-bold">Belum Punya Akun?</p>
                      <a class="text-success fw-bold ms-2" href="{{ route('pilihan.register') }}">Daftar</a>
                    </div>

                      <div class="text-center mt-4">
                        <a href="{{ url('/') }}" class="w-100">
                          <i class="fas fa-home me-2"></i> Kembali ke Home
                        </a>
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
  $('#formLogin').submit(function (e) {
    e.preventDefault();

    const email = $('#email').val().trim();
    const password = $('#password').val().trim();

    if (!email || !password) {
      Swal.fire({
        icon: 'warning',
        title: 'Oops!',
        text: 'Email dan password wajib diisi.',
      });
      return;
    }

    $.ajax({
      url: "{{ route('login.submit') }}",
      type: "POST",
      data: {
        email: email,
        password: password,
        _token: '{{ csrf_token() }}'
      },
      success: function (response) {
        Swal.fire({
          icon: 'success',
          title: 'Berhasil!',
          text: response.message,
          timer: 1500,
          showConfirmButton: false
        }).then(() => {
          window.location.href = response.redirect;
        });
      },
      error: function (xhr) {
        let message = 'Terjadi kesalahan';

        if (xhr.status === 401) {
          message = xhr.responseJSON?.message ?? 'Email atau password salah!';
        } else if (xhr.status === 422) {
          const errors = xhr.responseJSON.errors;
          const firstError = Object.values(errors)[0][0];
          message = firstError;
        } 
        Swal.fire({
          icon: 'error',
          title: 'Gagal!',
          text: message,
        });
      }
    });
  });
</script>
@endpush
