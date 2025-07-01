@extends('home.main.app_login')

@section('section_home_login')
<section class="py-5 bg-light">
    <div class="container">
        <div class="row align-items-center gy-5">
            <!-- Gambar dan deskripsi -->
            <div class="col-lg-6">
                <div class="rounded shadow overflow-hidden" style="aspect-ratio: 4/3;">
                    <img src="{{ asset('/home/img/hero-img2.png') }}" class="w-100 h-100 object-fit-cover" alt="Tentang Roomify">
                </div>
            </div>

            <div class="col-lg-6">
                <h2 class="fw-bold mb-3">Tentang <span class="text-primary">Roomify</span></h2>
                <p class="text-muted mb-3">
                    <strong>Roomify</strong> adalah platform pemesanan hotel berbasis teknologi AI yang dirancang untuk memudahkan siapa saja dalam mencari dan memesan akomodasi secara cepat dan aman. Kami menyediakan berbagai pilihan hotel terbaik dengan ulasan terpercaya dan sistem booking yang efisien.
                </p>

                <ul class="list-unstyled">
                    <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i> Lebih dari 5.000 hotel tersedia</li>
                    <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i> Sistem booking real-time & aman</li>
                    <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i> Layanan pelanggan 24/7</li>
                    <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i> Dilengkapi ulasan & rating pengguna</li>
                </ul>

                <a href="#services" class="btn btn-outline-primary mt-3">
                    Lihat Hotel Tersedia <i class="bi bi-arrow-right ms-2"></i>
                </a>
            </div>
        </div>

        <!-- Alamat dan Peta -->
        <br><br>
        <div class="row mt-5">
            <div class="col-lg-6">
                <h4 class="fw-semibold mb-3"><i class="bi bi-geo-alt-fill text-danger me-2"></i>Alamat Kantor Roomify</h4>
                <p class="text-muted mb-1">Roomify Indonesia</p>
                <p class="text-muted mb-1">Jalan Teknologi No. 88, Kuta, Badung, Bali</p>
                <p class="text-muted mb-1">Kode Pos: 80361</p>
                <p class="text-muted mb-1">Email: support@roomify.com</p>
                <p class="text-muted">Telepon: (0361) 123-4567</p>
            </div>
            <div class="col-lg-6">
                <div class="rounded shadow overflow-hidden" style="height: 300px;">
                    <div id="leafletMap" style="width: 100%; height: 100%;"></div>
                </div>

            </div>
        </div>
    </div>
</section>

@endsection

@push('scripts')
<script>
  document.addEventListener('DOMContentLoaded', function () {
    var map = L.map('leafletMap').setView([-8.723272, 115.172852], 13); 

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
      attribution: '&copy; <a href="https://openstreetmap.org">OpenStreetMap</a> contributors'
    }).addTo(map);

    L.marker([-8.723272, 115.172852]).addTo(map)
      .bindPopup('<b>Roomify Indonesia</b><br>Jalan Teknologi No. 88, Kuta')
      .openPopup();
  });
</script>
@endpush