<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jurusan extends Model
{
    use HasFactory;

    protected $table = 'tm_jurusan';
    protected $primaryKey = 'jurusan_id';
    public $incrementing = false; // Karena pakai string, bukan auto-increment
    protected $fillable = ['jurusan_id', 'jurusan_nama'];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($jurusan) {
            $lastJurusan = self::orderBy('jurusan_id', 'desc')->first();
            if ($lastJurusan) {
                $lastNumber = (int) substr($lastJurusan->jurusan_id, 4);
                $jurusan->jurusan_id = 'JRS-' . str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);
            } else {
                $jurusan->jurusan_id = 'JRS-001';
            }
        });
    }

    public function siswa()
    {
        return $this->hasMany(Siswa::class, 'jurusan_id');
    }
}
