@extends('layout.app')

@section('content')


<div class="page-header">
  <h1>
    Dashboard
    <small>
      <i class="ace-icon fa fa-angle-double-right"></i>
      Configuración
    </small>
  </h1>
</div><!-- /.page-header -->


 <form action="{{ url($url) }}" method="post" enctype="multipart/form-data">

  {{ csrf_field() }}
  
  @if(isset($edit))
    {{ method_field('PATCH') }}
  @endif

  <input type="hidden" id="imagen" name="imagen" value="avatar.png">

  <div class="col-xs-12 col-sm-4">
    <div class="widget-box">
      <div class="widget-header">
        <h4 class="widget-title">Imagen Vista Previa</h4>
      </div>  
       <div class="widget-body">
         <div class="widget-main">
          <ul class="ace-thumbnails clearfix text-center" style="list-style-type: none;">
            <li class="">   
              <a id="ref_login" href="{{ asset('assets_sistema/images/avatars/avatar.png') }}" data-rel="colorbox" class="text-center">
                <img id = "imagen_login" name= "imagen_login" width="170" height="170" alt="170x170" src="{{ asset('assets_sistema/images/avatars/'.$imagen) }}"/>
                <div class="text">
                  <div class="inner">Imagenes</div>
                </div>
              </a>
            </li>
            <a href="#" class="btn btn-app btn-purple" data-toggle='modal' data-target='#modal_perfil'>
              <i class="ace-icon fa fa-refresh bigger-230"></i>
              Cambiar
            </a>
          </ul>       
        </div>
      </div>
    </div>
  </div>
  <div class="col-xs-12 col-sm-4">
    <div class="widget-box">
      <div class="widget-header">
        <h4 class="widget-title">Tipo de Usuario
      </div>  

      <div class="widget-body">
        <div class="widget-main">
          <div>
            <label for="form-field-select-1">Seleccione</label>
            <span class="badge badge-transparent">
              <i class="light-red ace-icon fa fa-asterisk"></i>
            </span>
            <select class="form-control" id="id_permiso" name="id_permiso">
              @foreach($perfil as $row)
                <option value="{{ $row->id }}" {{ $user && $user->id_permiso === $row->id ? 'selected' : '' }}>
                  {{ $row->nombre }}
                </option>
              @endforeach
            </select>
          </div> 
        </div>
      </div>
    </div>

    <div class="widget-box">
        <div class="widget-header">
          <h4 class="widget-title">Login</h4>
        </div>  
         <div class="widget-body">
           <div class="widget-main">
            <div>
              <label for="form-field-select-1">Requerido</label>
              <span class="badge badge-transparent">
                <i class="light-red ace-icon fa fa-asterisk"></i>
              </span>
                  <input type="text" class="form-control" placeholder="Login" name="login" id="login" required="true" allow-pattern="[a-z A-Z 0-9]" value="{{ $user ? $user->login : '' }}">
               </div> 
             </div>
          </div>
        </div>

        <div class="widget-box">
        <div class="widget-header">
          <h4 class="widget-title">Correo</h4>
        </div>  
        <div class="widget-body">
        <div class="widget-main">

        <label for="form-field-select-1">Requerido</label>
              <span class="badge badge-transparent">
                <i class="light-red ace-icon fa fa-asterisk"></i>
              </span> <br>  
          <span class="input-icon">
            <input type="email" placeholder="Email" name="email" id="email" class="form-control" required="true" onchange="correo()"/ value="{{ $user ? $user->email : '' }}">
          <i class="ace-icon fa fa-envelope"></i>
        </span>
        
           </div>
         </div>
        </div>
       </div>

        <div class="col-xs-12 col-sm-4">

           <div class="widget-box">
        <div class="widget-header">
          <h4 class="widget-title">Cédula</h4>
        </div>  
         <div class="widget-body">
           <div class="widget-main">
            <div>
              <label for="form-field-select-1">Requerido</label>
              <span class="badge badge-transparent">
                <i class="light-red ace-icon fa fa-asterisk"></i>
              </span>
                  <input type="text" class="form-control" placeholder="Cédula" name="cedula" id="cedula" required="true" value="{{ $user ? $user->cedula : '' }}">
               </div> 
             </div>
          </div>
        </div>
      
       
       <div class="widget-box">
        <div class="widget-header">
          <h4 class="widget-title">Nombre y Apellido</h4>
        </div>  
         <div class="widget-body">
           <div class="widget-main">
            <div>
              <label for="form-field-select-1">Requerido</label>
              <span class="badge badge-transparent">
                <i class="light-red ace-icon fa fa-asterisk"></i>
              </span>
                <input type="text" class="form-control" placeholder="Nombre" name="nombre" id="nombre" required="true" value="{{ $user ? $user->nombre : '' }}">
               </div> 
               <div> <br>
                <input type="text" class="form-control" placeholder="Apellido" name="apellido" id="apellido" required="true" value="{{ $user ? $user->apellido : '' }}">
               </div> 
             </div>
          </div>
        </div>
     </div>
     
     <br/><br/>
     <div class="col-xs-12 text-center">
        <button class="btn btn-rose btn-md radius-4">
          <i class="ace-icon fa fa-floppy-o bigger-160"></i>
          Guardar Cambios
      </button>
     </div>           
</form>

<div id="modal_perfil" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header modalHeader">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <h4 class="modal-title">Agregar Imagen Perfil</h4>
            </div>
            <form action="" class="form-horizontal" id="form_perfil" method="POST">
             
                <div class="form-group">
                  <div class="modal-body">
          <div class="col-md-12 col-sm-12">
                  
                  <?php for ($i = 1; $i <= 11; $i++) { ?>

                  <img id = "imagen_ciclo" name = "imagen_ciclo" width="50" height="50" alt="50x50" src="{{ asset('assets_sistema/images/avatars/avatar'.$i.'.png') }}" onclick="activate_match({{ $i }})"/>
                    <?php }?>

                </div>
              </div><!-- fin modal-body -->
             

              </div><!-- fin modal-body -->
              <div class="modal-footer">
                
                  <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
              </div>
            </form>
        </div><!-- fin modal-content -->
    </div><!-- fin modal-dialog -->
</div> <!-- fin modal -->

@endsection

@section('scripts')
   <script>
      function activate_match($i)
      {
        var id = $i;
        var ruta =  "{{ asset('assets_sistema/images/avatars/avatar') }}"+id+".png";
        document.getElementById('imagen_login').src = ruta;
        document.getElementById('ref_login').href = ruta;
        document.getElementById('imagen').value = "avatar"+id+".png";
      }

      function correo()
      {
        var correo = document.getElementById("email").value; 

       <?php foreach ($arr_usuarios as $valor)
        { ?>
            var xvariable = "<?php echo $valor->email;?>";

            if (xvariable.trim() == correo.trim() ){
              alert(xvariable+"---->"+correo);
            }

        <?php }?>  
      }
   </script>
       
@endsection