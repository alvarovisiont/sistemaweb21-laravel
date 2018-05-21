@extends('layout.app')

@section('content')
	<div class="breadcrumbs ace-save-state" id="breadcrumbs">
		<ul class="breadcrumb">
			<li>
				<i class="ace-icon fa fa-home home-icon"></i>
				<a href="#">Sistema</a>
			</li>

			<li>
				<a href="#">Menú</a>
			</li>
			<li class="active">Crear Módulo</li>
		</ul><!-- /.breadcrumb -->					
	</div>

	<div class="row">
		<div class="col-xs-12">
			<div class="panel panel-default">
				<div class="panel-heading"><h4>Formulario para Módulo</h4></div>
				
				<div class="panel-body">
					<form action="{{ url($route) }}" class="form-horizontal" id="form_registrar" method="POST">

						@if($register)
							{{method_field('PATCH')}}
						@endif
						{{csrf_field()}}

						
						<input type="hidden" name="id_tipo" value="1">
						<input type="hidden" name="id_padre" value="0">

						<div class="form-group">
							<label for="Nombre" class="control-label col-md-2 col-sm-2 col-md-offset-2 col-sm-offset-2">Módulo</label>
							<div class="col-md-4 col-sm-4">
								<input type="text" id="nombre" name="nombre" required="" class="form-control" value="<?= $register ? $register->nombre : '' ?>">
							</div>
						</div>
						<div class="form-group">
							<label for="Nombre" class="control-label col-md-2 col-sm-2 col-md-offset-2 col-sm-offset-2">Icono</label>
							
							<div class="col-md-4 col-sm-4">
								<select class="chosen-select form-control" id="icono" name="icono" data-placeholder="Icono">
									
									<option value="<?= $register ? $register->icono : '' ?>"><?= $register ? $register->icono : '' ?></option>	

								    <option value="fa-adjust">fa-adjust</option>
									<option value="fa-asterisk">fa-asterisk</option>
									<option value="fa-ban">fa-ban</option>
									<option value="fa-bar-chart-o">fa-bar-chart-o</option>
									<option value="fa-barcode">fa-barcode</option>
									<option value="fa-flask">fa-flask</option>
									<option value="fa-beer">fa-beer</option>
									<option value="fa-bell-o">fa-bell-o</option>
									<option value="fa-bell">fa-bell</option>
									<option value="fa-bolt">fa-bolt</option>
									<option value="fa-book">fa-book</option>
									<option value="fa-bookmark">fa-bookmark</option>
									<option value="fa-bookmark-o">fa-bookmark-o</option>
									<option value="fa-briefcase">fa-briefcase</option>
									<option value="fa-bullhorn">fa-bullhorn</option>
									<option value="fa-calendar">fa-calendar</option>
									<option value="fa-camera">fa-camera</option>
									<option value="fa-camera-retro">fa-camera-retro</option>
									<option value="fa-certificate">fa-certificate</option>
									<option value="fa-check-square-o">fa-check-square-o</option>
									<option value="fa-square-o">fa-square-o</option>
									<option value="fa-circle">fa-circle</option>
									<option value="fa-circle-o">fa-circle-o</option>
									<option value="fa-cloud">fa-cloud</option>
									<option value="fa-cloud-download">fa-cloud-download</option>
									<option value="fa-cloud-upload">fa-cloud-upload</option>
									<option value="fa-coffee">fa-coffee</option>
									<option value="fa-cog">fa-cog</option>
									<option value="fa-cogs">fa-cogs</option>
									<option value="fa-comment">fa-comment</option>
									<option value="fa-comment-o">fa-comment-o</option>
									<option value="fa-comments">fa-comments</option>
									<option value="fa-comments-o">fa-comments-o</option>
									<option value="fa-credit-card">fa-credit-card</option>
									<option value="fa-tachometer">fa-tachometer</option>
									<option value="fa-desktop">fa-desktop</option>
									<option value="fa-arrow-circle-o-down">fa-arrow-circle-o-down</option>
									<option value="fa-download">fa-download</option>
									<option value="fa-pencil-square-o">fa-pencil-square-o</option>
									<option value="fa-envelope">fa-envelope</option>
									<option value="fa-envelope-o">fa-envelope-o</option>
									<option value="fa-exchange">fa-exchange</option>
									<option value="fa-exclamation-circle">fa-exclamation-circle</option>
									<option value="fa-external-link">fa-external-link</option>
									<option value="fa-eye-slash">fa-eye-slash</option>
									<option value="fa-eye">fa-eye</option>
									<option value="fa-video-camera">fa-video-camera</option>
									<option value="fa-fighter-jet">fa-fighter-jet</option>
									<option value="fa-film">fa-film</option>
									<option value="fa-filter">fa-filter</option>
									<option value="fa-fire">fa-fire</option>
									<option value="fa-flag">fa-flag</option>
									<option value="fa-folder">fa-folder</option>
									<option value="fa-folder-open">fa-folder-open</option>
									<option value="fa-folder-o">fa-folder-o</option>
									<option value="fa-folder-open-o">fa-folder-open-o</option>
									<option value="fa-cutlery">fa-cutlery</option>
									<option value="fa-gift">fa-gift</option>
									<option value="fa-glass">fa-glass</option>
									<option value="fa-globe">fa-globe</option>
									<option value="fa-users">fa-users</option>
									<option value="fa-hdd-o">fa-hdd-o</option>
									<option value="fa-headphones">fa-headphones</option>
									<option value="fa-heart">fa-heart</option>
									<option value="fa-heart-o">fa-heart-o</option>
									<option value="fa-home">fa-home</option>
									<option value="fa-inbox">fa-inbox</option>
									<option value="fa-info-circle">fa-info-circle</option>
									<option value="fa-key">fa-key</option>
									<option value="fa-leaf">fa-leaf</option>
									<option value="fa-laptop">fa-laptop</option>
									<option value="fa-gavel">fa-gavel</option>
									<option value="fa-lemon-o">fa-lemon-o</option>
									<option value="fa-lightbulb-o">fa-lightbulb-o</option>
									<option value="fa-lock">fa-lock</option>
									<option value="fa-unlock">fa-unlock</option>
									<option value="fa-user-md">fa-user-md</option>
									<option value="fa-file-text-o">fa-file-text-o</option>
									<option value="fa-file-pdf-o">fa-file-pdf-o</option>
									<option value="fa-search">fa-search</option>
								</select>							
							</div>
						</div>
						<div class="form-group">
							<label for="Nombre" class="control-label col-md-2 col-sm-2 col-md-offset-2 col-sm-offset-2"></label>
							<div class="col-md-3 col-sm-3">
							<label for="link" class="radio-inline">	
	                             <input type="radio" id="link" name="link" value="1" {{ $register && $register->link ? 'checked' : '' }} />
	                             Link
		            		</label>
							</div>
							<div class="col-md-3 col-sm-3">
		            			<label for="sub" class="radio-inline">
		            				
	                                <input type="radio" id="sub" name="link" value="0" {{ $register && !$register->link ? 'checked' : '' }}>
		            				Sub Menú
		            			</label>
		            		</div>	
						</div>

						<div class="form-group" id="ruta_oculta" 
						<?php if ($register){
	                                      if (!$register->link){ ?>
	                                      	style="display: none;
	                                      <?php } 
	                                  } else 
	                                  { ?> style="display: none; <?php } ?>
	                                      ">

		            		<div class="form-group">
		            			<label for="ruta" class="control-label col-md-4 col-sm-4">Ruta</label>
		            			<div class="col-md-4 col-sm-4">
		            			<input type="text" id="ruta_area" name="ruta" class="form-control" value="<?= $register ? $register->ruta : '' ?>">
		            			</div>
		            		</div>
		            	</div>

						<div class="form-group">
							<div class="col-md-4 col-sm-4 col-sm-offset-4 col-md-offset-4">
								<button type="submit" class="btn btn-block btn-pink">Guardar&nbsp;<i class="fa fa-send"></i></button>
							</div>
						</div>
						<div class="form-group">
							<div class="col-md-4 col-sm-4 col-sm-offset-4 col-md-offset-4 text-center">
								<a class="btn btn-default" href="{{ route('menu.index') }}">Volver a la vista del Menú </a>
							</div>
						</div>
							
					</form>
				</div>
			</div>	
		</div>
	</div>
@endsection

@section('scripts')
	<script>
		$(function(){

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
		})
			
	</script>
@endsection

