@extends('layout.app')

@section('content')

<div class="breadcrumbs ace-save-state" id="breadcrumbs">
  <ul class="breadcrumb">
    <li>
      <i class="ace-icon fa fa-home home-icon"></i>
      <a href="#">Sistema</a>
    </li>

    <li>
      <a href="#">Configuración</a>
    </li>
    <li class="active">Configuración Login</li>
  </ul><!-- /.breadcrumb -->          
</div>

<div class="page-header">
  <h1>
    Dashboard
    <small>
      <i class="ace-icon fa fa-angle-double-right"></i>
      Configuración
    </small>
  </h1>
</div><!-- /.page-header -->

<div class="row no-gutters">
    <div class="col-md-10 col-sm-10">

      <a href="{{ route('config.index', ['tipo_db' => 1]) }}" 
        class="btn btn-app btn-{{ session('tipo_db') === '1' ? 'primary':'default' }}">
        <i class="ace-icon fa fa-tachometer bigger-250"></i>Default&nbsp;
      </a>
    
      <a href="{{ route('config.index', ['tipo_db' => 2]) }}" 
        class="btn btn-app btn-{{ session('tipo_db') === '2' ? 'primary':'default' }}">
        <i class="ace-icon fa fa-eye bigger-250"></i>Admin&nbsp;
      </a>
    </div>
</div>


 <form action="{{ url('config/'.$id) }}" method="POST" enctype="multipart/form-data">
    
    {{ csrf_field() }}
    {{ method_field('PATCH') }}

    <div class="col-xs-12 col-sm-4">
        <div class="widget-box">
          <div class="widget-header">
            <h4 class="widget-title">Tipo de logueo
          </div>  

          <div class="widget-body">
            <div class="widget-main">
              <div>
                <label for="form-field-select-1">Seleccione</label>
                <span class="badge badge-transparent">
                  <i class="light-red ace-icon fa fa-asterisk"></i>
                </span>
                <select class="form-control" id="login" name="login"
                onchange="activate_match()">
                  <?php for ($i = 1; $i <= 6; $i++) { 
                  ?>
                    <option value="{{ $i }}" {{ $datos->login && $datos->login === $i ? 'selected' : '' }}> Tipo <?php echo $i;?> </option>     
                  <?php } ?>            
                </select>
              </div> 
            </div>
          </div>
        </div>

        <div class="widget-box">
          <div class="widget-header">
            <h4 class="widget-title">Imagen Vista Previa</h4>
          </div>  
          <div class="widget-body">
            <div class="widget-main">
              <ul class="ace-thumbnails clearfix text-center" style="list-style-type: none;">
                <li class="">   
                  <a id="ref_login" href="{{ asset('assets_sistema/images/gallery/login/login'.$datos->login.'.jpg') }}" data-rel="colorbox" class="text-center">      
                    <img id="imagen_login" width="200" height="170" alt="200x170" src="{{ asset('assets_sistema/images/gallery/login/login'.$datos->login.'.jpg') }}"/>    
                    <div class="text">
                      <div class="inner">Imagenes pichurri</div>
                    </div>
                  </a>
                </li>
              </ul>       
            </div>
          </div>
        </div>
              <div class="widget-box">
              <div class="widget-header">
                <h4 class="widget-title">Tipo Login</h4>
              </div>  
               <div class="widget-body">
                 <div class="widget-main">
                  <div class="row">
                    <div class="col-sm-6 col-md-6">
                      <label class="radio-inline" for="email">
                        <input type="radio" id="email" name="acceso" value="1"
                        <?= $datos->acceso === 1 ? 'checked=""' : '' ?>
                        />
                        Email
                      </label>
                    </div>
                    <div class="col-sm-6 col-md-6">
                      <label class="radio-inline" for="username">
                        <input type="radio" id="username" name="acceso" value="2" 
                        <?= $datos->acceso === 2 ? 'checked=""' : '' ?>
                        />
                        Username
                      </label>
                    </div>
                  </div>
                </div>
                </div>
              </div>
             </div> <!-- fin div col-xs-12 -->

            <div class="col-xs-12 col-sm-4">
              <div class="widget-box">
              <div class="widget-header">
                <h4 class="widget-title">
                  Imagen Complementaria
                  
                  @if($datos->imagen)
                    <button class="btn btn-danger btn-md remove_img_plantilla_img pull-right" 
                    type="button"
                    data-id="{{ $datos->id }}"
                    data-ref="complemento"
                    data-tool="tooltip"
                    title="Remover Imagen"
                    data-img="{{ $datos->imagen }}"
                    >
                      <i class="fa fa-remove"></i>
                    </button>
                  @endif
                </h4>
              </div>  
               <div class="widget-body">
                 <div class="widget-main">
                  <div>
                    <input type="file" name="imagen">
                     </div> 
                     <div>
                      <ul class="ace-thumbnails clearfix text-center" style="list-style-type: none;">
                      <li class="">   
                        <a id="ref_complemento" href="{{ asset('assets_sistema/images/gallery/complementos_login/'.$datos->imagen)}}" data-rel="colorbox" class="text-center">
                          <img id="imagen_complemento" width="200" height="170" alt="200x170" src="{{ asset('assets_sistema/images/gallery/complementos_login/'.$datos->imagen)}}"/>
                          <div class="text">
                            <div class="inner">Imagenes pichurri</div>
                          </div>
                        </a>
                      </li>
                    </ul>
                     </div>
                   </div>
                </div>
              </div>
              <div class="widget-box">
              <div class="widget-header">
                <h4 class="widget-title">
                  Imagen Cintillo
                  
                  @if($datos->cintillo)
                    <button class="btn btn-danger btn-md remove_img_plantilla_img pull-right" 
                    type="button"
                    data-id="{{ $datos->id }}"
                    data-ref="cintillo"
                    data-tool="tooltip"
                    title="Remover Imagen"
                    data-img="{{ $datos->cintillo }}"
                    >
                      <i class="fa fa-remove"></i>
                    </button>
                  @endif
                </h4>
              </div>  
               <div class="widget-body">
                 <div class="widget-main">
                  <div>
                    <input type="file" name="cintillo">
                     </div> 
                     <div>
                      <ul class="ace-thumbnails clearfix text-center" style="list-style-type: none;">
                      <li class="">   
                        <a id="ref_cintillo" href="{{ asset('assets_sistema/images/gallery/complementos_login/'.$datos->cintillo) }}" data-rel="colorbox" class="text-center">
                          
                          <img id ="imagen_cintillo" width="200" height="170" alt="200x170" src="{{ asset('assets_sistema/images/gallery/complementos_login/'.$datos->cintillo) }}"/>
                          
                          <div class="text">
                            <div class="inner">Imagenes pichurri</div>
                          </div>
                        </a>
                      </li>
                    </ul>
                     </div>
                   </div>
                </div>
              </div>
          </div>
          <div class="col-xs-12 col-sm-4">
            <div class="widget-box">
              <div class="widget-header">
                <h4 class="widget-title">
                  Logo Reportes
                  @if($datos->logo)
                    <button class="btn btn-danger btn-md remove_img_plantilla_img pull-right" 
                    type="button"
                    data-id="{{ $datos->id }}"
                    data-ref="logo"
                    data-tool="tooltip"
                    title="Remover Imagen"
                    data-img="{{ $datos->logo }}"
                    >
                      <i class="fa fa-remove"></i>
                    </button>
                  @endif
                </h4>
              </div>  
               <div class="widget-body">
                 <div class="widget-main">
                  <div>
                    <input type="file" name="logo">
                     </div> 
                     <div>
                      <ul class="ace-thumbnails clearfix text-center" style="list-style-type: none;">
                      <li class="">   
                        <a id="ref_logo" href="{{ asset('assets_sistema/images/gallery/complementos_login/'.$datos->logo) }}" data-rel="colorbox" class="text-center">
                          
                          <img id = "imagen_logo" width="200" height="170" alt="200x170" src="{{ asset('assets_sistema/images/gallery/complementos_login/'.$datos->logo) }}"/>
                          
                          <div class="text">
                            <div class="inner">Imagenes pichurri</div>
                          </div>
                        </a>
                      </li>
                    </ul>
                     </div>
                   </div>
                </div>
              </div>
            <div class="widget-box">
              <div class="widget-header">
                <h4 class="widget-title">Titulo del Login</h4>
              </div>  
               <div class="widget-body">
                 <div class="widget-main">
                  <div>
                    <input type="text" class="form-control" placeholder="Titulo Login" name="titulo"
                    value="{{ $datos->titulo }}" 
                    />
                     </div> 
                   </div>
                </div>
              </div>
          </div>
          <br/>
          <div class="row no-gutters">
            <div class="col-xs-12 text-right">
                <button class="btn btn-pink btn-md radius-4">
                  <i class="ace-icon fa fa-floppy-o bigger-160"></i>
                  Guardar Cambios
              </button>
            </div>
          </div>
           <input type="hidden" id="id" name="id" value="<?php echo $datos->id ;?>">
