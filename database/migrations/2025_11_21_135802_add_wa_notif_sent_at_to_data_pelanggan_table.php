<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('data_pelanggan', function (Blueprint $table) {
            if (!Schema::hasColumn('data_pelanggan', 'wa_notif_sent_at')) {
                $table->timestamp('wa_notif_sent_at')->nullable()->after('no_hp');
            }
        });
    }

    public function down()
    {
        Schema::table('data_pelanggan', function (Blueprint $table) {
            $table->dropColumn('wa_notif_sent_at');
        });
    }
};
