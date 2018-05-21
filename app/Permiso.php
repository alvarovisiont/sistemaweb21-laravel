<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Permiso extends Model
{
    //
    protected $table = 'acceso';

    protected $fillable = ['id_usuario','id_perfil','id_modulo','id_area','id_sub_area','visible','createdat','updatedat'];

    public $timestamps = false;
}
