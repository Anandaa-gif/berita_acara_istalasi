<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\BeritaAcara;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf;

class UserViewController extends Controller
{
    public function index()
    {
        $acaras = BeritaAcara::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('user.index', compact('acaras'));
    }

    public function create()
    {
        return view('user.create');
    }

    public function show($id)
    {
        try {
            $beritaAcara = BeritaAcara::where('id', $id)
                ->where('user_id', Auth::id())
                ->firstOrFail();
            return view('user.show', compact('beritaAcara'));
        } catch (\Exception $e) {
            Log::error('Gagal menampilkan detail: ' . $e->getMessage());
            return back()->with('error', 'Data tidak ditemukan');
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_lengkap' => 'required',
            'no_ktp' => 'required',
            'alamat_lengkap' => 'required',
            'tanggal_registrasi' => 'required',
            'jenis_perangkat' => 'required',
            'nama_teknisi_1' => 'required',
            'paket_berlangganan' => 'required',
            'biaya_registrasi' => 'required',
            'tanda_tangan_pelanggan' => 'required',
            'tanda_tangan_petugas' => 'required',
        ]);

        $data = $request->all();

        // Simpan tanda tangan
        if ($request->tanda_tangan_pelanggan) {
            $data['tanda_tangan_pelanggan'] = $this->saveSignature($request->tanda_tangan_pelanggan, 'pelanggan');
        }
        if ($request->tanda_tangan_petugas) {
            $data['tanda_tangan_petugas'] = $this->saveSignature($request->tanda_tangan_petugas, 'petugas');
        }

        // Upload foto
        foreach (['foto_rumah', 'foto_odp', 'foto_dokumentasi_pelanggan'] as $field) {
            if ($request->hasFile($field)) {
                $data[$field] = $request->file($field)->store('berita-acara', 'public');
            }
        }

        $data['user_id'] = Auth::id();
        $beritaAcara = BeritaAcara::create($data);

        // Generate & simpan PDF otomatis
        $this->generateAndSavePdf($beritaAcara);

        return redirect()->route('user.index')->with('success', 'Berita Acara berhasil disimpan');
    }

    private function saveSignature($base64, $label)
    {
        $image = str_replace('data:image/png;base64,', '', $base64);
        $image = str_replace(' ', '+', $image);
        $fileName = 'tanda_tangan_' . $label . '_' . time() . '.png';
        Storage::disk('public')->put('tanda-tangan/' . $fileName, base64_decode($image));
        return 'tanda-tangan/' . $fileName;
    }

    private function generateAndSavePdf($beritaAcara)
    {
        $pdf = Pdf::loadView('user.pdf', compact('beritaAcara'))
            ->setPaper('a4', 'portrait');

        $fileName = 'BeritaAcara_' . str_replace(' ', '_', $beritaAcara->nama_lengkap) . '.pdf';
        $path = 'pdf_berita_acara/' . $fileName;

        Storage::disk('public')->put($path, $pdf->output());
    }

    public function exportPdf($id)
    {
        try {
            $beritaAcara = BeritaAcara::where('id', $id)
                ->where('user_id', Auth::id())
                ->firstOrFail();

            $pdf = Pdf::loadView('user.pdf', compact('beritaAcara'))
                ->setPaper('a4', 'portrait');

            $fileName = 'BeritaAcara_' . str_replace(' ', '_', $beritaAcara->nama_lengkap) . '_' . date('YmdHis') . '.pdf';
            return $pdf->download($fileName);
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal export PDF');
        }
    }

    // INI YANG DIPERBAIKI: KEMBALIKAN JSON, BUKAN REDIRECT
    public function sendWhatsapp($id)
    {
        try {
            // ❗ JANGAN batasi user_id jika route public
            $beritaAcara = BeritaAcara::findOrFail($id);

            // Normalisasi nomor HP
            $phone = preg_replace('/[^0-9]/', '', $beritaAcara->no_hp);
            if (substr($phone, 0, 1) === '0') {
                $phone = '62' . substr($phone, 1);
            }

            // Pastikan folder & PDF
            $fileName = 'BeritaAcara_' . str_replace(' ', '_', $beritaAcara->nama_lengkap) . '.pdf';
            $pdfPath = 'pdf_berita_acara/' . $fileName;

            if (!Storage::disk('public')->exists($pdfPath)) {
                $this->generateAndSavePdf($beritaAcara);
            }

            $message = <<<EOT
*BERITA ACARA INSTALASI BARU*
MEGADATA ISP BESUKI

━━━━━━━━━━━━━━━━━━━━━━━

Terima kasih telah berlangganan internet di MEGADATA ISP.

Detail Pelanggan:
- Nama: {$beritaAcara->nama_lengkap}
- No KTP: {$beritaAcara->no_ktp}
- No HP: {$beritaAcara->no_hp}
- Alamat: {$beritaAcara->alamat_lengkap}

Paket Berlangganan:
- Rp. {$beritaAcara->paket_berlangganan} {$beritaAcara->kecepatan}
- Biaya Registrasi: Rp {$beritaAcara->biaya_registrasi}

Perangkat:
- Modem dipinjamkan oleh pihak MEGADATA ISP dan tetap menjadi milik MEGADATA ISP.
- Pelanggan wajib menjaga dan menggunakan perangkat dengan baik selama masa berlangganan.

Teknisi:
- {$beritaAcara->nama_teknisi_1}
- {$beritaAcara->nama_teknisi_2}

Simpan dokumen ini sebagai bukti instalasi Anda.
Terima kasih atas kepercayaan Anda!

_MEGADATA ISP - Internet Cepat & Stabil_
EOT;

            $waUrl = "https://api.whatsapp.com/send?phone={$phone}&text=" . urlencode($message);

            return response()->json([
                'status' => true,
                'wa_url' => $waUrl
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
