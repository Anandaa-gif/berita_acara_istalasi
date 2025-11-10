<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('data_pelanggan', function (Blueprint $table) {
            $table->id();
            $table->string('nama_lengkap');
            $table->string('no_ktp');
            $table->string('email')->nullable();
            $table->text('alamat_lengkap');
            $table->string('no_hp');

            $table->date('tanggal_registrasi');
            $table->string('jenis_perangkat');
            $table->string('mac_address')->nullable();
            $table->string('serial_number')->nullable();

            $table->string('nama_teknisi_1');
            $table->string('nama_teknisi_2')->nullable();

            $table->string('paket_berlangganan');
            $table->decimal('biaya_registrasi', 12, 2)->default(0);
            $table->boolean('accept_terms')->default(false);

            $table->longText('tanda_tangan_pelanggan');
            $table->longText('tanda_tangan_petugas');

            $table->string('foto_rumah')->nullable();
            $table->string('foto_odp')->nullable();
            $table->string('foto_dokumentasi_pelanggan')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_pelanggan');
    }
};
