@extends('admin.main.app')

@section('title', 'Edit Hotel | Roomify Dashboard')

@push('styles')
<style>
    #map {
        height: 600px; 
        border-radius: 8px;
        border: 1px solid #dee2e6;
    }
    .star-rating {
        display: flex;
        flex-direction: row-reverse;
        justify-content: flex-end;
        font-size: 2rem;
        cursor: pointer;
    }
    .star-rating input { display: none; }
    .star-rating label {
        color: #ddd;
        transition: 0.3s;
    }
    .star-rating input:checked ~ label,
    .star-rating label:hover,
    .star-rating label:hover ~ label {
        color: #ffc107;
    }
</style>
@endpush

@section('content_dashboard_admin')
<div class="container-fluid mt-4">
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
                <h4 class="mb-4">Update Hotel</h4>
            </div>

            {{-- Alert --}}
            <div class="alert alert-info d-flex align-items-start" role="alert" style="background-color: #eaf4ff;">
                <i class="bi bi-info-circle-fill fs-3 me-3 text-primary"></i>
                <div>
                    <strong>Panduan Pengisian Form Hotel</strong><br>
                     <ul class="mt-2 mb-0">
                        <li><strong>Data Hotel:</strong> Isikan nama hotel secara lengkap dan jelas sesuai dokumen resmi.</li>
                        <li><strong>Kontak:</strong> Pastikan nomor telepon dan email yang dimasukkan aktif dan dapat dihubungi.</li>
                        <li><strong>Fasilitas:</strong> Centang semua fasilitas yang tersedia agar calon tamu mendapatkan informasi akurat.</li>
                        <li><strong>Lokasi Hotel:</strong>Lokasi akan terdeteksi otomatis menggunakan GPS perangkat Anda (izinkan akses lokasi di browser).</li>
                        <li><strong>Foto Hotel:</strong> Upload foto beresolusi baik untuk menampilkan tampilan hotel secara profesional (maks. 2MB, format JPG/PNG).</li>
                        <li><strong>Deskripsi:</strong> Tulis deskripsi menarik yang menggambarkan keunggulan dan suasana hotel Anda.</li>
                        <li><strong>Validasi:</strong> Periksa kembali semua data sebelum menekan tombol <em>Submit</em>.</li>
                    </ul>
                </div>
            </div>

            {{-- Validasi --}}
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form id="formHotel" action="{{ route('myhotel.data.update', $hotel->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Pemilik Hotel</label>
                            <select name="user_id" class="form-control" required>
                                @foreach($hotelOwners as $owner)
                                    <option value="{{ $owner->id }}" {{ $hotel->owner_id == $owner->id ? 'selected' : '' }}>
                                        {{ $owner->name }} ({{ $owner->email }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Nama Hotel</label>
                            <input type="text" name="name" value="{{ old('name', $hotel->name) }}" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Deskripsi Hotel</label>
                            <div id="quillEditor" style="height: 300px;"></div>
                            <input type="hidden" name="description" id="descriptionInput" value="{{ old('description', $hotel->description) }}">
                        </div>

                        @if($hotel->photos && $hotel->photos->count() > 0)
                            <div class="mb-3">
                                <label class="form-label">Foto Saat Ini</label>
                                <div id="photoSlider" class="carousel slide" data-bs-ride="carousel">
                                    <div class="carousel-inner">
                                        @foreach($hotel->photos as $index => $photo)
                                            <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                                                <img 
                                                    src="{{ asset('storage/' . $photo->photo) }}" 
                                                    class="d-block w-100 img-thumbnail cursor-pointer" 
                                                    alt="Foto Hotel" 
                                                    style="max-height: 300px; object-fit: cover;"
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#photoModal" 
                                                    data-photo-index="{{ $index }}"
                                                >
                                            </div>
                                        @endforeach
                                    </div>
                                    <button class="carousel-control-prev" type="button" data-bs-target="#photoSlider" data-bs-slide="prev">
                                        <span class="carousel-control-prev-icon"></span>
                                        <span class="visually-hidden">Previous</span>
                                    </button>
                                    <button class="carousel-control-next" type="button" data-bs-target="#photoSlider" data-bs-slide="next">
                                        <span class="carousel-control-next-icon"></span>
                                        <span class="visually-hidden">Next</span>
                                    </button>
                                </div>
                            </div>

                            <!-- Modal -->
                            <div class="modal fade" id="photoModal" tabindex="-1" aria-labelledby="photoModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-xl">
                                    <div class="modal-content bg-transparent border-0">
                                        <div class="modal-body p-0 position-relative">
                                            <button type="button" class="btn-close btn-close-white position-absolute top-0 end-0 m-3" data-bs-dismiss="modal" aria-label="Close"></button>
                                            <div id="modalCarousel" class="carousel slide" data-bs-ride="false">
                                                <div class="carousel-inner">
                                                    @foreach($hotel->photos as $index => $photo)
                                                        <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                                                            <img src="{{ asset('storage/' . $photo->photo) }}" class="d-block w-100" style="max-height: 80vh; object-fit: contain;" alt="Foto Hotel">
                                                        </div>
                                                    @endforeach
                                                </div>
                                                <button class="carousel-control-prev" type="button" data-bs-target="#modalCarousel" data-bs-slide="prev">
                                                    <span class="carousel-control-prev-icon"></span>
                                                    <span class="visually-hidden">Previous</span>
                                                </button>
                                                <button class="carousel-control-next" type="button" data-bs-target="#modalCarousel" data-bs-slide="next">
                                                    <span class="carousel-control-next-icon"></span>
                                                    <span class="visually-hidden">Next</span>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <div class="mb-3">
                            <label class="form-label">Upload Foto Baru (Minimal 3 gambar)</label>
                            <input type="file" class="form-control" id="photoInput" name="photos[]" multiple>
                            <div id="previewContainer" class="d-flex gap-2 mt-2 flex-wrap"></div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Rating</label>
                            <div class="star-rating">
                                @foreach([5, 4, 3, 2, 1] as $rating)
                                    <input type="radio" id="star{{ $rating }}" name="rating" value="{{ $rating }}" {{ $hotel->rating == $rating ? 'checked' : '' }}>
                                    <label for="star{{ $rating }}">★</label>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Lokasi di Peta</label>
                            <div id="map" style="z-index: 0;"></div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Latitude</label>
                                <input type="text" name="latitude" id="latitude" class="form-control" value="{{ $hotel->latitude }}" readonly required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Longitude</label>
                                <input type="text" name="longitude" id="longitude" class="form-control" value="{{ $hotel->longitude }}" readonly required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Alamat Detail Hotel</label>
                            <input type="text" name="address" id="address" value="{{ $hotel->address }}" class="form-control" required>
                        </div>
                    </div>
                </div>

                <div class="text-end">
                    <button type="submit" class="btn btn-primary">Update Hotel</button>
                    <button type="button" class="btn btn-danger" onclick="window.location.href='{{ route('myhotel.index') }}'">Kembali</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const photoSlider = document.getElementById('photoSlider');
        const modalCarousel = document.getElementById('modalCarousel');
        const modal = new bootstrap.Modal(document.getElementById('photoModal'));
        
        photoSlider.querySelectorAll('img[data-photo-index]').forEach(img => {
            img.addEventListener('click', function () {
                const index = parseInt(this.getAttribute('data-photo-index'));
                const modalCarouselInstance = bootstrap.Carousel.getInstance(modalCarousel);
                if (!modalCarouselInstance) {
                    new bootstrap.Carousel(modalCarousel);
                }
                bootstrap.Carousel.getInstance(modalCarousel).to(index);
                modal.show();
            });
        });
    });

    let quill;
    $(document).ready(function () {
        quill = new Quill('#quillEditor', {
            theme: 'snow',
            modules: {
                toolbar: [
                    [{ header: [1, 2, false] }],
                    ['bold', 'italic', 'underline'],
                    [{ list: 'ordered' }, { list: 'bullet' }],
                    ['link', 'image'],
                    ['clean']
                ]
            }
        });

        quill.root.innerHTML = `{!! old('description', $hotel->description) !!}`;

        $('#photoInput').on('change', function () {
            const previewContainer = $('#previewContainer').html('');
            Array.from(this.files).forEach(file => {
                const reader = new FileReader();
                reader.onload = function (e) {
                    $('<img>', {
                        src: e.target.result,
                        class: 'img-thumbnail',
                        width: 100
                    }).appendTo(previewContainer);
                };
                reader.readAsDataURL(file);
            });
        });

        const defaultCenter = [{{ $hotel->latitude }}, {{ $hotel->longitude }}];
        const map = L.map('map').setView(defaultCenter, 13);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap'
        }).addTo(map);

        const marker = L.marker(defaultCenter, { draggable: true }).addTo(map);

        function updateLatLngInputs(latlng) {
            $('#latitude').val(latlng.lat.toFixed(6));
            $('#longitude').val(latlng.lng.toFixed(6));
        }

        marker.on('dragend', function (e) {
            updateLatLngInputs(e.target.getLatLng());
        });

        map.on('click', function (e) {
            marker.setLatLng(e.latlng);
            map.panTo(e.latlng);
            updateLatLngInputs(e.latlng);
        });


         $('#formHotel').on('submit', function (e) {
            const form = this;
            $('#descriptionInput').val(quill.root.innerHTML);
            const lat = $('#latitude').val(), lng = $('#longitude').val();
            form.submit();
        });

    });
</script>
@endpush
