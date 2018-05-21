@extends('layout.app')

@section('content')

	<div class="breadcrumbs ace-save-state" id="breadcrumbs">
		<ul class="breadcrumb">
			<li>
				<i class="ace-icon fa fa-home home-icon"></i>
				<a href="#">Sistema</a>
			</li>

			<li class="active">
				<a href="#">Menú</a>
			</li>
			
		</ul><!-- /.breadcrumb -->					
	</div>

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
	    <div class="row no-gutters">
			<div class="col-md-10 col-sm-10">

				<a href="{{ route('menu.index', ['tipo_db' => 1]) }}" 
					class="btn btn-app btn-{{ session('tipo_db') === '1' ? 'primary':'default' }}">
					<i class="ace-icon fa fa-tachometer bigger-250"></i>Default&nbsp;
				</a>
			
				<a href="{{ route('menu.index', ['tipo_db' => 2]) }}" 
					class="btn btn-app btn-{{ session('tipo_db') === '2' ? 'primary':'default' }}">
					<i class="ace-icon fa fa-eye bigger-250"></i>Admin&nbsp;
				</a>
			</div>


			<div class="col-sm-2 col-md-2">				
						<a href="{{ route('menu.create') }}" class="btn btn-app btn-success">
							<i class="ace-icon fa fa-fire bigger-230"></i>
							+ Módulo&nbsp;
						</a>
			</div>	
	    </div>	
		<div class="col-md-12 col-sm-12">
			<br/>
			<table class="table table-bordered table-responsive" id="tabla">
				<thead>
					<tr>
						<th class="text-center">Id</th>
						<th class="text-center">Nombre</th>
						<th class="text-center">Id Padre</th>
						<th class="text-center">Tipo</th>
						<th class="text-center">Icono</th>
						<th class="text-center">Ruta</th>
						<th class="text-center">Acción</th>
					</tr>
				</thead>
				<tbody class="text-center">
					<? foreach ($menu as $row) 
					{
						$tipo = '';

						$agregar_area = '';
						$agregar_sub_area = '';

						$editar_area     = '';
						$editar_sub_area = '';
						$editar_modulo   = '';
						
						$eliminar_area     = '';
						$eliminar_sub_area = '';
						$eliminar_modulo   = '';

						$title = "";
						$disabled="";

						switch ($row->id_tipo) {
							case 1:
								$tipo = '<span class="badge">Módulo</span>';

								if($row->link)
								{
									$disabled="disabled=''";
									$title = "No te vuelvas loco que no puedes agregar más!";
								}
								else
								{
									$title="Agregar Área";
								}

								$agregar_area = "<button type='button' class='btn btn-xs btn-info' data-toggle='modal' data-target='#modal_area' data-modulo='".$row->id."' title='".$title."' $disabled
									data-tool='tooltip'>
									<i class='fa fa-plus'></i> 
								</button>";

								$editar_modulo = "<a href='".url('menu/'.$row->id.'/edit')."' class='btn btn-xs btn-warning' title='Editar Modulo'
									data-tool='tooltip'>
									<i class='fa fa-edit'></i> 
								</a>";

								$eliminar_modulo = "<button type='button' class='btn btn-xs btn-danger eliminar_menu' title='Eliminar Módulo'
									data-eliminar='".$row->id."'
									data-tool='tooltip'>
									<i class='fa fa-trash'></i> 
								</button>";

							break;
							case 2:
								$tipo = '<span class="badge">Área</span>';

								if($row->link)
								{
									$disabled="disabled=''";
									$title = "No te vuelvas loco que no puedes agregar más!";
								}
								else
								{
									$title="Agregar Sub Area";
								}

								$agregar_sub_area = "<button type='button' class='btn btn-xs btn-info' data-toggle='modal' data-target='#modal_sub_area' data-area='".$row->id."' title='".$title."' $disabled
									data-tool='tooltip'
									>
									<i class='fa fa-plus'></i>
								</button>";

								$editar_area = "<button type='button' class='btn btn-xs btn-warning' data-toggle='modal' data-target='#modal_area' data-modulo='".$row->id_padre."' title='Editar Area'
									data-tool='tooltip'
									data-edit='".$row->id."'
									data-nombre='".$row->nombre."'
									data-link='".$row->link."'
									data-ruta='".$row->ruta."'
									>
									<i class='fa fa-edit'></i>
								</button>";

								$eliminar_area = "<button type='button' class='btn btn-xs btn-danger eliminar_menu' title='Eliminar Area'
									data-tool='tooltip'
									data-eliminar='".$row->id."'
									>
									<i class='fa fa-trash'></i>
								</button>";

							break;
							case 3:
								$tipo = '<span class="badge">Sub Area</span>';

								$agregar_sub_area = "<button type='button' class='btn btn-xs btn-default' data-toggle='modal' data-target='#modal_sub_area' data-area='".$row->id."' title='No te vuelvas loco que no puedes agregar más!'
									data-tool='tooltip'
									disabled=''
									>
									<i class='fa fa-plus'></i>
								</button>";


								$editar_sub_area = "<button type='button' class='btn btn-xs btn-warning' data-toggle='modal' data-target='#modal_sub_area' data-area='".$row->id_padre."' title='Editar Sub Area'
									data-tool='tooltip'
									data-edit='".$row->id."'
									data-nombre='".$row->nombre."'
									data-ruta='".$row->ruta."'
									>
									<i class='fa fa-edit'></i>
								</button>";

								$eliminar_sub_area = "<button type='button' class='btn btn-xs btn-danger eliminar_menu' title='Eliminar Sub Area'
									data-tool='tooltip'
									data-eliminar='".$row->id."'
									>
									<i class='fa fa-trash'></i>
								</button>";
							break;
						}

						echo 	"<tr>
									<td>{$row->id}</td>
									<td>{$row->nombre}</td>
									<td>{$row->id_padre}</td>
									<td>{$tipo}</td>
									<td><i class='fa ".$row->icono."'></i></td>
									<td>{$row->ruta}</td>
									<td>{$agregar_area} {$agregar_sub_area} {$editar_modulo} {$editar_area} {$editar_sub_area}  {$eliminar_modulo} {$eliminar_area} {$eliminar_sub_area}</td>
								";
					}
					?>
				</tbody>
			</table>
		</div>
	</div>

	<div id="modal_area" class="modal fade" role="dialog">
	    <div class="modal-dialog">
	        <!-- Modal content-->
	        <div class="modal-content">
	            <div class="modal-header modalHeader">
	                <button type="button" class="close" data-dismiss="modal">×</button>
	                <h4 class="modal-title">Agregar/Editar Área</h4>
	            </div>
	            <form action="" class="form-horizontal" id="form_area" method="POST">
	            	{{ csrf_field() }}
		            <div class="modal-body">
						<input type="hidden" id="id_padre_area" name="id_padre">
						<input type="hidden" name="id_tipo" value="2">
		            	<div class="form-group">
		            		<label for="nombre" class="control-label col-md-2 col-sm-2">Nombre Área</label>
		            		<div class="col-md-4 col-sm-4">
		            			<input type="text" id="nombre_area" name="nombre" required="" class="form-control" value="">
		            		</div>
		            		<div class="col-md-3 col-sm-3">
		            			<label for="link" class="radio-inline">
		            				<input type="radio" id="link" name="link" value="1">
		            				Link
		            			</label>
		            		</div>
		            		<div class="col-md-3 col-sm-3">
		            			<label for="sub" class="radio-inline">
		            				<input type="radio" id="sub" name="link" value="0">
		            				Sub Menú
		            			</label>
		            		</div>
		            	</div>
		            	<div class="form-group" id="ruta_oculta" style="display: none;">
		            		<div class="form-group">
		            			<label for="ruta" class="control-label col-md-2 col-sm-2">Ruta</label>
		            			<div class="col-md-4 col-sm-4">
		            				<input type="text" id="ruta_area" name="ruta" class="form-control" value="">
		            			</div>
		            		</div>
		            	</div>

		            </div><!-- fin modal-body -->
		            <div class="modal-footer">
		                <button type="submit" class="btn btn-pink">Grabar</button>
		                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
		            </div>
	            </form>
	        </div><!-- fin modal-content -->
	    </div><!-- fin modal-dialog -->
	</div> <!-- fin modal -->

	<div id="modal_sub_area" class="modal fade" role="dialog">
	    <div class="modal-dialog">
	        <!-- Modal content-->
	        <div class="modal-content">
	            <div class="modal-header modalHeader">
	                <button type="button" class="close" data-dismiss="modal">×</button>
	                <h4 class="modal-title">Crear/Editar Sub Área</h4>
	            </div>
	            <form action="" class="form-horizontal" method="POST" id="form_sub_area">
	            	{{ csrf_field() }}
	           	 	<div class="modal-body">
							<input type="hidden" name="id_tipo" value="3">
							<input type="hidden" name="link" value="true">
							<input type="hidden" id="id_padre_sub_area" name="id_padre">

			            	<div class="form-group">
			            		<label for="nombre" class="control-label col-md-2 col-sm-2">Nombre Sub Área</label>
			            		<div class="col-md-4 col-sm-4">
			            			<input type="text" id="nombre_sub_area" name="nombre" required="" class="form-control" value="">
			            		</div>
			            		<label for="nombre" class="control-label col-md-2 col-sm-2">Ruta</label>
			            		<div class="col-md-4 col-sm-4">
			            			<input type="text" id="ruta_sub_area" name="ruta" required="" class="form-control" value="">
			            		</div>
			            	</div>
	            	</div><!-- fin modal-body -->
		            <div class="modal-footer">
		                <button type="submit" class="btn btn-pink">Grabar</button>
		                <button type="button" class="btn btn-info" data-dismiss="modal">Cerrar</button>
		            </div>
	            </form>
	        </div><!-- fin modal-content -->
	    </div><!-- fin modal-dialog -->
	</div> <!-- fin modal -->

	<form action="{{ url('menu/'.':USER') }}" id="form_eliminar" method="POST">
		{{csrf_field()}}
		{{method_field('DELETE')}}
	</form>
