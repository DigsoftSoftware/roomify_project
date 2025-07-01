@extends('admin.main.app')

@section('title', 'Detail Hotel | Roomify Dashboard')

@section('content_dashboard_admin')
<div class="container mt-4">
    <div class="card">
       <div class="card-header d-flex justify-content-between align-items-center">
            <h4>Detail Hotel <b>{{ $hotel->name }}</b></h4>
            <div>
                <a href="{{ route('myhotel.index') }}" class="btn btn-danger me-2">Kembali</a>
            </div>
        </div>

        <div class="card-body row">
            <div class="col-md-6 mb-3">
                <div id="carouselPhotos" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner">
                       @foreach($hotel->photos as $key => $photo)
                            <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                               <img src="{{ asset('storage/' . $photo->photo) }}" 
                                    class="d-block w-100 img-thumbnail" 
                                    style="cursor: zoom-in; height: 400px; object-fit: cover;" 
                                    data-bs-toggle="modal" data-bs-target="#photoModal{{ $key }}">
                            </div>

                            <!-- Modal -->
                            <div class="modal fade" id="photoModal{{ $key }}" tabindex="-1">
                                <div class="modal-dialog modal-dialog-centered modal-lg">
                                    <div class="modal-content">
                                        <img src="{{ asset('storage/' . $photo->photo) }}" class="w-100" style="height: 1000px; object-fit: cover;">
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
                <h5>Alamat Detail Hotel</h5>
                <p>{{ $hotel->address }}</p>
                
                <h5>Lokasi Maps</h5>
                <div id="map" style="height: 250px; z-index: 0;"></div>
                
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

@push('scripts')
    <script>
        var map = L.map('map').setView([{{ $hotel->latitude }}, {{ $hotel->longitude }}], 15);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);
        L.marker([{{ $hotel->latitude }}, {{ $hotel->longitude }}]).addTo(map)
            .bindPopup("<strong>{{ $hotel->name }}</strong><br>{{ $hotel->address }}");
    </script>
@endpush
