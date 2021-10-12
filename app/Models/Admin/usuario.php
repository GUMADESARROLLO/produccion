<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use App\Models\Admin\Rol;
use App\Models\Admin\usuario_rol;

class usuario extends Model
{
    protected $table = "users";
    protected $fillable = ['nombres', 'apellidos', 'username', 'password', 'fecha_nacimiento', 'image', 'estado', 'id_grupo'];

    public function roles() {
    	return $this->belongsToMany(Rol::class, 'usuario_rol');
    }

    public static function usuarioByRole() {
        $usuario = new usuario();
        return $usuario->whereHas('roles', function ($query) {
            $query->where('rol_id', 5);
        })->get()
          ->toArray();
    }
}
