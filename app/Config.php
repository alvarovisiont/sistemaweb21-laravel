<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Config extends Model
{
    //
  protected $table = "config";

  protected $fillable = ['id_tipo','login','titulo','cintillo','imagen','logo','nuevo','acceso','rpassword','created_at','updated_at'];

  public $timestamps =  false;
}
