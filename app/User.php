<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'usuario';

    protected $fillable = ['login', 'email', 'password','id_permiso','password_activo','usuario_activo','correo_activo','fecha_acceso','createdat','updatedat','correlativo'];

    public $timestamps = false;

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function perfil_usuario()
    {
        return $this->belongsTo('App\Perfil','id_permiso','id');
    }

    public function show_user($id = null)
    {   
        $data = '';

        if($id)
        {
            return $this->join('usuario_info','usuario_info.id_usuario','=','usuario.id')
                    ->where('usuario_info.id_usuario',$id)
                    ->select('usuario.*','usuario_info.*')
                    ->first();
        }
        else
        {
            return $this->hasOne('App\Userinfo','id_usuario');
        }
    }

}
