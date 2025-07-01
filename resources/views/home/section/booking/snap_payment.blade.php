<!DOCTYPE html>
<html>
<head>
    <title>Bayar Booking</title>
</head>
<body>

    <h3>Bayar Booking #{{ $booking->id }}</h3>
    <p>Total: Rp {{ number_format($booking->total_price, 0, ',', '.') }}</p>

    <button id="pay-button">Bayar Sekarang</button>

    <script src="https://app.sandbox.midtrans.com/snap/snap.js"
            data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>

    <script type="text/javascript">
        var payButton = document.getElementById('pay-button');
        payButton.addEventListener('click', function () {
            snap.pay('{{ $snapToken }}', {
                onSuccess: function(result){
                    window.location.href = "{{ route('mybooking.index') }}?success=1";
                },
                onPending: function(result){
                    alert("Transaksi belum selesai.");
                },
                onError: function(result){
                    alert("Pembayaran gagal.");
                },
                onClose: function(){
                    alert("Popup ditutup sebelum bayar.");
                }
            });
        });
    </script>

</body>
</html>
