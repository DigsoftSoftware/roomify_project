@extends('home.main.app_login')

@section('section_home_login')
<section class="py-5 bg-light">
    <div class="container">
        <div class="row g-5">
            <div class="col-lg-7">
                <a href="{{ url()->previous() }}" class="btn btn-outline-success mb-3">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>
                <h2 class="mb-3">{{ $detail_hotel->name }}</h2>
                <div id="mainPhotoCarousel" class="carousel slide rounded shadow-sm mb-3" data-bs-ride="carousel" style="max-height: 400px; overflow:hidden;">
                    <div class="carousel-inner rounded">
                        @foreach($detail_hotel->photos as $key => $photo)
                        <div class="carousel-item @if($key == 0) active @endif" style="cursor:pointer;">
                            <img src="{{ asset('storage/' . $photo->photo) }}" 
                                 class="d-block w-100 object-fit-cover" 
                                 alt="Foto Hotel"
                                 data-bs-toggle="modal" data-bs-target="#photoModal" 
                                 data-bs-slide-to="{{ $key }}">
                        </div>
                        @endforeach
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#mainPhotoCarousel" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon"></span>
                        <span class="visually-hidden">Sebelumnya</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#mainPhotoCarousel" data-bs-slide="next">
                        <span class="carousel-control-next-icon"></span>
                        <span class="visually-hidden">Selanjutnya</span>
                    </button>
                </div>

                <div class="mb-3">{!! $detail_hotel->description !!}</div>

                <h5 class="mt-4">Alamat</h5>
                <p>{{ $detail_hotel->address }}</p>

                <div id="map" style="height: 300px; border-radius: 12px; overflow: hidden;" class="shadow-sm mb-2"></div>

                <br><br>
                <div class="">
                    <a href="https://www.google.com/maps/search/?api=1&query={{ $detail_hotel->latitude }},{{ $detail_hotel->longitude }}" target="_blank" 
                       class="btn btn-success w-100 mb-4" style="border-radius: 30px; font-size: 1rem;">
                        <i class="bi bi-geo-alt-fill me-2"></i> Kunjungi Lokasi
                    </a>
                </div>

            </div>

            <div class="col-lg-5">
                <div class="card shadow-sm border-0 rounded">
                    <div class="card-body">
                        <h5 class="mb-3">Pesan Kamar</h5>

                        <form method="POST" action="{{ route('booking.store') }}">
                            @csrf
                            <input type="hidden" name="hotel_id" value="{{ $detail_hotel->id }}">

                            <div class="mb-3">
                                <label for="room_id" class="form-label">Tipe Kamar</label>
                                <select name="room_id" id="room_id" class="form-select" required>
                                    <option value="">Pilih tipe kamar</option>
                                    @foreach($detail_hotel->rooms as $room)
                                        <option value="{{ $room->id }}" data-price="{{ $room->price }}" @if(!$room->availability) disabled @endif>
                                            {{ $room->type }} - Rp{{ number_format($room->price, 0, ',', '.') }} 
                                            @if(!$room->availability)
                                                (Tidak tersedia)
                                            @endif
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Harga per Hari</label>
                                <input type="text" id="price_per_day" class="form-control" readonly value="Rp 0">
                            </div>

                            <div class="mb-3">
                                <label for="check_in" class="form-label">Check-In</label>
                                <input type="datetime-local" class="form-control" name="check_in" id="check_in" required>
                            </div>

                            <div class="mb-3">
                                <label for="check_out" class="form-label">Check-Out</label>
                                <input type="datetime-local" class="form-control" name="check_out" id="check_out" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Total Harga</label>
                                <input type="text" id="total_price" class="form-control" readonly value="Rp 0">
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-success">
                                    <i class="bi bi-calendar-check"></i> Pesan Sekarang
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="mt-4">
                    <h5 class="mb-3">Daftar Kamar</h5>
                    @forelse($detail_hotel->rooms as $room)
                        <div class="border rounded p-3 mb-3 shadow-sm bg-white">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <strong>{{ $room->type }}</strong><br>
                                    <small>Rp{{ number_format($room->price, 0, ',', '.') }}</small>
                                </div>
                                <div class="text-end">
                                    <span class="badge {{ $room->availability ? 'bg-success' : 'bg-danger' }}">
                                        {{ $room->availability ? 'Tersedia' : 'Tidak Tersedia' }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    @empty
                        <p class="text-muted">Belum ada kamar tersedia.</p>
                    @endforelse
                </div>
            </div>

        </div>
    </div>
</section>

<div class="modal fade" id="photoModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-xl">
    <div class="modal-content rounded">
      <div class="modal-body p-0">
        <div id="modalPhotoCarousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner rounded">
                @foreach($detail_hotel->photos as $key => $photo)
                <div class="carousel-item @if($key == 0) active @endif">
                    <img src="{{ asset('storage/' . $photo->photo) }}" class="d-block w-100 object-fit-contain" style="max-height: 600px;" alt="Foto Hotel Modal">
                </div>
                @endforeach
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#modalPhotoCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon"></span>
                <span class="visually-hidden">Sebelumnya</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#modalPhotoCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon"></span>
                <span class="visually-hidden">Selanjutnya</span>
            </button>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var lokasi = [{{ $detail_hotel->latitude }}, {{ $detail_hotel->longitude }}];
        var map = L.map('map').setView(lokasi, 14);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);

        L.marker(lokasi).addTo(map)
            .bindPopup("{{ $detail_hotel->name }}")
            .openPopup();

      
        const mainCarousel = document.getElementById('mainPhotoCarousel');
        const modalCarousel = new bootstrap.Carousel(document.getElementById('modalPhotoCarousel'));

        mainCarousel.querySelectorAll('.carousel-item img').forEach((img, idx) => {
            img.addEventListener('click', () => {
                modalCarousel.to(idx);
            });
        });

      
        const rooms = {};
        @foreach($detail_hotel->rooms as $room)
            rooms["{{ $room->id }}"] = {{ $room->price }};
        @endforeach

        // Fungsi yang diperbaiki
        function updatePrices() {
            const roomId = document.getElementById('room_id').value;
            const priceInput = document.getElementById('price_per_day');
            const totalPriceInput = document.getElementById('total_price');

            if (!roomId) {
                priceInput.value = 'Rp 0';
                totalPriceInput.value = 'Rp 0';
                return;
            }

            const pricePerDay = rooms[roomId] ?? 0;
            priceInput.value = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(pricePerDay);

            const checkInVal = document.getElementById('check_in').value;
            const checkOutVal = document.getElementById('check_out').value;

            if (!checkInVal || !checkOutVal) {
                // Jika tanggal belum lengkap, tampilkan harga untuk 1 hari
                totalPriceInput.value = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(pricePerDay);
                return;
            }

            const checkIn = new Date(checkInVal);
            const checkOut = new Date(checkOutVal);

            if (checkOut <= checkIn) {
                totalPriceInput.value = 'Tanggal tidak valid';
                return;
            }

            const diffMs = checkOut - checkIn;
            // Menghitung jumlah hari. Math.ceil membulatkan ke atas.
            // Contoh: 25 jam akan dihitung sebagai 2 hari.
            const diffDays = Math.ceil(diffMs / (1000 * 60 * 60 * 24));

            // Pastikan minimal dihitung 1 hari
            const totalDays = diffDays > 0 ? diffDays : 1;
            
            const total = totalDays * pricePerDay;

            totalPriceInput.value = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(total);
        }

        document.getElementById('room_id').addEventListener('change', updatePrices);
        document.getElementById('check_in').addEventListener('change', updatePrices);
        document.getElementById('check_out').addEventListener('change', updatePrices);

        // Inisialisasi tampilan harga saat halaman dimuat
        updatePrices();
    });
</script>
@endsection
