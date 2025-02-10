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
        Schema::table('tm_peminjaman', function (Blueprint $table) {
            // Hapus kolom lama
            $table->dropColumn(['pb_no_siswa', 'pb_nama_siswa']);

            // Tambah kolom siswa_id
            $table->string('siswa_id', 10)->nullable()->after('user_id');

            // Tambah foreign key ke tabel tm_siswa
            $table->foreign('siswa_id')->references('siswa_id')->on('tm_siswa');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tm_peminjaman', function (Blueprint $table) {
            // Kembalikan perubahan jika rollback
            $table->dropForeign(['siswa_id']);
            $table->dropColumn('siswa_id');

            // Tambah kembali kolom lama
            $table->string('pb_no_siswa', 20)->nullable();
            $table->string('pb_nama_siswa', 100)->nullable();
        });
    }
};
