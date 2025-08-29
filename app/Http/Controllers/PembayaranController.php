<?php

namespace App\Http\Controllers;

use App\Models\Pendaftaran;
use Illuminate\Http\Request;
use Midtrans\Snap;
use Midtrans\Config;
use Midtrans\Transaction;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade as PDF;

class PembayaranController extends Controller
{
    public function __construct()
    {
        Config::$serverKey = config('midtrans.server_key');
        Config::$clientKey = config('midtrans.client_key');
        Config::$isProduction = false;
        // Config::$isSanitized = true;
        // Config::$is3ds = true;

        if (!Config::$serverKey) {
            dd('Server Key kosong');
        }
    }

    public function formBayar($id)
    {
        $pendaftaran = Pendaftaran::where('id', $id)->first();

        if (!$pendaftaran || $pendaftaran->status != 'accepted') {
            return abort(404, 'Data pendaftaran belum disetujui atau tidak ditemukan.');
        }

        // Generate payment_token jika belum ada
        if (!$pendaftaran->payment_token) {
            $pendaftaran->payment_token = Str::uuid()->toString(); // UUID unik
            $pendaftaran->save();
        }

        $snapToken = $pendaftaran->snap_token;
        $orderId = $pendaftaran->order_id;
        $regenerateToken = false;

        if ($snapToken && $orderId) {
            try {
                $status = Transaction::status($orderId);
                if (in_array($status->transaction_status, ['expire', 'cancel', 'failure'])) {
                    $regenerateToken = true;
                }
            } catch (\Exception $e) {
                $regenerateToken = true; // Snap token mungkin tidak valid
            }                      
        } else {
            $regenerateToken = true;
        }

        if ($regenerateToken) {
            $orderId = 'ORDER-' . uniqid();
            $pendaftaran->order_id = $orderId;

            $params = [
                'transaction_details' => [
                    'order_id' => $orderId,
                    'gross_amount' => 200000,
                ],
                'customer_details' => [
                    'first_name' => $pendaftaran->nama_santri,
                    'email' => 'santri@example.com',
                ],
            ];

            try {
                $snapToken = Snap::getSnapToken($params);
                $pendaftaran->snap_token = $snapToken;
                $pendaftaran->save();
            } catch (\Exception $e) {
                return response()->json(['error' => $e->getMessage()]);
            }
        }

        return view('pembayaran', compact('pendaftaran', 'snapToken'));
    }

    public function processBayar(Request $request)
    {
        $orderId = 'ORDER-' . uniqid(); // Buat order_id baru

        $params = [
            'transaction_details' => [
                'order_id' => $orderId,
                'gross_amount' => 200000,
            ],
            'customer_details' => [
                'first_name' => 'Santri Baru',
                'email' => 'santri@example.com',
            ]
        ];

        try {
            $snapToken = Snap::getSnapToken($params);
            return response()->json([
                'token' => $snapToken,
                'order_id' => $orderId,
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function suksesPembayaran(Request $request)
    {
        // Ambil token dari URL (query parameter)
        $token = $request->get('token');
        

        // Cari data pendaftaran berdasarkan payment_token
        $pendaftaran = Pendaftaran::where('payment_token', $token)->first();

        // Jika tidak ditemukan, tampilkan error 404
        if (!$pendaftaran) {
            return abort(404, 'Pendaftaran tidak ditemukan');
        }

        // Ambil order_id dari data pendaftaran untuk cek status transaksi di Midtrans
        $orderId = $pendaftaran->order_id;

        try {
            // Ambil status transaksi dari Midtrans menggunakan order_id
            $status = \Midtrans\Transaction::status($orderId);

            if ($status->transaction_status === 'settlement') {
                // Jika pembayaran berhasil
                $pendaftaran->status_pembayaran = 'sudah';

                // Cek apakah santri sudah ada, jika belum buat data santri baru
                $existingSantri = \App\Models\Santri::where('pendaftaran_id', $pendaftaran->id)->first();
                if (!$existingSantri) {
                    $yearPrefix = \Carbon\Carbon::parse($pendaftaran->created_at)->format('y'); // 2 digit tahun
                    $birthDatePart = \Carbon\Carbon::parse($pendaftaran->tanggal_lahir)->format('dmy'); // ddmmyy

                    // Hitung jumlah santri dengan pola NIK yang sama untuk urutan
                    $count = \App\Models\Santri::where('nis', 'like', $yearPrefix . $birthDatePart . '%')->count();
                    $sequence = str_pad($count + 1, 3, '0', STR_PAD_LEFT);

                    $nik = $yearPrefix . $birthDatePart . $sequence;

                    \App\Models\Santri::create([
                        'pendaftaran_id' => $pendaftaran->id,
                        'nik' => $nik,
                        'nama_santri' => $pendaftaran->nama_santri,
                        'tempat_lahir' => $pendaftaran->tempat_lahir,
                        'tanggal_lahir' => $pendaftaran->tanggal_lahir,
                        'jenis_kelamin' => $pendaftaran->jenis_kelamin,
                        'alamat' => $pendaftaran->alamat,
                        'nama_orang_tua' => $pendaftaran->nama_orang_tua,
                        'no_hp' => $pendaftaran->no_hp,
                        'akta_kelahiran' => $pendaftaran->akta_kelahiran,
                        'kartu_keluarga' => $pendaftaran->kartu_keluarga,
                    ]);
                }
                $pendaftaran->save();

            } elseif ($status->transaction_status === 'pending') {
                // Jika transaksi masih pending
                $pendaftaran->status_pembayaran = 'pending';
                $pendaftaran->save();

            } else {
                // Jika transaksi gagal atau dibatalkan
                $pendaftaran->status_pembayaran = 'gagal';
                $pendaftaran->save();
            }
        } catch (\Exception $e) {
            // Jika gagal mengambil status transaksi dari Midtrans
            return abort(500, 'Gagal mengambil status transaksi dari Midtrans: ' . $e->getMessage());
        }

        // Tampilkan view sukses pembayaran
        return view('pembayaran.sukses', compact('pendaftaran'));
    }



    public function checkTransactionStatus($orderId)
    {
        try {
            $status = Transaction::status($orderId);
            dd($status); // Debug
        } catch (\Exception $e) {
            dd($e->getMessage()); // Bisa "Transaction doesn't exist"
        }
    }



}
