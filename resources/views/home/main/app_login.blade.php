<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Home | Roomify</title>
  <meta name="description" content="">
  <meta name="keywords" content="">

  <meta name="theme-color" content="#3CD668">
  <link rel="manifest" href="{{ asset('manifest.json') }}">

  <!-- Favicons -->
  <link href="{{ asset('/admin/images/logos/icon.jpg') }}" rel="icon">

  <!-- Fonts -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Raleway:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="{{asset('/home/vendor/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
  <link href="{{asset('/home/vendor/bootstrap-icons/bootstrap-icons.css')}}" rel="stylesheet">
  <link href="{{asset('/home/vendor/aos/aos.css')}}" rel="stylesheet">
  <link href="{{asset('/home/vendor/glightbox/css/glightbox.min.css')}}" rel="stylesheet">
  <link href="{{asset('/home/vendor/swiper/swiper-bundle.min.css')}}" rel="stylesheet">
  <link href="{{asset('/home/css/main.css')}}" rel="stylesheet">

  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


</head>

<body class="sarter-page-page">

    <form id="logoutForm" action="{{ route('users.logout') }}" method="POST" style="display: none;">
      @csrf
  </form>

  <header id="header" class="header d-flex align-items-center sticky-top">
    @include('home.components.navbar_login')
    @yield('navbar_login')
  </header>

  <main class="main">
  @yield('section_home')
  @yield('section_home_login')
  </main>

  <footer id="footer" class="footer">
    @include('home.components.footer')
    @yield('footer')
  </footer>

  <!-- Scroll Top -->
  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Preloader -->
  <div id="preloader"></div>

  <!-- Vendor JS Files -->
  <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
  <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
  <script src="{{asset('/home/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
  <script src="{{asset('/home/vendor/php-email-form/validate.js ')}}"></script>
  <script src="{{asset('/home/vendor/aos/aos.js')}}"></script>
  <script src="{{asset('/home/vendor/glightbox/js/glightbox.min.js')}}"></script>
  <script src="{{asset('/home/vendor/purecounter/purecounter_vanilla.js')}}"></script>
  <script src="{{asset('/home/vendor/imagesloaded/imagesloaded.pkgd.min.js')}}"></script>
  <script src="{{asset('/home/vendor/isotope-layout/isotope.pkgd.min.js')}}"></script>
  <script src="{{asset('/home/vendor/swiper/swiper-bundle.min.js')}}"></script>

  <!-- Main JS File -->
  <script src="{{asset('/home/js/main.js')}}"></script>

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
  </script>

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

 @stack('scripts')

</body>

</html>
