<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Instrumen extends Model
{
    use HasFactory;
    protected $table = "instrumens";
    protected $primaryKey = "id_instrumen";
    protected $fillable = [
        'instrumen',
        'jumlah_instrumen',
        'tanggal_t_maintenance',
        'status',
        'tanggal_b_maintenance',
    ];
}
