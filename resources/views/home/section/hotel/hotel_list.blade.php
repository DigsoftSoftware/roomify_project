@extends('home.main.app_login')

@section('section_home_login')
<section class="py-5 bg-light">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold">Daftar Hotel</h2>
            <p class="text-muted">Silakan pilih hotel sesuai keinginanmu!</p>
        </div>

        <div class="row justify-content-center mb-4">
            <div class="col-lg-10">
                <form method="GET" action="{{ route('hotel.daftar') }}">
                    <div class="row g-2 align-items-center">
                        <div class="col-md-6">
                            <input type="text" name="search" value="{{ request('search') }}" class="form-control form-control-lg shadow-sm" placeholder="Cari nama hotel...">
                        </div>
                        <div class="col-md-4">
                            <select name="rating" class="form-select form-select-lg shadow-sm">
                                <option value="">Filter Rating</option>
                                @for($i = 5; $i >= 1; $i--)
                                    <option value="{{ $i }}" {{ request('rating') == $i ? 'selected' : '' }}>{{ $i }} ⭐ atau lebih</option>
                                @endfor
                            </select>
                        </div>
                        <div class="col-md-2">
                            <button class="btn btn-success btn-lg w-100 shadow-sm" type="submit">
                                <i class="bi bi-funnel-fill me-1"></i> Filter
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <br><br>
        <div class="row g-4">
            @forelse($daftar_hotel as $hotel)
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow rounded-4 overflow-hidden">
                        <div id="carouselHotel{{ $hotel->id }}" class="carousel slide" data-bs-ride="carousel">
                            <div class="carousel-inner ratio ratio-4x3">
                                @foreach($hotel->photos as $key => $photo)
                                    <div class="carousel-item @if($key == 0) active @endif">
                                        <img src="{{ asset('storage/' . $photo->photo) }}" class="d-block w-100 object-fit-cover" alt="Foto Hotel">
                                    </div>
                                @endforeach
                                @if($hotel->photos->isEmpty())
                                    <div class="carousel-item active">
                                        <img src="{{ asset('noimage.jpg') }}" class="d-block w-100 object-fit-cover" alt="Foto Hotel">
                                    </div>
                                @endif
                            </div>
                            @if($hotel->photos->count() > 1)
                            <button class="carousel-control-prev" type="button" data-bs-target="#carouselHotel{{ $hotel->id }}" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon"></span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#carouselHotel{{ $hotel->id }}" data-bs-slide="next">
                                <span class="carousel-control-next-icon"></span>
                            </button>
                            @endif
                        </div>

                        <div class="card-body d-flex flex-column">
                            <h4 class="card-title text-truncate">{{ $hotel->name }}</h4>
                            <p class="mb-1 text-muted">⭐ {{ number_format($hotel->rating ?? 0, 1) }}</p>
                            <p class="small text-muted">
                                <i class="bi bi-geo-alt-fill me-1"></i> {{ $hotel->address }}
                            </p>

                            @php
                                $desc = strip_tags($hotel->description);
                                $words = explode(' ', $desc);
                                $shortDesc = implode(' ', array_slice($words, 0, 50)) . (count($words) > 50 ? '...' : '');
                            @endphp
                            <p class="text-muted small mb-3" style="text-align: justify;">{{ $shortDesc }}</p>
                            <div class="mt-auto text-center">
                                <a href="{{ route('hotel.detail', $hotel->id) }}" class="btn btn-outline-success btn-lg w-75 rounded-pill shadow-sm">
                                    <i class="bi bi-eye me-1"></i> Lihat Selengkapnya
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center">
                    <p class="text-muted">Tidak ada hotel ditemukan.</p>
                </div>
            @endforelse
        </div>

      <div class="mt-5 d-flex justify-content-center">
        {{ $daftar_hotel->links('vendor.pagination.bootstrap-5') }}
     </div>
    </div>
</section>

@endsection
