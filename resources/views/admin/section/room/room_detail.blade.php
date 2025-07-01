@extends('admin.main.app')

@section('title', 'Detail Hotel | Roomify Dashboard')

@section('content_dashboard_admin')
<div class="container mt-4">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4>{{ $hotel->name }}</h4>
            <a href="{{ route('hotels.index') }}" class="btn btn-secondary">Kembali</a>
        </div>
        <div class="card-body row">
            <div class="col-md-6 mb-3">
                <div id="carouselPhotos" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        @foreach($hotel->photos as $key => $photo)
                            <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                                <img src="{{ asset('storage/' . $photo) }}" class="d-block w-100 img-thumbnail" style="cursor: zoom-in;" data-bs-toggle="modal" data-bs-target="#photoModal{{ $key }}">
                            </div>

                            <!-- Modal untuk foto -->
                            <div class="modal fade" id="photoModal{{ $key }}" tabindex="-1">
                                <div class="modal-dialog modal-dialog-centered modal-lg">
                                    <div class="modal-content">
                                        <img src="{{ asset('storage/' . $photo) }}" class="w-100">
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselPhotos" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon"></span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselPhotos" data-bs-slide="next">
                        <span class="carousel-control-next-icon"></span>
                    </button>
                </div>
            </div>

            <div class="col-md-6 mb-3">
                <h5>Alamat</h5>
                <p>{{ $hotel->address }}</p>
                
                <h5>Lokasi Maps</h5>
                <div id="map" style="height: 250px;"></div>
                
                <h5 class="mt-3">Rating</h5>
                <p>
                    @for($i = 1; $i <= 5; $i++)
                        <i class="bi {{ $i <= $hotel->rating ? 'bi-star-fill text-warning' : 'bi-star text-secondary' }}"></i>
                    @endfor
                    <span class="ms-2">({{ $hotel->rating }}/5)</span>
                </p>
            </div>

            <div class="col-12">
                <h5>Deskripsi</h5>
                <div class="border p-3" style="background: #f9f9f9;">
                    {!! $hotel->description !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
