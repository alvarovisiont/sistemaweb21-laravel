<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Perfil;

class PerfilController extends Controller
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
        
        $perfil = Perfil::all();

        return view('perfil.index')->with('perfil',$perfil);       
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

        $perfil = new perfil;

        $perfil->fill($request->all());

        $perfil->createdat = date('Y-m-d H:i:s');
        $perfil->updatedat = date('Y-m-d H:i:s');

        $perfil->save();

        return redirect()->route('perfil.index')->with([
            'message' => 'Registro agregado Correctamente',
            'type' => 'success']
        );

        return redirect()->route('perfil.index')->with([
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
    }
}
