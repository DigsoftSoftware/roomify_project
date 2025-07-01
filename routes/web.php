<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\HotelOwnerController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\MyHotelController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\LaporanController;
use Illuminate\Support\Facades\Route;

// Homepage
Route::get('/', [HomeController::class, 'index'])->name('home');

// Homepage Sudah Login
Route::middleware(['check.role:user'])->group(function () {
    Route::get('/homepages/users', [HomeController::class, 'home_login'])->name('home_login');
    Route::get('/homepages/about', [HomeController::class, 'about'])->name('home_about');

    Route::get('/homepages/hotel', [HomeController::class, 'daftar_hotel'])->name('hotel.daftar');
    Route::get('/homepages/hotel/{id}', [HomeController::class, 'detail_hotel'])->name('hotel.detail');
    Route::post('/homepages/booking', [HomeController::class, 'storeBooking'])->name('booking.store');

    // Halaman Edit Profil
    Route::get('/homepages/profile/edit/{id}', [HomeController::class, 'edit'])->name('home.profile.edit');
    Route::put('/homepages/profile/update/{id}', [HomeController::class, 'update'])->name('home.profile.update');

    // Halaman MyBooking
    Route::get('/homepages/booking/view',[HomeController::class,'myBooking'])->name('mybooking.index');
    Route::get('/homepages/booking/detail/{id}',[HomeController::class,'detailBooking'])->name('mybooking.detail');
    
    // Halaman pilih metode pembayaran
    Route::get('/homepages/booking/payment/{id}', [HomeController::class, 'payment'])->name('mybooking.payment');

    // Snap Token page
    Route::post('homepages/snap/payment/{id}', [HomeController::class, 'paymentSnap'])->name('mybooking.payment.snap');

    Route::get('/payment/finish', [HomeController::class, 'paymentFinish'])->name('payment.finish');
    Route::get('/payment/error', [HomeController::class, 'paymentError'])->name('payment.error');

    // Callback dari Midtrans
    Route::post('midtrans/callback', [HomeController::class, 'midtransCallback']);

    // Manual confirm
    Route::post('/homepages/booking/confirm/{id}', [HomeController::class, 'confirmPayment'])->name('mybooking.confirm');

    // Halaman Pembayaran
    Route::get('/homepages/booking/payment/{id}', [HomeController::class, 'payment'])->name('mybooking.payment');
    Route::post('/homepages/booking/payment/confirm/{id}', [HomeController::class, 'confirmPayment'])->name('mybooking.payment.confirm');
    Route::post('/homepages/booking/payment/deleted/{id}', [HomeController::class, 'cancelBooking'])->name('mybooking.delete');
});

// Login dan Register
Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login/submit', [LoginController::class, 'login'])->name('login.submit');
Route::get('/pilih/register', [LoginController::class, 'pilihandaftar'])->name('pilihan.register');
Route::get('/register/hotel', [LoginController::class, 'indexHotelOwner'])->name('hotelowner.register');
Route::post('/register/submit/hotel', [LoginController::class, 'registerHotelOwner'])->name('hotelowner.register.submit');
Route::get('/register/users', [LoginController::class, 'indexUsers'])->name('users.register');
Route::post('/register/submit/users', [LoginController::class, 'registerUsers'])->name('users.register.submit');
Route::post('/logout', [LoginController::class, 'logout'])->name('users.logout');

// Dashboard Untuk Admin
Route::middleware(['check.role:admin'])->group(function () {
    Route::get('/dashboard/admin', [AdminController::class, 'index'])->name('dashboard.admin');
    Route::get('/admin/view', [AdminController::class, 'indexdata'])->name('admin.index');
    Route::get('/admin/view/create', [AdminController::class, 'create'])->name('admin.data.create');
    Route::post('/admin/view/store', [AdminController::class, 'store'])->name('admin.data.store');
    Route::get('/admin/view/edit/{id}', [AdminController::class, 'edit'])->name('admin.data.edit');
    Route::put('/admin/view/update/{id}', [AdminController::class, 'update'])->name('admin.data.update');
    Route::delete('/admin/delete/{id}', [AdminController::class, 'destroy'])->name('admin.data.destroy');
});

