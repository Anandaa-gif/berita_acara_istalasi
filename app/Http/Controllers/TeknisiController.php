<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class TeknisiController extends Controller
{
    /**
     * Menampilkan daftar teknisi
     */
    public function index()
    {
        $teknisi = User::where('role', 'teknisi')->orderBy('name')->get();
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
     * Menyimpan data teknisi baru
     */
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
            'no_hp.regex'         => 'Nomor HP harus diawali 08 dan berisi 10-13 angka.',
            'no_hp.unique'        => 'Nomor HP sudah terdaftar.',
        ]);

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'alamat'   => $request->alamat,
            'no_hp'    => $request->no_hp,
            'role'     => 'teknisi',
        ]);

        return redirect()
            ->route('admin.teknisi.index')
            ->with('success', 'Teknisi berhasil ditambahkan.');
    }

    /**
     * Menghapus teknisi
     */
    public function destroy($id)
    {
        $teknisi = User::findOrFail($id);

        // Pastikan hanya teknisi yang bisa dihapus
        if ($teknisi->role !== 'teknisi') {
            return back()->with('error', 'Tidak dapat menghapus: bukan data teknisi!');
        }

        $teknisi->delete();

        return back()->with('success', 'Teknisi berhasil dihapus.');
    }
}
