@extends('admin.main.app')

@section('title', 'Data Payment | Roomify Dashboard')

@section('content_dashboard_admin')
<div class="datatables">
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="card-title mb-0">Data Pembayaran</h4>
            </div>

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="table-responsive">
                <table id="myTable" class="table table-striped table-bordered text-nowrap align-middle">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kode Transaksi</th>
                            <th>Nama Pemesan</th>
                            <th>Ruangan</th>
                            <th>Tanggal Masuk</th>
                            <th>Tanggal Keluar</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($payment as $index => $p)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $p->kode_transaksi }}</td>
                                <td>{{ $p->booking->user->name ?? '-' }}</td>
                                <td>
                                    {{ $p->booking->room->type ?? '-' }} <br>
                                    <small class="text-muted">{{ $p->booking->room->hotel->name ?? '-' }}</small>
                                </td>
                                <td>{{ \Carbon\Carbon::parse($p->booking->check_in)->format('d M Y, H:i') }}</td>
                                <td>{{ \Carbon\Carbon::parse($p->booking->check_out)->format('d M Y, H:i') }}</td>
                                <td>
                                    <span class="badge 
                                        {{ 
                                            $p->booking->status === 'confirmed' ? 'bg-success' : 
                                            ($p->booking->status === 'cancelled' ? 'bg-danger' : 'bg-warning') 
                                        }}">
                                        {{ ucfirst($p->booking->status) }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('payment.data.detail', $p->id) }}" class="btn btn-sm btn-primary">
                                        <i class="fa fa-eye"></i>
                                    </a>
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
