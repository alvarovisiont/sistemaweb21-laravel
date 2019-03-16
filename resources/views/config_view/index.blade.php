@extends('layout.app')

@section('content')
  @php
    $string_cols = "12,6,6,6";

    $campos = [
      [$string_cols,'Proyecto',1,1,'proyecto','Por favor Introduzca el Nombre del Proyecto'],
      [$string_cols,'Sección',1,0,'section','Por favor Introduzca el Nombre de la Sección del Proyecto'],
      [$string_cols,'Modulo',1,1,'modulo','Por favor Introduzca el Nombre del Módulo'],
      [$string_cols,'Tabla',1,1,'tabla','Nombre de la Tabla a consultar'],
      [$string_cols,'Titulo',1,1,'titulo','Titulo de la Tabla en la Vista'],
      [$string_cols,'Breadcrumbs',1,1,'breadcrumb','Locación actual del sistema, separado por comas'],
      [$string_cols,'Registros Permitidos',2,1,'registros_permitidos','Si es 0 cantidad indefinida'],
      [$string_cols,'Ruta Imagen',1,0,'ruta_imagen','Ruta para guardar Imagenes de este módulo'],
      [$string_cols,'Activo',5,1,
        [
          ['Si','activo',true],
          ['No','activo',0]
        ]
      ],
      [$string_cols,'Enctype',5,1,
        [
          ['Si','enctype',true],
          ['No','enctype',0]
        ]
      ],
      [$string_cols,'Membrete',5,1,
        [
          ['Si','membrete',true],
          ['No','membrete',0]
        ]
      ]
    ];

    $th = [['',[]],['Proyecto',[]],['Módulo',[]],['tabla',[]],['titulo',[]],['Ruta Imagen',[]]];
    
    $keys_data = [['proyecto',1,0,[]],['modulo',0,0,[]],['tabla',1,0,[]],['titulo',0,0,[]],['ruta_imagen',0,0,[]]];

    $totales = ['Vistas' => count($data)];

    $color   = 'pink';

    $titulo  = 'Vistas del Sistema';

    $bread = ['Configuración','Vistas'];

    $route_image = '';

    echo form_vista(null,'',$campos, $data,$th,$keys_data,$totales,$color,$bread,$titulo,null,'t',$route_image); 
  @endphp
@endsection

@section('scripts')
@endsection