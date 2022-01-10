<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoCambio extends Model
{
    protected $connection = 'sqlsrv';
    public $timestamps = false;
    protected $table = "umk.TIPO_CAMBIO_HIST";
}
