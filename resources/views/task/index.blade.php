 
@extends("layout.app")
@section("content")
  
  @php
    $th = [["Acción",[]],['Descripción',[]],['Estado',[]],['Activo',[]]];

    $key_data = [['description',0,0,[]],['state',1,0,[]],['activo',0,0,[]]];

    $titulo ='Tareas Pendientes';

    $bread = ['Tareas'];

    $color = "pink";

    $membrete = '';

    $totales = [];

    $ruta_imagen = "";

    $enctype = "";

    echo form_vista($enctype,null,$campos, $data,$th,$key_data,$totales,$color,$bread,$titulo,$membrete,$ruta_imagen); 

  @endphp
@endsection

@section("scripts")
  <script>
    $(function(){

    })
  </script>
@endsection
