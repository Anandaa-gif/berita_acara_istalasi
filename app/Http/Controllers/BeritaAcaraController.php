<?php

namespace App\Http\Controllers;

use App\Exports\BeritaAcaraExport;
use App\Models\BeritaAcara;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;       
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;

class BeritaAcaraController extends Controller
{
    public function index(Request $request)
    {
        $beritaAcaras = BeritaAcara::latest()->paginate(15);

        $tahunList = BeritaAcara::selectRaw('YEAR(tanggal_registrasi) as tahun')
            ->distinct()
            ->orderBy('tahun', 'desc')
            ->pluck('tahun');

        if ($tahunList->isEmpty()) {
            $tahunList = collect([date('Y')]);
        }

        return view('berita_acara.index', compact('beritaAcaras', 'tahunList'));
    }

    public function create()
    {
        return view('berita_acara.create');
    }

    // ================== KIRIM KE GRUP TELEGRAM ==================
    private function kirimNotifTelegram($bai)
    {
        $token   = env('TELEGRAM_BOT_TOKEN');
        $chat_id = env('TELEGRAM_GROUP_ID');

        if (!$token || !$chat_id) {
            Log::warning('TELEGRAM: Token atau Chat ID kosong di .env');
            return;
        }

        $pesan = "BERITA ACARA BARU!\n\n" .
            "No. BAI       : *{$bai->id}*\n" .
            "Pelanggan     : {$bai->nama_lengkap}\n" .
            "No HP         : {$bai->no_hp}\n" .
            "Alamat        : {$bai->alamat_lengkap}\n" .
            "Paket         : {$bai->paket_berlangganan}\n" .
            "Teknisi       : {$bai->nama_teknisi_1}" . ($bai->nama_teknisi_2 ? " & {$bai->nama_teknisi_2}" : "") . "\n" .
            "Tanggal       : " . $bai->tanggal_registrasi->format('d-m-Y') . "\n\n" .
            "Lihat: " . route('berita_acara.show', $bai->id);

        $response = Http::post("https://api.telegram.org/bot{$token}/sendMessage", [
            'chat_id'    => $chat_id,
            'text'       => $pesan,
            'parse_mode' => 'Markdown',
        ]);

        if ($response->failed()) {
            Log::error('Gagal kirim Telegram: ' . $response->body());
        } else {
            Log::info('Telegram terkirim untuk BAI ID: ' . $bai->id);
        }
    }

    // ================== KIRIM WA KE PELANGGAN VIA WATZAP.ID ==================
    // ================== KIRIM WA KE PELANGGAN (SUDAH AMAN 100%) ==================
    private function kirimWelcomeWAPelanggan($bai)
    {
        try {
            // NORMALISASI NOMOR HP – BEBAS 08 / 62 / +62 / SPASI → PASTI JADI 62xxx
            $phone = preg_replace('/[^0-9]/', '', $bai->no_hp); // hapus semua kecuali angka

            if (strlen($phone) < 10) {
                Log::warning("Nomor HP terlalu pendek: {$bai->no_hp}");
                return;
            }

            // Ubah 08xxx → 62xxx
            if (substr($phone, 0, 1) === '0') {
                $phone = '62' . substr($phone, 1);
            }
            // Kalau sudah 62xx atau +62xx → tetap
            elseif (substr($phone, 0, 2) !== '62') {
                $phone = '62' . $phone;
            }

            $message = "*TERIMA KASIH SUDAH BERLANGGANAN MEGADATA ISP!*\n\n" .
                "Halo *{$bai->nama_lengkap}*,\n\n" .
                "Instalasi internet Anda sudah selesai!\n\n" .
                "*Detail Berlangganan*\n" .
                "• Paket       : {$bai->paket_berlangganan}\n" .
                "• Biaya Reg   : Rp " . number_format($bai->biaya_registrasi) . "\n" .
                "• Teknisi     : {$bai->nama_teknisi_1}" . ($bai->nama_teknisi_2 ? " & {$bai->nama_teknisi_2}" : "") . "\n" .
                "• Tanggal     : " . $bai->tanggal_registrasi->format('d-m-Y') . "\n\n" .
                "Silakan cek kecepatan internet Anda sekarang!\n" .
                "Ada kendala? Balas pesan ini atau hubungi kami.\n\n" .
                "Terima kasih atas kepercayaannya!\n\n" .
                "Salam cepat,\n" .
                "*MEGADATA ISP Besuki*";

            $response = Http::timeout(30)
                ->withHeaders(['Content-Type' => 'application/json'])
                ->post('https://api.watzap.id/v1/send_message', [
                    'api_key'   => env('WATZAP_API_KEY'),
                    'device_id' => env('WATZAP_DEVICE_ID', '1'),
                    'number'    => $phone,
                    'message'   => $message,
                    'type'      => 'text',
                ]);

            if ($response->successful() && str_contains(strtolower($response->body()), 'success')) {
                Log::info("WA Pelanggan TERKIRIM → {$phone} (BAI ID: {$bai->id})");
            } else {
                Log::warning("Gagal kirim WA pelanggan → {$phone} | Response: " . $response->body());
            }
        } catch (\Exception $e) {
            Log::error("Error kirim WA pelanggan: " . $e->getMessage());
        }
    }

