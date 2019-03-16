<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Menu;
use App\PermisoAccion;
use App\Permiso;

class MenuController extends Controller
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
        
        $menu = Menu::show_menu();

        return view('menu.index')->with('menu',$menu);       
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('menu.form')->with(['register' => null, 'route' => 'menu']);
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
        $menu = new Menu;

        $menu->fill($request->all());

        $menu->createdat = date('Y-m-d H:i:s');
        $menu->updatedat = date('Y-m-d H:i:s');

        $menu->save();

        return redirect()->route('menu.index')->with([
            'message' => 'Registro agregado Correctamente',
            'type' => 'success']
        );
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
        $menu = Menu::findOrFail($id);

        return view('menu.form')->with(['register' => $menu, 'route' => 'menu/'.$id]);
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

        $menu = Menu::findOrFail($id);

        $menu->fill($request->all());

        $menu->updatedat = date('Y-m-d H:i:s');

        $menu->save();

        return redirect()->route('menu.index')->with([
            'message' => 'Registro modificado Correctamente',
            'type' => 'success']
        );
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
        $count = Menu::where('id_padre',$id)->count();

        if($count > 0)
        {
            return redirect()->route('menu.index')->with([
                'message' => 'No se pudo remover el registro porque posee hijos',
                'type' => 'alert']
            );
        }
        else
        {
            DB::transaction(function() use ($id){
                
                Menu::destroy($id);
                PermisoAccion::where('id_modulo',$id)->delete();

                $sql = "UPDATE acceso SET id_sub_area = array_remove(id_sub_area, $id), id_area = array_remove(id_area, $id)";
                DB::raw($sql);
                Permiso::where('id_modulo',$id)->delete();

            });

            return redirect()->route('menu.index')->with([
                'message' => 'Registro removido Correctamente',
                'type' => 'success']
            );


        }
    }
}
