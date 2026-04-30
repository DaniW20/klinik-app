<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailTransaksi extends Model
{
    use HasFactory;
    protected $fillable = [
    'transaksi_id',
    'jenis',
    'obat_id',
    'tindakan_id',
    'qty',
    'harga',
    'subtotal'
];

    public function transaksi()
{
    return $this->belongsTo(Transaksi::class);
}

public function obat()
{
    return $this->belongsTo(Obat::class);
}

public function tindakan()
{
    return $this->belongsTo(Tindakan::class);
}
}
