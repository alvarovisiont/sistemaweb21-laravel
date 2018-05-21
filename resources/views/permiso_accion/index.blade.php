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
			<li class="active">Acciones del Menú</li>
		</ul><!-- /.breadcrumb -->					
	</div>

	<div class="page-header">
		<h1>
			Dashboard
			<small>
				<i class="ace-icon fa fa-angle-double-right"></i>
				Acciones Menú
			</small>
		</h1>
	</div><!-- /.page-header -->

	<!-- =============================== Sección principal ==================================== -->

	<div class="row no-gutters" id="div_principal">
		<div class="col-md-12 col-sm-12">
			<div class="widget-box">
				<div class="widget-header">
					<h3 class="widget-title">Acciones del Menú</h3>
				</div>
				<div class="widget-body">
					<div class="widget-main">
						<div class="row no-gutters">
							<div class="col-md-6 col-sm-6">
								<h4 class="">Base de datos</h4>
								<a href="{{ route('permiso_accion.index', ['tipo_db' => 1]) }}" 
										class="btn btn-app btn-{{ session('tipo_db') === '1' ? 'primary':'default' }}">
										<i class="ace-icon fa fa-tachometer bigger-250"></i>Default&nbsp;
								</a>
							
								<a href="{{ route('permiso_accion.index', ['tipo_db' => 2]) }}" 
									class="btn btn-app btn-{{ session('tipo_db') === '2' ? 'primary':'default' }}">
									<i class="ace-icon fa fa-eye bigger-250"></i>Admin&nbsp;
								</a>
							</div>
					    </div>
						<div class="row no-gutters">
							<div class="col-md-offset-4 col-sm-offset-4 col-md-2 col-sm-2 text-center">
								<h4 class="">Perfiles</h4>
								<br/>
								<button class="btn btn-app btn-danger no-radius show_div" data-type="perfiles">
									<i class="ace-icon fa fa-lock bigger-230"></i>
										Editar
									<span class="badge badge-warning badge-left">{{ $total_perfiles }}</span>
									
								</button>
							</div>
							<div class="col-md-2 col-sm-2 text-center">
								<h4 class="">Usuario</h4>
								<br/>
								<button class="btn btn-app btn-danger no-radius show_div" data-type="manuales">
									<i class="ace-icon fa fa-lock bigger-230"></i>
										Editar
									<span class="badge badge-warning badge-left">{{ $total_users }}</span>
								</button>
							</div>
						</div>
					</div>
				</div>	
			</div>
		</div>
	</div>

	<div class="row no-gutters" id="div_oculto" style="display: none;">
		
		<div class="row no-gutters">
			<form id="form_perfil" action="">
				<input type="hidden" id="tipo_perfil" name="tipo_perfil">
				

				<div class="col-md-12 col-sm-12">
					<div class="widget-box">
						<div class="widget-header">
							<h3 class="widget-title">
								Otorgar Permisos&nbsp;<i class="fa fa-lock"></i>
								<button type="button" class="btn btn-fill btn-info show_permissions pull-right">
										Tipo Permisos &nbsp;<i class="fa fa-user"></i>&nbsp;<i class="fa fa-arrow-up"></i>
								</button>
							</h3>
						</div>
						<div class="widget-body">
							<div class="widget-main">
							
								<!-- =============================== Sección Perfiles ==================================== -->
								<div class="row no-gutters">
									<div class="col-md-4 col-sm-4 col-sm-offset-3 col-md-offset-3">
										<label for="" class="control-label">Perfiles</label>
										<select name="perfiles_select" id="perfiles_select" class="form-control">
											
										</select>
									</div>
								</div>
								<div class="row no-gutters" id="div_select_usuarios">
									<div class="col-md-4 col-sm-4 col-sm-offset-3 col-md-offset-3">
										<label for="" class="control-label">Usuario</label>
										<select name="usuario_select" id="usuario_select" class="form-control">
											
										</select>
									</div>
								</div>
								<br/>
								<div class="row no-gutters hidden" id="div_oculto_tablas">
									<div class="col-md-12 col-sm-12">
										<table class="table table-bordered table-condensed table-responsive" id="tabla_acceso" width="100%">
											<thead>
												<tr>
													<th class="text-center">Módulo</th>
													<th class="text-center">Área</th>
													<th class="text-center">Sub Área</th>
													<th class="text-center">Crear</th>
													<th class="text-center">Modificar</th>
													<th class="text-center">Ver</th>
													<th class="text-center">Eliminar</th>
													<th class="text-center">Reporte</th>
													<th class="text-center">Imprimir</th>
													<th class="text-center">Activar</th>
												</tr>
											</thead>
											<tbody class="text-center">
												
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
	<!-- =============================== Gift Cargando ==================================== -->

	<div class="row no-gutters loading_gift" id="div_image" style="display: none;">
		<div class="col-md-4 col-sm-4 col-md-offset-4 col-sm-offset-4">
			<div class="">
				<img src="{{ asset('assets_sistema/images/gift/cargando.gif') }}" alt="">
				<br/>
				Cargando...
			</div>
		</div>
	</div>

