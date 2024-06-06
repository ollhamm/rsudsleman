<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pemeriksaan extends Model
{
    use HasFactory;
    protected $table = "pemeriksaan";
    protected $primaryKey = "id_periksa";
    protected $fillable = [
        'id_pasien',
        'tanggal_pemeriksaan',
        'amnesis_dokter',
        'unit_pemeriksaan',
        'verifikator',
        'rujukan_pemeriksaan',
        'jenis_pembayaran',
        'payment',
        'payment_status',
        'WBC',
        'RBC',
        'PLT',
        'HGB',
        'HTM',
        'Neu',
        'Eos',
        'Bas',
        'Lym',
        'Mon',
        'MCV',
        'MCH',
        'MCHC'
    ];



    public function patients()
    {
        return $this->belongsTo(Patient::class, 'id_pasien', 'id_pasien');
    }

}
