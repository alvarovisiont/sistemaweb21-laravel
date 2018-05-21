<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use App\Menu;
use App\Config;

class AuthController extends Controller
{
    //

  public function index()
  {
    
      select_db(1);
      //buscar tipo de logueo
      $row = Config::first();

       $tipo = $row->login;
       $datos = [
        'imagen' => $row->imagen,
        'banner' => $row->cintillo,
        'titulo' => $row->titulo,
        'logo' => $row->logo
      ];
      session(['acceso' => $row->acceso]);

      switch ($tipo) 
      {
        case 1:
            return view('auth.login1')->with($datos);
        break;
        case 2:
            return view('auth.login2')->with($datos);
        break;
        case 3:
             return view('auth.login3')->with($datos);
        break;
        case 4:
             return view('auth.login4')->with($datos);
        break;
        case 5:
            return view('auth.login5')->with($datos);
        break; 
        case 6:
            return view('auth.login6')->with($datos);
        break;       
      }// fin switch
  }


  public function auth(Request $request)
  {

      $form_field = session('acceso') === 1 ? 'email' : 'login';
      $field_table = session('acceso') === 1 ? 'email' : 'login';

      $this->validate($request, [$form_field => 'required' , 'password' => 'required']);

      if(Auth::attempt( $request->only([$form_field, 'password']) ) )
      { 
          session(['menu_usuario' => Menu::show_menu_perfil(),'id_permiso' => Auth::user()->id_permiso ]);
          return redirect()->route('home');
      }
      else
      {
        return redirect()->route('/')->with('message','Error en sus credenciales');
      }
  }

  public function logout(Request $request)
  {
      Auth::logout();
      return redirect()->route('/');
  }
}
