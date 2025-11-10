<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BeritaAcara extends Model
{
    use HasFactory;

    protected $table = 'data_pelanggan';

    protected $fillable = [
        'user_id', // ✅ tambahkan ini supaya data ikut tersimpan
        'nama_lengkap',
        'no_ktp',
        'email',
        'alamat_lengkap',
        'no_hp',
        'tanggal_registrasi',
        'jenis_perangkat',
        'mac_address',
        'serial_number',
        'nama_teknisi_1',
        'nama_teknisi_2',
        'paket_berlangganan',
        'biaya_registrasi',
        'accept_terms',
        'tanda_tangan_pelanggan',
        'tanda_tangan_petugas',
        'foto_rumah',
        'foto_odp',
        'foto_dokumentasi_pelanggan',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
