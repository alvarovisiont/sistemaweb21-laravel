<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Config;

class ConfigController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $array = [];

        select_db($request->tipo_db);

        $datos = Config::first();

        $array['datos'] = $datos ? $datos : new Config;
        $array['id'] = $datos ? $datos->id : 1;

        return view('config_login.index')->with($array);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    public function update(Request $request,$id)
    {

        $config = Config::find($id);

        $method = $config ? "update" : "create";

        $config = $config ? $config : new Config;

        $config->fill($request->all());

        $config->id_tipo    = $request->login;
        $config->updated_at = date('Y-m-d H:i:s');

        foreach ($_FILES as $key => $row) 
        {
          if(!empty($row['name']))
          {

            $file = $request->{$key};

            
            $imageName = $file->getClientOriginalName().time().'.'.$file->getClientOriginalExtension();

            $file->move(public_path('assets_sistema/images/gallery/complementos_login'), $imageName);

            $config->{$key} = $imageName;
          }

        }

        if($method === "update"){
          $config->update();
        }else{
          $config->created_at = date('Y-m-d H:i:s');
          $config->save();
        }

        return redirect()->route('config.index')->with([
            'type' => 'success',
            'message' => 'Actualización realizada con éxito'
        ]);
    }

    public function remove_img(Request $request){

      $id  = $request->id;
      $ref = $request->ref;
      $img = $request->img;
      $key = $ref === 'complemento' ? 'imagen' : $ref;
      $ruta= public_path().'/assets_sistema/images/gallery/complementos_login/'.$img;

      if(file_exists($ruta))
      {
        unlink($ruta);
      }

      Config::where('id',$id)->update([$key => null]);

    }
}

