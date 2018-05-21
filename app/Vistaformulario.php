<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vistaformulario extends Model
{
    //
    protected $table = "vista_formulario";

    protected $fillable = ['id_config','label','tipo','required','name_id','placeholder','value','option','selected','orden','activo','multiple','check_table','check_field','createdat','updatedat','cols'];

    public $timestamps = false;
}
