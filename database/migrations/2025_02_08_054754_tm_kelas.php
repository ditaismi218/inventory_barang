<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tm_kelas', function (Blueprint $table) {
            $table->string('kelas_id', 10)->primary(); 
            $table->string('kelas_nama', 50);
            $table->enum('tingkatan', ['X', 'XI', 'XII']);
            $table->string('jurusan_id', 10);
            $table->foreign('jurusan_id')->references('jurusan_id')->on('tm_jurusan')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tm_kelas');
    }
};