@endsection

@section('scripts')
	<script>
		$('.show_div').click(function(e) {
			
			/* 	================================================
					 	|FUNCIÓN PARA BUSCAR LOS PERFILES|
				================================================ */

			const type = $(this).data('type')

			$('#tipo_perfil').val(type)

			$('#div_principal').hide('slow/400/fast', function(){

				$('#div_image').show()
				$('body').css('opacity',0.5);

				$.ajax({
					url: '{{ route("permiso.buscar_perfiles_ajax") }}',
					type: 'GET',
					dataType: 'JSON',
					data: {type},
				})
				.done(function(data) {

					let options = ''

					let options_users
					if(type === 'manuales')
					{

						$.grep(data.perfiles,function(i,e){

							options+= `<option value="${i.id}">${i.nombre}</option>`
						})
						
						options_users = '<option disabled="" selected="">Seleccione Usuario</option>'

						$.grep(data.usuarios, function(i,e){
							options_users+= `<option value="${i.id}">${i.login}</option>`
						})

						$('#div_select_usuarios').show()
						$('#usuario_select').html(options_users)
							
					}
					else
					{
						options = '<option selected="" disabled="">Seleccione</option>'

						$.grep(data.perfiles,function(i,e){

							if(i.activo === true)
							{
								options+= `<option value="${i.id}">${i.nombre}</option>`
							}
							else
							{
								options+= `<option value="${i.id}">${i.nombre}</option>`	
							}
						})

						$('#div_select_usuarios').hide()
						$('#usuario_select').html('')
					}
						

					$('#perfiles_select').html(options)
					$('#div_image').hide()
					$('body').css('opacity',1);

					$('#div_oculto').show('slow/400/fast')
				})
				.fail(function() {
					console.log("error");
				})
				.always(function() {
					console.log("complete");
				});
				
			})
		})

		$('#perfiles_select').change(function(e) {

			// función al cambiar el perfil en el select

			const id_perfil = e.target.value

			$('#div_image').show()
			$('body').css('opacity',0.5);
			$('#div_oculto_tablas').addClass('hidden').removeClass('animated bounceInUp')

			$('.table').DataTable().destroy()

			$.ajax({
				url: '{{ route("permiso_accion.buscar_accesos") }}',
				type: 'GET',
				dataType: 'JSON',
				data: {id: id_perfil ,type: "perfil"},
			})
			.done(function(data) {
				
				let filas = print_table_acceso(data)
				if(filas)
				{

					$('#tabla_acceso').children('tbody').html(filas)

					$('.table').dataTable({
						order: [],
						language: {url: "{{ asset('assets_sistema/json/esp.json') }}"}
					})
				}
				else
				{
					filas = '<tr><td colspan="10">Este elemento no posee accesos del menú asignados</td></tr>'
					$('#tabla_acceso').children('tbody').html(filas)
				}

				

				$('#div_image').hide()
				$('body').css('opacity',1);
				$('#div_oculto_tablas').removeClass('hidden').addClass('animated bounceInUp')
			})
			
		});

		$('#usuario_select').change(function(e) {
			
			// función al cambiar el usuario en el select

			const id_usuario = e.target.value

			$('#div_image').show()
			$('body').css('opacity',0.5);
			$('#div_oculto_tablas').addClass('hidden').removeClass('animated bounceInUp')

			$('.table').DataTable().destroy()

			$.ajax({
				url: '{{ route("permiso_accion.buscar_accesos") }}',
				type: 'GET',
				dataType: 'JSON',
				data: {id: id_usuario ,type: "usuario"},
			})
			.done(function(data) {

				let filas = print_table_acceso(data)

				if(filas)
				{

					$('#tabla_acceso').children('tbody').html(filas)

					$('.table').dataTable({
						order: [],
						language: {url: "{{ asset('assets_sistema/json/esp.json') }} "}
					})
				}
				else
				{
					filas = '<tr><td colspan="10">Este elemento no posee accesos del menú asignados</td></tr>'
					$('#tabla_acceso').children('tbody').html(filas)
				}

					

				$('#div_image').hide()
				$('body').css('opacity',1);
				$('#div_oculto_tablas').removeClass('hidden').addClass('animated bounceInUp')
				
			})
		});

		$('#tabla_acceso').children('tbody').on('click','tr td .check_accion',function(e){

			// función al cambiar algún permiso en los checkbox

			let datos  = e.target.value.split('-'),
				type   = $('#tipo_perfil').val(),
				id     = type === 'manuales' ? $('#usuario_select').val() : $('#perfiles_select').val(),
				status = e.target.checked ? true : false

			datos.push(status)

			$.ajax({
				url: '{{ route("permiso_accion.modificar_acceso") }}',
				type: 'POST',
				data: {datos,id,type, _token: "{{csrf_token()}}", _method: "PATCH"},
			})
			.done(function() {
				console.log("success");
			})
			.fail(function() {
				console.log("error");
			})
			.always(function() {
				console.log("complete");
			});
			
		})

		$('.show_permissions').click(function(e) {
			
			$('#tabla_acceso').children('tbody').empty()
			$('#div_oculto').hide()
			$('#div_oculto_tablas').addClass('hidden').removeClass('animated bounceInUp')
			$('#form_perfil')[0].reset()
			$('#div_principal').show('slow/400/fast')
		});

		function print_table_acceso (data) {
			let filas = ''
			if(data.length > 0)
			{
				$.grep(data,function(i,e) {
						
					let crear_checked = i.n_accion === true ? 'checked=""' : '',
						modificar_checked = i.m_accion === true ? 'checked=""' : '',
						ver_checked = i.v_accion === true ? 'checked=""' : '',
						delete_checked = i.e_accion === true ? 'checked=""' : '',
						imprimir_checked = i.i_accion === true ? 'checked=""' : '',
						activar_checked = i.a_accion === true ? 'checked=""' : '',
						reporte_checked = i.r_accion === true ? 'checked=""' : ''

					filas += `<tr>
								<td>${i.modulo}</td>
								<td>${i.area}</td>
								<td>${i.sub_area}</td>
								<td>
									<label class="">
										<small class="muted smaller-90"></small>
										<input id="id-button-borders" type="checkbox" 
										${crear_checked}
										class="ace ace-switch ace-switch-5 check_accion" 
										name="" value="${i.id_modulo}-n_accion"
										/>
										<span class="lbl middle"></span>
									</label>
								</td>
								<td>
									<label class="">
										<small class="muted smaller-90"></small>
										<input id="id-button-borders" type="checkbox" 
										${modificar_checked}
										class="ace ace-switch ace-switch-5 check_accion" 
										name="" value="${i.id_modulo}-m_accion"
										/>
										<span class="lbl middle"></span>
									</label>
								</td>
								<td>
									<label class="">
										<small class="muted smaller-90"></small>
										<input id="id-button-borders" type="checkbox"
										${ver_checked} 
										class="ace ace-switch ace-switch-5 check_accion" 
										name="" value="${i.id_modulo}-v_accion"
										/>
										<span class="lbl middle"></span>
									</label>
								</td>
								<td>
									<label class="">
										<small class="muted smaller-90"></small>
										<input id="id-button-borders" type="checkbox" 
										${delete_checked}
										class="ace ace-switch ace-switch-5 check_accion" 
										name="" value="${i.id_modulo}-e_accion"
										/>
										<span class="lbl middle"></span>
									</label>
								</td>
								<td>
									<label class="">
										<small class="muted smaller-90"></small>
										<input id="id-button-borders" type="checkbox" 
										${reporte_checked}
										class="ace ace-switch ace-switch-5 check_accion" 
										name="" value="${i.id_modulo}-r_accion"
										/>
										<span class="lbl middle"></span>
									</label>
								</td>
								<td>
									<label class="">
										<small class="muted smaller-90"></small>
										<input id="id-button-borders" type="checkbox" 
										${imprimir_checked}
										class="ace ace-switch ace-switch-5 check_accion" 
										name="" value="${i.id_modulo}-i_accion"
										/>
										<span class="lbl middle"></span>
									</label>
								</td>
								<td>
									<label class="">
										<small class="muted smaller-90"></small>
										<input id="id-button-borders" type="checkbox" 
										${activar_checked}
										class="ace ace-switch ace-switch-5 check_accion" 
										name="" value="${i.id_modulo}-a_accion"
										/>
										<span class="lbl middle"></span>
									</label>
								</td>
							</tr>`
				
					}) // fin grep	
				}
				else
				{
					filas = ``
				}

				return filas
		} // fin función
	</script>
@endsection