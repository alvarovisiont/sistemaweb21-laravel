<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


class Menu extends Model
{
    //

    protected $table = 'menu';

    protected $fillable = ['nombre','id_padre','id_tipo','ruta','icono','session','orden','createdat','updatedat','link'];

    public $timestamps = false;



    public static function show_menu()
    {     
      $sql = "
      WITH RECURSIVE modulos(id,nombre,id_padre,id_tipo,link,icono,ruta,con) AS 
      (
        SELECT id, nombre, id_padre, id_tipo, link, icono, ruta, id as con from menu  where id_padre = 0
      ), 
        areas(id,nombre,id_padre,id_tipo,link,icono,ruta,con) AS( 

        SELECT menu.id, menu.nombre, menu.id_padre, menu.id_tipo, menu.link, menu.icono, menu.ruta, modulos.con
        from menu 
        JOIN modulos ON menu.id_padre = modulos.id
      ) 
      ,
      sub_area(id,nombre,id_padre,id_tipo,link,icono,ruta, con) AS (
          
          SELECT menu.id, menu.nombre, menu.id_padre, menu.id_tipo, menu.link, menu.icono, menu.ruta, areas.con
          FROM menu 
          JOIN areas ON menu.id_padre = areas.id
      )

      SELECT * from (SELECT * from modulos UNION SELECT * from areas UNION SELECT * from sub_area)
                    as result ORDER BY con asc, id_tipo asc";

      return DB::select(DB::raw($sql));
    }

    public static function show_menu_perfil()
    {
      $sql = "
         WITH RECURSIVE modulos(id,nombre,id_padre,id_tipo,link,icono,ruta,con) AS 
        (
          SELECT id, nombre, id_padre, id_tipo, link, icono, ruta, id as con from menu  where id_padre = 0
        ), 
          areas(id,nombre,id_padre,id_tipo,link,icono,ruta,con) AS( 

          SELECT menu.id, menu.nombre, menu.id_padre, menu.id_tipo, menu.link, menu.icono, menu.ruta, modulos.con
          from menu 
          JOIN modulos ON menu.id_padre = modulos.id
        ) 
        ,
        sub_area(id,nombre,id_padre,id_tipo,link,icono,ruta, con) AS (
            
            SELECT menu.id, menu.nombre, menu.id_padre, menu.id_tipo, menu.link, menu.icono, menu.ruta, areas.con
            FROM menu 
            JOIN areas ON menu.id_padre = areas.id
        ) 
        SELECT result.*, a.id_area, a.id_sub_area from 
        (SELECT * from modulos UNION SELECT * FROM areas UNION SELECT * from sub_area) as result 
        inner join acceso as a on result.id = a.id_modulo 
        
        where a.id_perfil =".Auth::user()->id_permiso." and a.visible = true
        ORDER BY result.con asc, result.id_tipo asc ";

        return DB::select(DB::raw($sql));
    }

    public static function print_menu()
    {
        $menu = self::show_menu_perfil();

        $html_menu = '<ul class="nav nav-list">';  

         $aux_tipo = 0;
        

        foreach ($menu as $row)
        {
          if (!$row->link){
            $ruta_link = "#";
            $classe = 'class="dropdown-toggle"';
            $classe_flecha = 'class="arrow fa fa-angle-down"';
            $icono_classe = 'class="menu-icon fa '.$row->icono.'"';
          }
          else
          {
            $ruta_link = route($row->ruta,['menu' => base64_encode($row->id) ]);
            $classe = 'class=""';
            $classe_flecha = 'class=""';
            $icono_classe = 'class="menu-icon fa '.$row->icono.'"';
          }
    /*-----------------------------------------------------------------*/
           $html_menu .= '
               <li class="">
                <a href="'.$ruta_link.'" '.$classe.' >
                <i '.$icono_classe.'></i>
                <span class="menu-text">'.$row->nombre.'
                </span>
                <b '.$classe_flecha.'></b>
              </a>
              <b class="arrow"></b>'; 
           /*-----------------------------------------------------------------*/

           $aux_tipo = 1;

           $areas = explode(',', $row->id_area);
           $sub_areas = explode(',', $row->id_sub_area);



          foreach ($areas as $row_areas)
          {
            $id_area = trim($row_areas, "{}");

            if (!empty($id_area))
            { 
              $area_menu  = self::show_menu_area($id_area);

              if (!empty($area_menu)) {

                if ($aux_tipo == 1)
                {
                   $html_menu .= '<ul class="submenu">';
                   $aux_tipo = 2;
                }


                if (!$area_menu->link){
                  $ruta_link = "#";
                  $classe = 'class="dropdown-toggle"';
                  $classe_flecha = 'class="arrow fa fa-angle-down"';
                }
                else
                {
                  $ruta_link = route($area_menu->ruta,['menu' => base64_encode($area_menu->id)]);
                  $classe = 'class=""';
                  $classe_flecha = 'class=""';
                }    

           
                $html_menu .= '
                  <li class="">
                   <a href="'.$ruta_link.'" '.$classe.' >
                  <i class="menu-icon fa fa-caret-right"></i>
                  <span class="menu-text">'.$area_menu->nombre.'
                  </span>
                   <b '.$classe_flecha.'></b>
                </a>
                <b class="arrow"></b>';  
             

            /*----------------------------------------------------------------*/         
                foreach ($sub_areas as $row_sub_areas)
                {
                  $id_sub_area = trim($row_sub_areas, "{}");

                  if (!empty($id_sub_area))
                  { 
                    $sub_menu  = self::show_menu_sub_area($id_area, $id_sub_area);

                    if (!empty($sub_menu)) 
                    {   
                        $ruta_link = route($sub_menu->ruta,['menu' => base64_encode($sub_menu->id)]);
                        $classe = 'class=""';
                        $classe_flecha = 'class=""';

                        $html_menu .= '<ul class="submenu">
                         <li class="">
                              <a href="'.$ruta_link.'" '.$classe.' >
                              <i class="menu-icon fa fa-caret-right"></i>
                               <span class="menu-text">'.$sub_menu->nombre.'
                              </span>
                               <b '.$classe_flecha.'></b>
                            </a>
                          
                            <b class="arrow"></b>
                          </li></ul> ';
                     }  //datos sub area
                  } //if null sub area  
                }// en sub area*/

               $html_menu .= '</li>'; //cierre de la area
              }  
            } 
          }//en de area

        if ($aux_tipo == 2)
        {
           $html_menu .= '</ul>';
        }

        $html_menu .= '</li>';  
      }//en modulo   
    /*-----------------------------------------------------------------*/

      $html_menu .= '</ul>
                      <div class="sidebar-toggle sidebar-collapse" id="sidebar-collapse">
                          <i id="sidebar-toggle-icon" class="ace-icon fa fa-angle-double-left ace-save-state" data-icon1="ace-icon fa fa-angle-double-left" data-icon2="ace-icon fa fa-angle-double-right"></i>
                      </div>';

      session(['menu_usuario' => $html_menu]);
    }

    private static function show_menu_area($area)
    {
      return self::where('id',$area)->first(); 
    }  

    private static function show_menu_sub_area($area, $sub_area)
    {

      return self::where([ ['id','=',$sub_area], ['id_padre','=',$area] ])->first();
    } 
}
