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
        Schema::table('users', function (Blueprint $table) {
            // د Staff لپاره یوزرنیم (اختیاري د Admin لپاره)
            $table->string('username')->nullable()->unique()->after('name');
            // د تلیفون شمېره (اختیاري)
            $table->string('phone')->nullable()->after('email');
            // د واک مشخص کول (یوازې د Staff لپاره)
            $table->string('permission')->nullable()->after('role'); // لکه: ads, packages, services...
            // که ایمیل د Staff لپاره اجباري نه وي
            // (پخوانی email ستون د nullable کېدو لپاره یو جلا مایګریشن غواړي، خو موږ یې د اوس لپاره په لاسي ډول تنظیموو)
        });

        // د email ستون nullable کول (ځکه چې Staff ایمیل نه لري)
        Schema::table('users', function (Blueprint $table) {
            $table->string('email')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['username', 'phone', 'permission']);
            $table->string('email')->nullable(false)->change();
        });
    }
};