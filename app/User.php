<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use App\Models\usuario_rol;

class User extends Authenticatable
{
    use Notifiable, HasApiTokens;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    /*protected $fillable = [
       'id', 'username', 'password', 'nombres', 'apellidos', 'fecha_nacimiento', 'image', 'estado', 'id_grupo'
    ];*/
    protected $fillable = [
        'username', 'password', 'nombres', 'apellidos', 'image', 'estado', 'id_grupo'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function activeRole() {//retorna el role del usuario actual
        $role = usuario_rol::select('rol_id')->where('usuario_id', $this->id)->get()->first();
        return $role->rol_id;
    }
}
