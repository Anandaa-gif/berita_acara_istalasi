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
    /**
     * Menampilkan daftar teknisi
     */
    public function index()
    {
        $teknisi = User::where('role', 'teknisi')
            ->orderBy('name')
            ->get();

        return view('admin.teknisi.index', compact('teknisi'));
    }

    /**
     * Menampilkan form tambah teknisi
     */
    public function create()
    {
        return view('admin.teknisi.create');
    }

    /**
     * Menyimpan teknisi baru + kirim WhatsApp otomatis
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'alamat'   => 'required|string',
            'no_hp'    => [
                'required',
                'regex:/^08[0-9]{8,11}$/', // 08 + 8-11 digit → total 10-13 digit
                Rule::unique('users', 'no_hp'),
            ],
        ], [
            'name.required'        => 'Nama wajib diisi.',
            'email.required'       => 'Email wajib diisi.',
            'email.unique'         => 'Email sudah terdaftar.',
            'password.required'    => 'Password wajib diisi.',
            'password.confirmed'   => 'Konfirmasi password tidak cocok.',
            'alamat.required'      => 'Alamat wajib diisi.',
            'no_hp.required'       => 'Nomor HP wajib diisi.',
            'no_hp.regex'          => 'Nomor HP harus diawali 08 dan berisi 10-13 angka.',
            'no_hp.unique'         => 'Nomor HP sudah terdaftar.',
        ]);

        // Buat teknisi
        $teknisi = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'alamat'   => $request->alamat,
            'no_hp'    => $request->no_hp,
            'role'     => 'teknisi',
        ]);

        // Kirim WA selamat datang (password masih plaintext di sini)
        $this->kirimWelcomeWATeknisi($teknisi, $request->password);

        return redirect()
            ->route('admin.teknisi.index')
            ->with('success', 'Teknisi berhasil ditambahkan & notifikasi WhatsApp otomatis terkirim!');
    }

    /**
     * Kirim pesan selamat datang via WhatsApp (Watzap.id / Wablas / Fonnte / dll)
     */
    private function kirimWelcomeWATeknisi(User $teknisi, string $plainPassword): void
    {
        try {
            // Ubah 08xxx → 62xxx (format internasional WA)
            $phone = preg_replace('/^0/', '62', $teknisi->no_hp);

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
                Log::info("Welcome WA berhasil terkirim ke teknisi: {$phone}");
            } else {
                Log::warning("Gagal kirim welcome WA ke teknisi {$phone}: " . $response->body());
            }
        } catch (\Exception $e) {
            Log::error("Error kirim welcome WA teknisi {$teknisi->name}: " . $e->getMessage());
        }
    }

    /**
     * Hapus teknisi
     */
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
