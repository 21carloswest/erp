<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Certificado extends Model
{
    use HasFactory;
    protected $fillable = [
        'path',
        'password',
        'empresaId',
        'dataValidade',
    ];

    protected $hidden = [
        'password',
        'path'
    ];
}
