<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class TeknisiController extends Controller
{
    public function index()
    {
        $teknisi = User::where('role', 'teknisi')
            ->orderBy('name')
            ->get();

        return view('admin.teknisi.index', compact('teknisi'));
    }

    public function create()
    {
        return view('admin.teknisi.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
            'alamat'   => 'required|string|max:500',
            'no_hp'    => [
                'required',
                'regex:/^08[0-9]{8,11}$/',
                Rule::unique('users', 'no_hp'),
            ],
        ], [
            'name.required'       => 'Nama lengkap wajib diisi.',
            'email.required'      => 'Email wajib diisi.',
            'email.email'         => 'Format email tidak valid.',
            'email.unique'        => 'Email sudah digunakan.',
            'password.required'   => 'Password wajib diisi.',
            'password.min'        => 'Password minimal 8 karakter.',
            'password.confirmed'  => 'Konfirmasi password tidak cocok.',
            'alamat.required'     => 'Alamat wajib diisi.',
            'no_hp.required'      => 'Nomor HP wajib diisi.',
            'no_hp.regex'         => 'Nomor HP harus diawali 08 dan panjang 10-13 angka.',
            'no_hp.unique'        => 'Nomor HP sudah terdaftar.',
        ]);

        $teknisi = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'alamat'   => $request->alamat,
            'no_hp'    => $request->no_hp,
            'role'     => 'teknisi',
        ]);

        // OTOMATIS kirim WA selamat datang
        $this->kirimWelcomeWATeknisi($teknisi, $request->password);

        return redirect()
            ->route('admin.teknisi.index')
            ->with('success', 'Teknisi berhasil ditambahkan & notifikasi WhatsApp otomatis terkirim!');
    }

    private function kirimWelcomeWATeknisi($teknisi, $plainPassword)
    {
        try {
            // Konversi 08xxx → 62xxx (WAJIB untuk Watzap.id)
            $phone = $teknisi->no_hp;
            if (substr($phone, 0, 1) === '0') {
                $phone = '62' . substr($phone, 1);
            }

            $message = "*SELAMAT DATANG DI TIM MEGADATA ISP!*\n\n" .
                "Halo *{$teknisi->name}*,\n\n" .
                "Akun teknisi Anda sudah aktif!\n\n" .
                "Link Login:\n" . url('/login') . "\n\n" .
                "Email: `{$teknisi->email}`\n" .
                "Password: `{$plainPassword}`\n\n" .
                "Setelah login pertama, silakan ganti password Anda.\n\n" .
                "Tugas Anda:\n" .
                "• Input Berita Acara Instalasi pelanggan\n" .
                "• Upload foto sebelum & sesudah\n" .
                "• Pastikan data lengkap\n\n" .
                "Terima kasih sudah bergabung!\n" .
                "Semangat kerja!\n\n" .
                "Salam cepat,\n" .
                "*Tim MEGADATA ISP Besuki*";

            // PERBAIKAN UTAMA: GANTI asForm() → JSON + header
            $response = Http::timeout(30)
                ->withHeaders(['Content-Type' => 'application/json'])
                ->post('https://api.watzap.id/v1/send_message', [
                    'api_key'   => env('WATZAP_API_KEY'),
                    'device_id' => env('WATZAP_DEVICE_ID'),
                    'number'    => $phone,
                    'message'   => $message,
                    'type'      => 'text',
                ]);

            if ($response->successful() && str_contains(strtolower($response->body()), 'success')) {
                Log::info("Welcome WA terkirim ke teknisi: {$phone}");
            } else {
                Log::warning("Gagal kirim welcome WA ke teknisi {$phone}: " . $response->body());
            }
        } catch (\Exception $e) {
            Log::error("Error kirim welcome WA teknisi: " . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        $teknisi = User::findOrFail($id);
        if ($teknisi->role !== 'teknisi') {
            return back()->with('error', 'Tidak dapat menghapus: bukan data teknisi!');
        }
        $teknisi->delete();
        return back()->with('success', 'Teknisi berhasil dihapus.');
    }
}
