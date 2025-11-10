<?php

namespace App\Exports;

use App\Models\BeritaAcara;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class BeritaAcaraExport implements FromCollection, WithHeadings
{
    protected $bulan;
    protected $tahun;

    public function __construct($bulan, $tahun)
    {
        $this->bulan = $bulan;
        $this->tahun = $tahun;
    }

    public function collection()
    {
        return BeritaAcara::whereMonth('tanggal_registrasi', $this->bulan)
            ->whereYear('tanggal_registrasi', $this->tahun)
            ->select(
                'nama_lengkap',
                'no_ktp',
                'email',
                'alamat_lengkap',
                'no_hp',
                'tanggal_registrasi',
                'jenis_perangkat',
                'nama_teknisi_1',
                'nama_teknisi_2',
                'paket_berlangganan',
                'biaya_registrasi'
            )
            ->get();
    }

    public function headings(): array
    {
        return [
            'Nama Lengkap',
            'No KTP',
            'Email',
            'Alamat Lengkap',
            'No HP',
            'Tanggal Registrasi',
            'Jenis Perangkat',
            'Teknisi 1',
            'Teknisi 2',
            'Paket Berlangganan',
            'Biaya Registrasi'
        ];
    }
}
