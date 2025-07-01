@extends('admin.main.app')

@section('title', 'Detail Pembayaran | Roomify Dashboard')

@push('styles')
<style>
    .img-thumbnail { cursor: zoom-in; height: 400px; object-fit: cover; }
    .modal-img { width: 100%; height: 80vh; object-fit: contain; }
    #map { height: 250px; z-index: 0; width: 100%; border-radius: 0.375rem; }
</style>
@endpush

@section('content_dashboard_admin')
<div class="container-fluid mt-4">
    <div class="card shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Detail Pembayaran</h4>
            <a href="{{ route('payment.index') }}" class="btn btn-danger">
                <i class="bi bi-arrow-left me-1"></i>Kembali
            </a>
        </div>

        <div class="card-body">
            <div class="row mb-4">
                {{-- Informasi Pemesan --}}
                <div class="col-md-6">
                    <div class="card h-100">
                        <div class="card-header bg-light">
                            <h5 class="mb-0">Informasi Pemesan</h5>
                        </div>
                        <div class="card-body">
                            <p><strong>Nama:</strong> {{ $payment->booking->user->name }}</p>
                            <p><strong>Email:</strong> {{ $payment->booking->user->email }}</p>
                            <p><strong>Kode Booking:</strong> <span class="badge bg-secondary">{{ $payment->booking->kode_bookings }}</span></p>
                        </div>
                    </div>
                </div>

                {{-- Informasi Pembayaran --}}
                <div class="col-md-6">
                    <div class="card h-100">
                        <div class="card-header bg-light">
                            <h5 class="mb-0">Detail Pembayaran</h5>
                        </div>
                        <div class="card-body">
                            <p><strong>Kode Transaksi:</strong> {{ $payment->kode_transaksi }}</p>
                            <p><strong>Metode:</strong> {{ ucfirst(str_replace('_', ' ', $payment->payment_method)) }}</p>
                            <p><strong>Status Pembayaran:</strong> 
                                @php
                                    $statusBadgeClass = match($payment->payment_status) {
                                        'paid' => 'bg-success',
                                        'failed' => 'bg-danger',
                                        default => 'bg-warning',
                                    };

                                    $statusText = match($payment->payment_status) {
                                        'paid' => 'Lunas',
                                        'pending' => 'Menunggu',
                                        'failed' => 'Gagal',
                                        default => ucfirst($payment->payment_status),
                                    };
                                @endphp

                                <span class="badge {{ $statusBadgeClass }}">
                                    {{ $statusText }}
                                </span>

                            </p>
                            <p><strong>Total Bayar:</strong> <span class="text-success fw-bold">Rp{{ number_format($payment->amount, 0, ',', '.') }}</span></p>
                        </div>
                    </div>
                </div>
            </div>

            <hr class="my-4">

            <div class="row">
                {{-- Informasi Hotel --}}
                <div class="col-lg-6 mb-4">
                    <div class="card">
                        <div class="card-header bg-light"><h5 class="mb-0">Foto Hotel</h5></div>
                        <div class="card-body p-0">
                            <div id="carouselPhotos" class="carousel slide" data-bs-ride="carousel">
                                <div class="carousel-inner">
                                    @foreach($payment->booking->room->hotel->photos as $key => $photo)
                                        <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                                            <img src="{{ asset('storage/' . $photo->photo) }}" 
                                                 class="d-block w-100 img-thumbnail" 
                                                 data-bs-toggle="modal" data-bs-target="#photoModal{{ $key }}" 
                                                 alt="Hotel Photo {{ $key + 1 }}">
                                        </div>

                                        <!-- Modal Zoom -->
                                        <div class="modal fade" id="photoModal{{ $key }}" tabindex="-1" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered modal-xl">
                                                <div class="modal-content p-0 border-0 bg-transparent">
                                                    <div class="modal-body p-0">
                                                        <button type="button" class="btn-close btn-close-white position-absolute top-0 end-0 m-3" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        <img src="{{ asset('storage/' . $photo->photo) }}" class="modal-img" alt="Zoomed Hotel Photo">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                                @if(count($payment->booking->room->hotel->photos) > 1)
                                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselPhotos" data-bs-slide="prev">
                                        <span class="carousel-control-prev-icon"></span>
                                        <span class="visually-hidden">Previous</span>
                                    </button>
                                    <button class="carousel-control-next" type="button" data-bs-target="#carouselPhotos" data-bs-slide="next">
                                        <span class="carousel-control-next-icon"></span>
                                        <span class="visually-hidden">Next</span>
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Info Lokasi & Rating --}}
                <div class="col-lg-6 mb-4">
                    <div class="card h-100">
                        <div class="card-header bg-light"><h5 class="mb-0">Informasi Hotel</h5></div>
                        <div class="card-body">
                            <p><strong>Nama Hotel:</strong> {{ $payment->booking->room->hotel->name }}</p>
                            <p><strong>Alamat:</strong> {{ $payment->booking->room->hotel->address }}</p>
                            <div class="mb-4">
                                <h6 class="fw-bold">Peta Lokasi</h6>
                                <div id="map" class="border"></div>
                            </div>
                            <div class="mb-0">
                                <h6 class="fw-bold">Rating</h6>
                                <div class="d-flex align-items-center">
                                    <div class="me-2">
                                        @for($i = 1; $i <= 5; $i++)
                                            <i class="bi {{ $i <= $payment->booking->room->hotel->rating ? 'bi-star-fill text-warning' : 'bi-star text-secondary' }}"></i>
                                        @endfor
                                    </div>
                                    <span class="badge bg-warning text-dark">{{ $payment->booking->room->hotel->rating }}/5</span>
                                </div>
                            </div>
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
    var map = L.map('map').setView([{{ $payment->booking->room->hotel->latitude }}, {{ $payment->booking->room->hotel->longitude }}], 15);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);
    L.marker([{{ $payment->booking->room->hotel->latitude }}, {{ $payment->booking->room->hotel->longitude }}]).addTo(map)
        .bindPopup("<strong>{{ $payment->booking->room->hotel->name }}</strong><br>{{ $payment->booking->room->hotel->address }}")
        .openPopup();
</script>
@endpush
