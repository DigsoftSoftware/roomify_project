@extends('home.main.app_login')

@section('section_home_login')
<section class="py-5 bg-light">
    <div class="container">
        <h2 class="mb-4 fw-bold text-center">Detail Pemesanan</h2>
        <a href="{{ url()->previous() }}" class="btn btn-outline-success mb-3">
              <i class="bi bi-arrow-left"></i> Kembali
          </a>
        <div class="row gx-5">
            <div class="col-lg-8 mb-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">
                        <h4 class="fw-semibold mb-2">{{ $booking->room->hotel->name }}</h4>
                        <p class="text-muted mb-1">
                            <i class="bi bi-geo-alt-fill me-1 text-danger"></i>{{ $booking->room->hotel->address }}
                        </p>
                        <p class="text-muted mb-3">
                            <i class="bi bi-clock-history me-1 text-primary"></i>
                            Tanggal Pemesanan: {{ \Carbon\Carbon::parse($booking->created_at)->format('d M Y H:i') }}
                        </p>

                        <div id="carouselDetail" class="carousel slide rounded mb-4" data-bs-ride="carousel">
                            <div class="carousel-inner rounded">
                                @foreach($booking->room->hotel->photos as $key => $photo)
                                    <div class="carousel-item @if($key == 0) active @endif">
                                        <img src="{{ asset('storage/' . $photo->photo) }}"
                                            class="d-block w-100 rounded object-fit-cover"
                                            style="max-height: 320px; object-fit: cover;" alt="Foto Hotel">
                                    </div>
                                @endforeach
                            </div>
                            <button class="carousel-control-prev" type="button" data-bs-target="#carouselDetail" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon"></span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#carouselDetail" data-bs-slide="next">
                                <span class="carousel-control-next-icon"></span>
                            </button>
                        </div>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <p class="mb-1"><strong>Tipe Kamar:</strong><br>{{ $booking->room->type }}</p>
                            </div>
                            <div class="col-md-6">
                                <p class="mb-1"><strong>Harga per Hari:</strong><br>Rp{{ number_format($booking->room->price, 0, ',', '.') }}</p>
                            </div>
                            <div class="col-md-6">
                                <p class="mb-1"><strong>Check-In:</strong><br>{{ \Carbon\Carbon::parse($booking->check_in)->format('d M Y H:i') }}</p>
                            </div>
                            <div class="col-md-6">
                                <p class="mb-1"><strong>Check-Out:</strong><br>{{ \Carbon\Carbon::parse($booking->check_out)->format('d M Y H:i') }}</p>
                            </div>
                        </div>

                        <hr class="my-4">

                        <p class="fs-6">
                            <strong>Status:</strong>
                            @if($booking->status === 'confirmed')
                                <span class="badge bg-success">Dikonfirmasi</span>
                            @elseif($booking->status === 'pending')
                                <span class="badge bg-warning text-dark">Menunggu Konfirmasi</span>
                            @else
                                <span class="badge bg-danger">Dibatalkan</span>
                            @endif
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 mb-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">
                        <h5 class="mb-3 fw-semibold">Ringkasan Pembayaran</h5>

                        <ul class="list-group list-group-flush mb-3">
                            <li class="list-group-item d-flex justify-content-between">
                                <span>Harga per Hari</span>
                                <strong>Rp{{ number_format($booking->room->price, 0, ',', '.') }}</strong>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                <span>Lama Menginap</span>
                                <strong>{{ \Carbon\Carbon::parse($booking->check_in)->diffInDays(\Carbon\Carbon::parse($booking->check_out)) }} Hari</strong>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                <span class="fw-bold">Total Harga</span>
                                <strong class="text-success fs-5">Rp{{ number_format($booking->total_price, 0, ',', '.') }}</strong>
                            </li>
                        </ul>

                       @if($booking->status === 'confirmed')
                            <button class="btn btn-secondary w-100 py-2" disabled>
                                <i class="bi bi-check-circle me-2"></i> Pembayaran Selesai
                            </button>
                        @elseif($booking->status === 'cancelled')
                            <button class="btn btn-danger w-100 py-2" disabled>
                                <i class="bi bi-x-circle me-2"></i> Pesanan Dibatalkan
                            </button>
                        @else
                            <a href="{{ route('mybooking.payment', $booking->id) }}" target="_blank" class="btn btn-success w-100 py-2">
                                <i class="bi bi-credit-card me-2"></i> Lanjutkan ke Pembayaran
                            </a>
                        @endif



                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
