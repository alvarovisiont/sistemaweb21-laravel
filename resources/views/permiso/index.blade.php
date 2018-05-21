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
			<li class="active">Permisos</li>
		</ul><!-- /.breadcrumb -->					
	</div>

	<div class="page-header">
		<h1>
			Dashboard
			<small>
				<i class="ace-icon fa fa-angle-double-right"></i>
				Permisología
			</small>
		</h1>
	</div><!-- /.page-header -->

	<!-- =============================== Sección principal ==================================== -->

	<div class="row no-gutters" id="div_principal">
		<div class="col-md-12 col-sm-12">
			<div class="widget-box">
				<div class="widget-header">
					<h3 class="widget-title">Permisología</h3>
				</div>
				<div class="widget-body">
					<div class="widget-main">
						<div class="row no-gutters">
							<div class="col-md-6 col-sm-6">
								<h4 class="">Base de datos</h4>
								<a href="{{ route('permiso.index', ['tipo_db' => 1]) }}" 
									class="btn btn-app btn-{{ session('tipo_db') === '1' ? 'primary':'default' }}">
									<i class="ace-icon fa fa-tachometer bigger-250"></i>Default&nbsp;
								</a>
							
								<a href="{{ route('permiso.index', ['tipo_db' => 2]) }}" 
									class="btn btn-app btn-{{ session('tipo_db') === '2' ? 'primary':'default' }}">
									<i class="ace-icon fa fa-eye bigger-250"></i>Admin&nbsp;
								</a>
							</div>
					    </div>
						<div class="row no-gutters">
							<div class="col-md-offset-4 col-sm-offset-4 col-md-2 col-sm-2 text-center">
								<h4 class="">Perfiles</h4>
								<br/>
								<button class="btn btn-app btn-purple no-radius show_div" data-type="perfiles">
									<i class="ace-icon fa fa-pencil-square-o bigger-230"></i>
										Editar
									<span class="badge badge-warning badge-left">{{ $total_perfiles }}</span>
									
								</button>
							</div>
							<div class="col-md-2 col-sm-2 text-center">
								<h4 class="">Usuario</h4>
								<br/>
								<button class="btn btn-app btn-purple no-radius show_div" data-type="manuales">
									<i class="ace-icon fa fa-pencil-square-o bigger-230"></i>
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
			<form id="form_perfil" action="{{ route('permiso.store') }}" method="POST">
				{{ csrf_field() }}
				<input type="hidden" id="tipo_perfil" name="tipo_perfil">
				<input type="hidden" id="registros_link" name="registros_link">

				<div class="col-md-12 col-sm-12">
					<div class="widget-box">
						<div class="widget-header">
							<h3 class="widget-title">
								Otorgar Permisos&nbsp;<i class="fa fa-lock"></i>
								<button type="button" class="btn btn-fill btn-purple show_permissions pull-right">
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

								<!-- =================== Sección Módulos y Áreas ================================ -->
								<div class="tabbable" id="div_oculto_modulos" style="display: none;">

								<!-- =============================== Módulos ==================================== -->
								<?
									$tabs = '<ul class="nav nav-tabs" id="myTab">';
									$con = 1;

									$id_area = 0;
									$con_areas = 1;
									$areas = '';

									$sub_areas = '';
									$con_sub_areas = 1;

									foreach ($accesos as $value) 
									{	

										// ===================== \ foreach módulos \ ==============================

										if($value->id_tipo === 1)
										{
											$clase = '';
											if($con === 1)
											{
												$clase = 'active';
											}
											
											$tipo = $value->link === true ? '(Link)' : '(Nivel)';

											$tabs.= '<li class="'.$clase.' text-center">
														<a data-toggle="tab" href="#'.$value->id.'">
															<i class="green ace-icon fa '.$value->icono.' bigger-120"></i>
															'.$value->nombre.'
															<br/>
															'.$tipo.'
														</a>
													</li>';

											$areas.='
													<div id="'.$value->id.'" class="tab-pane fade in '.$clase.'">
														<br/>
														<div class="row">
															<div class="col-md-3 col-sm-3">
																<label class="pull-left inline">
																	<small class="muted smaller-90">Añadir Módulo:</small>
																	<input id="id-button-borders" type="checkbox" class="ace ace-switch ace-switch-5 modulos_visible" name="modulos[]" value="'.$value->id.'" multiple="" data-link='.$value->link.' />
																	<span class="lbl middle"></span>
																</label>
															</div>
															<div class="col-md-3 col-sm-3 hidden div_visible_modulo" id="div_visible_modulo_'.$value->id.'">
																<label class="pull-left inline">
																	<small class="muted smaller-90">Módulo Visible:</small>
																	<input id="id-button-borders" type="checkbox" checked="true" class="ace ace-switch ace-switch-5" name="modulos_visible[]" value="'.$value->id.'" multiple="" />
																	<span class="lbl middle"></span>
																</label>
															</div>
														</div>
														<br/>
														<div class="row no-gutters div_areas" id="div_areas_'.$value->id.'">
															<div class="col-md-12 col-sm-12">
																<div class="tabbable tabs-left">
																	<ul class="nav nav-tabs" id="myTab3">';

											$sub_areas = '<div class="tab-content">';


											foreach ($accesos as $value1) 
											{

												if($value1->id_padre === $value->id)
												{

													// ===================== \ foreach areas \ ======================

													$tipo = $value1->link === true ? '(Link)' : '(Nivel)';

													$areas.='<li class="li_areas" id="li_area_'.$value1->id.'">
																<a data-toggle="tab" href="#'.$value1->id.'">
																	<i class="pink ace-icon fa fa-tachometer bigger-110"></i>
																	'.$value1->nombre.'
																	<br/>
																	'.$tipo.'
																</a>
															</li>';
													
													$sub_areas.='<div id="'.$value1->id.'" class="tab-pane div_sub_areas_tab">
																	<br/>
																	<div class="row">
																		<div class="col-md-12 col-sm-12" >
																			<label class="pull-right inline">
																				<small class="muted smaller-90">Añadir Área:</small>
																				<input id="id-button-borders" type="checkbox" class="ace ace-switch ace-switch-5 areas_visible check_modulo_'.$value->id.'" name="areas_'.$value->id.'[]" value="'.$value1->id.'" data-link="'.$value1->link.'"
																				/>
																				<span class="lbl middle"></span>
																			</label>
																		</div>
																	</div>
																	<br/>
																	<div class="row no-gutters div_sub_areas_modulo_'.$value->id.' div_sub_areas" id="div_sub_areas_'.$value1->id.'">
																		<div class="col-md-7 col-md-offset-2 col-sm-7 col-sm-offset-2 text-center">
																		<h4>Sub Áreas</h4>
																		<ul class="list-group">';

													foreach ($accesos as $value2) 
													{
														// ============= \ foreach sub-areas \ ============= //

														if($value2->id_padre === $value1->id)									{
															
															$sub_areas.='
																		<li class="list-group-item">
																			<div class="row no-gutters">
																				<b class="pull-left">'.$value2->nombre.'</b>
																				<label class="pull-right inline">
																					<small class="muted smaller-90">
																						Añadir Sub Área:
																					</small>
																					<input id="id-button-borders" 
																						type="checkbox" 
																						checked="true" 
																						class="ace ace-switch ace-switch-5 check_area_'.$value1->id.' check_modulo_'.$value->id.'
																							checkbox_sub_areas"
																						name="sub_areas_'.$value1->id.'[]" 
																						value="'.$value2->id.'" multiple=""
																						data-link='.$value2->link.' 
																					/>
																					<span class="lbl middle"></span>
																				</row>
																			</label>
																		</li>
																		';

														} // fin if id_padre sub-area == id área

													} // fin foreach sub-areas

													$sub_areas.='
																	</ul>
																</div>
															</div>
														</div>';

												} // fin if id_padre area == id modulo

											} // fin foreach areas
													
													$areas.= '</ul>';
													$sub_areas.= '</div>';

													$areas.= $sub_areas;

													$areas.='
														</div>
													</div>
												</div>
											</div>';
										
										} // fin si es un módulo					

										$con++;
									
									} // finn foreach modulo

									$tabs.='</ul>';

									echo $tabs;
								?>

								<!-- =============================== Áreas y Sub-Áreas ==================================== -->

									<div class="tab-content">
										<?= $areas; ?>
									</div>
								</div>
							</div>
						</div> <!-- fin panel-body -->
						<div class="panel-footer">
							<div class="row no-gutters">
								<div class="col-md-12 col-sm-12">
									<button type="submit" class="btn btn-pink btn-fill pull-right">Guardar&nbsp;<i class="fa fa-thumbs-up"></i></button>
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

		$('#perfiles_select').change(function(e){

			/* 	=======================================================================
					 	|FUNCIÓN PARA BUSCAR LOS ACCESOS AL ESCOGER UN PERFIL|
				======================================================================= */

			const perfil = e.target.value

			$('#div_image').show()
			$('body').css('opacity',0.5);

			$.ajax({
				url: '{{ route("permiso.buscar_modulos_ajax") }}',
				type: 'GET',
				dataType: 'JSON',
				data: {perfil},
			})
			.done(function(data) {

				if(data.length > 0)
				{
					$('input[type="checkbox"]').prop('checked',false)
					$('.div_sub_areas_tab').removeClass('active')
					$('.li_areas').removeClass('active')
					$('.div_visible_modulo').addClass('hidden')
					$('.div_sub_areas').hide()
					$('.div_areas').hide()

					$.grep(data,function(i,e){

						$('input[name="modulos[]"][value="'+i.id_modulo+'"]').prop({
							'checked':true,
							'disabled': true
						})



						$('#div_visible_modulo_'+i.id_modulo).removeClass('hidden')

						let valor = i.visible ? true : false

						$('input[name="modulos_visible[]"][value="'+i.id_modulo+'"]').prop('checked',valor)
						
						
						let area = i.id_area
						area = area.replace('{','')
						area = area.replace('}','')
						area = area.split(',')
						
						area.forEach(function(area_record,index){

							$(`input[name="areas_${i.id_modulo}[]"][value="${area_record}"]`).prop('checked',true)
							$('#div_areas_'+i.id_modulo).show()

							let link = $(`input[name="areas_${i.id_modulo}[]"][value="${area_record}"]`).data('link')

							if(index === 0)
							{
								$('#li_area_'+area_record).addClass('active')
								$('#'+area_record).addClass('active')
							}

							if(!link)
							{
								$('#div_sub_areas_'+area_record).show('slow/400/fast')

								let sub_area = i.id_sub_area

								sub_area = sub_area.replace('{','')
								sub_area = sub_area.replace('}','')
								sub_area = sub_area.split(',')

								sub_area.forEach(function(sub_area,index1){
									$(`input[name="sub_areas_${area_record}[]"][value="${sub_area}"]`).prop('checked',true)
								})
							}
								

						})
					})
				}
				else
				{
					$('input[type="checkbox"]').prop('checked',false)
					$('.div_sub_areas_tab').removeClass('active')
					$('.li_areas').removeClass('active')
					$('.div_visible_modulo').addClass('hidden')
					$('.div_sub_areas').hide()
					$('.div_areas').hide()

				}

				$('#div_image').hide()
				$('body').css('opacity',1);

				$('#div_oculto_modulos').show('slow/400/fast')
			})
			.fail(function() {
				console.log("error");
			})
			.always(function() {
				console.log("complete");
			});	
			
		})

		$('#usuario_select').change(function(e) {
			
			/* 	=======================================================================
					 	|FUNCIÓN PARA BUSCAR LOS ACCESOS AL ESCOGER UN USUARIO|
				======================================================================= */

			let user = e.target.value

			$('#div_image').show()
			$('body').css('opacity',0.5);

			$.ajax({
				url: '{{ route("permiso.buscar_modulos_ajax_user") }}',
				type: 'GET',
				dataType: 'JSON',
				data: {user},
			})
			.done(function(data) {

				if(data.length > 0)
				{
					$('input[type="checkbox"]').prop('checked',false)
					$('.div_sub_areas_tab').removeClass('active')
					$('.li_areas').removeClass('active')
					$('.div_visible_modulo').addClass('hidden')
					$('.div_sub_areas').hide()
					$('.div_areas').hide()

					$.grep(data,function(i,e){

						$('input[name="modulos[]"][value="'+i.id_modulo+'"]').prop({
							'checked':true,
							'disabled': true
						})

						$('#div_visible_modulo_'+i.id_modulo).removeClass('hidden')

						let valor = i.visible.toString() === true ? true : false

						$('input[name="modulos_visible[]"][value="'+i.id_modulo+'"]').prop('checked',valor)
						
						
						let area = i.id_area
						area = area.replace('{','')
						area = area.replace('}','')
						area = area.split(',')
						
						area.forEach(function(area_record,index){

							$(`input[name="areas_${i.id_modulo}[]"][value="${area_record}"]`).prop('checked',true)
							$('#div_areas_'+i.id_modulo).show()

							let link = $(`input[name="areas_${i.id_modulo}[]"][value="${area_record}"]`).data('link')

							if(index === 0)
							{
								$('#li_area_'+area_record).addClass('active')
								$('#'+area_record).addClass('active')
							}

							if(!link)
							{
								$('#div_sub_areas_'+area_record).show('slow/400/fast')



								let sub_area = i.id_sub_area

								sub_area = sub_area.replace('{','')
								sub_area = sub_area.replace('}','')
								sub_area = sub_area.split(',')

								sub_area.forEach(function(sub_area,index1){
									$(`input[name="sub_areas_${area_record}[]"][value="${sub_area}"]`).prop('checked',true)
								})
							}

						})
					})
				}
				else
				{
					$('input[type="checkbox"]').prop('checked',false)
					$('.div_sub_areas_tab').removeClass('active')
					$('.li_areas').removeClass('active')
					$('.div_visible_modulo').addClass('hidden')
					$('.div_sub_areas').hide()
					$('.div_areas').hide()


				}

				$('#div_image').hide()
				$('body').css('opacity',1);

				$('#div_oculto_modulos').show('slow/400/fast')
			})
			.fail(function() {
				console.log("error");
			})
			.always(function() {
				console.log("complete");
			});


		});

		$('.show_permissions').on('click',function(e){
			/* 	=======================================================================
					 	|FUNCIÓN PARA MOSTRAR LOS TIPOS DE PERFILES DE NUEVO|
				======================================================================= */

			$('#div_oculto').hide()
			$('#div_oculto_modulos').hide()
			$('.div_visible_modulo').addClass('hidden')
			$('#form_perfil')[0].reset()
			$('#div_principal').show('slow/400/fast')
		})

		$('.modulos_visible').click(function(e){
			
			/* 	===================================================================================
					|FUNCIÓN PARA OCULTAR Y DESCHECKEAR TODO LO REFERENTE AL MÓDULO O MOSTRARLOS|
				=================================================================================== */

			let id_modulo = e.target.value,
				input = $('#registros_link'),	
				record_link = input.val()

			if(e.target.checked)
			{
				let link = e.target.dataset.link

				if(link !== '1')
				{
					$('#div_areas_'+id_modulo).show('slow/400/fast')
				}
				else
				{
					record_link+= id_modulo+','
					input.val(record_link)
				}

				$('#div_visible_modulo_'+id_modulo).removeClass('hidden')
				$('input[name="modulos_visible[]"][value="'+id_modulo+'"]').prop('checked',true)
				
			}
			else
			{
				$('#div_areas_'+id_modulo).hide('slow/400/fast')

				$('.div_sub_areas_modulo_'+id_modulo).hide('slow/400/fast')

				$('#div_visible_modulo_'+id_modulo).addClass('hidden')

				$('input[name="modulos_visible[]"][value="'+id_modulo+'"]').prop('checked',false)

				$('.check_modulo_'+id_modulo).each(function(e){
					$(this).prop('checked',false)
				})

				record_link = record_link.replace(`${id_modulo},`,'')
				input.val(record_link)
				
			}
		})

		$('.areas_visible').click(function(e){

			/* 	=============================================================================================
					|FUNCIÓN PARA OCULTAR Y DESCHECKEAR TODAS LAS SUB-ÁREAS REFERENTE AL ÁREA O MOSTRARLAS|
				============================================================================================= */

			let id_area = e.target.value,
				input = $('#registros_link'),
				record_link = input.val()


			if(e.target.checked)
			{
				let link = e.target.dataset.link
				if(link !== '1')
				{
					$('#div_sub_areas_'+id_area).show('slow/400/fast')
				}
				else
				{
					record_link+= id_area+','

					input.val(record_link)
				
				}
			}
			else
			{
				$('#div_sub_areas_'+id_area).hide('slow/400/fast')

				$('.check_area_'+id_area).each(function(e){
					$(this).prop('checked',false)
				})

				record_link = record_link.replace(`${id_area},`,'')
				input.val(record_link)

			}
		})

		$('.checkbox_sub_areas').click(function(e){
			
			let id_sub = e.target.value,
				input = $('#registros_link'),
				record_link = input.val()

			if(e.target.checked)
			{
						
				record_link+= id_sub+','
				input.val(record_link)
			}
			else
			{
				record_link =  record_link.replace(`${id_sub},`,'')
				input.val(record_link)
			}
		})

		$('#form_perfil').submit(function(e) {
			/* Act on the event */
			e.preventDefault()
			$('.modulos_visible').each(function(e){
				$(this).prop('disabled',false)
			})

			document.getElementById('form_perfil').submit()

		});
	</script>
@endsection