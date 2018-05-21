@extends('layout.app')

@section('content')
	<div class="page-header">
		<h1>
			Dashboard
			<small>
				<i class="ace-icon fa fa-angle-double-right"></i>
				Perfil
			</small>
		</h1>
	</div><!-- /.page-header -->

	<div class="row no-gutters">
		<div class="col-md-10 col-sm-10">
			<div class="row no-gutters">
				<h4 class="">Base de datos</h4>
				<a href="{{ route('perfil.index', ['tipo_db' => 1]) }}" 
					class="btn btn-app btn-{{ session('tipo_db') === '1' ? 'primary':'default' }}">
					<i class="ace-icon fa fa-tachometer bigger-250"></i>Default&nbsp;
				</a>
			
				<a href="{{ route('perfil.index', ['tipo_db' => 2]) }}" 
					class="btn btn-app btn-{{ session('tipo_db') === '2' ? 'primary':'default' }}">
					<i class="ace-icon fa fa-eye bigger-250"></i>Admin&nbsp;
				</a>
					

		    </div>
		</div>

		<div class="col-sm-2 col-md-2">				
						<a href="#" class="btn btn-app btn-success" data-toggle='modal' data-target='#modal_perfil'>
							<i class="ace-icon fa fa-fire bigger-250"></i>
							+ Perfil&nbsp;
						</a>
			</div>		


	</div>


	<div class="row no-gutters">
		<div class="col-md-12 col-sm-12">
			
			<table class="table table-bordered table-responsive" id="tabla">
				<thead>
					<tr>
						<th class="text-center">Id</th>
						<th class="text-center">Nombre</th>
						<th class="text-center">Activo</th>
						<th class="text-center">Acción</th>
					</tr>
				</thead>
				<tbody class="text-center">
					<?php foreach ($perfil as $row) 
					{ ?>
						<tr>
							<td class="hidden-480">
							  <?php echo $row->id; ?>
							</td>
							<td class="hidden-480">
							  <?php echo $row->nombre; ?>
							</td>
					     	<td class="hidden-480">
					     	<?php if ($row->activo == 't'){?>	
					     	<span class="label label-sm label-success">Activo</span>
					     	<?php }else{ ?>	
							<span class="label label-sm label-warning">Inactivo</span>
							<?php } ?>	
							</td>
							<td class="hidden-480">
							
							</td>
						</tr>	
					<?php }?>	
				</tbody>
			</table>
		</div>
	</div>
			

	<div id="modal_perfil" class="modal fade" role="dialog">
	    <div class="modal-dialog">
	        <!-- Modal content-->
	        <div class="modal-content">
	            <div class="modal-header modalHeader">
	                <button type="button" class="close" data-dismiss="modal">×</button>
	                <h4 class="modal-title">Agregar Perfil</h4>
	            </div>
	            <form action="{{ url('perfil') }}" class="form-horizontal" id="form_perfil" method="POST">
	            	{{ csrf_field() }}
		            <div class="modal-body">
						
		            	<div class="form-group">
		            		<label for="nombre" class="control-label col-md-2 col-sm-2">Nombre Perfil</label>
		            		<div class="col-md-4 col-sm-4">
		            			<input type="text" id="nombre" name="nombre" required="" class="form-control" value="">
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
@endsection

@section('scripts')

@endsection





			

				
