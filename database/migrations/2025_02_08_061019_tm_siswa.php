
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
        Schema::create('tm_siswa', function (Blueprint $table) {
            $table->string('siswa_id', 10)->primary(); // Ex: SIS0001
            $table->string('nis', 20)->unique(); // Tambahkan NIS sebagai unik
            $table->string('siswa_nama', 100);
            $table->string('kelas_id', 10);
            $table->string('jurusan_id', 10);
            $table->timestamps();
        
            $table->foreign('kelas_id')->references('kelas_id')->on('tm_kelas');
            $table->foreign('jurusan_id')->references('jurusan_id')->on('tm_jurusan');
        });                
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
