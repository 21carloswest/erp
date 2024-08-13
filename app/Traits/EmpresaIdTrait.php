<?php

namespace App\Traits;

use Illuminate\Support\Facades\Auth;

trait EmpresaIdTrait
{
    function empresaId() 
    {
        return Auth::user()->empresaId ?? Auth::user()->id;
    }
}