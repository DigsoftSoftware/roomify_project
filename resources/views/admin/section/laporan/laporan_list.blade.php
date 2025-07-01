@extends('admin.main.app')

@section('title', 'Pilih Jenis Laporan | Roomify Dashboard')

@push('styles')
<style>
    .card-report {
        transition: transform 0.2s, box-shadow 0.2s;
        height: 100%; 
    }
    .card-report:hover {
        transform: translateY(-5px);
        box-shadow: 0 4px 20px rgba(0,0,0,0.1);
    }
    .card-report .card-body {
        text-align: center;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }
    .card-report .icon-wrapper {
        font-size: 48px;
        margin-bottom: 1rem;
    }
    .card-report .btn {
        cursor: pointer;
    }
</style>
@endpush

@section('content_dashboard_admin')
<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title mb-4">Pilih Jenis Laporan</h4>
            <div class="row">
                <div class="col-md-6 mb-4">
                    <div class="card card-report shadow-sm">
                        <div class="card-body">
                            <div>
                                <div class="icon-wrapper text-danger">
                                    <i class="fas fa-globe-asia"></i>
                                </div>
                                <h5 class="card-title">Laporan Keseluruhan</h5>
                                <p class="card-text text-muted">Cetak seluruh data transaksi booking yang telah selesai atau dibatalkan</p>
                            </div>
                            <button class="btn btn-danger" id="btn-cetak-semua">Cetak Laporan</button>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 mb-4">
                    <div class="card card-report shadow-sm">
                        <div class="card-body">
                            <div>
                                <div class="icon-wrapper text-info">
                                    <i class="fas fa-user-check"></i>
                                </div>
                                <h5 class="card-title">Laporan per User</h5>
                                <p class="card-text text-muted">Cetak riwayat transaksi booking untuk satu user spesifik yang Anda pilih.</p>
                            </div>
                            <button class="btn btn-info text-white" data-bs-toggle="modal" data-bs-target="#laporanUserModal">Pilih User</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="laporanUserModal" tabindex="-1" aria-labelledby="laporanUserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="laporanUserModalLabel">Pilih User untuk Laporan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Silakan pilih user dari daftar di bawah untuk membuat laporan PDF.</p>
                <div class="mb-3">
                    <label for="user_id" class="form-label">Nama User</label>
                    <select name="user_id" id="user_id_select" class="form-select" required>
                        <option value="">-- Pilih User --</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" id="btn-cetak-per-user">
                    <i class="fas fa-print"></i> Cetak Laporan
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    $('#btn-cetak-semua').on('click', function() {
        Swal.fire({
            title: 'Cetak Laporan Keseluruhan?',
            text: "Anda akan membuat PDF yang berisi semua data booking.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, Cetak!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                window.open("{{ route('laporan.cetak', ['jenis' => 'semua']) }}", '_blank');
            }
        });
    });

    $('#btn-cetak-per-user').on('click', function() {
        const userId = $('#user_id_select').val();

        if (!userId) {
            Swal.fire({
                icon: 'error',
                title: 'Belum Memilih User',
                text: 'Anda harus memilih user terlebih dahulu.',
            });
            return;
        }
        const url = "{{ route('laporan.cetak') }}?jenis=per_user&user_id=" + userId;
        window.open(url, '_blank');
        $('#laporanUserModal').modal('hide');
    });
});
</script>
@endpush