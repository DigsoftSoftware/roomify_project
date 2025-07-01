@extends('admin.main.app')

@section('title', 'Data Booking | Roomify Dashboard')

@section('content_dashboard_admin')
<div class="datatables">
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="card-title mb-0">Data Booking</h4>
            </div>

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="table-responsive">
                <table id="myTable" class="table table-striped table-bordered text-nowrap align-middle">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kode Booking</th>
                            <th>Nama Pemesan</th>
                            <th>Ruangan</th>
                            <th>Tanggal Masuk</th>
                            <th>Tanggal Keluar</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($bookings as $index => $booking)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $booking->kode_bookings }}</td>
                                <td>{{ $booking->user->name }}</td>
                                <td>{{ $booking->room->type }}</td>
                                <td>{{ \Carbon\Carbon::parse($booking->check_in)->format('d M Y, H:i') }}</td>
                                <td>{{ \Carbon\Carbon::parse($booking->check_out)->format('d M Y, H:i') }}</td>
                                <td>
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

                                </td>
                                <td>
                                    <button class="btn btn-primary btn-sm" onclick="window.location.href='{{ route('booking.data.detail', $booking->id) }}'">
                                        <i class="fa-solid fa-eye"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>     
            </div>
        </div>      
    </div>
</div>

@push('scripts')
<script>
    $(document).ready(function() {
        $('#myTable').DataTable();
    });
</script>
@endpush
@endsection
