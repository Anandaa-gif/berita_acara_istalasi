<?php

namespace App\Observers;

use App\Models\BeritaAcara;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class BeritaAcaraObserver
{
    /**
     * Trigger saat Berita Acara baru dibuat
     */
    public function created(BeritaAcara $bai): void
    {
        $this->kirimTelegramAdmin($bai);
        $this->kirimWAPelanggan($bai);
    }

    /**
     * ================= TELEGRAM KE ADMIN =================
     */
    private function kirimTelegramAdmin(BeritaAcara $bai): void
    {
        $token   = config('services.telegram.bot_token');
        $chatId  = config('services.telegram.group_id');

        if (!$token || !$chatId) {
            Log::warning('Telegram tidak dikirim: token / chat_id kosong');
            return;
        }

        $pesan =
            "📄 *BERITA ACARA INSTALASI BARU*\n\n" .
            "*ID*        : {$bai->id}\n" .
            "*Pelanggan*: {$bai->nama_lengkap}\n" .
            "*HP*        : {$bai->no_hp}\n" .
            "*Alamat*    : {$bai->alamat_lengkap}\n" .
            "*Paket*     : {$bai->paket_berlangganan}\n" .
            "*Teknisi*   : {$bai->nama_teknisi_1}" .
            ($bai->nama_teknisi_2 ? " & {$bai->nama_teknisi_2}" : "") . "\n" .
            "*Tanggal*   : " . $bai->tanggal_registrasi->format('d-m-Y');

        try {
            $response = Http::post(
                "https://api.telegram.org/bot{$token}/sendMessage",
                [
                    'chat_id'    => $chatId,
                    'text'       => $pesan,
                    'parse_mode' => 'Markdown',
                ]
            );

            if ($response->failed()) {
                Log::error('Gagal kirim Telegram BAI ID ' . $bai->id . ': ' . $response->body());
            }
        } catch (\Exception $e) {
            Log::error('Error Telegram Observer: ' . $e->getMessage());
        }
    }

    /**
     * ================= WHATSAPP KE PELANGGAN =================
     * Nomor HP diasumsikan SUDAH dinormalisasi (62xxx) oleh Controller
     */
    private function kirimWAPelanggan(BeritaAcara $bai): void
    {
        $phone = preg_replace('/[^0-9]/', '', $bai->no_hp);

        if (strlen($phone) < 10) {
            Log::warning("WA tidak dikirim, nomor tidak valid: {$bai->no_hp}");
            return;
        }

        $message =
            "*TERIMA KASIH TELAH BERLANGGANAN MEGADATA ISP!*\n\n" .
            "Halo *{$bai->nama_lengkap}*,\n\n" .
            "Instalasi internet Anda telah *SELESAI*.\n\n" .
            "*Detail Berlangganan*\n" .
            "• Paket       : {$bai->paket_berlangganan}\n" .
            "• Biaya Reg   : Rp " . number_format($bai->biaya_registrasi) . "\n" .
            "• Teknisi     : {$bai->nama_teknisi_1}" .
            ($bai->nama_teknisi_2 ? " & {$bai->nama_teknisi_2}" : "") . "\n" .
            "• Tanggal     : " . $bai->tanggal_registrasi->format('d-m-Y') . "\n\n" .
            "Jika ada kendala, silakan hubungi kami.\n\n" .
            "*MEGADATA ISP Besuki*";

        try {
            $response = Http::withHeaders([
                'Authorization' => env('FONNTE_TOKEN'),
            ])->post('https://api.fonnte.com/send', [
                'target'  => $phone,
                'message' => $message,
                'delay'   => 2,
            ]);

            if ($response->failed()) {
                Log::error("Gagal kirim WA pelanggan {$phone}: " . $response->body());
            }
        } catch (\Exception $e) {
            Log::error('Error WA Observer: ' . $e->getMessage());
        }
    }
}
