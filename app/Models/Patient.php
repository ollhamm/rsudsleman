<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;

    protected $table = 'patients';
    protected $primaryKey = 'id_pasien';

    protected $fillable = [
        'rm',
        'rujukan',
        'jenis_asuransi',
        'nomor_asuransi',
        'status',
        'user_id',
        'id_call'
    ];

    public function pemeriksaan()
    {
        return $this->hasMany(Pemeriksaan::class, 'id_pasien', 'id_pasien');
    }


    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function dataCallcenter()
    {
        return $this->belongsTo(DataCallcenter::class, 'id_call', 'id');
    }
    
}
