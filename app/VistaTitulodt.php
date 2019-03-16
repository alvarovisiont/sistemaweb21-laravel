<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VistaTitulodt extends Model
{
    //
  protected $table = "vista_titulodt";

  protected $fillable = ['id_config','nombre','key','orden','activo','createdat','updatedat','resaltar','format_number','hidden'];

  public $timestamps = false;

}