    // ================== STORE – INPUT DARI TEKNISI (BEBAS 08 / 62) ==================
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'no_ktp' => 'required|string|max:50',
            'email' => 'nullable|email|max:255',
            'alamat_lengkap' => 'required|string',
            'no_hp' => 'required|string|min:10|max:20', // boleh 08 / 62 / +62
            'tanggal_registrasi' => 'required|date',
            'jenis_perangkat' => 'required|string|max:100',
            'mac_address' => 'nullable|string|max:100',
            'serial_number' => 'nullable|string|max:100',
            'nama_teknisi_1' => 'required|string|max:255',
            'nama_teknisi_2' => 'nullable|string|max:255',
            'paket_berlangganan' => 'required|string|max:255',
            'biaya_registrasi' => 'required|numeric|min:0',
            'accept_terms' => 'required|accepted',
            'tanda_tangan_pelanggan' => 'required|string',
            'tanda_tangan_petugas' => 'required|string',
            'foto_rumah' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'foto_odp' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'foto_dokumentasi_pelanggan' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        try {
            $data = $validated;

            // NORMALISASI NOMOR HP SEBELUM DISIMPAN KE DATABASE
            $noHp = preg_replace('/[^0-9]/', '', $data['no_hp']);
            if (substr($noHp, 0, 1) === '0') {
                $noHp = '62' . substr($noHp, 1);
            } elseif (substr($noHp, 0, 2) !== '62') {
                $noHp = '62' . $noHp;
            }
            $data['no_hp'] = $noHp;
            // =================================================================

            // Upload foto
            foreach (['foto_rumah', 'foto_odp', 'foto_dokumentasi_pelanggan'] as $field) {
                if ($request->hasFile($field)) {
                    $data[$field] = $request->file($field)->store('berita_acara', 'public');
                }
            }

            $beritaAcara = BeritaAcara::create($data);

            // Kirim notifikasi otomatis
            $this->kirimNotifTelegram($beritaAcara);
            $this->kirimWelcomeWAPelanggan($beritaAcara);

            return redirect()->route('berita_acara.index')
                ->with('success', 'Berita Acara berhasil disimpan! Notifikasi Telegram & WhatsApp otomatis terkirim!');
        } catch (\Exception $e) {
            Log::error('Gagal simpan BAI: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }
    public function show($id)
    {
        $beritaAcara = BeritaAcara::findOrFail($id);
        return view('berita_acara.show', compact('beritaAcara'));
    }

    public function edit($id)
    {
        $beritaAcara = BeritaAcara::findOrFail($id);
        return view('berita_acara.edit', compact('beritaAcara'));
    }

    public function update(Request $request, $id)
    {
        // validasi sama seperti store, cuma accept_terms jadi optional
        $validated = $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'no_ktp' => 'required|string|max:50',
            'email' => 'nullable|email|max:255',
            'alamat_lengkap' => 'required|string',
            'no_hp' => 'required|string|max:20',
            'tanggal_registrasi' => 'required|date',
            'jenis_perangkat' => 'required|string|max:100',
            'mac_address' => 'nullable|string|max:100',
            'serial_number' => 'nullable|string|max:100',
            'nama_teknisi_1' => 'required|string|max:255',
            'nama_teknisi_2' => 'nullable|string|max:255',
            'paket_berlangganan' => 'required|string|max:255',
            'biaya_registrasi' => 'required|numeric|min:0',
            'accept_terms' => 'sometimes|boolean',
            'tanda_tangan_pelanggan' => 'required|string',
            'tanda_tangan_petugas' => 'required|string',
            'foto_rumah' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'foto_odp' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'foto_dokumentasi_pelanggan' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        try {
            $beritaAcara = BeritaAcara::findOrFail($id);
            $data = $validated;

            foreach (['foto_rumah', 'foto_odp', 'foto_dokumentasi_pelanggan'] as $field) {
                if ($request->hasFile($field)) {
                    if ($beritaAcara->$field) {
                        Storage::disk('public')->delete($beritaAcara->$field);
                    }
                    $data[$field] = $request->file($field)->store('berita_acara', 'public');
                }
            }

            $beritaAcara->update($data);

            return redirect()->route('berita_acara.index')
                ->with('success', 'Data berhasil diperbarui!');
        } catch (\Exception $e) {
            Log::error('Gagal update: ' . $e->getMessage());
            return back()->with('error', 'Gagal update: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $beritaAcara = BeritaAcara::findOrFail($id);
            foreach (['foto_rumah', 'foto_odp', 'foto_dokumentasi_pelanggan'] as $field) {
                if ($beritaAcara->$field) {
                    Storage::disk('public')->delete($beritaAcara->$field);
                }
            }
            $beritaAcara->delete();
            return back()->with('success', 'Data berhasil dihapus');
        } catch (\Exception $e) {
            Log::error('Error delete: ' . $e->getMessage());
            return back()->with('error', 'Gagal hapus data');
        }
    }

    public function exportPdf($id)
    {
        $beritaAcara = BeritaAcara::findOrFail($id);

        $fields = ['tanda_tangan_pelanggan', 'tanda_tangan_petugas', 'foto_rumah', 'foto_odp', 'foto_dokumentasi_pelanggan'];
        foreach ($fields as $field) {
            $path = storage_path('app/public/' . $beritaAcara->$field);
            $beritaAcara->{$field . '_base64'} = $beritaAcara->$field && file_exists($path)
                ? 'data:image/png;base64,' . base64_encode(file_get_contents($path))
                : null;
        }

        $pdf = Pdf::loadView('berita_acara.pdf', compact('beritaAcara'))->setPaper('a4', 'portrait');
        $fileName = 'BeritaAcara_' . str_replace(' ', '_', $beritaAcara->nama_lengkap) . '_' . date('YmdHis') . '.pdf';

        return $pdf->download($fileName);
    }

    public function sendWhatsapp($id)
    {
        $beritaAcara = BeritaAcara::findOrFail($id);

        $phone = preg_replace('/[^0-9]/', '', $beritaAcara->no_hp);
        if (substr($phone, 0, 1) === '0') {
            $phone = '62' . substr($phone, 1);
        }

        $message = "*BERITA ACARA INSTALASI*\nMEGADATA ISP Besuki\n\n" .
            "Terima kasih telah berlangganan!\n\n" .
            "*Detail Pelanggan*\n" .
            "- Nama: {$beritaAcara->nama_lengkap}\n" .
            "- No HP: {$beritaAcara->no_hp}\n" .
            "- Alamat: {$beritaAcara->alamat_lengkap}\n\n" .
            "*Paket*: {$beritaAcara->paket_berlangganan}\n" .
            "*Biaya Registrasi*: Rp " . number_format($beritaAcara->biaya_registrasi) . "\n" .
            "*Teknisi*: {$beritaAcara->nama_teknisi_1}" . ($beritaAcara->nama_teknisi_2 ? " & {$beritaAcara->nama_teknisi_2}" : "") . "\n\n" .
            "Terima kasih!\n_MEGADATA ISP_";

        $waUrl = "https://api.whatsapp.com/send?phone={$phone}&text=" . urlencode($message);

        return redirect()->away($waUrl);
    }

    public function export(Request $request)
    {
        $request->validate([
            'bulan' => 'required',
            'tahun' => 'required'
        ]);

        return Excel::download(
            new BeritaAcaraExport($request->bulan, $request->tahun),
            "berita-acara-{$request->bulan}-{$request->tahun}.xlsx"
        );
    }
}
