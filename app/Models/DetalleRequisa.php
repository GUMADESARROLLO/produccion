<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetalleRequisa extends Model
{
    protected $table = 'detalle_requisas';
    protected $primaryKey = 'id';
    protected $fillable = ['requisa_id', 'elemento_id', 'cantidad', 'estado'];
    public $timestamps = true;
}
