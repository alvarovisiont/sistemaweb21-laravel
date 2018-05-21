<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Perfil;
use App\User;
use App\PermisoAccion;


class PermisoAccionController extends Controller
{
    //

    public function index(Request $request) 
    {
    	
        select_db($request->get('tipo_db'));

        $total_perfiles = Perfil::count();
    	$total_users = User::count();

        $datos = ['total_perfiles' => $total_perfiles, 'total_users' => $total_users];

        return view('permiso_accion.index')->with($datos);
    }

    public function buscar_accesos(Request $request)
    {
    	$type = $request->get('type');
        $valor   = $request->get('id');

        $key = $type === 'usuario' ? 'acceso.id_usuario' : 'acceso.id_perfil';

        $accesos = PermisoAccion::buscar_accesos($key,$valor);

        return response()->json($accesos);
    }

    public function modificar_acceso(Request $request)
    {
    	$key = $request->type === 'perfiles' ? 'id_perfil' : 'id_usuario';
    	$valor = $request->id;

    	$array_where  = ['id_modulo' => $request->datos[0], $key => $valor];
    	$array_update = [$request->datos[1] => $request->datos[2]];

    	PermisoAccion::where([ ['id_modulo',$request->datos[0] ],[$key,$valor] ])->update($array_update);
    }
}
