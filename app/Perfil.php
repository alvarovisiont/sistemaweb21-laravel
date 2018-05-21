<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Perfil extends Model
{
    //

    protected $table = 'perfil';

    protected $fillable = ['nombre','descripcion','activo','sistema','createdat','updatedat'];

    public $timestamps = false;
}
