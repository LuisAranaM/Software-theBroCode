<?php

namespace App\Http\Controllers;
use App\Entity\Criterio as eCriterio;
use App\Entity\Categoria as eCategoria;
use App\Entity\Subcriterio as eSubcriterio;
use App\Entity\EscalaCalificacion as eEscala;


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

    public function rubricasGestion(Request $request) {
        $categorias=[];
        $indicadores=[];
        $resultados = eCriterio::getCriterios()->toArray();
        if(is_null($request->resultado)){
            $categorias = eCategoria::getCategoriasId($resultados[0]->ID_CATEGORIA)->toArray();
            $indicadores = eSubcriterio::getSubCriteriosId($categorias[0]->ID_CRITERIO)->toArray();
            $request->resultado = $resultados[0]->ID_CATEGORIA;
        }
        else{
            $categorias = eCategoria::getCategoriasId($request->resultado)->toArray();
            if(is_null($request->categoria)){
                $indicadores = eSubcriterio::getSubCriteriosId($categorias[0]->ID_CRITERIO)->toArray(); 
                $request->categoria = $categorias[0]->ID_CRITERIO;           
            }
            else{
                $indicadores = eSubcriterio::getSubCriteriosId($request->categoria)->toArray();
            }
        }
        if(is_null($request->indicador)){
            $descripciones= array($indicadores[0]->DESCRIPCION_1,$indicadores[0]->DESCRIPCION_2,$indicadores[0]->DESCRIPCION_3,$indicadores[0]->DESCRIPCION_4);
            $request->indicador = $indicadores[0]->ID_SUBCRITERIO;
        }else{
            foreach($indicadores as $indicador){
                if($indicador->ID_SUBCRITERIO===$request->indicador){
                    $descripciones= array($indicador->DESCRIPCION_1,$indicador->DESCRIPCION_2,$indicador->DESCRIPCION_3,$indicador->DESCRIPCION_4);
                }
            }
        }
        $escalas = eEscala::getEscalas()->toArray();
        //$first= array_shift($resultados);
        //dd($categorias);
        return view('rubricas.gestion')
        ->with('resClick',$request->resultado)
        ->with('catClick',$request->categoria)
        ->with('indClick',$request->indicador)
        ->with('resultados',$resultados)
        ->with('categorias',$categorias)
        ->with('indicadores', $indicadores)
        ->with('escalas', $escalas)
        ->with('descripciones', $descripciones);
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
    public function actualizarResultados(Request $request){
        $codigoRes = $request->get('_codRes', null);
        $nombreRes = $request->get('_descRes', null);

        $idResultado = eCriterio::insertCriterio($codigoRes,$nombreRes);

        return redirect()->route('rubricas.gestion');
    }
    public function actualizarCategorias(Request $request){
        $categoria = $request->get('_descCat', null);
        $idRes = $request->get('resultado',null);
        $idCat = eCategoria::insertCategoria(1,1,$categoria, $idRes);
        $request->categoria = $idCat;
        return redirect()->route('rubricas.gestion');
    }
    public function actualizarIndicadores(Request $request){
        $indicador = $request->get('_descInd', null);
        $idCat = $request->get('_idCat',null);
        $idInd = eSubcriterio::insertSubCriterio($idCat,1,1,$indicador, null,null,null,null);
        $request->indicador= $idInd;

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
