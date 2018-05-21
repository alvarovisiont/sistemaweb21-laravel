<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PermisoAccion extends Model
{
    //
    protected $table = 'acceso_accion';

    protected $fillable = ['id_usuario','id_perfil','id_modulo','n_accion','m_accion','e_accion','a_accion','i_accion','r_accion','createdat','updatedat'];

    public $timestamps = false;

    public static function buscar_accesos($key,$valor)
    {
    	$sql = "SELECT acceso.*,
              
              CASE  
              
              WHEN menu.id_tipo = 3 THEN 
                (SELECT menu1.nombre from menu as menu1 where id = (SELECT menu2.id_padre from menu as menu2 where id = menu.id_padre)
                )
              WHEN menu.id_tipo = 2 THEN
                (SELECT menu1.nombre from menu as menu1 where menu1.id = menu.id_padre)
              ELSE
                menu.nombre
              END AS modulo,

              CASE  
              
              WHEN menu.id_tipo = 3 THEN 
                (SELECT menu1.nombre from menu as menu1 where menu1.id = menu.id_padre)
              WHEN menu.id_tipo = 2 THEN
                menu.nombre
              ELSE
                ''
              END  as area,

              CASE  
              
              WHEN menu.id_tipo = 3 THEN 
                menu.nombre
              WHEN menu.id_tipo = 2 THEN
                ''
              ELSE
                ''
              END  as sub_area

              from acceso_accion as acceso 
              INNER JOIN menu ON menu.id = acceso.id_modulo
              WHERE $key = $valor";

        return DB::select(DB::raw($sql));
    }

    public static function all_access($id_menu)
    {
      $tipo = Auth::user()->id_permiso == 1 ? 1 : 2;

      $key = $tipo == 1 ? 'id_usuario' : 'id_perfil';
      $valor = $tipo == 1 ? Auth::user()->id : Auth::user()->id_permiso;

      return self::where('id_modulo',$id_menu)->where($key,$valor)->first();
    }
}
