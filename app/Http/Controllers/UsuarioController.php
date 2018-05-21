<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\User;
use App\Perfil;
use App\Userinfo;

class UsuarioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        select_db($request->get('tipo_db'));
        
        $users = User::all();

        return view('users.index')->with('users',$users);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $url = "users";
        $perfil = Perfil::all();
        $user = new User;

        $arr_usuarios = User::select('usuario.email')->get();
        
        $imagen = 'avatar.png';

        return view('users.form')->with(['url' => $url, 'perfil' => $perfil, 'arr_usuarios' => $arr_usuarios,'imagen' => $imagen, 'user' => $user]);
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
        $user = new User;

        $user->createdat    = date('Y-m-d H:i:s');
        $user->updatedat    = date('Y-m-d H:i:s');
        $user->fecha_acceso = date('Y-m-d H:i:s');
        $user->password     = bcrypt('12345');
        $user->login        = strtolower($request->login);
        $user->email        = strtolower($request->email);
        $user->id_permiso   = $request->id_permiso;
        $user->correo_activo= TRUE;

        $user_info = new Userinfo;

        $user_info->createdat = date('Y-m-d H:i:s');
        $user_info->updatedat = date('Y-m-d H:i:s');
        $user_info->cedula    = $request->cedula;
        $user_info->nombre    = $request->nombre;
        $user_info->apellido  = $request->apellido;
        $user_info->imagen    = $request->imagen;

        $type = 'success';
        $message = "Registro creado con éxito";

        DB::transaction(function() use($user,$user_info) {
          $user->save();
          
          $user_info->id_usuario = $user->id;

          $user_info->save();
        });

        return redirect()->route('users.index')->with(['type' => $type, 'message' => $message]);

        
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
        $user_class = new User;
        
        $user = $user_class->show_user($id);

        $perfil = Perfil::all();
        $arr_usuarios = User::select('usuario.email')->get();

        $url = "users/".$id;
        $edit = true;

        $imagen = $user->imagen;

        return view('users.form')->with(['url' => $url, 'perfil' => $perfil, 'arr_usuarios' => $arr_usuarios, 'user' => $user,'edit' => $edit,'imagen' => $imagen]);
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
        $user = User::findOrFail($id);

        $user->createdat    = date('Y-m-d H:i:s');
        $user->updatedat    = date('Y-m-d H:i:s');
        $user->fecha_acceso = date('Y-m-d H:i:s');
        $user->password     = bcrypt('12345');
        $user->login        = strtolower($request->login);
        $user->email        = strtolower($request->email);
        $user->id_permiso   = $request->id_permiso;
        $user->correo_activo= TRUE;

        $user_info = Userinfo::where('id_usuario',$id)->first();

        $user_info->createdat = date('Y-m-d H:i:s');
        $user_info->updatedat = date('Y-m-d H:i:s');
        $user_info->cedula    = $request->cedula;
        $user_info->nombre    = $request->nombre;
        $user_info->apellido  = $request->apellido;
        $user_info->imagen    = $request->imagen;

        $type = 'success';
        $message = "Registro modificado con éxito";

        DB::transaction(function() use($user,$user_info) {
          $user->update();
          $user_info->update();
        });

        return redirect()->route('users.index')->with(['type' => $type, 'message' => $message]);

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
        try
        {
            User::destroy($id);

            return redirect()->route('users.index')->with(['type' => 'success', 'message' => 'Registro eliminado con Éxito']);

        }
        catch(\Illuminate\Database\QueryException $e)
        {
            $message = 'No se puede eliminar el registro porque tiene registros asociados';

            return redirect()->route('users.index')->with(['type' => 'success', 'message' => $message]);
        }
    }

    public function user_active(Request $request,$id,$user_active)
    {
      $id = $id;
      $user_active = $user_active === '1' ? FALSE : TRUE;

      User::where('id',$id)->update(['usuario_activo' => $user_active]);

      return redirect()->route('users.index')->with(['type' => 'success', 'message' => 'Acceso Modificado con Éxito']);
    }
}
