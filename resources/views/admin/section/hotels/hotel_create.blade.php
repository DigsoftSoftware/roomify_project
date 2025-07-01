@extends('admin.main.app')

@section('title', 'Tambah Hotel | Roomify Dashboard')

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
                 <h4 class="mb-4">Tambah Hotel</h4>
            </div>
            <div class="alert alert-info d-flex align-items-start" role="alert" style="background-color: #eaf4ff;">
                <i class="bi bi-info-circle-fill fs-3 me-3 text-primary"></i>
                <div>
                    <strong>Panduan Pengisian Form Hotel</strong><br>
                    <span>Mohon perhatikan hal-hal berikut sebelum mengisi form pendaftaran hotel:</span>
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
        
            @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

           <form id="formHotel" action="{{ route('myhotel.data.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Pemilik Hotel</label>
                            <select name="user_id" class="form-control" required>
                                <option value="">-- Pilih Pemilik Hotel --</option>
                                @foreach($hotelOwners as $owner)
                                    <option value="{{ $owner->id }}">{{ $owner->name }} ({{ $owner->email }})</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Nama Hotel</label>
                            <input type="text" name="name" class="form-control" placeholder="Contoh: Hotel Sangkara" required>
                        </div>

                       <div class="mb-3">
                            <label class="form-label">Deskripsi Hotel</label>
                            <div id="quillEditor" style="height: 300px;"></div>
                            <input type="hidden" name="description" id="descriptionInput">
                        </div>


                        <div class="mb-3">
                            <label class="form-label">Foto (Minimal 3 gambar)</label><br>
                            <input type="file" class="form-control" id="photoInput" name="photos[]" multiple>
                            <div id="previewContainer" class="d-flex gap-2 mt-2 flex-wrap"></div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Rating</label>
                            <div class="star-rating">
                                @foreach([5, 4, 3, 2, 1] as $rating)
                                    <input type="radio" id="star{{ $rating }}" name="rating" value="{{ $rating }}">
                                    <label for="star{{ $rating }}">★</label>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Lokasi di Peta (Menggunakan GPS)</label>
                            <div id="map" style="z-index: 0;"></div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Latitude</label>
                                <input type="text" name="latitude" id="latitude" class="form-control" required readonly>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Longitude</label>
                                <input type="text" name="longitude" id="longitude" class="form-control" required readonly>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Alamat Detail Hotel</label>
                            <input type="text" name="address" id="address" class="form-control" placeholder="Contoh: Jalan Nusa Dua, No.15 Jimbaran" required>
                        </div>
                    </div>
                </div>

                <div class="text-end">
                    <button type="submit" class="btn btn-primary">Simpan Hotel</button>
                    <button type="button" class="btn btn-danger" onclick="window.location.href='{{ route('myhotel.index') }}'" >Kembali</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')

<script>
$(document).ready(function () {
   $('#formHotel').on('submit', function () {
        const htmlContent = quill.root.innerHTML;
        $('#descriptionInput').val(htmlContent);

        const files = $('#photoInput')[0].files;
        if (files.length < 3) {
            alert('Harap unggah minimal 3 foto hotel.');
            return false;
        }

        const lat = $('#latitude').val();
        const lng = $('#longitude').val();
    });



    var quill = new Quill('#quillEditor', {
        theme: 'snow',
        placeholder: 'Tulis deskripsi hotel di sini...',
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
    
    $('#photoInput').on('change', function () {
        const files = this.files;
        const previewContainer = $('#previewContainer');

        previewContainer.html('');

        if (files.length > 0) {
            Array.from(files).forEach(file => {
                const reader = new FileReader();
                reader.onload = function (e) {
                    const img = $('<img>', {
                        src: e.target.result,
                        class: 'img-thumbnail',
                        width: 100
                    });
                    previewContainer.append(img);
                };
                reader.readAsDataURL(file);
            });
        }
    });

    var defaultCenter = [-2.5489, 118.0149]; 
    var map = L.map('map').setView(defaultCenter, 5);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap'
    }).addTo(map);

    var marker = L.marker(defaultCenter, { draggable: true }).addTo(map);

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
    })

    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function (position) {
            let latlng = L.latLng(position.coords.latitude, position.coords.longitude);
            map.setView(latlng, 13);
            marker.setLatLng(latlng);
            updateLatLngInputs(latlng);
        });
    } else {
        updateLatLngInputs(marker.getLatLng());
    }


});
</script>
@endpush
