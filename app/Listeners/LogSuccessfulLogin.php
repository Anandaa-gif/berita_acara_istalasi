<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use App\Models\LoginLog;
use Illuminate\Support\Facades\Request;

class LogSuccessfulLogin
{
    public function handle(Login $event)
    {
        $user = $event->user;
        $ip = Request::ip();
        $now = now();

        // Cegah duplikasi dalam waktu 2 menit terakhir untuk user + IP yang sama
        $alreadyLogged = LoginLog::where('user_id', $user->id)
            ->where('ip_address', $ip)
            ->whereBetween('created_at', [$now->copy()->subMinutes(2), $now])
            ->exists();

        if (! $alreadyLogged) {
            LoginLog::create([
                'user_id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'ip_address' => $ip,
                'login_time' => $now,
            ]);
        }
    }
}
