<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('team_members', function (Blueprint $table) {
            $table->id();
            $table->string('name');                          // د غړي نوم
            $table->string('position');                      // دنده (رئیس، معاون، مدیر...)
            $table->string('image')->nullable();             // د غړي انځور
            $table->string('whatsapp_number')->nullable();   // د واټساپ شمېره
            $table->string('whatsapp_qr_code')->nullable();  // د QR کوډ انځور (اختیاري)
            $table->integer('sort_order')->default(0);       // د ترتیب لپاره
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('team_members');
    }
};