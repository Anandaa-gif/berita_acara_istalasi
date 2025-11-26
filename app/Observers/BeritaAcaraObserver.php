<?php

namespace App\Observers;

use App\Models\BeritaAcara;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;

class BeritaAcaraObserver
{
    public function created(BeritaAcara $data)
    {
        // Hanya kirim kalau dari teknisi
        if (Route::currentRouteName() !== 'user.store') {
            return;
        }

        // Cuma cek HP kosong atau tidak
        if (empty($data->no_hp)) {
            return;
        }

        $phone = preg_replace('/^0/', '62', $data->no_hp);

        $message = "Megadata Internet

Selamat! Pemasangan Anda telah terjadwal

*Nama:* {$data->nama_lengkap}
*Alamat:* {$data->alamat_lengkap}
*Tanggal:* {$data->tanggal_registrasi}
*Paket:* {$data->paket_berlangganan}
*Teknisi:* {$data->nama_teknisi_1}" . ($data->nama_teknisi_2 ? " & {$data->nama_teknisi_2}" : '') . "

Kami akan hubungi Anda segera.

Terima kasih  
Tim Megadata ISP Besuki";

        Http::post('https://api.watzap.id/v1/send_message', [
            'api_key'   => env('WATZAP_API_KEY'),
            'device_id' => env('WATZAP_DEVICE_ID'),
            'number'    => $phone,
            'message'   => $message,
            'type'      => 'text',
        ]);
    }
}
