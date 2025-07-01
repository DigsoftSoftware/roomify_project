@extends('admin.main.app')

@section('title', 'Edit Data Kamar | Roomify Dashboard')

@section('content_dashboard_admin')
<div class="container-fluid">
    <form action="{{ route('room.data.update', $room->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="mb-4">Edit Data Kamar</h4>
                </div>

                <div class="form-group mb-3">
                    <label class="form-label" for="hotel_id">Nama Hotel</label>
                    <select name="hotel_id" id="hotel_id" class="form-control @error('hotel_id') is-invalid @enderror" required>
                        <option value="">Pilih Nama Hotel</option>
                        @foreach($hotels as $hotel)
                            <option value="{{ $hotel->id }}" {{ $room->hotel_id == $hotel->id ? 'selected' : '' }}>{{ $hotel->name }}</option>
                        @endforeach
                    </select>
                    @error('hotel_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label class="form-label" for="type">Tipe Kamar</label>
                    <select name="type" id="type" class="form-control @error('type') is-invalid @enderror" required>
                        <option value="">Pilih Tipe</option>
                        <option value="Single" {{ $room->type == 'Single' ? 'selected' : '' }}>Single</option>
                        <option value="Double" {{ $room->type == 'Double' ? 'selected' : '' }}>Double</option>
                        <option value="Twin" {{ $room->type == 'Twin' ? 'selected' : '' }}>Twin</option>
                        <option value="Suite" {{ $room->type == 'Suite' ? 'selected' : '' }}>Suite</option>
                        <option value="Family" {{ $room->type == 'Family' ? 'selected' : '' }}>Family</option>
                    </select>
                    @error('type')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label class="form-label" for="price_display">Harga</label>
                    <div class="input-group">
                        <input type="text"
                            class="form-control @error('price') is-invalid @enderror"
                            id="price_display"
                            placeholder="Contoh: Rp10.000,00"
                            value="{{ number_format($room->price, 0, ',', '.') }}"
                            required>
                        <input type="hidden" name="price" id="price" value="{{ $room->price }}">
                    </div>
                    @error('price')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-4">
                    <label class="form-label" for="availability">Ketersediaan</label>
                    <select name="availability" id="availability" class="form-control @error('availability') is-invalid @enderror" required>
                        <option value="">Pilih Ketersediaan</option>
                        <option value="1" {{ $room->availability ? 'selected' : '' }}>Tersedia</option>
                        <option value="0" {{ !$room->availability ? 'selected' : '' }}>Tidak Tersedia</option>
                    </select>
                    @error('availability')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-2 mt-2">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <button type="button" class="btn btn-danger" onclick="window.location.href='{{ route('room.index') }}'">Kembali</button>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
    const priceDisplay = document.getElementById('price_display');
    const priceInput = document.getElementById('price');

    priceDisplay.addEventListener('input', function (e) {
        let value = e.target.value.replace(/[^0-9]/g, '');

        if (value === '') {
            e.target.value = '';
            priceInput.value = '';
            return;
        }

        let numeric = parseInt(value);
        let formatted = new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            minimumFractionDigits: 0,
            maximumFractionDigits: 0
        }).format(numeric);

        e.target.value = formatted;
        priceInput.value = numeric;
    });

    window.addEventListener('DOMContentLoaded', function () {
        const currentPrice = priceInput.value;
        if (currentPrice) {
            priceDisplay.value = new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0,
                maximumFractionDigits: 0
            }).format(parseInt(currentPrice));
        }
    });
</script>
@endpush
