@extends('home.main.app_login')

@section('section_home_login')
<section class="py-5 bg-light">
    <div class="container">
        <h3 class="mb-4">Edit Profil Saya</h3>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form action="{{ route('home.profile.update', $user->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="row mb-3">
                <div class="col-md-3">
                    <label for="name" class="form-label">Nama Lengkap</label>
                </div>
                <div class="col-md-9">
                    <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $user->name) }}" required>
                    @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-3">
                    <label for="username" class="form-label">Username</label>
                </div>
                <div class="col-md-9">
                    <input type="text" name="username" id="username" class="form-control" value="{{ old('username', $user->username) }}" required>
                    @error('username') <small class="text-danger">{{ $message }}</small> @enderror
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-3">
                    <label for="phone" class="form-label">No. Telepon</label>
                </div>
                <div class="col-md-9">
                    <input type="text" name="phone" id="phone" class="form-control" value="{{ old('phone', $user->phone) }}">
                    @error('phone') <small class="text-danger">{{ $message }}</small> @enderror
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-3">
                    <label for="password" class="form-label">Password Baru</label>
                </div>
                <div class="col-md-9">
                    <input type="password" name="password" id="password" class="form-control" placeholder="Biarkan kosong jika tidak ingin mengganti">
                    @error('password') <small class="text-danger">{{ $message }}</small> @enderror
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-md-3">
                    <label for="photo_profile" class="form-label">Foto Profil</label>
                </div>
                <div class="col-md-9 d-flex align-items-center">
                    @if($user->photo_profile)
                        <img src="{{ asset('storage/' . $user->photo_profile) }}" alt="Foto Profil" class="rounded-circle me-3" width="150" height="150">
                    @endif
                    <input type="file" name="photo_profile" id="photo_profile" class="form-control">
                    @error('photo_profile') <small class="text-danger">{{ $message }}</small> @enderror
                </div>
            </div>

            <div class="d-flex gap-2">
                <a href="{{ route('home_login') }}" class="btn btn-danger">Kembali</a>
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</section>
@endsection
