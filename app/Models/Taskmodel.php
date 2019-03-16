<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Taskmodel extends Model
{
    //
  protected $table = "task";

  protected $fillable = ['description','state','activo','updated_at','created_at'];

  public $timestamps =  false;
}
?>