@endsection

@section('scripts')
	<script>
		$(function(){

			$('.eliminar_menu').click(function(e){
				let agree = confirm('Esta seguro de querer eliminar este registro? Ten en cuenta que eliminaras todo lo relacionado'),
				id    = e.currentTarget.dataset.eliminar,
				form = $('#form_eliminar'),
				ruta = form.prop('action').replace(':USER',id)

				form.attr('action',ruta)
				form.submit()
			})

			$('input[name="link"]').click(function(e){
				let value = e.target.value

				if(parseInt(value) === 1)
				{
					$('#ruta_oculta').show('slow/400/fast',function(){
						
						document.getElementById('ruta_area').setAttribute('required',true)
					})	
				}
				else
				{
					$('#ruta_oculta').hide('slow/400/fast',function(){
						document.getElementById('ruta_area').removeAttribute('required')
						document.getElementById('ruta_area').value = ''
					})	
				}
			})

			$('#modal_area').on('show.bs.modal',function(e){
				let padre = e.relatedTarget.dataset.modulo,
					edit  = e.relatedTarget.dataset.edit

				document.getElementById('id_padre_area').value = padre

				let ruta = ''

				if(!!edit)
				{

					$('#form_area').append('{{ method_field("PATCH") }}')

					ruta = '{{ url("menu/") }}'+'/'+edit

					let nombre = e.relatedTarget.dataset.nombre,
						link = e.relatedTarget.dataset.link,
						ruta_input = e.relatedTarget.dataset.ruta

					document.getElementById('nombre_area').value = nombre

					if(link)
					{
						document.getElementById('ruta_oculta').style.display = 'block'
						document.getElementById('ruta_area').value = ruta_input

					}

					if(link)
					{
						
						$('input[name="link"][value="1"]').prop('checked',true)
					}
					else
					{
						$('input[name="link"][value="0"]').prop('checked',true)
					}
				}
				else
				{
					ruta = '{{ url("menu") }}'

					$('#form_area').find('input[_method]').remove()
				}

				document.getElementById('form_area').removeAttribute('action')
				document.getElementById('form_area').setAttribute('action',ruta)

			})

			$('#modal_area').on('hidden.bs.modal',function(){
				$('#form_area')[0].reset()
			})

			$('#modal_sub_area').on('show.bs.modal',function(e){
				let area = e.relatedTarget.dataset.area,
					edit  = e.relatedTarget.dataset.edit

				document.getElementById('id_padre_sub_area').value = area

				let ruta = ''

				if(!!edit)
				{
					$('#form_sub_area').append('{{ method_field("PATCH") }}')

					ruta = '{{ url("menu") }}'+'/'+edit

					let nombre = e.relatedTarget.dataset.nombre,
						ruta_input = e.relatedTarget.dataset.ruta

					document.getElementById('nombre_sub_area').value = nombre
					document.getElementById('ruta_sub_area').value   = ruta_input 
				}
				else
				{
					ruta = '{{ url("menu") }}'

					$('#form_sub_area').find('input[_method]').remove()
				}

				document.getElementById('form_sub_area').removeAttribute('action')
				document.getElementById('form_sub_area').setAttribute('action',ruta)

			})

			$('#modal_sub_area').on('hidden.bs.modal',function(){
				$('#form_sub_area')[0].reset()
			})
		})
	</script>
@endsection