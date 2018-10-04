<?php

namespace App\Http\Controllers;
use App\Entity\Criterio as eCriterio;
use App\Entity\Categoria as eCategoria;
use App\Entity\Subcriterio as eSubcriterio;

use Illuminate\Http\Request;

class CriterioController extends Controller
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

    public function rubricasGestion() {        
        $categorias=[];
        $subcriterios=[];
        $criterios = eCriterio::getCriterios();
        foreach ($criterios as $criterio){
            $idCrit = $criterio->ID_CATEGORIA;
            $categorias[$idCrit-1] = eCategoria::getCategorias($idCrit);
            foreach($categorias[$idCrit-1] as $categoria){
                $idCat = $categoria->ID_CRITERIO;
                $subcriterios[$idCat-1] = eSubcriterio::getSubCriterios($idCat);
            }                             
        } 
        //dd($idCrit);
        return view('rubricas.gestion')
        ->with('lastIdCrit',$idCrit)
        ->with('lastIdCat',$idCat)
        ->with('criterios',$criterios)
        ->with('ultimoCriterio',$criterios[$idCrit-1])
        ->with('ultimaCategoria',$categorias[$idCrit-1][count($categorias[$idCrit-1])-1])
        ->with('ultimoSubcriterio',$subcriterios[$idCat-1][count($subcriterios[$idCat-1])-1]);
    }

    public function actualizarCriterios(Request $request){
        //dd("HOLA");
        //return redirect()->route('rubricas.gestion');
        $codigoRes = $request->get('codigo', null);
        $nombreRes = $request->get('nombre', null);
        $idCriterio = eCriterio::insertCriterio($codigoRes,$nombreRes);

        $categoria = $request->get('categoria',null);
        $idCategoria = eCategoria::insertCategoria(1,1,$categoria,$idCriterio);

        $subcriterio = $request->get('indicador',null);
        $texto1 = $request->get('texto1',null);
        $texto2 = $request->get('texto2',null);
        $texto3 = $request->get('texto3',null);
        $texto4 = $request->get('texto4',null);
        eSubcriterio::insertSubCriterio($idCategoria,1,1,$subcriterio, $texto1,$texto2,$texto3,$texto4);
        return redirect()->route('rubricas.gestion');

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
}