// Dashboard Untuk Users
Route::middleware(['check.role:admin'])->group(function () {
    Route::get('/users/view', [UsersController::class, 'index'])->name('users.index');
    Route::get('/users/view/create', [UsersController::class, 'create'])->name('users.data.create');
    Route::post('/users/view/store', [UsersController::class, 'store'])->name('users.data.store');
    Route::get('/users/view/edit/{id}', [UsersController::class, 'edit'])->name('users.data.edit');
    Route::put('/users/view/update/{id}', [UsersController::class, 'update'])->name('users.data.update');
    Route::delete('/users/delete/{id}', [UsersController::class, 'destroy'])->name('users.data.destroy');
});

// Dashboard Untuk Pemilik Hotel
Route::middleware(['check.role:admin,hotel_owner'])->group(function () {
    Route::get('/dashboard/hotel_owner', [HotelOwnerController::class, 'index'])->name('dashboard.hotels');
    Route::get('/owners/view', [HotelOwnerController::class, 'indexdata'])->name('hotels.index');
    Route::get('/owners/view/create', [HotelOwnerController::class, 'create'])->name('hotels.data.create');
    Route::post('/owners/view/store', [HotelOwnerController::class, 'store'])->name('hotels.data.store');
    Route::get('/owners/view/edit/{id}', [HotelOwnerController::class, 'edit'])->name('hotels.data.edit');
    Route::put('/owners/view/update/{id}', [HotelOwnerController::class, 'update'])->name('hotels.data.update');
    Route::get('/owners/editdata/{id}', [HotelOwnerController::class, 'edithw'])->name('hotels.profile');
    Route::put('/owners/editdata/{id}', [HotelOwnerController::class, 'updatehw'])->name('hotels.update.profile');
    Route::delete('/owners/delete/{id}', [HotelOwnerController::class, 'destroy'])->name('hotels.data.destroy');
});

// Dashboard Untuk Hotel
Route::middleware(['check.role:admin,hotel_owner'])->group(function () {
    Route::get('/hotels/view', [MyHotelController::class, 'index'])->name('myhotel.index');
    Route::get('/hotels/view/details/{id}', [MyHotelController::class, 'detail'])->name('myhotel.data.detail');
    Route::get('/hotels/view/create', [MyHotelController::class, 'create'])->name('myhotel.data.create');
    Route::post('/hotels/view/store', [MyHotelController::class, 'store'])->name('myhotel.data.store');
    Route::get('/hotels/view/edit/{id}', [MyHotelController::class, 'edit'])->name('myhotel.data.edit');
    Route::put('/hotels/view/update/{id}', [MyHotelController::class, 'update'])->name('myhotel.data.update');
    Route::delete('/hotels/delete/{id}', [MyHotelController::class, 'destroy'])->name('myhotel.data.destroy');
});

// Dashboard Untuk Ruangan Hotels
Route::middleware(['check.role:admin,hotel_owner'])->group(function () {
    Route::get('/room/view', [RoomController::class, 'index'])->name('room.index');
    Route::get('/room/view/create', [RoomController::class, 'create'])->name('room.data.create');
    Route::post('/room/view/store', [RoomController::class, 'store'])->name('room.data.store');
    Route::get('/room/view/edit/{id}', [RoomController::class, 'edit'])->name('room.data.edit');
    Route::put('/room/view/update{id}', [RoomController::class, 'update'])->name('room.data.update');
    Route::delete('/room/delete/{id}', [RoomController::class, 'destroy'])->name('room.data.destroy');
});

// Dashboard Untuk Booking Hotels
Route::middleware(['check.role:admin,hotel_owner'])->group(function () {
    Route::get('/booking/view', [BookingController::class, 'index'])->name('booking.index');
    Route::get('/booking/view/detail/{id}', [BookingController::class, 'detail'])->name('booking.data.detail');
});

// Dashboard Untuk Payment Hotels
Route::middleware(['check.role:admin,hotel_owner'])->group(function () {
    Route::get('/payment/view', [PaymentController::class, 'index'])->name('payment.index');
    Route::get('/payment/view/detail/{id}', [PaymentController::class, 'detail'])->name('payment.data.detail');
});


// Dashboard Untuk Laporan 
Route::middleware(['check.role:admin,hotel_owner'])->group(function () {
    Route::get('/laporan/view', [LaporanController::class, 'index'])->name('laporan.index');
    Route::post('/laporan/check', [LaporanController::class, 'checkData'])->name('laporan.checkData');
    Route::get('/laporan/cetak', [LaporanController::class, 'cetak'])->name('laporan.cetak');
});

