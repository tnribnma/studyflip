<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('decks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('title', 100);
            $table->text('description')->nullable();
            $table->enum('color', ['blue', 'green', 'purple', 'orange', 'red', 'teal'])->default('blue');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('decks');
    }
};
