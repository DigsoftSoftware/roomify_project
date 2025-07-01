@extends('admin.main.app')

@section('title', 'Dashboard')

@section('content_dashboard_admin')
<div class="container-fluid">
    <h3 class="fw-semibold mb-4">Selamat Datang di Dashboard, {{ session('users_name') }}</h3>

    @if(Session::get('users_role') === 'admin')
    <div class="row g-4">
        <!-- Users -->
        <div class="col-md-3">
            <div class="card text-white bg-primary shadow-sm">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <div class="fs-5 fw-semibold">User</div>
                        <div class="fs-5 fw-bold">{{ $countUsers }}</div>
                    </div>
                    <i class="bi bi-person display-4"></i>
                </div>
            </div>
        </div>

        <!-- Pemilik Hotel -->
        <div class="col-md-3">
            <div class="card text-white bg-success shadow-sm">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <div class="fs-5 fw-semibold">Pemilik Hotel</div>
                        <div class="fs-5 fw-bold">{{ $countOwners }}</div>
                    </div>
                    <i class="bi bi-person-fill-check display-4"></i>
                </div>
            </div>
        </div>

        <!-- Hotels -->
        <div class="col-md-3">
            <div class="card text-white bg-warning shadow-sm">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <div class="fs-5 fw-semibold">Hotel</div>
                        <div class="fs-5 fw-bold">{{ $countHotels }}</div>
                    </div>
                    <i class="bi bi-building display-4"></i>
                </div>
            </div>
        </div>

        <!-- Bookings -->
        <div class="col-md-3">
            <div class="card text-white bg-danger shadow-sm">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <div class="fs-5 fw-semibold">Booking</div>
                        <div class="fs-5 fw-bold">{{ $countBookings }}</div>
                    </div>
                    <i class="bi bi-journal-bookmark display-4"></i>
                </div>
            </div>
        </div>
    </div>
    @endif

    @if(Session::get('users_role') === 'hotel_owner')
    <div class="row g-4">
        <!-- Hotels -->
        <div class="col-md-6">
            <div class="card text-white bg-warning shadow-sm">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <div class="fs-5 fw-semibold">Hotel</div>
                        <div class="fs-5 fw-bold">{{ $countHotels }}</div>
                    </div>
                    <i class="bi bi-building display-4"></i>
                </div>
            </div>
        </div>

        <!-- Bookings -->
        <div class="col-md-6">
            <div class="card text-white bg-danger shadow-sm">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <div class="fs-5 fw-semibold">Booking</div>
                        <div class="fs-5 fw-bold">{{ $countBookings }}</div>
                    </div>
                    <i class="bi bi-journal-bookmark display-4"></i>
                </div>
            </div>
        </div>
    </div>
    @endif


    <div class="mt-5">
        <h4 class="mb-3">Grafik Booking Hotel per Bulan</h4>
        <canvas id="bookingChart" height="120"></canvas>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
     const ctx = document.getElementById('bookingChart').getContext('2d');

     const bookingData = @json($bookingsPerMonth ?? []);

        if (Object.keys(bookingData).length === 0) {
            console.log("Data booking kosong");
        } else {
            console.log("Ada data booking:", bookingData);
        }

    const bookingChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
            datasets: [{
                label: 'Total Booking',
                data: bookingData,
                backgroundColor: 'rgba(54, 162, 235, 0.6)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 2,
                hoverBackgroundColor: 'rgba(255, 159, 64, 0.8)',
                hoverBorderColor: 'rgba(255, 159, 64, 1)',
                borderRadius: 8,
            }]
        },
        options: {
            responsive: true,
            animation: {
                duration: 1500,
                easing: 'easeOutBounce'
            },
            plugins: {
                title: {
                    display: true,
                    text: 'Statistik Booking per Bulan',
                    font: {
                        size: 18,
                        weight: 'bold'
                    }
                },
                tooltip: {
                    enabled: true,
                    callbacks: {
                        label: function(context) {
                            return `Total: ${context.parsed.y} booking`;
                        }
                    }
                },
                legend: {
                    display: true,
                    labels: {
                        color: '#333'
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 2,
                        precision: 0
                    },
                    grid: {
                        color: '#f1f1f1'
                    }
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            }
        }
    });
</script>
@endpush

