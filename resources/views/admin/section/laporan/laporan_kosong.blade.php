@extends('admin.main.app')

@section('title', 'Laporan Kosong | Roomify Dashboard')

@section('content_dashboard_admin')
<div class="container-fluid">
    <div class="card">
        <div class="card-body text-center">
            <div class="my-5">
                <i class="fas fa-file-excel fa-4x text-muted mb-3"></i>
                <h4 class="card-title">Laporan Tidak Dapat Dicetak</h4>
                <p class="text-muted">{{ $message }}</p>
                <a href="{{ route('laporan.index') }}" class="btn btn-primary mt-3">Kembali ke Halaman Laporan</a>
            </div>
        </div>
    </div>
</div>
@endsection