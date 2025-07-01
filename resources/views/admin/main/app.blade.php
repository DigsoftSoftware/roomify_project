<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="theme-color" content="#3CD668">
  <title>@yield('title', 'Roomify')</title>
  <link rel="manifest" href="{{ asset('manifest.json') }}">
  <link rel="shortcut icon" type="image/png" href="{{ asset('/admin/images/logos/icon.jpg') }}" />
  <link rel="stylesheet" href="{{ asset('/admin/css/styles.min.css') }}" />
  <link rel="stylesheet" href="https://cdn.datatables.net/2.3.0/css/dataTables.dataTables.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
 <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
 
  @stack('styles')
</head>

<body>
  <form id="logoutForm" action="{{ route('users.logout') }}" method="POST" style="display: none;">
      @csrf
  </form>
  <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
    data-sidebar-position="fixed" data-header-position="fixed">

    <!-- Sidebar -->
    @include('admin.components.sidebar')

    <!-- Main Content -->
    <div class="body-wrapper">
      <!-- Navbar -->
      @include('admin.components.navbar')

      <!-- Content -->
      <div class="container-fluid">
        @yield('content_login')
        @yield('content_dashboard_admin')
        @yield('content_dashboard_hotel_onwers')
      </div>

      <footer class="footer py-5">
          <div class="text-muted text-center">
              © <?= date('Y') ?> Roomify | Booking System. Created by. <b>Kelompok 8, MI 4C.</b>
          </div>
      </footer>

    </div>
  </div>

 
  <script src="{{ asset('/admin/libs/jquery/dist/jquery.min.js') }}"></script>
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <script src="https://cdn.datatables.net/2.3.0/js/dataTables.js"></script>
  <script src="{{ asset('/admin/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('/admin/js/sidebarmenu.js') }}"></script>
  <script src="{{ asset('/admin/js/app.min.js') }}"></script>
  <script src="{{ asset('/admin/libs/simplebar/dist/simplebar.js') }}"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
  <script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>

  <script>
    if ('serviceWorker' in navigator) {
      navigator.serviceWorker.register("{{ asset('service-worker.js') }}")
        .then(function(registration) {
          console.log('Service Worker registered with scope:', registration.scope);
        })
        .catch(function(error) {
          console.error('Service Worker registration failed:', error);
        });
    }
  </script>

  <script>

    const successMessage = "{{ session('success') ?? '' }}";
    const errorMessage = "{{ session('error') ?? '' }}";

    if(successMessage) {
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: successMessage,
            timer: 3000,
            showConfirmButton: false
        });
    }

    if(errorMessage) {
        Swal.fire({
            icon: 'error',
            title: 'Gagal!',
            text: errorMessage,
            timer: 3000,
            showConfirmButton: false
        });
    }

    $('#btnLogout').click(function (e) {
      e.preventDefault();

      Swal.fire({
        title: 'Apakah Anda Akan Logout?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#198754',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, logout!'
      }).then((result) => {
        if (result.isConfirmed) {
          $('#logoutForm').submit();
        }
      });
    });

    document.addEventListener("DOMContentLoaded", function () {
        const deleteButtons = document.querySelectorAll('.delete-btn');

        deleteButtons.forEach(button => {
            button.addEventListener('click', function () {
                const form = this.closest('form');

                Swal.fire({
                    title: 'Yakin mau hapus?',
                    text: "Data akan hilang permanen!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    });
    document.addEventListener("DOMContentLoaded", function () {
        const saveButtons = document.querySelectorAll('.save-btn');

        saveButtons.forEach(button => {
            button.addEventListener('click', function () {
                const form = this.closest('form');

                Swal.fire({
                    title: 'Simpan perubahan?',
                    text: "Pastikan data yang Anda isi sudah benar.",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Ya, Simpan',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    });
  </script>
@stack('scripts')
</body>
</html>
