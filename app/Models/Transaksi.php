<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;
    protected $fillable = [
        'invoice',
    'pasien_id',
    'user_id',
    'total',
    'tanggal'
];

    public function pasien()
{
    return $this->belongsTo(Pasien::class);
}

public function user()
{
    return $this->belongsTo(User::class);
}

public function detail()
{
    return $this->hasMany(DetailTransaksi::class);
}
}
