<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Permiso;
use App\Perfil;
use App\User;
use App\Menu;
use App\PermisoAccion;

class PermisoController extends Controller
{
    //

	public function index(Request $request)
	{
    
    select_db($request->get('tipo_db'));

    $accesos = Menu::show_menu();
    $total_perfiles = Perfil::count();
    $total_users = User::count();

    $datos = ['accesos' => $accesos,'total_perfiles' => $total_perfiles, 'total_users' => $total_users];

		return view('permiso.index')->with($datos);
	}

    public function buscar_perfiles_ajax(Request $request)
    {
    	// -- función para buscar los perfiles

    	$type = $request->get('type') === 'manuales' ? true : false;
    	$where = '';

    	if($type)
	    {
	        $where = "sistema = 't'";
	    }
	      else
	    {
	        $where = "sistema = 'f'";
	    }

	    $perfil = Perfil::whereRaw($where)->get();
	    $user   = User::all();
    	
    	$result = ['perfiles' => $perfil, 'usuarios' => $user];

    	return response()->json($result);
    }

    public function buscar_modulos_ajax(Request $request)
    {
    	// -- función para traer los accesos al seleccionar un perfil

    	$perfil = $request->get('perfil');

    	$result = Permiso::where('id_perfil',$perfil)->get(); 

    	return response()->json($result);
    	
    }

    public function buscar_modulos_ajax_user()
    {
    	// -- función para traer los accesos al seleccionar un usuario

    	$user = $request->get('user');
    	$this->db->where(['id_usuario' => $user, 'id_perfil' => 1]);


        $result = Permiso::where([ ['id_usuario' => $user], ['id_perfil' => 1] ])->get();

        return response()->json($result);
    }

    public function store(Request $request)
    {
      // función para guardar los accesos

      $insert = [];

      $array_where = [];
      $array_link = [];

      if(!empty($request->registros_link))
      {
        $array_link = substr($request->registros_link, 0, strlen($request->registros_link) - 1);

        $array_link = explode(',', $array_link);
      }

        
      if($request->tipo_perfil === 'manuales')
      {
        $insert['id_usuario'] = $request->usuario_select;

      } 
      else
      {
        $insert['id_perfil'] = $request->perfiles_select;
      }

      foreach ($request->modulos as $value) 
      {
        
        $array_areas = '{';
        $array_sub_areas = '{';
        $insert['id_modulo'] = $value;
        $insert['visible'] = false;

        $this->acceso_accion_insert($value,$array_link,$insert);

        if(array_key_exists('modulos_visible', $request->all()))
        {
          if(in_array($value, $request->modulos_visible))
          {
            $insert['visible'] = true;
          }
        }

        if(array_key_exists('areas_'.$value, $request->all()))
        {
          
          foreach ($request->{'areas_'.$value} as $value1) 
          {
            
            $array_areas.= $value1.',';

            $this->acceso_accion_insert($value1,$array_link,$insert);


            if(array_key_exists('sub_areas_'.$value1, $request->all()))
            {
              
              foreach ($request->{'sub_areas_'.$value1} as $value2) 
              {
               
               
               $array_sub_areas.= $value2.','; 

               $this->acceso_accion_insert($value2,$array_link,$insert);
               

              } // fin foreach sub areas

            }  // fin si existen sub areas

          } // fin foreach areas
          
        } // fin si existen areas

        if(strlen($array_areas) === 1)
        {
          $array_areas.= '}';
        }
        else
        {
          $array_areas = substr($array_areas, 0, strlen($array_areas) -1);
          $array_areas.= '}';
        }
        
        $insert['id_area'] = $array_areas;

        if(strlen($array_sub_areas) === 1)
        {
          $array_sub_areas.= '}';
        }
        else
        {
          $array_sub_areas = substr($array_sub_areas, 0, strlen($array_sub_areas) -1);
          $array_sub_areas.= '}';
        }

        $insert['id_sub_area'] = $array_sub_areas;


        // buscar si existe el registro y así modificar sus accesos 

        $key   =  array_key_exists('id_usuario', $insert) ? 'id_usuario' : 'id_perfil';

        $valor = array_key_exists('id_usuario', $insert) ? $insert['id_usuario'] : $insert['id_perfil'];

        $array_where = ['id_modulo' => $insert['id_modulo'], $key => $valor];

        
        $total = Permiso::where([ ['id_modulo',$insert['id_modulo'] ],[$key, $valor] ])->count();

        if($total > 0)
        {
          
          $insert['updatedat']   = date('Y-m-d H:i:s');
          Permiso::where([ ['id_modulo',$insert['id_modulo'] ],[$key, $valor] ])->update($insert);
        }
        else
        {
          // si no existe registro se crea
          $insert['createdat']   = date('Y-m-d H:i:s');
          $insert['updatedat']   = date('Y-m-d H:i:s');
          Permiso::create($insert);

        }
      
      } // fin foreach modulos

      if(session('tipo_db') === '1'){
        Menu::print_menu();
      }

      return redirect()->route('permiso.index')->with([
            'message' => 'Permisos otorgados Correctamente',
            'type' => 'success']
        );

    }

    public function acceso_accion_insert($value, $array_link, $insert)
    {

      	// buscar si existe el registro en acceso_accion y así no tener que volver a registralo
      	// y si no existe registralo

        if(in_array($value, $array_link))
        {

          $key   =  array_key_exists('id_usuario', $insert) ? 'id_usuario' : 'id_perfil';

          $valor = array_key_exists('id_usuario', $insert) ? $insert['id_usuario'] : $insert['id_perfil'];
          
          $total = PermisoAccion::where([ ['id_modulo',$value],[$key,$valor] ])->count();

          if($total < 1)
          {
            $array_insert = ['id_modulo' => $value, $key => $valor, 
                             'createdat' => date('Y-m-d H:i:s'), 
                             'updatedat' => date('Y-m-d H:i:s')];

            PermisoAccion::create($array_insert);
          }
        }
    }
}
