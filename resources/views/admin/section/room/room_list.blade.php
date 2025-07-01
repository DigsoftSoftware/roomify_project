@extends('admin.main.app')

@section('title', 'Data Ruangan | Roomify Dashboard')

@section('content_dashboard_admin')
<div class="datatables">
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="card-title mb-0">Data Ruangan</h4>
                <a href="{{ route('room.data.create') }}" class="btn btn-primary">Tambah Data</a>
            </div>

            <div class="table-responsive">
                <table id="roomTable" class="table table-striped table-bordered text-nowrap align-middle">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Hotel</th>
                            <th>Tipe Kamar</th>
                            <th>Harga</th>
                            <th>Ketersediaan</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($rooms as $index => $room)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $room->hotel->name }}</td>
                                <td>{{ $room->type }}</td>
                                <td>Rp{{ number_format($room->price, 0, ',', '.') }}</td>
                                <td>
                                    <span class="badge bg-{{ $room->availability ? 'success' : 'danger' }}">
                                        {{ $room->availability ? 'Tersedia' : 'Tidak Tersedia' }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('room.data.edit', $room->id) }}" class="btn btn-warning btn-sm">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>
                                    <form action="{{ route('room.data.destroy', $room->id) }}" method="POST" class="d-inline delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-danger btn-sm delete-btn">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </form>
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
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function () {
        $('#roomTable').DataTable({
            responsive: true,
            lengthChange: true,
            autoWidth: false
        });

        $('.delete-btn').on('click', function () {
            const form = $(this).closest('form')[0];
            Swal.fire({
                title: 'Yakin ingin menghapus ruangan ini?',
                text: "Data yang dihapus tidak bisa dikembalikan.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
</script>
@endpush
@endsection
