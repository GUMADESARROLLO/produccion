<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class jumboroll_detalle extends Model
{
    protected $table = "jumboroll_detalle";
    protected $fillable = ['id', 'vinieta', 'kg','gsm','yankee','idJumboroll'];
}
