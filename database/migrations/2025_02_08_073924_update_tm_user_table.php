<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tm_user', function (Blueprint $table) {
            // Ubah kolom user_hak agar hanya bisa berisi 'SU', 'OP', atau 'AD'
            $table->enum('user_hak', ['SU', 'OP', 'AD'])->change();

            // Ubah user_sts agar hanya bisa berisi '1' (Aktif) atau '0' (Nonaktif) dengan default '1'
            $table->enum('user_sts', ['0', '1'])->default('1')->change();
        });
    }

    public function down(): void
    {
        Schema::table('tm_user', function (Blueprint $table) {
            // Rollback perubahan jika diperlukan (kembali ke string biasa)
            $table->string('user_hak', 2)->change();
            $table->string('user_sts', 2)->change();
        });
    }
};
