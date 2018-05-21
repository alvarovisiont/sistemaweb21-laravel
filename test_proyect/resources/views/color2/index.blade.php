 
  <? 
    @extends("layout.app")
    @section("content")

      $th = ["Acción",'Color'];

      $key_data = ['nombre'];

      $titulo ='Colores del Sistema';

      $bread = ['Configuración/Color'];

      $color = "pink";

      $membrete = '';

      $totales = [];

      $ruta_imagen = "sets_sistema/images/color/";

      $enctype = "";

      echo form_vista($enctype,null,$campos, $data,$th,$key_data,$totales,$color,$bread,$titulo,$membrete,$ruta_imagen); 
    @endsection

    @section("scripts")
      <script>
        $(function(){

        })
      </script>
    @endsection
  ?>