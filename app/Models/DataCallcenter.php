<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;



class DataCallcenter extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'rm',
    ];

    public function patients()
    {
        return $this->hasMany(Patient::class, 'id_call', 'id_call');
    }

}
