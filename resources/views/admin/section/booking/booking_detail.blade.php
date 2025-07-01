@extends('admin.main.app')

@section('title', 'Detail Booking | Roomify Dashboard')

@push('styles')
<style>
    .img-thumbnail {
        cursor: zoom-in;
        height: 400px;
        object-fit: cover;
    }
    .modal-img {
        width: 100%;
        height: 80vh;
        object-fit: contain;
    }
    #map { 
        height: 250px; 
        z-index: 0;
        width: 100%;
        border-radius: 0.375rem;
    }
    .carousel-item img {
        border-radius: 0.375rem;
    }
</style>
@endpush

@section('content_dashboard_admin')
<div class="container-fluid mt-4">
    <div class="card shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Detail Booking</h4>
            <div>
                <a href="{{ route('booking.index') }}" class="btn btn-danger">
                    <i class="bi bi-arrow-left me-1"></i>Kembali
                </a>
            </div>
        </div>

        <div class="card-body">
            <div class="row mb-4">
                <div class="col-md-6">
                    <div class="card h-100">
                        <div class="card-header bg-light">
                            <h5 class="mb-0">Informasi Pemesan</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <strong>Kode Booking:</strong>
                                <span class="badge bg-secondary">{{ $booking->kode_bookings }}</span>
                            </div>
                            <div class="mb-3">
                                <strong>Nama:</strong> {{ $booking->user->name }}
                            </div>
                            <div class="mb-3">
                                <strong>Email:</strong> {{ $booking->user->email ?? '-' }}
                            </div>
                            <div class="mb-0">
                                <strong>Status:</strong>
                                @php
                                    $statusText = [
                                        'confirmed' => 'Diterima',
                                        'cancelled' => 'Dibatalkan',
                                        'pending' => 'Diproses'
                                    ];

                                    $statusColor = [
                                        'confirmed' => 'bg-success',
                                        'cancelled' => 'bg-danger',
                                        'pending' => 'bg-warning'
                                    ];

                                    $status = $booking->status;
                                @endphp

                                <span class="badge {{ $statusColor[$status] ?? 'bg-secondary' }}">
                                    {{ $statusText[$status] ?? ucfirst($status) }}
                                </span>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card h-100">
                        <div class="card-header bg-light">
                            <h5 class="mb-0">Detail Booking</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <strong>Ruangan:</strong> {{ $booking->room->type }}
                            </div>
                            <div class="mb-3">
                                <strong>Check-In:</strong> {{ \Carbon\Carbon::parse($booking->check_in)->format('d M Y, H:i') }} WIB
                            </div>
                            <div class="mb-3">
                                <strong>Check-Out:</strong> {{ \Carbon\Carbon::parse($booking->check_out)->format('d M Y, H:i') }} WIB
                            </div>
                            <div class="mb-0">
                                <strong>Total Harga:</strong> 
                                <span class="text-success fw-bold">Rp{{ number_format($booking->total_price, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <hr class="my-4">

            <div class="row">
                <div class="col-lg-6 mb-4">
                    <div class="card">
                        <div class="card-header bg-light">
                            <h5 class="mb-0">Foto Hotel</h5>
                        </div>
                        <div class="card-body p-0">
                            <div id="carouselPhotos" class="carousel slide" data-bs-ride="carousel">
                                <div class="carousel-inner">
                                @foreach($booking->room->hotel->photos as $key => $photo)
                                    <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                                        <img src="{{ asset('storage/' . $photo->photo) }}" 
                                                class="d-block w-100 img-thumbnail" 
                                                data-bs-toggle="modal" data-bs-target="#photoModal{{ $key }}"
                                                alt="Hotel Photo {{ $key + 1 }}">
                                    </div>

                                    <!-- Modal Zoom Foto -->
                                    <div class="modal fade" id="photoModal{{ $key }}" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered modal-xl">
                                            <div class="modal-content p-0 border-0 bg-transparent">
                                                <div class="modal-body p-0">
                                                    <button type="button" class="btn-close btn-close-white position-absolute top-0 end-0 m-3" data-bs-dismiss="modal" aria-label="Close" style="z-index: 1060;"></button>
                                                    <img src="{{ asset('storage/' . $photo->photo) }}" class="modal-img" alt="Hotel Photo {{ $key + 1 }}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                                </div>
                                
                                @if(count($booking->room->hotel->photos) > 1)
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

                <div class="col-lg-6 mb-4">
                    <div class="card h-100">
                        <div class="card-header bg-light">
                            <h5 class="mb-0">Informasi Hotel</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-4">
                                <h6 class="fw-bold">Alamat</h6>
                                <p class="text-muted mb-0">{{ $booking->room->hotel->address }}</p>
                            </div>
                            
                            <div class="mb-4">
                                <h6 class="fw-bold">Lokasi Maps</h6>
                                <div id="map" class="border"></div>
                            </div>
                            
                            <div class="mb-0">
                                <h6 class="fw-bold">Rating</h6>
                                <div class="d-flex align-items-center">
                                    <div class="me-2">
                                        @for($i = 1; $i <= 5; $i++)
                                            <i class="bi {{ $i <= $booking->room->hotel->rating ? 'bi-star-fill text-warning' : 'bi-star text-secondary' }}"></i>
                                        @endfor
                                    </div>
                                    <span class="badge bg-warning text-dark">{{ $booking->room->hotel->rating }}/5</span>
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
    var map = L.map('map').setView([{{ $booking->room->hotel->latitude }}, {{ $booking->room->hotel->longitude }}], 15);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);
    L.marker([{{ $booking->room->hotel->latitude }}, {{ $booking->room->hotel->longitude }}]).addTo(map)
        .bindPopup("<strong>{{ $booking->room->hotel->name }}</strong><br>{{ $booking->room->hotel->address }}")
        .openPopup();

    setTimeout(function() {
        map.invalidateSize();
    }, 100);
</script>
@endpush