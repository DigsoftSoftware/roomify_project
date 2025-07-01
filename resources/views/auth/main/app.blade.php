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
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"/>
</head>

<body>
  
  <!-- Content Login dan Register -->
  @yield('content_login')
  @yield('content_pilihan_register')
  @yield('content_register_users')
  @yield('content_register_hotels_onwer')

  <script src="{{ asset('/admin/libs/jquery/dist/jquery.min.js') }}"></script>
  <script src="https://cdn.datatables.net/2.3.0/js/dataTables.js"></script>
  <script src="{{ asset('/admin/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('/admin/js/sidebarmenu.js') }}"></script>
  <script src="{{ asset('/admin/js/app.min.js') }}"></script>
  <script src="{{ asset('/admin/libs/simplebar/dist/simplebar.js') }}"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="{{ asset('/admin/libs/jquery/dist/jquery.min.js') }}"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


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
