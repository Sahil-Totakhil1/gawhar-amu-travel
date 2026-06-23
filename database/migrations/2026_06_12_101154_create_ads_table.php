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
        Schema::create('ads', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->json('title');        // په دریو ژبو کې سرلیک: {"ps": "...", "dr": "...", "en": "..."}
            $table->json('description')->nullable(); // په دریو ژبو کې تشریح
            $table->string('image')->nullable();     // د انځور آدرس
            $table->string('video_url')->nullable(); // د ویډیو لینک
            $table->decimal('price', 10, 2)->nullable();
            $table->string('location')->nullable();
            $table->string('category');              // visa, tour, hajj, ticket...
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->unsignedBigInteger('views')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ads');
    }
};