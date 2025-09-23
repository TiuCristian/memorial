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
        Schema::create('memories', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100)->nullable();           // Nume și prenume (opțional)
            $table->string('relation', 100);                   // Relația cu Dana
            $table->text('message');                           // Mesajul / amintirea
            $table->string('media_path')->nullable();          // Calea către fișierul încărcat
            $table->string('media_mime', 100)->nullable();     // Tip MIME (image/jpeg, video/mp4, etc.)
            $table->boolean('consent')->default(false);        // Acord publicare
            $table->string('status', 20)->default('pending');  // pending | approved | rejected (pentru moderare ulterioară)
            $table->string('ip', 45)->nullable();              // IPv4/IPv6 (anti-abuz)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('memories');
    }
};
