<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    use HasFactory;

    protected $table = 'tm_peminjaman';
    protected $primaryKey = 'pb_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'pb_id', 'user_id', 'pb_no_siswa', 'pb_nama_siswa', 'pb_tgl', 'pb_harus_kembali_tgl', 'pb_stat'
    ];

    // protected $casts = [
    //     'pb_harus_kembali_tgl' => 'date',
    // ];
    

    public function peminjaman_barang(){
        return $this->hasMany(PeminjamanBarang::class, 'pb_id', 'pb_id');
    }
}
