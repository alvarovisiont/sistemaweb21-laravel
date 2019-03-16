<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Signaturemodel extends Model
{
    //
  protected $table = "signature";
  protected $fillable = ['signature_json','signature_picture'];

  public $timestamps = false;
}
