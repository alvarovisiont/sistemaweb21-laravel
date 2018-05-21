<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Userinfo extends Model
{
    //
  protected $table = 'usuario_info';

  protected $fillable = ['id_usuario','cedula','apellido','nombre','id_pais','id_operadora','telefono','id_grupo_depart','imagen','createdat','updatedat','fecha_nacimiento','genero','direccion','id_centro'];

  public $timestamps = false;
}
