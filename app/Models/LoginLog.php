<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class LoginLog extends Model
{
    use HasFactory;

    protected $table = 'login_logs'; // nama tabel
    protected $fillable = ['user_id', 'email', 'ip_address', 'login_time'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
