<?php

namespace App\Http\Controllers;

use App\Models\BeritaAcara;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf;

class PelangganController extends Controller
{
    /**
     * Tampilkan detail Berita Acara untuk pelanggan
     */
    public function show($id)
    {
        try {
            $beritaAcara = BeritaAcara::findOrFail($id);

            // Opsional: validasi agar hanya pelanggan yang sesuai bisa mengakses
            // misal cek nomor HP atau email pelanggan
            // if ($beritaAcara->no_hp != session('no_hp')) { abort(403); }

            return view('pelanggan.show', compact('beritaAcara'));
        } catch (\Exception $e) {
            Log::error('Gagal menampilkan detail pelanggan: ' . $e->getMessage());
            return back()->with('error', 'Data tidak ditemukan');
        }
    }

    /**
     * Download PDF Berita Acara untuk pelanggan
     */
    public function exportPdf($id)
    {
        try {
            $beritaAcara = BeritaAcara::findOrFail($id);

            // Pastikan view 'pelanggan.pdf.berita_acara' sudah ada
            $pdf = Pdf::loadView('pelanggan.pdf.berita_acara', compact('beritaAcara'))
                ->setPaper('a4', 'portrait');

            $fileName = 'BeritaAcara_' . str_replace(' ', '_', $beritaAcara->nama_lengkap) . '_' . date('YmdHis') . '.pdf';

            return $pdf->download($fileName);
        } catch (\Exception $e) {
            Log::error('Gagal export PDF (Pelanggan): ' . $e->getMessage());
            return back()->with('error', 'Gagal export PDF');
        }
    }
}
