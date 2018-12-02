<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Entity\Avisos as eAvisos;

class AvisosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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

    public function generarAviso(Request $request){
        $desc = $request->get('_desc',null);
        $fechaIni = $request->get('_fechaIni',null);
        $fechaFin = $request->get('_fechaFin',null);
        //dd($request->all());
        $id = eAvisos::insertAvisos($desc,$fechaIni,$fechaFin);
        return $id;
    }

    public function eliminarAviso(Request $request) {
        $idAviso = $request->get('_idAviso', null);
        

        if(eAvisos::eliminarAviso($idAviso)){
            flash('El aviso se eliminó con éxito')->success();
        } else {
            flash('Hubo un error al tratar de eliminar el aviso')->error();
        }

        return back();
    }

    public function gestionAvisos() {    
        $avisos = eAvisos::getAvisos()->get();
        //dd($avisos);
        return view('avisos.avisos')
        ->with('avisos',$avisos);
    }

}
