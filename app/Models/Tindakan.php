<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tindakan extends Model
{
    use HasFactory;
    protected $fillable = [
    'nama_tindakan',
    'harga'
];

    public function detail()
{
    return $this->hasMany(DetailTransaksi::class);
}
}
