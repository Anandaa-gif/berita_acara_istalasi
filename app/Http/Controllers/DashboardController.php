<?php

namespace App\Http\Controllers;

use App\Models\BeritaAcara;
use App\Models\User;
use App\Models\Login;
use App\Models\LoginLog;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Auth\Events\Login as EventsLogin;

class DashboardController extends Controller
{
    public function index()
    {
        // === Grafik pemasangan per bulan ===
        $pemasangan_per_bulan = BeritaAcara::select(
            DB::raw("MONTH(tanggal_registrasi) as bulan"),
            DB::raw("COUNT(*) as total")
        )
            ->groupBy('bulan')
            ->pluck('total', 'bulan')
            ->toArray();

        $bulan_labels = [];
        $bulan_values = [];

        foreach ($pemasangan_per_bulan as $bulan => $total) {
            $bulan_labels[] = Carbon::create()->month($bulan)->translatedFormat('F');
            $bulan_values[] = $total;
        }

        // === Statistik ringkas ===
        $total_semua = BeritaAcara::count();
        $total_bulan_ini = BeritaAcara::whereMonth('tanggal_registrasi', Carbon::now()->month)->count();

        // === Teknisi teraktif ===
        $teknisi_bulan_ini = BeritaAcara::select(
            DB::raw("nama_teknisi_1 as teknisi"),
            DB::raw("COUNT(*) as total")
        )
            ->whereMonth('tanggal_registrasi', Carbon::now()->month)
            ->groupBy('nama_teknisi_1');

        $teknisi2_bulan_ini = BeritaAcara::select(
            DB::raw("nama_teknisi_2 as teknisi"),
            DB::raw("COUNT(*) as total")
        )
            ->whereMonth('tanggal_registrasi', Carbon::now()->month)
            ->groupBy('nama_teknisi_2');

        $teknisi_teraktif = $teknisi_bulan_ini
            ->unionAll($teknisi2_bulan_ini)
            ->get()
            ->groupBy('teknisi')
            ->map(function ($row) {
                return $row->sum('total');
            })
            ->sortDesc();

        // === Daftar pengguna yang pernah login ===
        $riwayat_login = LoginLog::with('user')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();


        return view('dashboard.index', compact(
            'bulan_labels',
            'bulan_values',
            'total_semua',
            'total_bulan_ini',
            'teknisi_teraktif',
            'riwayat_login'
        ));
    }
}
