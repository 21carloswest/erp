<?php

namespace App\Traits;

trait TimezoneTrait
{
    private $utc3 = [
        'SP',
        'RJ',
        'MG',
        'ES',
        'RS',
        'SC',
        'PR',
        'GO',
        'MS',
        'DF',
        'BA',
        'SE',
        'AL',
        'PE',
        'PB',
        'RN',
        'CE',
        'MA',
    ];

    private $utc4 = [
        'AM',
        'RR',
        'RO',
        'AC',
        'MT',
    ];

    private $utc5 = [
        'AC',
    ];

    // private $utc2 = [
    //     'Fernando de Noronha' => 'FEN',
    // ];

    public function getTimezone($uf)
    {
        if (in_array($uf, $this->utc3)) {
            return -3;
        }

        if (in_array($uf, $this->utc4)) {
            return -4;
        }

        if (in_array($uf, $this->utc5)) {
            return -5;
        }
    }
}