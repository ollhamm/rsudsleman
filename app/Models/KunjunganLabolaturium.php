<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KunjunganLabolaturium extends Model
{
    use HasFactory;
    protected $table = 'kunjungan_labolaturium';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id_pemeriksaan',
        'tanggal_kunjungan',
        'tanggal_selesai',
        'EDTA',
        'Serum',
        'Citrate',
        'Urine',
        'Lainya',
        'kondisi_sampel'
    ];
    public function pemeriksaan()
    {
        return $this->belongsTo(Pemeriksaan::class, 'id_pemeriksaan', 'id_periksa');
    }
    
}
