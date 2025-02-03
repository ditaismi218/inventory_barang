<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BarangInventaris extends Model
{
    use HasFactory;

    protected $table = 'tm_barang_inventaris';

    protected $primaryKey = 'br_kode'; // Menentukan primary key

    public $incrementing = false; // Karena kode barang tidak auto increment

    protected $fillable = [
        'br_kode',
        'jns_brg_kode',
        'user_id',
        'br_nama',
        'br_tgl_terima',
        'br_tgl_entry',
        'br_status',
    ];

    public function jenisBarang()
    {
        return $this->belongsTo(JenisBarang::class, 'jns_brg_kode');
    }

    public function users()
    {
        return $this->hasMany(User::class, 'user_id');
    }

    public function peminjaman_barang(){
        return $this->hasMany(PeminjamanBarang::class, 'br_kode', 'br_kode');
    }
}
