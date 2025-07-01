@extends('admin.main.app')

@section('title', 'Data Hotel | Roomify Dashboard')

@push('styles')
    <style>
    .star-rating .star {
        font-size: 20px;
        color: #ccc; 
    }
    .star-rating .star.filled {
        color: gold;
    }
    </style>
@endpush

@section('content_dashboard_admin')
    <div class="datatables">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="card-title mb-0">Data Hotels</h4>
                    <button class="btn btn-primary" onclick="window.location.href='{{ route('myhotel.data.create') }}'">Tambah Hotels</button>
                </div>
                <div class="table-responsive">
                    <table id="myTable" class="table table-striped table-bordered text-nowrap align-middle">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Alamat</th>
                                <th>Owner</th>
                                <th>Rating</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($hotels as $index => $hotel)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $hotel->name }}</td>
                                <td>{{ $hotel->address }}</td>
                                <td>{{ $hotel->owner->name }}</td>
                                <td>
                                    <div class="star-rating">
                                        @for($i = 1; $i <= 5; $i++)
                                            @if($i <= $hotel->rating)
                                                <span class="star filled">★</span>
                                            @else
                                                <span class="star">★</span>
                                            @endif
                                        @endfor
                                    </div>
                                </td>
                                <td>
                                    <button class="btn btn-primary btn-sm" onclick="window.location.href='{{ route('myhotel.data.detail', $hotel->id) }}'"><i class="fa-solid fa-eye"></i></button>
                                    <buttonw class="btn btn-warning btn-sm" onclick="window.location.href='{{ route('myhotel.data.edit', $hotel->id) }}'"><i class="fa-solid fa-pen-to-square"></i></buttonw>
                                    <form action="{{ route('myhotel.data.destroy', $hotel->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirmDelete(this)">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm"><i class="fa-solid fa-trash"></i></button>
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
        <script>
            function confirmDelete(form) {
                event.preventDefault();
                Swal.fire({
                    title: 'Yakin hapus hotel ini?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    confirmButtonText: 'Hapus',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            }
            $(document).ready(function() {
                $('#myTable').DataTable({
                });
            });
        </script>
    @endpush
@endsection
