@extends('home.main.app_login')

@section('section_home_login')

<!-- Hero Section -->
<section id="hero" class="hero section bg-light py-5">
  <div class="container">
    <div class="row gy-4 align-items-center">
      <div class="col-lg-6 order-2 order-lg-1" data-aos="fade-up">
        <h1 class="fw-bold mb-3">Solusi Booking tercepat dan teraman di Bali</h1>
        <p class="mb-4 text-muted">Kami telah melayani serta menjembatani owner hotel dan user yang ingin booking hotel cepat dan aman.</p>
         <div class="d-flex">
            <a href="{{ route('hotel.daftar') }}" class="btn-get-started"><i class="fa-solid fa-magnifying-glass"></i>  Cek Hotel Impianmu</a>
          </div>
      </div>
      <div class="col-lg-6 order-1 order-lg-2 text-center" data-aos="zoom-out" data-aos-delay="100">
        <img src="{{ asset('/home/img/hero-img.png') }}" class="img-fluid animated" alt="hero">
      </div>
    </div>
  </div>
</section>

<!-- Hotel Terbaru Section -->
<section class="py-5 bg-light">
  <div class="container">
    <div class="text-center mb-5">
      <h2 class="fw-bold">Hotel Terbaru</h2>
      <p class="text-muted">Jelajahi daftar hotel terbaru yang tersedia untuk Anda</p>
    </div>

    <div class="row g-4">
      @forelse($daftar_hotel as $hotel)
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow rounded-4 overflow-hidden">
                        <div id="carouselHotel{{ $hotel->id }}" class="carousel slide" data-bs-ride="carousel">
                            <div class="carousel-inner ratio ratio-4x3">
                                @foreach($hotel->photos as $key => $photo)
                                    <div class="carousel-item @if($key == 0) active @endif">
                                        <img src="{{ asset('storage/' . $photo->photo) }}" class="d-block w-100 object-fit-cover" alt="Foto Hotel">
                                    </div>
                                @endforeach
                                @if($hotel->photos->isEmpty())
                                    <div class="carousel-item active">
                                        <img src="{{ asset('noimage.jpg') }}" class="d-block w-100 object-fit-cover" alt="Foto Hotel">
                                    </div>
                                @endif
                            </div>
                            @if($hotel->photos->count() > 1)
                            <button class="carousel-control-prev" type="button" data-bs-target="#carouselHotel{{ $hotel->id }}" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon"></span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#carouselHotel{{ $hotel->id }}" data-bs-slide="next">
                                <span class="carousel-control-next-icon"></span>
                            </button>
                            @endif
                        </div>

                        <div class="card-body d-flex flex-column">
                            <h4 class="card-title text-truncate">{{ $hotel->name }}</h4>
                            <p class="mb-1 text-muted">⭐ {{ number_format($hotel->rating ?? 0, 1) }}</p>
                            <p class="small text-muted">
                                <i class="bi bi-geo-alt-fill me-1"></i> {{ $hotel->address }}
                            </p>

                            @php
                                $desc = strip_tags($hotel->description);
                                $words = explode(' ', $desc);
                                $shortDesc = implode(' ', array_slice($words, 0, 50)) . (count($words) > 50 ? '...' : '');
                            @endphp
                            <p class="text-muted small mb-3" style="text-align: justify;">{{ $shortDesc }}</p>
                            <div class="mt-auto text-center">
                                <a href="{{ route('hotel.detail', $hotel->id) }}" class="btn btn-outline-success btn-lg w-75 rounded-pill shadow-sm">
                                    <i class="bi bi-eye me-1"></i> Lihat Selengkapnya
                                </a>
                            </div>
                        </div>

                    </div>
                </div>
            @empty
                <div class="col-12 text-center">
                    <p class="text-muted">Tidak ada hotel ditemukan.</p>
                </div>
            @endforelse
       </div>
  </div>
</section>
<section class="py-5 bg-light">
    <div class="mt-5 pt-5">
        <div class="container">
            <div class="mb-5" data-aos="fade-up">
              <h3 class="fw-bold text-center">Pertanyaan Umum (FAQ)</h3>
              <p class="text-muted text-center">Silahkan anda dapat melihat beberapa pertanyaan yang sering kami dapatkan!</p>
            </div>

            <div class="faq-item mb-3" data-aos="fade-up" data-aos-delay="100">
                <button class="faq-question btn btn-light w-100 text-start border rounded shadow-sm px-4 py-3">
                    Bagaimana cara memesan hotel?
                </button>
                <div class="faq-answer mt-2 px-3 text-muted" style="display: none;">
                    Pilih hotel yang diinginkan, klik tombol "Lihat Selengkapnya", lalu lanjutkan ke halaman pemesanan.
                </div>
            </div>

            <div class="faq-item mb-3" data-aos="fade-up" data-aos-delay="200">
                <button class="faq-question btn btn-light w-100 text-start border rounded shadow-sm px-4 py-3">
                    Apakah saya bisa membatalkan pesanan?
                </button>
                <div class="faq-answer mt-2 px-3 text-muted" style="display: none;">
                    Ya, pembatalan dapat dilakukan sesuai kebijakan masing-masing hotel yang tersedia di halaman detail hotel.
                </div>
            </div>

            <div class="faq-item mb-3" data-aos="fade-up" data-aos-delay="300">
                <button class="faq-question btn btn-light w-100 text-start border rounded shadow-sm px-4 py-3">
                    Bagaimana cara melihat status pemesanan saya?
                </button>
                <div class="faq-answer mt-2 px-3 text-muted" style="display: none;">
                    Silakan login ke akun Anda, lalu buka menu "Pemesanan Saya" untuk melihat status dan detail pemesanan.
                </div>
            </div>

            <div class="faq-item mb-3" data-aos="fade-up" data-aos-delay="400">
                <button class="faq-question btn btn-light w-100 text-start border rounded shadow-sm px-4 py-3">
                    Metode pembayaran apa saja yang tersedia?
                </button>
                <div class="faq-answer mt-2 px-3 text-muted" style="display: none;">
                    Kami mendukung berbagai metode pembayaran seperti transfer bank, e-wallet, dan pembayaran langsung di hotel tertentu.
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const questions = document.querySelectorAll(".faq-question");

        questions.forEach(function (question) {
            question.addEventListener("click", function () {
                const answer = this.nextElementSibling;

                document.querySelectorAll(".faq-answer").forEach(function (el) {
                    if (el !== answer) {
                        el.style.display = "none";
                    }
                });

                answer.style.display = answer.style.display === "none" || answer.style.display === "" ? "block" : "none";
            });
        });
    });
</script>
@endpush
