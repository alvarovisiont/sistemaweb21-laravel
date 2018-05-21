@extends('layout.app')

@section('content')
  <div class="page-header">
  <h1>
    Dashboard
    <small>
      <i class="ace-icon fa fa-angle-double-right"></i>
      Menú
    </small>
  </h1>
</div><!-- /.page-header -->

 <div class="row no-gutters">
    <div class="col-md-10 col-sm-10">

    <a href="{{ route('users.index', ['tipo_bd' => 1]) }}" 
    class="btn btn-app btn-{{ session('tipo_db') === '1' ? 'primary':'default' }}">
    <i class="ace-icon fa fa-tachometer bigger-250"></i>Default&nbsp;
    </a>
    
      <a href="{{ route('users.index', ['tipo_bd' => 2]) }} }}" 
        class="btn btn-app btn-{{ session('tipo_db') === '2' ? 'primary':'default' }}">
            <i class="ace-icon fa fa-eye bigger-250"></i>
            Admin&nbsp;
      </a>
    </div>


    <div class="col-sm-2 col-md-2">       
          <a href="{{ route('users.create') }}" class="btn btn-app btn-success">
            <i class="ace-icon fa fa-fire bigger-230"></i>
            + Usuario&nbsp;
          </a>
    </div>  
    </div>


     
    <br/>
  <div class="row no-gutters">
  <div class="col-xs-12">

    <table class="table table-bordered table-responsive" id="tabla">
      <thead>
        <tr>
          <th class="text-center">Login</th>
          <th class="text-center">Correo</th>
          <th class="text-center">Permiso</th>
          <th class="text-center">Estatus</th>
          <th class="text-center">Correo Activo</th>
          <th class="text-center">Acceso Sistema</th>
          <th class="text-center">Fecha Acceso</th>
          <th class="text-center">Acción</th>
        </tr>
      </thead>
      <tbody class="text-center">
        <? foreach ($users as $row) 
        { ?>
          <tr>
            <td class="hidden-480">
              <?php echo $row->login; ?>
            </td>
            <td class="hidden-480">
              <?php echo $row->email; ?>
            </td>
            <td class="hidden-480">
              <?php echo $row->perfil_usuario->nombre; ?>
            </td>

            <td class="hidden-480">
              <?php $res = !$row->usuario_activo ? "denegado.png" : "activo.jpeg";?>
              <?php $titulo = !$row->usuario_activo ? "Acceso Denegado" : "Activado";?>
             
               <?php 
                   
                   $label = "<img src='".asset("assets/galerias/sistema/".$res)."' height='35' title='".$titulo."' data-tool='tooltip'/>";
                   
                   $active = $row->usuario_activo ? '1' : '0';

                   echo '<a href="'.route('users.users_active',[$row->id,$active]).'">'.$label.'</a>';
                ?>
            </td>
            <td class="hidden-480">
              <?php $res = !$row->correo_activo ? "aviso.png" : "activo.jpeg";?>
              <?php $titulo = !$row->correo_activo ? "Sin Verificar" : "Verificado";?>
               <img src="{{ asset('assets/galerias/sistema/'.$res) }}"  height="35" title='<?php echo $titulo;?>' data-tool='tooltip'/>
            </td>
            <td class="hidden-480">
              <?php $res = !$row->password_activo ? "inactivo.png" : "activo.jpeg";?>
              <?php $titulo = !$row->password_activo ? "Sin Entrada" : "Activo";?>
               <img src="{{ asset('assets/galerias/sistema/'.$res) }}"  height="35"
                title='<?php echo $titulo;?>' data-tool='tooltip'/>
            </td>
            <td class="hidden-480">
               {{ date('d-m-Y',strtotime($row->fecha_acceso)) }}
            </td>
            <td class="hidden-480">
              <a href="{{ url('users/'.$row->id.'/edit') }}" data-tool="tooltip" title="Editar">Editar</a>
              <a href="#" class="eliminar" data-tool="tooltip" title="Eliminar" data-eliminar="{{ $row->id }} ">Eliminar</a>
            </td>
          </tr>
        <?php 
          }
        ?>
      </tbody>
    </table>
  </div>
</div>

<form action="{{ url('users/:USER') }}" id="form_delete" method="POST">
  {{ csrf_field() }}
  {{ method_field('DELETE') }}
  }
</form>

@endsection

@section('scripts')
  <script>
    
    $(function(e){
      
      $('.eliminar').click(function(e){
        
        e.preventDefault()
        
        var id = e.currentTarget.dataset.eliminar,
            ruta = $('#form_delete').attr('action'),
            ruta = ruta.replace(':USER',id),
            agree = confirm('Esta seguro de querer eliminar este registro?')
        

        if(agree)
        {
          $('#form_delete').attr('action',ruta)

          $('#form_delete').submit()
        }
          
      })
    })

  </script>
@endsection
