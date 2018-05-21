<?php

  use App\PermisoAccion;
  use Illuminate\Support\Facades\DB;

  function form_vista($enctype = null,$f_store = null,$campos, $data = null,$th = null,$key_data = null,$totales = null,$color_totales = null,$breadcrumbs,$titulo_vista = null,$membrete = null,$ruta_imagen)
   {

        /* 
            ============================ LEYENDA =================================== 
                                
                                        (-- FORMULARIO --)

            enctype : *| Si es true el formulario puede mandar imagenes |*,

            f_store : *| función a donde va el post, si es nulo va a store |*,

            $campos : *| 

                         array de los campos del formulario, cada campo es un array dentro de un array padre.
                         Ejemplo : [ [] , [], [] ]

                         Campos de los arrays:

                         $a[0] = medida de espacios desde xs hasta lg separados por comas,
                         $a[1] = Nombre del label,
                         $a[2] = Tipo de campo (
                                                    1: texto, 2:number, 3: select de array objetos, 4: select de array normal
                                                    5: radio, 6: checkbox, 7: textarea, 8:date, 9: tlf, 10: hidden, 11: file
                                                )
                         
                         $a[3] = requerido si es 1 

                         $a[4] = id y name del input, (si es un check o radio se pasa un array con los datos de cada input,
                                                    ejemplo: 

                                                    [
                                                        ['Sexo',3,1, 
                                                            [
                                                                (label y id del radio o check), 
                                                                (name), 
                                                                valor de radio, 
                                                                checked:
                                                                (si se pasa este valor se checkeara el input de lo contrario no se pasa nada),
                                                                tabla 
                                                            ]
                                                        ]
                                                    ]


                                                 )

                         $a[5] = placeholder

                         $a[6] = valor de input

                         $a[7] = si es un select este seria el array de los options

                         $a[8] = el nombre de la key del campo que mostrar en el los options, (por default el campo id va de value en los options). Si $a[5] es contrario de vacio o null se hara match del id con el valor pasado y el coincidente sera selected por default

                         $a[9] = el campo se convierte en un array si existe. (multiple)


                      *| 

                                            (-- TABLA --)


            data       : *| data de la base de datos del dataTable |*

            th         : *| Nombre de los campos en la tabla |*

            key_data   : *| arreglo de las keys del foreach de data en el dataTable, ejemplo: ['id_permiso','nombre'] |*

            totales    : *| arreglo para mostrar los totales de la vista, ejemplo: ['compras' => 80,'inventario' => 100] |*  

            color_totales: *| string del color de los botones de totales |*

            breadcrumbs: *| indicatorio de que vista esta, ejemplo: ['censo', 'padre_familia', 'registrar_padre_familia'] |*

            titulo_vist: *| Título de la vista en la caja de texto |*

            membrete   : *| Si se manda true mostrara el membrete de la vista con el nivel de acceso del trabajador |*

            controlador: *| Si es null es el controlador maestro, si es true se usa el controlador en cuestión |* 
        */

        // ================================ SECCIÓN TABLA ====================================================


        $clase_bd_1 = session('tipo_db') == 1 ? 'primary' : 'default';
        $clase_bd_2 = session('tipo_db') == 2 ? 'primary' : 'default';
        $clase_bd_3 = session('tipo_db') == 3 ? 'primary' : 'default';


        $url = '';
        
        if( strpos($_SERVER['HTTP_HOST'],'herokuapp.com') === false)
        {

            $url = explode('/', $_SERVER['REQUEST_URI']);
            if(count($url) > 2){
              $url = array_slice($url, 3,2);
                $url = implode('/', $url);
                $url = explode('?', $url)[0];
            }else{
                $url = array_slice($url, 1,1);
                $url = implode('/', $url);
                $url = explode('?', $url)[0];
            }
                
        }
        else
        {
            $url = explode('/', $_SERVER['REQUEST_URI']);

            $url = array_slice($url, 1,1);

            $url = implode('/', $url);
            $url = explode('?', $url)[0];
        }

        $ruta = $url;

        $ruta_acciones = asset('/assets_sistema/images/acciones/').'/';

        $ruta_acciones = str_replace('\\', '/', $ruta_acciones);

        $color_totales = $color_totales ? $color_totales : 'pink';

        $boton_header = '';
        $boton_accion = '';

        $membrete_html = '';
        $totales_html = '';
        $keys_tabla   = '';
        $cuerpo_tabla = '';
        $breadcrumbs_html = '<div class="breadcrumbs ace-save-state" id="breadcrumbs">
                                <ul class="breadcrumb">
                                    <li>
                                        <i class="ace-icon fa fa-home home-icon"></i>
                                        <a href="#">Sistema</a>
                                    </li>';
        $html_header = '';

        $html_body = '';


// ================================= | MEMBRETE | ============================================================                  

    if($membrete === 't')
    {
        $membrete_html = '  <div class="page-header text-center">
                                <li class="bigger-200 '.$color_totales.'">
                                    <i class="ace-icon fa fa-circle"></i>
                                    '.session('membrete').'
                                    <br>
                                </li>
                            </div><!-- /.page-header -->';
    }           

// ================================= | TOTALES DE LA VISTA | ============================================================

        foreach ($totales as $key => $row) {

            $totales_html.='    <button class="btn btn-app btn-'.$color_totales.' no-radius" data-tool="tooltip" title="total '.$key.'">
                            <i class="ace-icon fa fa-pencil-square-o bigger-230"></i>
                                '.$key.'
                            <span class="badge badge-warning badge-left">'.$row.'</span>
                        </button>';
        }
// ================================== | BREADCRUMBS | ==========================================================
        $con_bread = 1;
        foreach ($breadcrumbs as $row) 
        {
            
            if($con_bread === count($breadcrumbs))
            {
                $breadcrumbs_html.='<li class="active">'.$row.'</li>';
            }
            else
            {

                $breadcrumbs_html.='<li><a href="#">Configuración</a></li>';
            }

            $con_bread++;
        }

        $breadcrumbs_html.='</ul></div><!-- /.breadcrumb -->';

// =============================== | NOMBRE DE LOS CAMPOS EN LA TABLA | ========================================
        
        foreach ($th as $row) {
            $keys_tabla.='<th class="text-center text-primary">'.ucwords($row).'</th>';
        }

// =============================== | BOTONES PERMISOS TABLA | ==================================================

        $result = PermisoAccion::all_access(base64_decode(session('id_menu')));

        if($result->n_accion)
        {
          
           $boton_header .= '<button type="button" class="btn btn-app btn-success no-radius pull-right" data-tool="tooltip" title="Crear nuevo registro" id="btn_table_helper_new" data-ruta="'.url($ruta).'">
                                <i class="ace-icon fa fa-plus bigger-230"></i>
                                Nuevo
                            </button>';
        }

        if($result->r_accion)
        {
            $boton_header .= '<a class="btn btn-warning btn-app pull-right" data-tool="tooltip" title="PDF de toda la data" href="'.$ruta.'/pdf_general">
                                <i class="ace-icon fa fa-file-pdf-o bigger-230"></i>
                                PDF
                              </a>';    
        }

// =============================== | DATA DE LA TABLA | ========================================================
        
        foreach ($data as $key => $row) {

            $boton_accion = '';

            if($result->m_accion)
            {
                // botón modificar

                $data_attr = '';

                foreach ($campos as $row1) 
                {   
                    
                    if(!is_array($row1[3]) && isset($row1[6]) && !is_array($row1[6]))
                    {
                        $data_attr .= ' data-'.$row1[3].'="'.$row->{$row1[3]}.'"' ;
                    }
                    elseif(isset($row1[6]) && is_array($row1[6]))
                    {
                        $data_attr .= ' data-'.$row1[3].'_select="'.$row->{$row1[3]}.'"';       
                    }
                    else if(is_array($row1[3]))
                    {
                        foreach ($row1[3] as $row2) 
                        {
                            $data_attr .= ' data-'.$row2[1].'_check_radio="'.$row->{$row2[1]}.'"';       
                        }
                    }
                    else
                    {
                        $data_attr .= ' data-'.$row1[3].'="'.$row->{$row1[3]}.'"' ;
                    }
                }

                $data_attr.=' data-ruta="'.url($ruta.'/'.$row->id).'"';

                $boton_accion .= '<a data-tool="tooltip" title="modificar" href="#" '.$data_attr.'>
                                    <img src="'.$ruta_acciones.'modificar.png'.'" width="20px" class="modificar_btn_helper" />
                                </a>';
            }

            if($result->v_accion)
            {
                $boton_accion .= '<a data-tool="tooltip" title="Ver Detalles" href="'.url($ruta.'/'.$row->id).'">
                                    <img src="'.$ruta_acciones.'ver.jpg'.'" width="20px" />
                                </a>';  
            }

            if($result->e_accion)
            {
                $boton_accion .= '<a href="#" data-tool="tooltip" title="Eliminar" class="eliminar_btn_helper" data-ruta="'.url($ruta.'/'.$row->id).'">
                                    <img src="'.$ruta_acciones.'remover.jpg'.'" width="20px" />
                                </a>';  
            }

            if($result->i_accion)
            {
                $boton_accion .= '<a data-tool="tooltip" title="Imprimir Registro" href="'.$ruta.'/pdf_singular/'.$row->id.'">
                                    <img src="'.$ruta_acciones.'imprimir.jpg'.'" width="20px" />
                                </a>';  
            }

            $cuerpo_tabla.='<tr><td>'.$boton_accion.'</td>';

            foreach ($key_data as $row1) 
            {
               if($row->{$row1} === TRUE)
                {
                    $on_off = '<img width="35px" src="'.asset("assets_sistema/images/gallery/activo.jpg").'" data-tool="tooltip" title="Activo"/>';

                    $cuerpo_tabla.='<td>'.$on_off.'</td>';

                }
                else if($row->{$row1} === FALSE)
                {
                    $on_off = '<img width="35px" src="'.asset("assets_sistema/images/gallery/desactivado.png").'" data-tool="tooltip" title="Desactivado" />';

                    $cuerpo_tabla.='<td>'.$on_off.'</td>';
                    
                }
                else if($row->{$row1} === 'MASCULINO')
                {
                    $masculino = '<img width="35px" src="'.asset("assets_sistema/images/avatars/avatar3.png").'" data-tool="tooltip" title="MASCULINO"/>';

                    $cuerpo_tabla.='<td>'.$masculino.'</td>';

                }
                else if($row->{$row1} === 'FEMENINO')
                {
                    $femenino = '<img width="35px" src="'.asset("assets_sistema/images/avatars/avatar4.png").'" data-tool="tooltip" title="FEMENINO"/>';

                    $cuerpo_tabla.='<td>'.$femenino.'</td>';
                }
                else if( strpos($row->{$row1}, 'jpg') || strpos($row->{$row1}, 'png'))
                {
                    $imagen_campo = '
                    <a href="'.base_url().$ruta_imagen.$row->{$row1}.'" target="_blank">
                    <img width="40px" src="'.base_url().$ruta_imagen.$row->{$row1}.'" data-tool="tooltip" title=""/>
                    </a>';

                    $cuerpo_tabla.='<td>'.$imagen_campo.'</td>';
                }
                else if( strpos($row->{$row1}, 'pdf'))
                {
                    $imagen_campo = '
                    <a href="'.base_url().$ruta_imagen.$row->{$row1}.'" target="_blank">
                    <img width="40px" src="'.base_url().'assets_sistema/images/acciones/reporte.jpg" data-tool="tooltip" title=""/>
                    </a>';

                    $cuerpo_tabla.='<td>'.$imagen_campo.'</td>';
                }
                else
                {
                    $cuerpo_tabla.='<td>'.$row->{$row1}.'</td>';
                }
                
            }

            $cuerpo_tabla.='</tr>';
        }

// ================================ | HTML DE LA VISTA TABLA | =================================================================

        $html_header .= $breadcrumbs_html.'
                '.$membrete_html.'
                    <div class="row no-gutters" id="div_table_helper">
                        <div class="col-md-12 col-sm-12">
                            <div class="widget-box">
                                <div class="widget-header">
                                    <h3 class="widget-title">
                                        '.$titulo_vista.'
                                    </h3>
                                </div>
                                <div class="widget-body">
                                    <div class="widget-main">
                                        <div class="row no-gutters">
                                        </div>';
        $html_body.= '
                
                                    <div class="row no-gutters">
                                        <div class="col-sm-12 col-md-12">
                                            '.$totales_html.'
                                            '.$boton_header.'
                                        </div>
                                        <div class="clearfix"></div>
                                        <br/>
                                        <div class="col-sm-12 col-md-12">
                                            <table class="table table-bordered table-hover table-responsive" id="tabla">
                                                <thead>
                                                    <tr>
                                                        '.$keys_tabla.'
                                                    </tr>
                                                </thead>
                                                <tbody class="text-center">
                                                    '.$cuerpo_tabla.'
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>  
                        </div>
                    </div>
                </div>';


        // ============================-==== SECCIÓN FORMULARIO ====================================================

        $store =  $f_store ? $f_store : $url;

        $enctype_html = $enctype ? 'enctype="multipart/form-data"' : null;

        $html = '
            <div class="row no-gutters hidden" id="div_form_helper">
                    <div class="col-md-12 col-sm-12">
                        <div class="widget-box">
                            <div class="widget-header">
                                <h3 class="widget-title">
                                   Crear '.$titulo_vista.'
                                </h3>
                            </div>
                            <div class="widget-body">
                                <div class="widget-main">    
                                    <div class="row no-gutters">
                                        <form class="" id="form_registro" method="POST" '.$enctype_html.' action="'.url($store).'">
                                        '.csrf_field().'
                                        <div class="col-md-12 col-sm-12">
                                            <button type="button" class="btn btn-app btn-default no-radius" data-tool="tooltip" title="Volver a los Registros" id="btn_form_helper_back">
                                                <i class="ace-icon fa fa-refresh bigger-230"></i>
                                                Registros
                                            </button>
                                            <button class="btn btn-app btn-pink no-radius" type="submit">
                                                <i class="ace-icon fa fa-fire bigger-230"></i>
                                                Guardar
                                            </button>
                                        </div>
                                        <div class="clearfix"></div>
                                        <br/>';
        
        $con_boxes = 0;
        foreach ($campos as $row) 
        {   
            $cols = explode(',', $row[0]);

            $required = $row[3] ? 'required=""' : '';

            $name     = is_array($row[4]) ? '' : 'name="'.$row[4].'"';

            $id       = is_array($row[4]) ? '' : 'id="'.$row[4].'"';

            $name_id_r    = $name.' '.$id.' '.$required;
            
            $required_html  = $row[3] ? '<span class="badge badge-transparent"><i class="light-red ace-icon fa fa-asterisk"></i></span>' : '';

            $placeholder = isset($placeholder) && !empty($row[5]) && $row[5] !== null ? $row[5] : '';


            /*if($con_boxes === 0)
            {
                $html.='<div class="row no-gutters">';
            }*/
            
            $clase_boostrap = 'col-xs-'.$cols[0].' col-sm-'.$cols[1].' col-md-'.$cols[2].' col-lg-'.$cols[3];
            $html.='
                    <div class="'.$clase_boostrap.'">
                    <div class="form-group">
                    <label class="control-label">'.$row[1].$required_html.'</label>
                        ';
            
            

            switch ($row[2]) {
                case 1:
                    
                    $valor = isset($row[6]) ? $row[6] : '';

                    $html.='<input type="text" class="form-control" placeholder="'.$placeholder.'" '.$name_id_r.' value="'.$valor.'" />
                    ';
                break;

                case 2:
                    $valor = isset($row[6]) ? $row[6] : '';

                    $html.='<input type="number" placeholder="'.$placeholder.'" class="form-control" '.$name_id_r.' value="'.$valor.'" />
                    ';
                break;

                case 3:

                    $options = '';

                    foreach ($row[7] as $op) {
                        
                        $selected = $op->id === $row[6] ? 'selected=""' : '';

                        $options.='<option value="'.$op->id.'">'.$op->{$row[8]}.'</option>';
                    }

                    $html.= '
                        <select class="select2 form-control" '.$name_id_r.' style="width: 100%;">
                            <option disabled="" selected="">'.$placeholder.'</option>
                            '.$options.'
                        </select>
                    ';  
                break;

                case 4:
                    $options = '';

                    foreach ($row[7] as $op) {
                        
                        $selected = $op['id'] === $row[6] ? 'selected=""' : '';

                        $options.='<option value="'.$op['id'].'" '.$selected.'>'.$op[$row[8]].'</option>';
                    }

                    $html.= '
                        <select class="select2 form-control" '.$name_id_r.' style="width: 100%;">
                            <option disabled="" selected="">'.$placeholder.'</option>
                            '.$options.'
                        </select>
                    ';
                break;

                case 5:

                    $con = 0;
                    
                    foreach ($row[4] as $rad) 
                    {
                        # code...
                        if(isset($rad[4]))
                        {
                            $result = DD::select( DB::raw( base64_decode($rad[4]) ) );

                            foreach ($result as $row_radio) 
                            {
                                if($con === 0)
                                {
                                    $html.='<div class="row">';
                                }

                                $checked = isset($rad[3]) && $row_radio->id === $rad[3] ? 'checked=""' : '';

                                $html.= '<div class="col-sm-3 col-md-3">
                                            <label class="radio-inline" for="'.$row_radio->{$rad[0]}.$row[1].'">
                                                <input type="radio" id="'.$row_radio->{$rad[0]}.$row[1].'" name="'.$rad[1].'" '.$required.' value="'.$row_radio->id.'"
                                                '.$checked.' />
                                                '.$row_radio->{$rad[0]}.'
                                            </label>
                                        </div>';
                                $con++;

                                if($con === 4)
                                {
                                    $html.='</div>';
                                    $con = 0;
                                }

                            }
                        }
                        else
                        {

                            if($con === 0)
                            {
                                $html.='<div class="row">';
                            }

                            $checked = isset($rad[3]) && $rad[2] === $rad[3] ? 'checked=""' : '';

                            $html.= '<div class="col-sm-3 col-md-3">
                                        <label class="radio-inline" for="'.$rad[0].$row[1].'">
                                            <input type="radio" id="'.$rad[0].$row[1].'" name="'.$rad[1].'" '.$required.' value="'.$rad[2].'"
                                            '.$checked.' />
                                            '.$rad[0].'
                                        </label>
                                    </div>';
                            $con++;

                            if($con === 4)
                            {
                                $html.='</div>';
                                $con = 0;
                            }
                        }
                    }

                    if($con > 0 &&  $con < 4)
                    {
                        $html.='</div>';
                    }
                        
                break;

                case 6:
                    
                    $con = 0;

                    foreach ($row[4] as $che) 
                    {
                        if(isset($che[4]))
                        {
                            $result = DB::select( DB::raw( base64_decode($che[4]) ) );

                            foreach ($result as $row_check) 
                            {
                                if($con === 0)
                                {
                                    $html.='<div class="row">';
                                }

                                $checked = isset($che[3]) && $row_check->id === $che[3] ? 'checked=""' : '';

                                $html.= '<div class="col-sm-3 col-md-3">
                                            <label class="inline">
                                                <small class="muted smaller-90">'.$row_check->{$che[0]}.':</small>
                                                <input id="id-button-borders" type="checkbox" class="ace ace-switch ace-switch-5" id="'.$row_check->{$che[0]}.$row[1].'" name="'.$che[1].'" value="'.$row_check->id.'" '.$checked.' />
                                                <span class="lbl middle"></span>
                                            </label>
                                        </div>';
                                $con++;

                                if($con === 4)
                                {
                                    $html.='</div>';
                                    $con = 0;
                                }

                            }
                        }
                        else
                        {
                            if($con === 0)
                            {
                                $html.='<div class="row">';
                            }

                            $checked = isset($che[3]) && $che[2] === $che[3] ? 'checked=""' : '';

                            $html.= '<div class="col-sm-3 col-md-3">
                                        <label class="inline">
                                            <small class="muted smaller-90">'.$che[0].$row[1].':</small>
                                            <input id="id-button-borders" type="checkbox" class="ace ace-switch ace-switch-5" id="'.$che[0].$row[1].'" name="'.$che[1].'" value="'.$che[2].'" '.$checked.' />
                                            <span class="lbl middle"></span>
                                        </label>
                                    </div>';
                            $con++;

                            if($con === 4)
                            {
                                $html.='</div>';
                                $con = 0;
                            }
                        }

                            
                    }

                    if($con > 0 &&  $con < 4)
                    {
                        $html.='</div>';
                    }

                break;

                case 7:
                    $valor = isset($row[6]) ? $row[6] : '';
                    $html.='<textarea class="form-control" '.$name_id_r.' placeholder="'.$placeholder.'" row="2">'.$valor.'</textarea>';
                break;

                case 8:
                    $valor = isset($row[6]) ? $row[6] : '';

                    $html.='<input type="date" class="form-control" '.$name_id_r.' value="'.$valor.'" />
                    ';
                break;

                case 9:
                    $valor = isset($row[6]) ? $row[6] : '';

                    $html.='<input type="text" placeholder="'.$placeholder.'" class="form-control input-mask-phone" '.$name_id_r.' value="'.$valor.'" />
                    ';
                break;

                case 10: 
                    $valor = isset($row[6]) ? $row[6] : '';
                    $html.='<input type="hidden" class="" '.$name_id_r.' value="'.$valor.'" />';
                break;

                case 11: 
                    $valor = isset($row[6]) ? $row[6] : '';
                    $html.='<input type="file" '.$name_id_r.' /> <br/> <img src="'.asset('assets_sistema/images/archivos_usuarios/'.$valor).'" alt="" with="80px" />';

                break;

                case 12: 
                    $valor = isset($row[6]) ? $row[6] : '';
                    $html.='<input type="color" '.$name_id_r.' class="form-control" value="'.$valor.'"/>';

                break;

                case 13: 
                    $valor = isset($row[6]) ? $row[6] : '';

                    $html.='<input type="email" class="form-control" placeholder="'.$placeholder.'" '.$name_id_r.' value="'.$valor.'" />
                    ';

                break;

            } // fin swicth

            $html.=' </div>
                    </div>'; // cierre form group y div cols de espacio

            $con_boxes++;

            /*if($con_boxes === 2)
            {
                $con_boxes = 0;

                $html.='</div>';
            }*/
        } // fin foreach

        /*if($con_boxes > 0 && $con_boxes < 2)
        {
            $html.='</div>'; // cierre del row
        }*/

        $html.='
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>';

        $html_header.= $html_body;

        $html_header.= $html;

        $html_form_delete = "<form id='form_eliminar_helper' action='' method='POST'>"
                              .method_field('DELETE')."<br/>".csrf_field().
                            "</form>";

        $html_header.= $html_form_delete;

        return $html_header;

   } 

?>