<?php

namespace App\Http\Controllers;

use App\Exports\BeritaAcaraExport;
use App\Models\BeritaAcara;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;

class BeritaAcaraController extends Controller
{
    public function index()
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

    // ================= STORE =================
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'no_ktp' => 'required|string|max:50',
            'email' => 'nullable|email|max:255',
            'alamat_lengkap' => 'required|string',
            'no_hp' => 'required|string|min:10|max:20',
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
            // Normalisasi nomor HP
            $noHp = preg_replace('/[^0-9]/', '', $validated['no_hp']);
            if (substr($noHp, 0, 1) === '0') {
                $noHp = '62' . substr($noHp, 1);
            } elseif (substr($noHp, 0, 2) !== '62') {
                $noHp = '62' . $noHp;
            }
            $validated['no_hp'] = $noHp;

            // Upload foto
            foreach (['foto_rumah', 'foto_odp', 'foto_dokumentasi_pelanggan'] as $field) {
                if ($request->hasFile($field)) {
                    $validated[$field] = $request->file($field)->store('berita_acara', 'public');
                }
            }

            // SIMPAN DATA
            BeritaAcara::create($validated);

            // 🔔 NOTIFIKASI TIDAK DI SINI (OBSERVER)

            return redirect()
                ->route('berita_acara.index')
                ->with('success', 'Berita Acara berhasil disimpan!');
        } catch (\Exception $e) {
            Log::error('Gagal simpan BAI: ' . $e->getMessage());
            return back()
                ->with('error', 'Terjadi kesalahan saat menyimpan data')
                ->withInput();
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
            'tanda_tangan_pelanggan' => 'required|string',
            'tanda_tangan_petugas' => 'required|string',
            'foto_rumah' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'foto_odp' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'foto_dokumentasi_pelanggan' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        try {
            $beritaAcara = BeritaAcara::findOrFail($id);

            foreach (['foto_rumah', 'foto_odp', 'foto_dokumentasi_pelanggan'] as $field) {
                if ($request->hasFile($field)) {
                    if ($beritaAcara->$field) {
                        Storage::disk('public')->delete($beritaAcara->$field);
                    }
                    $validated[$field] = $request->file($field)->store('berita_acara', 'public');
                }
            }

            $beritaAcara->update($validated);

            return redirect()
                ->route('berita_acara.index')
                ->with('success', 'Data berhasil diperbarui!');
        } catch (\Exception $e) {
            Log::error('Gagal update BAI: ' . $e->getMessage());
            return back()->with('error', 'Gagal memperbarui data');
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
            Log::error('Gagal hapus BAI: ' . $e->getMessage());
            return back()->with('error', 'Gagal menghapus data');
        }
    }

    public function exportPdf($id)
    {
        $beritaAcara = BeritaAcara::findOrFail($id);

        $fields = [
            'tanda_tangan_pelanggan',
            'tanda_tangan_petugas',
            'foto_rumah',
            'foto_odp',
            'foto_dokumentasi_pelanggan'
        ];

        foreach ($fields as $field) {
            $path = storage_path('app/public/' . $beritaAcara->$field);
            $beritaAcara->{$field . '_base64'} =
                ($beritaAcara->$field && file_exists($path))
                ? 'data:image/png;base64,' . base64_encode(file_get_contents($path))
                : null;
        }

        return Pdf::loadView('berita_acara.pdf', compact('beritaAcara'))
            ->setPaper('a4', 'portrait')
            ->download('BeritaAcara_' . $beritaAcara->id . '.pdf');
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

    public function sendWhatsapp($id)
    {
        try {
            $beritaAcara = BeritaAcara::findOrFail($id);

            // Normalisasi nomor HP
            $phone = preg_replace('/[^0-9]/', '', $beritaAcara->no_hp);
            if (str_starts_with($phone, '0')) {
                $phone = '62' . substr($phone, 1);
            }

            // Generate PDF jika belum ada
            $fileName = 'BeritaAcara_' . str_replace(' ', '_', $beritaAcara->nama_lengkap) . '.pdf';
            $pdfPath = 'pdf_berita_acara/' . $fileName;

            if (!Storage::disk('public')->exists($pdfPath)) {
                // Panggil logic generate PDF (bisa refactor ke method protected)
                $pdf = Pdf::loadView('berita_acara.pdf', compact('beritaAcara'));
                Storage::disk('public')->put($pdfPath, $pdf->output());
            }

            $pdfUrl = Storage::url($pdfPath); // https://domain.com/storage/pdf_berita_acara/...

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
