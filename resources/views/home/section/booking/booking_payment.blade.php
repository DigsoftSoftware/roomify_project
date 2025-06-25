@extends('home.main.app_login')

@section('section_home_login')
<section class="py-5">
    <div class="container">
        <h2 class="mb-4">Pembayaran</h2>

        <div class="row g-4">
            <div class="col-md-8">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Detail Pemesanan</h5>
                        <p><strong>Hotel:</strong> {{ $booking->room->hotel->name }}</p>
                        <p><strong>Tipe Kamar:</strong> {{ $booking->room->type }}</p>
                        <p><strong>Total:</strong> Rp{{ number_format($booking->total_price, 0, ',', '.') }}</p>
                        <p><strong>Status:</strong> 
                            <span class="badge bg-warning text-dark">Menunggu Pembayaran</span>
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <form action="{{ route('mybooking.payment.confirm', $booking->id) }}" method="POST">
                    @csrf
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title mb-3">Metode Pembayaran</h5>

                            <div class="mb-3">
                                <select name="payment_method" class="form-select" required>
                                    <option value="">Pilih Metode</option>
                                    <option value="credit_card">Kartu Kredit</option>
                                    <option value="bank_transfer">Transfer Bank</option>
                                    <option value="ewallet">E-Wallet</option>
                                </select>
                            </div>

                            <button type="submit" class="btn btn-success w-100">
                                <i class="bi bi-credit-card"></i> Bayar Sekarang
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection
