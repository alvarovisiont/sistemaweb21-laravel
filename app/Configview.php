<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Configview extends Model
{
    //
    protected $table = "vista_config";

    protected $fillable = ['modulo','tabla','titulo','breadcrumb','activo','controlador','enctype','membrete','createdat','updatedat','ruta_imagen'];

    public $timestamps = false;
}
