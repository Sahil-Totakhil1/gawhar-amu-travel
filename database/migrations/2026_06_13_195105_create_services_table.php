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
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('icon')->nullable();           // د Font Awesome آیکون کلاس (لکه: fa-laptop)
            $table->json('title');                        // په دریو ژبو کې عنوان
            $table->json('description')->nullable();      // په دریو ژبو کې تشریح
            $table->integer('sort_order')->default(0);    // د ترتیب لپاره
            $table->boolean('is_active')->default(true);  // فعال/غیرفعال
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};