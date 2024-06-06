<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reagensia extends Model
{
    use HasFactory;
    protected $table = "reagensias";
    protected $primaryKey = "id_reagen";
    protected $fillable = [
        'nama_reagen_kit',
        'tanggal_kadaluarsa',
        'reagen_yang_telah_dipakai',
        'ketersediaan',
    ];
}
