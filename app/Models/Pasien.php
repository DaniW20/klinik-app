<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pasien extends Model
{
    use HasFactory;
    protected $fillable = [
    'nama',
    'alamat',
    'no_hp',
    'tanggal_lahir'
];

    public function transaksi()
{
    return $this->hasMany(Transaksi::class);
}
}
