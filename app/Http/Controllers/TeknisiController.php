<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class TeknisiController extends Controller
{
    public function index(Request $request)
    {
        $query = User::whereIn('role', ['admin', 'teknisi']);

        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        $users = $query->orderBy('name')->paginate(10);

        return view('admin.teknisi.index', compact('users'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
            'alamat'   => 'nullable|string',
            'role'     => 'required|in:admin,teknisi',
            'no_hp'    => [
                'required',
                'regex:/^08[0-9]{8,11}$/',
                Rule::unique('users', 'no_hp'),
            ],
        ]);

        $user = User::create([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'password' => Hash::make($validated['password']),
            'alamat'   => $validated['alamat'] ?? null,
            'no_hp'    => $validated['no_hp'],
            'role'     => $validated['role'],
        ]);

        // Kirim WA hanya kalau teknisi
        if ($user->role === 'teknisi') {
            $this->kirimWelcomeWATeknisi($user, $request->password);
        }

        return redirect()
            ->route('admin.teknisi.index')
            ->with('success', 'Pengguna berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email,' . $id,
            'no_hp'    => [
                'nullable',
                'regex:/^08[0-9]{8,11}$/',
                Rule::unique('users', 'no_hp')->ignore($id),
            ],
            'alamat'   => 'nullable|string',
            'role'     => 'required|in:admin,teknisi',
            'password' => 'nullable|min:8|confirmed',
        ]);

        $data = $request->only(['name', 'email', 'no_hp', 'alamat', 'role']);

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()
            ->route('admin.teknisi.index')
            ->with('success', 'Data pengguna berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);

        if (Auth::id() === $user->id) {
            return back()->with('error', 'Tidak bisa menghapus akun sendiri!');
        }

        $user->delete();

        return back()->with('success', 'Pengguna berhasil dihapus.');
    }

    private function kirimWelcomeWATeknisi(User $user, string $plainPassword)
    {
        try {
            $phone = preg_replace('/^0/', '62', $user->no_hp);

            $message = "*SELAMAT DATANG DI TIM MEGADATA ISP!*\n\n" .
                "Halo *{$user->name}*,\n\n" .
                "Akun teknisi Anda sudah aktif!\n\n" .
                "Login: " . url('/login') . "\n" .
                "Email: {$user->email}\n" .
                "Password: {$plainPassword}\n\n" .
                "Silakan ganti password setelah login.\n\n" .
                "*Tim MEGADATA ISP*";

            Http::timeout(20)->post('https://api.watzap.id/v1/send_message', [
                'api_key'   => env('WATZAP_API_KEY'),
                'device_id' => env('WATZAP_DEVICE_ID'),
                'number'    => $phone,
                'message'   => $message,
                'type'      => 'text',
            ]);
        } catch (\Exception $e) {
            Log::error("Gagal kirim WA: " . $e->getMessage());
        }
    }
}
