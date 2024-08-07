<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;


class Empresa extends Model
{
    use HasFactory, Notifiable, HasApiTokens;
    
    protected $fillable = [
        'cnpj',
        'razaoSocial',
        'nomeFantasia',
        'email',
        'password',
        'inscricaoEstadual',
        'inscricaoMunicipal',
        'ativa',
        'regimeTributario'
    ];

    protected $hidden = [
        'password',
    ];
}
