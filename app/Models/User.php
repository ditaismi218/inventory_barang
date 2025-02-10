<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'tm_user';  // Nama tabel

    protected $primaryKey = 'user_id';  // Primary key

    public $incrementing = false; // Karena 'user_id' bukan auto-increment

    protected $fillable = [
        'user_id',
        'user_nama',
        'user_pass',
        'user_hak',
        'user_sts',
    ];

    protected $hidden = [
        'user_pass',
        'remember_token',
    ];

    protected $rememberTokenName = 'remember_token';

    // Override metode untuk autentikasi
    public function getAuthIdentifierName()
    {
        return 'user_id';
    }

    public function getAuthIdentifier()
    {
        return $this->user_id;
    }

    public function getAuthPassword()
    {
        return $this->user_pass;
    }

    // Hash password secara otomatis saat menyimpan
    public function setUserPassAttribute($value)
    {
        $this->attributes['user_pass'] = Hash::make($value);
    }

    // Relasi (Jika user bisa memiliki banyak barang inventaris)
    public function barangInventaris()
    {
        return $this->hasMany(BarangInventaris::class, 'user_id');
    }

    public function isActive()
    {
        return $this->user_sts === '1';
    }

}
