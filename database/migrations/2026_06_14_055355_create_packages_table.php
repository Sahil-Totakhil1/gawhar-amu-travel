<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('packages', function (Blueprint $table) {
            $table->id();
            $table->json('title');                    // د پکېج سرلیک (ps, dr, en)
            $table->json('description')->nullable();  // د پکېج تشریح
            $table->string('image')->nullable();      // د پکېج انځور
            $table->string('destination')->nullable();// منزل (په متن)
            $table->string('duration')->nullable();   // موده (لکه: ۱۵ ورځې)
            $table->decimal('price', 10, 2)->nullable();
            $table->string('category');               // visa, tour, hajj, ticket...
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('packages');
    }
};