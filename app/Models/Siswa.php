<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Str;

class Siswa extends Model
{
    protected $table = 'tm_siswa';
    protected $primaryKey = 'siswa_id';
    public $incrementing = false;
    protected $fillable = ['siswa_id', 'nis', 'siswa_nama', 'kelas_id', 'jurusan_id'];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($siswa) {
            $latest = Siswa::orderBy('siswa_id', 'desc')->first();
            $number = $latest ? ((int)substr($latest->siswa_id, 3)) + 1 : 1;
            $siswa->siswa_id = 'SIS' . str_pad($number, 4, '0', STR_PAD_LEFT);
        });
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id');
    }

    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class, 'jurusan_id');
    }

}

