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
      <li class="active"><a href="#">Crear Vista</a></li>
      <li class="active">Detalles</li>
    </ul><!-- /.breadcrumb -->          
  </div>

  <br/>

  <div class="row no-gutters">
    <div class="col-md-12 col-sm-12">
      <div class="widget-box">
        <div class="widget-header">
          <h3 class="widget-title">
            Permisología
            <a href="{{ route('crear_vista.index',['menu' => session('id_menu')]) }}" class="btn btn-purple btn-md pull-right">Regresar&nbsp;<i class="fa fa-arrow-up"></i></a>
          </h3>
        </div>
        <div class="widget-body">
          <div class="widget-main">
            <div class="row no-gutters">
              <div class="col-md-12 col-sm-12">
                <div class="tabbable">
                  <ul class="nav nav-tabs padding-12 tab-color-blue background-blue" id="myTab4">
                    <li class="active">
                      <a data-toggle="tab" href="#home4">DataTable</a>
                    </li>

                    <li>
                      <a data-toggle="tab" href="#profile4">Formulario</a>
                    </li>

                    <li>
                      <a data-toggle="tab" href="#profile5">Generar Archivos</a>
                    </li>
                  </ul>

                  <div class="tab-content">
                    <div id="home4" class="tab-pane in active"> <!-- Data Table -->
                      <div id="div_table_dt">
                        <button class="btn btn-pink pull-right" data-ruta="{{ route('crear_vista.store_vista_dt') }} " id ="btn_add_dt">
                          <i class="ace-icon fa fa-plus bigger-160"></i>
                          Agregar
                        </button>
                        <div class="clearfix"></div>
                        <br/>
                        <table class="table table-bordered table-responsive table-hover" id="tabla_dt">
                          <thead>
                            <tr>
                              <th class="text-center text-primary"></th>
                              <th class="text-center text-primary">Th</th>
                              <th class="text-center text-primary">Activo</th>
                              <th class="text-center text-primary">Key Tbody</th>
                              <th class="text-center text-primary">Resaltar</th>
                              <th class="text-center text-primary">Orden</th>
                            </tr>
                          </thead>
                          <tbody class="text-center">
                            <?php foreach ($vista_dt as $row): ?>
                              
                              <tr>
                                <td>
                                  <a data-tool="tooltip" title="modificar" href="#" 
                                    
                                    data-id ="{{ $row->id }}"
                                    data-th ="{{ $row->nombre }}"
                                    data-activo ="{{ $row->activo }}"
                                    data-key ="{{ $row->key }}"
                                    data-resaltar ="{{ $row->resaltar }}"
                                    data-format_number ="{{ $row->format_number }}"
                                    data-orden ="{{ $row->orden }}"
                                  >
                                                      <img src="{{ asset('assets_sistema/images/acciones/modificar.png') }}" width="20px" class="modificar"/>
                                                  </a>
                                                  <a data-tool="tooltip" title="Eliminar" href="#" data-ruta="{{ url('crear_vista/delete_td/'.$row->id) }}">
                                                      <img src="{{ asset('assets_sistema/images/acciones/remover.jpg') }}" width="20px" class="eliminar_td"/>
                                                  </a>
                                </td>
                                <td>{{ $row->nombre }}</td>
                                <td>{{ $row->activo ? 'Activo' : 'Desactivado' }}</td>
                                <td>{{ $row->key }}</td>
                                <td>{{ $row->resaltar ? 'Si' : 'No' }}</td>
                                <td>
                                  
                                  <span class="label label-lg label-yellow arrowed-in arrowed-in-right">{{ $row->orden }}</span>
                                    
                                </td>
                              </tr>
                            <?php endforeach ?>
                          </tbody>
                        </table>
                      </div> <!-- fin div_tabla -->
                      <div id="div_form_dt" class="hidden">
                        <form action="" class="form-horizontal" id="form_dt">
  
                          {{ csrf_field() }}
                          <input type="hidden" id="id_config" name="id_config" value="{{ $modulo }}">
                          <input type="hidden" id="activo" name="activo" value="t">

                          <div class="form-group">
                            <label for="th" class="control-label col-md-2 col-sm-2">Th</label>
                            <div class="col-md-4 col-sm-4">
                              <input type="text" id="nombre" name="nombre" required="" class="form-control" value="">
                            </div>
                            <label for="key" class="control-label col-md-2 col-sm-2">Key Body</label>
                            <div class="col-md-4 col-sm-4">
                              <input type="text" id="key" name="key" required="" class="form-control" value="">
                            </div>
                          </div>
                          <div class="form-group">
                            <label for="th" class="control-label col-md-2 col-sm-2">Resaltar</label>
                            <div class="col-md-4 col-sm-4">
                              <select name="resaltar" id="resaltar" class="form-control">
                                <option value="">No</option>
                                <option value="1">Si</option>
                              </select>
                            </div>
                            <label for="key" class="control-label col-md-2 col-sm-2">Formateo Número</label>
                            <div class="col-md-4 col-sm-4">
                              <select name="format_number" id="format_number" class="form-control">
                                <option value="">No</option>
                                <option value="1">Si</option>
                              </select>
                            </div>
                          </div>
                          <div class="form-group">
                            <label for="orden" class="control-label col-md-2 col-sm-2">Order</label>
                            <div class="col-md-4 col-sm-4">
                              <input type="number" id="orden" name="orden" required="" class="form-control" value="" readonly="">
                            </div>
                          </div>
                          <div class="form-group">
                             <div class="col-md-offset-4 col-sm-offset-4">
                              <div class="col-md-3 col-sm-3">
                                <button type="submit" class="btn btn-pink btn-block">Guardar</button>
                              </div>
                              <div class="col-md-3 col-sm-3">
                                <button id="btn_form_list" type="button" class="btn btn-info btn-block">Ver Registros</button>
                              </div>
                             </div>
                          </div>
                        </form>
                      </div>
                    </div> <!-- fin pane -->

                    <div id="profile4" class="tab-pane"> <!-- Formulario -->
                      <div id="div_table_form">
                        <button class="btn btn-pink pull-right" data-ruta="{{ url('crear_vista/store_vista_form') }}" id ="btn_add_form">
                          <i class="ace-icon fa fa-plus bigger-160"></i>
                          Agregar
                        </button>
                        <div class="clearfix"></div>
                        <br/>
                        <table class="table table-bordered table-responsive table-hover" id="tabla_form">
                          <thead>
                            <tr>
                              <th class="text-center text-primary"></th>
                              <th class="text-center text-primary">Label</th>
                              <th class="text-center text-primary">Tipo</th>
                              <th class="text-center text-primary">Name_id</th>
                              <th class="text-center text-primary">Check_table</th>
                              <th class="text-center text-primary">Value</th>
                              <th class="text-center text-primary">Option</th>
                              <th class="text-center text-primary">Cols</th>
                              <th class="text-center text-primary">Orden</th>
                            </tr>
                          </thead>
                          <tbody class="text-center">
                            <?php foreach ($vista_form as $row): 

                              $type = '';
                              switch ($row->tipo) {
                                case '1':
                                  $type = 'Text';
                                break;

                                case '2':
                                  $type = 'Number';
                                break;

                                case '3':
                                  $type = 'Select A. Object';
                                break;

                                case '4':
                                  $type = 'Select A.';
                                break;

                                case '5':
                                  $type = 'Radio';
                                break;

                                case '6':
                                  $type = 'Checkbox';
                                break;

                                case '7':
                                  $type = 'Textarea';
                                break;

                                case '8':
                                  $type = 'Date';
                                break;

                                case '9':
                                  $type = 'Number';
                                break;

                                case '10':
                                  $type = 'Hidden';
                                break;

                                case '11':
                                  $type = 'File';
                                break;

                                case '12':
                                  $type = 'Color';
                                break;

                                case '13':
                                  $type = 'email';
                                break;
                              }

                              $requerido = $row->required ? 'Si' : 'No';

                            ?>
                              
                              <tr>
                                <td>
                                  <a data-tool="tooltip" title="modificar" href="#" 
                                    
                                    data-id ="{{ $row->id }}"
                                    data-label ="{{ $row->label }}"
                                    data-tipo ="{{ $row->tipo }}"
                                    data-required ="{{ $row->required }}"
                                    data-name_id ="{{ $row->name_id }}"
                                    data-placeholder ="{{ $row->placeholder }}"
                                    data-value ="{{ $row->value }}"
                                    data-option ="{{ $row->option }}"
                                    data-selected ="{{ $row->selected }}"
                                    data-orden ="{{ $row->orden }}"
                                    data-multiple ="{{ $row->multiple }}"
                                    data-check_table ="{{ $row->check_table }}"
                                    data-check_field ="{{ $row->check_field }}"
                                    data-cols ="{{ $row->cols }}"
                                  >
                                                      <img src="{{ asset('assets_sistema/images/acciones/modificar.png') }}" width="20px" class="modificar"/>
                                                  </a>
                                                  <a data-tool="tooltip" title="Eliminar" href="#" data-ruta="{{ url('crear_vista/delete_form/'.$row->id) }}">
                                                      <img src="{{ asset('assets_sistema/images/acciones/remover.jpg') }}" width="20px" class="eliminar_form"/>
                                                  </a>
                                </td>
                                <td>{{ $row->label }}</td>
                                <td>
                                  @php
                                  echo '<span class="label label-lg label-purple arrowed-in arrowed-in-right">'.$type.'</span><br/>'.'<b>Requerido:</b> '.$requerido;
                                  @endphp

                                </td>
                                <td>{{ $row->name_id }}</td>
                                <td>@php echo $row->check_table."<br/>".$row->check_field; @endphp</td>
                                <td>{{ $row->value }}</td>
                                <td>{{ $row->option }}</td>
                                <td>{{ $row->cols }}</td>
                                <td>
                                  
                                  <span class="label label-lg label-yellow arrowed-in arrowed-in-right">{{ $row->orden }}</span>
                                    
                                </td>
                              </tr>
                            <?php endforeach ?>
                          </tbody>
                        </table>
                      </div> <!-- fin div_tabla -->
                      <div id="div_form_form" class="hidden"><!-- div form  -->
                        <form action="" class="form-horizontal" id="form_form">

                          {{ csrf_field() }}
                          <input type="hidden" id="id_config" name="id_config" value="{{ $modulo }}">
                          
                          
                          <div class="form-group">
                            <label for="label" class="control-label col-md-2 col-sm-2">Label</label>
                            <div class="col-md-4 col-sm-4">
                              <input type="text" id="label" name="label" required="" class="form-control" value="">
                            </div>
                            <label for="tpi" class="control-label col-md-2 col-sm-2">Tipo</label>
                            <div class="col-md-4 col-sm-4">
                              <select name="tipo" id="tipo" class="form-control" required="">
                                <option value="">Seleccione</option>
                                <option value="1">Texto</option>
                                <option value="2">Number</option>
                                <option value="3">Select Object Array</option>
                                <option value="4">Select Array</option>
                                <option value="5">Radio</option>
                                <option value="6">Checkbox</option>
                                <option value="7">TextAerea</option>
                                <option value="8">Date</option>
                                <option value="9">Tlf</option>
                                <option value="10">Hidden</option>
                                <option value="11">File</option>
                                <option value="12">Color</option>
                                <option value="13">Email</option>
                              </select>
                            </div>
                          </div>
                          <div class="form-group">
                            <label for="required" class="control-label col-md-2 col-sm-2">Requerido</label>
                            <div class="col-md-4 col-sm-4">
                              <select name="required" id="required" class="form-control" required="">
                                <option value="1">Si</option>
                                <option value="0">No</option>
                              </select>
                            </div>
                            <label for="name_id" class="control-label col-md-2 col-sm-2">Name_ID</label>
                            <div class="col-md-4 col-sm-4">
                              <input type="text" id="name_id" name="name_id" required="" class="form-control" value="">
                            </div>
                          </div>
                          <div class="form-group">
                            <label for="placeholder" class="control-label col-md-2 col-sm-2">Placeholder</label>
                            <div class="col-md-4 col-sm-4">
                              <input type="text" id="placeholder" name="placeholder" class="form-control" value="">
                            </div>
                            <label for="value" class="control-label col-md-2 col-sm-2">Value</label>
                            <div class="col-md-4 col-sm-4">
                              <input type="text" id="value" name="value" class="form-control" value="">
                            </div>
                          </div>
                          <div class="form-group">
                            <label for="option" class="control-label col-md-2 col-sm-2">Option</label>
                            <div class="col-md-4 col-sm-4">
                              <input type="text" id="option" name="option" class="form-control" value="" disabled="">
                            </div>
                            <label for="selected" class="control-label col-md-2 col-sm-2">Selected</label>
                            <div class="col-md-4 col-sm-4">
                              <input type="text" id="selected" name="selected" class="form-control" value="" disabled="">
                            </div>
                          </div>
                          <div class="form-group">
                            <label for="orden" class="control-label col-md-2 col-sm-2">Orden</label>
                            <div class="col-md-4 col-sm-4">
                              <input type="number" id="orden" name="orden" class="form-control" value="">
                            </div>
                            <label for="multiple" class="control-label col-md-2 col-sm-2">Multiple</label>
                            <div class="col-md-4 col-sm-4">
                              <select name="multiple" id="multiple" class="form-control" required="">
                                <option value="0">No</option>
                                <option value="1">Si</option>
                              </select>
                            </div>
                          </div>
                          <div class="form-group">
                            <label for="check_table" class="control-label col-md-2 col-sm-2">check_table</label>
                            <div class="col-md-4 col-sm-4">
                              <input type="text" id="check_table" name="check_table" class="form-control" value="" disabled="">
                            </div>
                            <label for="check_field" class="control-label col-md-2 col-sm-2">check_field</label>
                            <div class="col-md-4 col-sm-4">
                              <input type="text" id="check_field" name="check_field" class="form-control" value="" disabled="">
                            </div>
                          </div>
                          <div class="form-group">
                            <label for="check_field" class="control-label col-md-2 col-sm-2">Cols</label>
                            <div class="col-md-4 col-sm-4">
                              <input type="text" id="cols" name="cols" class="form-control" value="12,6,6,6" placeholder="columnas de bootstrap desde xs hasta lg separados por ,">
                            </div>
                          </div>
                          <div class="form-group">
                             <div class="col-md-offset-4 col-sm-offset-4">
                              <div class="col-md-3 col-sm-3">
                                <button type="submit" class="btn btn-pink btn-block">Guardar</button>
                              </div>
                              <div class="col-md-3 col-sm-3">
                                <button id="btn_form_form" type="button" class="btn btn-info btn-block">Ver Registros</button>
                              </div>
                             </div>
                          </div>
                        </form>
                      </div> <!-- div form hidden -->
                    </div> <!-- fin panel formulario -->
                    <div id="profile5" class="tab-pane"> <!-- Generar Vista -->
                      <div class="col-md-12 col-sm-12">
                        <form action="" class="" id="form_txt">
                          {{ csrf_field() }}
                          <input type="hidden" name="modulo" value="{{ $modulo }}">
                          <h3 class="text-center">Generar Vista</h3>
                          <br/>
                          <div class="form-group row no-gutters">
                            <div class="col-md-4 col-sm-4 control-label col-md-offset-4 col-sm-offset-4">
                              <input type="text" class="form-control" name="sistema" required="" placeholder="Nombre del Sistema">
                            </div>
                          </div>
                          <div class="form-group row no-gutters">
                            <div class="col-md-offset-5 col-sm-offset-5 col-md-3 col-sm-3">
                              <button type="submit" class="btn btn-app btn-pink no-radius" id="btn_generar_vista">
                                <i class="ace-icon fa fa-cloud-upload bigger-250"></i>
                                Click
                              </button>
                            </div>
                          </div>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>  
              </div>
            </div>
          </div>
        </div>
      </div>    
    </div>  
  </div>


<!-- =============================== Gift Cargando ==================================== -->

  <div class="row no-gutters loading_gift" id="div_image" style="display: none;">
    <div class="col-md-4 col-sm-4 col-md-offset-4 col-sm-offset-4">
      <div class="">
        <img src="{{ asset('assets_sistema/images/gift/cargando.gif') }}" alt="">
        <br/>
        Realizando Configuración...
      </div>
    </div>
  </div>

<!-- =============================== FORM ELIMINAR ==================================== -->

<form action="" method="POST" id="form_delete">
  {{ csrf_field() }}
  {{ method_field('DELETE') }}
  <input type="hidden" name="modulo" value="{{ $modulo }}">
</form>

@endsection

@section('scripts')
    @include('config_view.scripts')
@endsection