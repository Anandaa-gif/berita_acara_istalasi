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
    /**
     * Tampilkan semua data berita acara
     */
    public function index(Request $request)
    {
        // Ambil daftar berita acara (paginate agar links() bekerja).
        $beritaAcaras = BeritaAcara::latest()->paginate(15);

        // Ambil daftar tahun berdasarkan kolom tanggal_registrasi
        $tahunList = BeritaAcara::selectRaw('YEAR(tanggal_registrasi) as tahun')
            ->distinct()
            ->orderBy('tahun', 'desc')
            ->pluck('tahun');

        // Jika kosong, sediakan tahun sekarang agar dropdown tidak kosong
        if ($tahunList->isEmpty()) {
            $tahunList = collect([date('Y')]);
        }

        return view('berita_acara.index', compact('beritaAcaras', 'tahunList'));
    }



    /**
     * Form tambah data
     */
    public function create()
    {
        return view('berita_acara.create');
    }

    /**
     * Simpan data baru
     */
    public function store(Request $request)
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
            'accept_terms' => 'required|accepted',
            'tanda_tangan_pelanggan' => 'required|string',
            'tanda_tangan_petugas' => 'required|string',
            'foto_rumah' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'foto_odp' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'foto_dokumentasi_pelanggan' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        try {
            $data = $validated;

            // Upload gambar jika ada
            foreach (['foto_rumah', 'foto_odp', 'foto_dokumentasi_pelanggan'] as $field) {
                if ($request->hasFile($field)) {
                    $data[$field] = $request->file($field)->store('berita_acara', 'public');
                }
            }

            BeritaAcara::create($data);

            return redirect()->route('berita_acara.index')->with('success', 'Berita Acara berhasil disimpan!');
        } catch (\Exception $e) {
            Log::error('Gagal menyimpan Berita Acara: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Tampilkan detail berita acara
     */
    public function show($id)
    {
        try {
            $beritaAcara = BeritaAcara::findOrFail($id);
            return view('berita_acara.show', compact('beritaAcara'));
        } catch (\Exception $e) {
            Log::error('Gagal menampilkan detail: ' . $e->getMessage());
            return back()->with('error', 'Data tidak ditemukan');
        }
    }

    /**
     * Form edit berita acara
     */
    public function edit($id)
    {
        try {
            $beritaAcara = BeritaAcara::findOrFail($id);
            return view('berita_acara.edit', compact('beritaAcara'));
        } catch (\Exception $e) {
            Log::error('Gagal membuka form edit: ' . $e->getMessage());
            return back()->with('error', 'Data tidak ditemukan');
        }
    }

    /**
     * Update data berita acara
     */
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
                    // Hapus lama
                    if ($beritaAcara->$field) Storage::disk('public')->delete($beritaAcara->$field);
                    $data[$field] = $request->file($field)->store('berita_acara', 'public');
                }
            }

            $beritaAcara->update($data);

            return redirect()->route('berita_acara.index')->with('success', 'Data berhasil diperbarui!');
        } catch (\Exception $e) {
            Log::error('Gagal update data: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat update: ' . $e->getMessage());
        }
    }

    /**
     * Hapus data berita acara
     */
    public function destroy($id)
    {
        try {
            $beritaAcara = BeritaAcara::findOrFail($id);
            foreach (['foto_rumah', 'foto_odp', 'foto_dokumentasi_pelanggan'] as $field) {
                if ($beritaAcara->$field) Storage::disk('public')->delete($beritaAcara->$field);
            }
            $beritaAcara->delete();
            return back()->with('success', 'Data berhasil dihapus');
        } catch (\Exception $e) {
            Log::error('Error deleting data: ' . $e->getMessage());
            return back()->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }

    /**
     * Export PDF
     */
    public function exportPdf($id)
    {
        try {
            $beritaAcara = BeritaAcara::findOrFail($id);

            // Convert tanda tangan & foto menjadi base64
            $ttdFields = ['tanda_tangan_pelanggan', 'tanda_tangan_petugas', 'foto_rumah', 'foto_odp', 'foto_dokumentasi_pelanggan'];
            foreach ($ttdFields as $field) {
                if ($beritaAcara->$field && file_exists(storage_path('app/public/' . $beritaAcara->$field))) {
                    $beritaAcara->{$field . '_base64'} = 'data:image/png;base64,' . base64_encode(file_get_contents(storage_path('app/public/' . $beritaAcara->$field)));
                } else {
                    $beritaAcara->{$field . '_base64'} = null;
                }
            }

            $pdf = Pdf::loadView('berita_acara.pdf', compact('beritaAcara'))->setPaper('a4', 'portrait');
            $fileName = 'BeritaAcara_' . str_replace(' ', '_', $beritaAcara->nama_lengkap) . '_' . date('YmdHis') . '.pdf';
            return $pdf->download($fileName);
        } catch (\Exception $e) {
            Log::error('Error exporting PDF: ' . $e->getMessage());
            return back()->with('error', 'Gagal export PDF: ' . $e->getMessage());
        }
    }


    /**
     * Kirim pesan WhatsApp via Watzap
     */
    public function sendWhatsapp($id)
    {
        $beritaAcara = BeritaAcara::findOrFail($id);

        // Format nomor WA (ubah 0 menjadi 62)
        $phone = preg_replace('/[^0-9]/', '', $beritaAcara->no_hp);
        if (substr($phone, 0, 1) === '0') {
            $phone = '62' . substr($phone, 1);
        }

        // URL file PDF (pastikan file sudah ada di folder storage/pdf_berita_acara)
        $pdfUrl = url('storage/pdf_berita_acara/BeritaAcara_' . $beritaAcara->nama_lengkap . '.pdf');

        // Generate URL login
        $loginUrl = route('login');

        // Template pesan WhatsApp
        $message = <<<EOT
*BERITA ACARA INSTALASI*
MEGADATA ISP Besuki

━━━━━━━━━━━━━━━━━━━━━━━

Terima kasih telah berlangganan internet di MEGADATA ISP.

📄 *Detail Pelanggan:*
- Nama: {$beritaAcara->nama_lengkap}
- No KTP: {$beritaAcara->no_ktp}
- No HP: {$beritaAcara->no_hp}
- Alamat: {$beritaAcara->alamat_lengkap}

💡 *Paket Berlangganan:*
- Rp. {$beritaAcara->paket_berlangganan} {$beritaAcara->kecepatan}
- Biaya Registrasi: Rp {$beritaAcara->biaya_registrasi}

👨‍🔧 *Teknisi:*
- {$beritaAcara->nama_teknisi_1}
- {$beritaAcara->nama_teknisi_2}

Simpan dokumen ini sebagai bukti instalasi Anda.
Terima kasih atas kepercayaan Anda!

_MEGADATA ISP - Koneksi Internet Cepat & Terpercaya_
EOT;

        // Encode agar aman untuk URL
        $encoded = urlencode($message);

        // Format link WhatsApp yang valid di semua perangkat
        $waUrl = "https://api.whatsapp.com/send?phone={$phone}&text={$encoded}";

        // Arahkan langsung ke WhatsApp
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
