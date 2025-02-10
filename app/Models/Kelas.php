<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    use HasFactory;

    protected $table = 'tm_kelas';
    protected $primaryKey = 'kelas_id';
    public $incrementing = false; // Karena pakai string, bukan auto-increment
    protected $fillable = ['kelas_id', 'kelas_nama', 'tingkatan', 'jurusan_id'];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($kelas) {
            $lastKelas = self::orderBy('kelas_id', 'desc')->first();
            if ($lastKelas) {
                $lastNumber = (int) substr($lastKelas->kelas_id, 4);
                $kelas->kelas_id = 'KLS-' . str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);
            } else {
                $kelas->kelas_id = 'KLS-001';
            }
        });
    }

    public function siswa()
    {
        return $this->hasMany(Siswa::class, 'kelas_id');
    }

    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class, 'jurusan_id');
    }
}
