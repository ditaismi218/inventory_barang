<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengembalian extends Model
{
    use HasFactory;

    protected $table = 'tm_pengembalian';
    protected $primaryKey = 'kembali_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'kembali_id', 'pb_id', 'kembali_tgl', 'kembali_sts', 'pb_tgl'
    ];

    public function peminjaman()
    {
        return $this->hasMany(Peminjaman::class, 'pb_id', 'pb_id');
    }
}
