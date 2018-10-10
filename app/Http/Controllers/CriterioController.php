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
        }
        else{
            $categorias = eCategoria::getCategoriasId($request->resultado)->toArray();
            if(is_null($request->categoria)){
                $indicadores = eSubcriterio::getSubCriteriosId($categorias[0]->ID_CRITERIO)->toArray();            
            }
            else{
                $indicadores = eSubcriterio::getSubCriteriosId($request->categoria)->toArray();
            }
        }
        $escalas = eEscala::getEscalas()->toArray();
        //$first= array_shift($resultados);
        //dd($categorias);
        return view('rubricas.gestion')
        ->with('resultados',$resultados)
        ->with('categorias',$categorias)
        ->with('indicadores', $indicadores)
        ->with('escalas', $escalas);
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
        //dd("HOLA");
        //return redirect()->route('rubricas.gestion');
        $codigoRes = $request->get('_codRes', null);
        $nombreRes = $request->get('_descRes', null);

        //dd("HOLA");
        $idResultado = eCriterio::insertCriterio($codigoRes,$nombreRes);

        //dd("HOLA");
        return redirect()->route('rubricas.gestion');
    }
    public function actualizarCategorias(Request $request){
        //dd("HOLA");
        $categoria = $request->get('_descCat', null);
        $idRes = $request->get('_idRes',null);
        $idCriterio = eCategoria::insertCategoria(1,1,$categoria, $idRes);

        return view('rubricas.gestion')
        ->with('resultados',$resultados)
        ->with('categorias',$categorias)
        ->with('indicadores', $indicadores)
        ->with('escalas', $escalas);
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
