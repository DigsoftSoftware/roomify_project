@extends('home.main.app_login')

@section('section_home_login')
<section class="py-5 bg-light">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h2 class="fw-bold mb-1">My Booking</h2>
                        <p class="text-muted mb-0">Kelola semua booking hotel Anda</p>
                    </div>
                    <a href="{{ route('hotel.daftar') }}" class="btn btn-success">
                        <i class="bi bi-plus-circle me-2"></i>Booking Baru
                    </a>
                </div>

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="bi bi-exclamation-circle me-2"></i>{{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <!-- Filter Status -->
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-md-8">
                                <h6 class="mb-0">Filter Status Booking</h6>
                            </div>
                            <div class="col-md-4">
                                <select class="form-select" id="statusFilter" onchange="filterBookings()">
                                    <option value="">Semua Status</option>
                                    <option value="pending">Pending</option>
                                    <option value="confirmed">Dikonfirmasi</option>
                                    <option value="cancelled">Dibatalkan</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                @forelse($bookings as $booking)
                    <div class="card mb-4 shadow-sm booking-item" data-status="{{ $booking->status }}">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="position-relative">
                                        @if($booking->room->hotel->photos->isNotEmpty())
                                            <img src="{{ asset('storage/' . $booking->room->hotel->photos->first()->photo) }}" 
                                                 class="img-fluid rounded" 
                                                 style="height: 200px; width: 100%; object-fit: cover;" 
                                                 alt="Hotel Image">
                                        @else
                                            <img src="{{ asset('noimage.jpg') }}" 
                                                 class="img-fluid rounded" 
                                                 style="height: 200px; width: 100%; object-fit: cover;" 
                                                 alt="No Image">
                                        @endif
                                        
                                        <span class="position-absolute top-0 start-0 m-2 badge 
                                            @if($booking->status == 'confirmed') bg-success
                                            @elseif($booking->status == 'cancelled') bg-danger
                                            @else bg-warning text-dark
                                            @endif">
                                            @if($booking->status == 'confirmed')
                                                Dikonfirmasi
                                            @elseif($booking->status == 'cancelled')
                                                Dibatalkan
                                            @elseif($booking->status == 'pending')
                                                Pending
                                            @else
                                                {{ ucfirst($booking->status) }}
                                            @endif
                                        </span>

                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <h5 class="fw-bold mb-2">{{ $booking->room->hotel->name }}</h5>
                                    <p class="text-muted mb-1">
                                        <i class="bi bi-geo-alt-fill me-1"></i>
                                        {{ Str::limit($booking->room->hotel->address, 50) }}
                                    </p>
                                    
                                    <div class="row mb-2">
                                        <div class="col-6">
                                            <small class="text-muted">Kode Booking</small>
                                            <p class="fw-bold mb-0">{{ $booking->kode_bookings }}</p>
                                        </div>
                                        <div class="col-6">
                                            <small class="text-muted">Tipe Kamar</small>
                                            <p class="fw-bold mb-0">{{ $booking->room->type }}</p>
                                        </div>
                                    </div>

                                    <div class="row mb-2">
                                        <div class="col-6">
                                            <small class="text-muted">Check-in</small>
                                            <p class="mb-0">{{ \Carbon\Carbon::parse($booking->check_in)->format('d M Y, H:i') }}</p>
                                        </div>
                                        <div class="col-6">
                                            <small class="text-muted">Check-out</small>
                                            <p class="mb-0">{{ \Carbon\Carbon::parse($booking->check_out)->format('d M Y, H:i') }}</p>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <small class="text-muted">Tanggal Booking</small>
                                        <p class="mb-0">{{ $booking->created_at->format('d M Y, H:i') }}</p>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="text-end h-100 d-flex flex-column justify-content-between">
                                        <div>
                                            <h4 class="text-success fw-bold mb-3">
                                                Rp{{ number_format($booking->total_price, 0, ',', '.') }}
                                            </h4>
                                        </div>

                                        <div class="d-grid gap-2">
                                            <a href="{{ route('mybooking.detail', $booking->id) }}" 
                                               class="btn btn-outline-primary btn-sm">
                                                <i class="bi bi-eye me-1"></i>Detail
                                            </a>

                                            @if($booking->status == 'pending')
                                                <a href="{{ route('mybooking.payment', $booking->id) }}"
                                                 target="_blank" 
                                                   class="btn btn-success btn-sm">
                                                    <i class="bi bi-credit-card me-1"></i>Bayar Sekarang
                                                </a>
                                                
                                                <button type="button" class="btn btn-outline-danger btn-sm btn-cancel-booking" data-id="{{ $booking->id }}">
                                                    <i class="bi bi-x-circle me-1"></i> Batalkan
                                                </button>

                                                
                                            @elseif($booking->status == 'confirmed')
                                                <button class="btn btn-success btn-sm" disabled>
                                                    <i class="bi bi-check-circle me-1"></i>Terkonfirmasi
                                                </button>
                                            @else
                                                <button class="btn btn-secondary btn-sm" disabled>
                                                    <i class="bi bi-x-circle me-1"></i>Dibatalkan
                                                </button>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="card">
                        <div class="card-body text-center py-5">
                            <i class="bi bi-calendar-x display-1 text-muted mb-3"></i>
                            <h4 class="text-muted">Belum Ada Booking</h4>
                            <p class="text-muted mb-4">Anda belum memiliki booking hotel apapun</p>
                            <a href="{{ route('hotel.daftar') }}" class="btn btn-success">
                                <i class="bi bi-plus-circle me-2"></i>Mulai Booking Hotel
                            </a>
                        </div>
                    </div>
                @endforelse

                <!-- @if($bookings->hasPages())
                    <div class="mt-4 d-flex justify-content-center">
                        {{ $bookings->links() }}
                    </div>
                @endif -->

            </div>
        </div>
    </div>
</section>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function() {
        $('.btn-cancel-booking').click(function() {
            const bookingId = $(this).data('id');

            Swal.fire({
                title: 'Yakin batalkan booking?',
                text: "Tindakan ini tidak bisa dibatalkan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, batalkan!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `/homepages/booking/payment/deleted/${bookingId}`,
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            Swal.fire(
                                'Dibatalkan!',
                                'Booking Anda sudah dibatalkan.',
                                'success'
                            ).then(() => {
                                location.reload();
                            });
                        },
                        error: function(xhr) {
                            Swal.fire(
                                'Gagal!',
                                'Terjadi kesalahan, silakan coba lagi.',
                                'error'
                            );
                        }
                    });
                }
            });
        });
    });

    function filterBookings() {
        const filter = document.getElementById('statusFilter').value;
        const bookings = document.querySelectorAll('.booking-item');
        
        bookings.forEach(booking => {
            if (filter === '' || booking.dataset.status === filter) {
                booking.style.display = 'block';
            } else {
                booking.style.display = 'none';
            }
        });
    }

    function confirmCancel(bookingId) {
        const cancelForm = document.getElementById('cancelForm');
        cancelForm.action = `/booking/cancel/${bookingId}`;
        
        const cancelModal = new bootstrap.Modal(document.getElementById('cancelModal'));
        cancelModal.show();
    }
</script>
@endsection