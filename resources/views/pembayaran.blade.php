@extends('layouts.berandaly')

<div class="w-11/12 md:w-3/4 mx-auto mb-[100px] drop-shadow-lg">
    <a href="#">
        <img src="{{ asset('img/bannerpendaftaran1.png') }}" 
             alt="Banner Pendaftaran" 
             class="w-full mb-6 rounded-lg">
    </a>

    <div class="bg-white p-8 rounded-xl shadow-lg border border-gray-300 flex flex-col">
        <h1 class="text-2xl font-bold text-center text-gray-800 mb-4">
            Detail Pembayaran Awal
        </h1>

        @if($pendaftaran->status_pembayaran == 'sudah') 
            <div class="bg-green-100 p-6 rounded-lg text-center">
                <p class="text-sm text-gray-700 mb-2">Status Pembayaran:</p>
                <p class="text-2xl font-bold text-green-700">Sudah Dibayar</p>
                <p class="mt-4 text-gray-600">
                    Terima kasih telah melakukan pembayaran. Proses pendaftaran Anda sedang kami verifikasi.
                </p>
            </div>
        @else
            <div class="bg-gray-100 p-6 rounded-lg">
                <table class="w-full text-sm text-left text-gray-700 mb-6">
                    <tbody>
                        <tr>
                            <td class="py-2">Biaya Pendaftaran</td>
                            <td class="py-2 font-semibold">Rp100.000</td>
                        </tr>
                        <tr>
                            <td class="py-2">Infak Bulanan</td>
                            <td class="py-2 font-semibold">Rp50.000</td>
                        </tr>
                        <tr>
                            <td class="py-2">Uang Rapot</td>
                            <td class="py-2 font-semibold">Rp50.000</td>
                        </tr>
                        <tr class="border-t border-gray-300">
                            <td class="py-3 font-bold text-lg">Total</td>
                            <td class="py-3 font-bold text-lg text-green-700">
                                Rp{{ number_format(200000, 0, ',', '.') }}
                            </td>
                        </tr>
                    </tbody>
                </table>

                <button id="pay-button"
                        class="w-full px-4 py-3 bg-green-600 text-white font-semibold rounded-lg hover:bg-green-700 transition duration-200">
                    Bayar Sekarang
                </button>
            </div>
        @endif
    </div>
</div>

@extends('layouts.footerly')

{{-- Midtrans Snap Script --}}
<script src="https://app.sandbox.midtrans.com/snap/snap.js" 
        data-client-key="{{ config('midtrans.client_key') }}"></script>

<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function () {
        const payButton = document.getElementById('pay-button');
        if (payButton) {
            payButton.addEventListener('click', function (e) {
                e.preventDefault();
                const snapToken = "{{ $snapToken }}";

                snap.pay(snapToken, {
                    onSuccess: function (result) {
                        window.location.href = "/pembayaran/sukses?token={{ $pendaftaran->payment_token }}";
                    },
                    onPending: function (result) {
                        console.log("Pending:", result);
                        alert("Pembayaran masih pending.");
                    },
                    onError: function (result) {
                        console.error("Error:", result);
                        alert("Terjadi kesalahan saat pembayaran.");
                    },
                    onClose: function () {
                        alert("Popup ditutup tanpa menyelesaikan pembayaran.");
                    }
                });
            });
        }
    });
</script>
