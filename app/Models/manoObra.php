<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class manoObra extends Model
{
    protected $table = "mano_obra";
    protected $fillable = ['idActividad','numOrden','dia','noche','total'];
    public $timestamps = false;
}