</form>
<!-- =============================== Gift Cargando ==================================== -->

  <div class="row no-gutters loading_gift" id="div_image" style="display: none;">
    <div class="col-md-4 col-sm-4 col-md-offset-4 col-sm-offset-4">
      <div class="">
        <img src="{{ asset('assets_sistema/images/gift/cargando.gif') }} " alt="">
        <br/>
        Cargando...
      </div>
    </div>
  </div>
         


      

@endsection

@section('scripts')
  <script>
    function activate_match()
    {
      var id = $('select#login').val();
      var ruta = "{{ asset('assets_sistema/images/gallery/login/login') }}"+id+".jpg";
      document.getElementById('imagen_login').src = ruta;
      document.getElementById('ref_login').href = ruta;

      document.querySelectorAll('input[name="acceso"]').forEach((ele,i) =>{
        ele.checked = false
      })
    }

    $('.remove_img_plantilla_img').click(function(e) {
            
      const agree = confirm('Esta seguro de querer eliminar esta imagen?')

      if(agree)
      {
        $('#div_image').show()
        $('body').css('opacity',0.5);

        let id_remove = e.target.dataset.id,
            ref       = e.target.dataset.ref,
            img       = e.target.dataset.img,
            datos     = {id: id_remove,ref,img, _token: "{{ csrf_token() }}", _method: "DELETE"}


        $.ajax({
          url: '{{ route("config.delete") }}',
          type: 'POST',
          data: datos,
        })
        .done(function(data) {
          
          $('#ref_'+ref).attr('href','')
          $('#imagen_'+ref).attr('src','')
          $('#div_image').hide()
          $('body').css('opacity',1); 

          toastr.success('Imagen removida con éxito','Éxito!')

          e.target.style.display = 'none'
        })
      }
      
    });
  </script>
@endsection