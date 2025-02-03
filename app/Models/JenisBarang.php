<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisBarang extends Model
{
    use HasFactory;

    protected $table = 'tr_jenis_barang';

    protected $primaryKey = 'jns_brg_kode';
    public $incrementing = false; // Important for non-incrementing primary keys
    protected $keyType = 'string'; // Because the primary key is a string

    protected $fillable = [
        'jns_brg_kode',
        'jns_brg_nama',
    ];

    public function barangInventaris()
    {
        return $this->hasMany(BarangInventaris::class, 'jns_brg_kode', 'jns_brg_kode');
    }
}
