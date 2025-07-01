@extends('admin.main.app')

@section('title', 'Data User | Roomify Dashboard')

@section('content_dashboard_admin')
    <div class="datatables">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="card-title mb-0">Data User</h4>
                    <button class="btn btn-primary" onclick="window.location.href='{{ route('users.data.create') }}'">Tambah Admin</button>
                </div>
                <div class="table-responsive">
                    <table id="myTable" class="table table-striped table-bordered text-nowrap align-middle">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Foto</th>
                                <th>Nama</th>
                                <th>Username</th>
                                <th>Email</th>
                                <th>No Telepon</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $index => $user)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    @if($user->photo_profile)
                                        <img src="{{ asset('storage/' . $user->photo_profile) }}" width="100" alt="Foto">
                                    @else
                                        <span>Tidak ada foto</span>
                                    @endif
                                </td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->username }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->phone }}</td>
                                <td class="text-center">
                                    <button class="btn btn-warning btn-sm" onclick="window.location.href='{{ route('users.data.edit', $user->id) }}'"><i class="fa-solid fa-pen-to-square"></i></button>
                                    <form action="{{ route('users.data.destroy', $user->id) }}" method="POST" class="d-inline delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-danger btn-sm delete-btn"><i class="fa-solid fa-trash"></i></button>
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
        $(document).ready(function() {
            $('#myTable').DataTable({
                "responsive": true,
                "lengthChange": true,
                "autoWidth": false
            });
        });
    </script>
    @endpush
@endsection
