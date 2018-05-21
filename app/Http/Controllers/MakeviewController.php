<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Configview;
use App\Vistaformulario;
use App\VistaTitulodt;

class MakeviewController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        session(['id_menu' => $request->menu ]);

        $data = Configview::all();
        return view('config_view.index')->with('data',$data);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $id = session('id_menu');

        $config_view = new Configview;

        $config_view->fill($request->all());
        $config_view->controlador = true;
        $config_view->createdat = date('Y-m-d H:i:s', strtotime('-4 hour'));
        $config_view->updatedat = date('Y-m-d H:i:s', strtotime('-4 hour'));

        $config_view->save();

        return redirect()->route('crear_vista.index',['menu' => $id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $data['vista_dt'] = VistaTitulodt::where('id_config',$id)->orderBy('orden','asc')->get();
        $data['vista_form'] = Vistaformulario::where('id_config',$id)->orderBy('orden','asc')->get();
        $data['modulo'] = $id;

        return view('config_view.show')->with($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //

        $id_menu = session('id_menu');

        $config_view = Configview::findOrFail($id);

        $config_view->fill($request->all());

        $config_view->updatedat = date('Y-m-d H:i:s', strtotime('-4 hour'));

        $config_view->update();

        return redirect()->route('crear_vista.index',['menu' => $id_menu]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $id_menu = session('id_menu');

        try{
            Configview::destroy($id);
            
            return redirect()->route('crear_vista.index',['menu' => $id_menu])->with([
                'type' => "success",
                "message" => "Registro Eliminado con Éxito"
            ]);
        }
        catch(\Illuminate\Database\QueryException $e){

            return redirect()->route('crear_vista.index',['menu' => $id_menu])->with([
                'type' => "danger",
                "message" => "No se puede eliminar registros con hijos"
            ]);
        }
    }

    // ==================================== DATATABLE VISTA ==================================================

    public function store_vista_dt(Request $request)
    {
      $vista_dt = new VistaTitulodt;

      $maximo_orden = VistaTitulodt::max('orden');
      $orden = !empty($maximo_orden) ? $maximo_orden + 1 : 1;

      $vista_dt->fill($request->all());

      $vista_dt->orden = $orden;
      $vista_dt->createdat = date('Y-m-d H:i:s', strtotime('-4 hour'));
      $vista_dt->updatedat = date('Y-m-d H:i:s', strtotime('-4 hour'));

      $res = false;
      $record = '';

      DB::beginTransaction();
      try
      {
        $vista_dt->save();
        $record = VistaTitulodt::where('id',$vista_dt->id)->get();
        DB::commit();

        $res = true;
      }  
      catch(\Illuminate\Database\QueryException $e)
      {
        DB::rollBack();
      }


      return response()->json(['r' => $res, 'datos' => $record]);
    }

    public function update_dt(Request $request, $id)
    {
      $vista_dt = VistaTitulodt::findOrFail($id);
      $vista_dt->fill($request->all());

      $vista_dt->updatedat = date('Y-m-d H:i:s', strtotime('-4 hour'));
      $vista_dt->update();

      $request->session()->flash('type', 'success');
      $request->session()->flash('message', 'Registro Modificado con Éxito');

      return response()->json(['r' => true,'edit' => true]);
    }

    public function delete_td(Request $request,$id)
    {
      VistaTitulodt::destroy($id);

      $request->session()->flash('type', 'success');
      $request->session()->flash('message', 'Registro Eliminado con Éxito');

      return redirect('crear_vista/'.$request->modulo);
    }
    // ==================================== FORM VISTA ==================================================

    public function store_vista_form(Request $request)
    {
      $vista_f = new Vistaformulario;
      $vista_f->fill($request->all());

      $maximo_orden = Vistaformulario::max('orden');

      $orden = !empty($maximo_orden) ? $maximo_orden + 1 : 1;
      
      $vista_f->orden = $orden;
      $vista_f->createdat = date('Y-m-d H:i:s', strtotime('-4 hour'));
      $vista_f->updatedat = date('Y-m-d H:i:s', strtotime('-4 hour'));
      $res = false;
      DB::beginTransaction();
      try
      {
        $vista_f->save();
        $record = Vistaformulario::where('id',$vista_f->id)->get();
        DB::commit();
        $res = true;
      }  
      catch(\Illuminate\Database\QueryException $e)
      {
        DB::rollBack();
      }
      return response()->json(['r' => $res, 'datos' => $record]);
    }

    public function update_form(Request $request,$id)
    {
      $vista_f = Vistaformulario::findOrFail($id);
      $vista_f->fill($request->all());

      $vista_f->updatedat = date('Y-m-d H:i:s', strtotime('-4 hour'));
      $vista_f->update();

      $request->session()->flash('type', 'success');
      $request->session()->flash('message', 'Registro Modificado con Éxito');

      return response()->json(['r' => true,'edit' => true]); 
    }

    public function delete_form(Request $request, $id)
    {
      Vistaformulario::destroy($id);

      $request->session()->flash('type', 'success');
      $request->session()->flash('message', 'Registro Eliminado con Éxito');

      return redirect('crear_vista/'.$request->modulo); 
    }

    public function make_view(Request $request){
      // ========================= CREACIÓN DE LAS RUTAS ======================================= //

      $vista = $request->modulo;

      $sistema = $request->sistema;

      $ruta = realpath(__DIR__.'../../../../../');

      $ruta = str_replace('\\', '/', $ruta);

      $ruta_vista = $ruta.'/'.$sistema.'/resources/views/';

      $ruta_controlador = $ruta.'/'.$sistema.'/app/Http/Controllers/';

      $ruta_modelo = $ruta.'/'.$sistema.'/app/Models/';

      $ruta_rutas = $ruta.'/'.$sistema."/routes/web";

  // ==================== VISTA DATA TABLE ========================================

      $config_modulo = Configview::where('id',$vista)->first();
      $config_dt = VistaTitulodt::where('id_config',$vista)->orderBy('orden','asc')->get();
      
      $th = '['.'"Acción",';
      $key_data = '[';

      $nombre_modulo = $config_modulo->modulo;
      $nombre_modulo_vista = strtolower(explode('Controller', $nombre_modulo)[0]);

      $nombre_controller= $nombre_modulo."Controller";

      $tabla = $config_modulo->tabla;
      $ruta_imagen = $config_modulo->ruta_imagen;

      $membrete = "'".$config_modulo->membrete."'";
      $titulo_vista = "'".$config_modulo->titulo."'";
      
      $bread = '[';
      
      $enctype = $config_modulo->enctype;
      $color = 'pink';
      $modelo_import = strtolower($nombre_modulo_vista.'model');
      $array_fillable = '[';

      
      foreach ($config_dt as $row) 
      {
        $th.= "'".$row->nombre."',";
        $key_data.= "'".$row->key."',";
      }

      foreach (explode(',', $config_modulo->breadcrumb) as $row) 
      {
        $bread.= "'".$row."',";
      }

      $th = strlen($th) > 1 ? substr($th,0,strlen($th) -1)."];" : $th.= '];';

      $bread = strlen($bread) > 1 ? substr($bread,0,strlen($bread) -1)."];" : $bread.= '];';

      $key_data = strlen($key_data) > 1 ? substr($key_data,0,strlen($key_data) -1)."];" : $key_data.= '];';
      

  // ================================ FORMULARIO ==========================================
      $config_form = Vistaformulario::where('id_config',$vista)->orderBy('orden','asc')->get();


      $campos = '[';

      $total_form_elements = count($config_form);
      $con_elements = 0;
      $options_html_querys = '';

      foreach ($config_form as $row) 
      {
        $array = '[';

        $array.= "'".$row->cols."'".",";
        $array.= "'".$row->label."'".",";
        $array.= "'".$row->tipo."'".",";
        $array.= "'".$row->required."'".",";

        $array_fillable.= "'$row->name_id',";

        if($row->tipo !== '5' && $row->tipo !== '6')
        {
          
          $array.= "'".$row->name_id."'".",";
          $array.= "'".$row->placeholder."'".",";
          $array.= "'".$row->value."'".",";

          if($row->tipo === '3')
          {
            $options_html_querys .= '$options'.$con_elements.'= DB::select(BD::raw("'."SELECT id, $row->selected from $row->option where activo = 't'".'"));'." \n \t \t";

            $selected = !empty($row->selected) ? $row->selected : 'nombre';
            
            $array.= '$options'.$con_elements.',';
            $array.= "'".$selected."',";
            
          }
          elseif($row->tipo === '4')
          {
            $valores = explode('-', $row->option);

            $asociacion = '[';

            $selected = !empty($row->selected) ? $row->selected : 'nombre';

            $con = 0;
            foreach ($valores as $row1) 
            {
              $y = explode(',', $row1);

              $z = '["id" => "'.$y[0].'", "'.$selected.'" => "'.$y[1].'"],';

              $asociacion.= $z;
            }

            $asociacion = substr($asociacion, 0, strlen($asociacion) - 1);

            $asociacion.=']';

            $array.= $asociacion.",";
            $array.= "'".$selected."'".',';
          }

          $array.= "'".$row->multiple."'";

        }
        else
        {

          if(!empty($row->check_table))
          {
            $sql = "SELECT id, $row->check_field from $row->check_table where activo = 't'";
            //$result = $this->configviewmodel->query($sql);
            
            $x = '[';
            
            $x.= "'".$row->check_field."'".',';
            $x.= "'".$row->name_id."'".',';
            $x.= "'0'".",";
            $x.= "'".$row->selected."'".",";
            $x.= "'".base64_encode($sql)."'".",";


            $x = substr($x, 0,strlen($x) -1);
            
            $pick = '['.$x.'],';

            $array.= $pick;
          }
          else
          {
            $id_name = explode('-',$row->name_id);

            $con = 0;
            $x = '';
            $valores = explode(',', $row->value);
            $pick = '[';

            foreach (explode(',', $id_name[1]) as $row1) 
            {

              $x = '[';

              $x.= "'".$row1."'".',';
              $x.= "'".$id_name[0]."'".',';
              $x.= "'".$valores[$con]."'".',';
              $x.= "'".$row->selected."'";

              $x = $x.'],';

              $pick.= $x;
              
              $con++;

            }

            $pick = substr($pick, 0,strlen($pick) -1);

            $pick = $pick.']';


            $array.= $pick;
          }
        } // end if si es radio o check

        $con_elements++;

        if($total_form_elements !== $con_elements)
        {

          $campos.= $array.'],';
        }
        else
        {
          $campos.= $array.']'; 
        }

      } // fin foreach

      $campos.='];';
      $array_fillable .= "'updated_at','created_at'];";
            

  //================================ HTML DE LA VISTA ===================================================

      $ruta_imagen_vista = $ruta_imagen;
      $data_vista = ' 
@extends("layout.app")
@section("content")
  
  @php
    $th = '.$th."\n".'
    $key_data = '.$key_data."\n".'
    $titulo ='.$titulo_vista.";\n".'
    $bread = '.$bread."\n".'
    $color = "pink";'."\n".'
    $membrete = '.$membrete.";\n".'
    $totales = [];'."\n".'
    $ruta_imagen = "'.$ruta_imagen_vista.'";'."\n".'
    $enctype = "'.$enctype.'";

    echo form_vista($enctype,null,$campos, $data,$th,$key_data,$totales,$color,$bread,$titulo,$membrete,$ruta_imagen); 

  @endphp
@endsection

@section("scripts")
  <script>
    $(function(){

    })
  </script>
@endsection
';

  //================================ FUNCIONES CONTROLADOR ===================================================

    $funciones_controlador_primario = '';
    $modelo_controlador_primario = '';

      $funciones_controlador_primario = '
        
      public function store(Request $request){
        
        $store = new '.ucwords($modelo_import).';
        $store->fill($request->all());
        $store->updated_at = date("Y-m-d H:i:s");
        $store->created_at = date("Y-m-d H:i:s");

        $function = session("funcion");
        $id_menu  = session("id_menu");

        foreach ($_FILES as $key => $row) {

          if(!empty($row["name"])){
            
            $ruta = "'.$ruta_imagen.'";

            $file = $request->{$key};

        
            $imageName = time().".".$file->getClientOriginalExtension();

            $file->move(public_path("'.$ruta_imagen.'"), $imageName);
            
            $store->{$key} = $imageName;
          }
        }

        $store->save();

        return redirect()->route($function,["menu" => $id_menu])->with([
          "type" => "success",
          "message" => "registro almacenado con éxito"
        ]);
      }

      //Update one item
      public function update(Request $request,$id){
        
        $store = '.ucwords($modelo_import).'::findOrFail($id);

        $store->fill($request->all());
        $store->updated_at = date("Y-m-d H:i:s");

        $function = session("funcion");
        $id_menu  = session("id_menu");

        foreach ($_FILES as $key => $row) 
        {
          if(!empty($row["name"]))
          {
            
            $ruta = "'.$ruta_imagen.'";

            $file = $request->{$key};

        
            $imageName = time().".".$file->getClientOriginalExtension();

            $file->move(public_path("'.$ruta_imagen.'"), $imageName);
            
            $store->{$key} = $imageName;
          }
        }

        $store->update();

        return redirect()->route($function,["menu" => $id_menu])->with([
          "type" => "success",
          "message" => "registro modificado con éxito"
        ]);
      }

      //Delete one item
      public function destroy($id)
      {
        $function = session("funcion");
        $id_menu  = session("id_menu");
        
        try{
        
          '.ucwords($modelo_import).'::destroy($id);
          return redirect()->route($function,["menu" => $id_menu])->with(["type" => "success", "message" => "Registro eliminado con Éxito"]);
        
        }catch(\Illuminate\Database\QueryException $e){
          
          $message = "No se puede eliminar el registro porque tiene registros asociados";
          return redirect()->route("users.index")->with(["type" => "success", "message" => $message]);
        }

      }

      public function pdf_general()
      {

      }

      public function pdf_singular($id)
      {

      }

      ';

  //================================ MODELO ===================================================

      $modelo_controlador_primario = '<?php

  namespace App\Models;

  use Illuminate\Database\Eloquent\Model;

  class '.ucwords($modelo_import).' extends Model
  {
      //
    protected $table = "'.$config_modulo->tabla.'";

    protected $fillable = '.$array_fillable.'

    public $timestamps =  false;
  }
?>';
  // ============================= CONTROLADOR MÄS FUNCIONES ==================================

    $data_controller = '<?php
  namespace App\Http\Controllers;

  use Illuminate\Support\Facades\Auth;
  use Illuminate\Support\Facades\DB;
  use Illuminate\Http\Request;

  use App\Models\\'.ucwords($modelo_import).';

  class '.$nombre_controller.' extends Controller
  {

    public function index(Request $request)
    {
      $id_menu = $request->get("menu");

      $array = array(
        "id_menu" => $id_menu,
        "funcion" => "'.$nombre_modulo_vista.'.index",
        "ruta_imagen" => "'.$ruta_imagen.'"
      );
      
      session($array);

      '.$options_html_querys.'
      $data["data"] = '.ucwords($modelo_import).'::all();
      $data["campos"] = '.$campos.'
      return view("'.strtolower($nombre_modulo_vista).'.index")->with($data);
    }

    '.$funciones_controlador_primario.' 
  }

  ?>
  ';
      $respuesta = [];
      if(!file_exists($ruta_vista.strtolower($nombre_modulo_vista)))
      {
        // si no existe la carpeta en la vista la creamos
        mkdir($ruta_vista.strtolower($nombre_modulo_vista),0777,true);
      }

      $vista_blade = fopen($ruta_vista.strtolower($nombre_modulo_vista)."/index.blade.php", "w");

      if ( ! fwrite($vista_blade, $data_vista))
      {
              $respuesta[] = ['vista' => 'No ha podido ser generada'];
              fclose($vista_blade);
      }
      else
      {       
              $respuesta[] = ['vista' => 'Generada con éxito'];
              fclose($vista_blade);
      }

      $controller_blade = fopen($ruta_controlador.$nombre_controller.".php", "w");

      if ( ! fwrite($controller_blade, $data_controller))
      {
            // creación del controlador
              $respuesta[] = ['controlador' => 'No ha podido ser generado'];
              fclose($controller_blade);
      }
      else
      {
              $respuesta[] = ['controlador' => 'Ha sido generado con éxito'];
              fclose($controller_blade);
      }

      $model_blade = fopen($ruta_modelo.ucwords($modelo_import).".php", "w");

      if ( ! fwrite($model_blade, $modelo_controlador_primario))
      {
          // creacion del modelo
              $respuesta[] = ['modelo' => 'No ha podido ser generado'];
      }
      else
      {
              $respuesta[] = ['modelo' => 'Ha sido generado con éxito'];
      } 

      $route_blade = fopen($ruta_rutas.".php", "a");
      $ruta_nueva = "\n//$nombre_modulo\nroute::resource('$nombre_modulo_vista','$nombre_controller');";

      if ( ! fwrite($route_blade, $ruta_nueva))
      {
            // creacion de la ruta
              $respuesta[] = ['ruta' => 'No ha podido ser generado'];
      }
      else
      {
              $respuesta[] = ['ruta' => 'Ha sido generado con éxito'];
      } 

      return response()->json($respuesta);
    } // FIN FUNCION

}

