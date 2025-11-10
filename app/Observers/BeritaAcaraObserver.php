<?php

namespace App\Observers;

use App\Models\BeritaAcara;
use App\Services\WazabService;

class BeritaAcaraObserver
{
    /**
     * Handle event ketika data BeritaAcara berhasil dibuat
     */
    public function created(BeritaAcara $beritaAcara): void
    {
        // Pesan yang dikirim ke WhatsApp
        $message = "Halo {$beritaAcara->nama_lengkap}, 
        data instalasi Anda berhasil disimpan.
        Terima kasih sudah menggunakan layanan kami 🙏";

        // Kirim WA via Wazab Service
        WazabService::sendMessage($beritaAcara->no_hp, $message);
    }
}
