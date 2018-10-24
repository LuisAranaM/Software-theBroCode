<?php

namespace App\Http\Controllers;
use App\Entity\Resultado as eResultado;
use App\Entity\Categoria as eCategoria;
use App\Entity\Indicador as eIndicador;
use App\Entity\EscalaCalificacion as eEscala;


use Illuminate\Http\Request;

class ResultadoController extends Controller
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
        $resultados = eResultado::getResultados()->toArray();
        if(is_null($request->resultado)){
            $categorias = eCategoria::getCategoriasId($resultados[0]->ID_CATEGORIA)->toArray();
            $indicadores = eIndicador::getIndicadoresId($categorias[0]->ID_RESULTADO)->toArray();
            $request->resultado = $resultados[0]->ID_CATEGORIA;
        }
        else{
            $categorias = eCategoria::getCategoriasId($request->resultado)->toArray();
            if(is_null($request->categoria)){
                $indicadores = eIndicador::getIndicadoresId($categorias[0]->ID_RESULTADO)->toArray(); 
                $request->categoria = $categorias[0]->ID_RESULTADO;           
            }
            else{
                $indicadores = eIndicador::getIndicadoresId($request->categoria)->toArray();
            }
        }
        if(is_null($request->indicador)){
            $descripciones= array($indicadores[0]->DESCRIPCION_1,$indicadores[0]->DESCRIPCION_2,$indicadores[0]->DESCRIPCION_3,$indicadores[0]->DESCRIPCION_4);
            $request->indicador = $indicadores[0]->ID_SUBCRITERIO;
        }else{
            foreach($indicadores as $indicador){
                if($indicador->ID_INDICADOR===$request->indicador){
                    //$descripciones= array($indicador->DESCRIPCION_1,$indicador->DESCRIPCION_2,$indicador->DESCRIPCION_3,$indicador->DESCRIPCION_4);
                }
            }
        }
        $escalas = eEscala::getEscalas()->toArray();
        //$first= array_shift($resultados);
        //dd($categorias);
        return view('rubricas.gestion')
        ->with('resultados',$resultados)
        ->with('categorias',$categorias)
        ->with('indicadores', $indicadores);
        //->with('escalas', $escalas)
        //->with('descripciones', $descripciones);
    }

    public function actualizarResultados(Request $request){
        $codigoRes = $request->get('_codRes', null);
        $nombreRes = $request->get('_descRes', null);

        $idResultado = eResultado::insertCriterio($codigoRes,$nombreRes);

        return $idResultado;
    }
    public function actualizarCategorias(Request $request){
        $categoria = $request->get('_descCat', null);
        $idRes = $request->get('resultado',null);
        $idCat = eCategoria::insertCategoria($categoria, $idRes);
        return $idCat;
    }
    public function actualizarIndicadores(Request $request){
        $indicador = $request->get('_descInd', null);
        $idCat = $request->get('_idCat',null);
        $idInd = eIndicador::insertIndicador($idCat,1,1,$indicador, null,null,null,null);
        return $idInd;
    }
    public function actualizarDescripciones(Request $request){
        $descripcion = $request->get('_descDesc', null);
        $idInd = $request->get('_idInd',null);
        $idDesc = eDescripcion::insertDescripcion($idInd,$descripcion);

        return $idDesc;
    }
    public function actualizarEscalas(Request $request){
        $escala = $request->get('_escala', null);
        $descripcion = $request->get('_descripcion',null);
        $idInd = $request->get('_idInd',null);
        $indicador = eIndicador::getSubCriterioId($idInd)->toArray()[0];
        if(is_null($indicador->DESCRIPCION_1)){
            $indicador->DESCRIPCION_1=$descripcion;
        }else if(is_null($indicador->DESCRIPCION_2)){
            $indicador->DESCRIPCION_2=$descripcion;          
        }else if(is_null($indicador->DESCRIPCION_3)){
            $indicador->DESCRIPCION_3=$descripcion;          
        }else if(is_null($indicador->DESCRIPCION_4)){
            $indicador->DESCRIPCION_4=$descripcion;       
        }
        eIndicador::updateSubcriterio($indicador);
        //obtener indicador y verificar si tiene las descripciones
        //updateamos la primera descripcion que este en null

        return;
    }
    public function refrescarResultados(Request $request){

        $resultados = eResultado::getCriterios()->toArray();

        return $resultados;
    }
    public function refrescarCategorias(Request $request){

        $idRes = $request->get('_idRes',null);
        $categorias = eCategoria::getCategoriasId($idRes)->toArray();

        return $categorias;
    }
    public function refrescarIndicadores(Request $request){

        $idCat = $request->get('_idCat',null);
        $indicadores = eIndicador::getSubCriteriosId($idCat)->toArray();

        return $indicadores;
    }

    public function refrescarDescripciones(Request $request){

        $idInd= $request->get('_idInd',null);
        $descripciones = eDescripcion::getDescripcionesId($idInd)->toArray();

        return $descripciones;
    }
    public function refrescarEscalas(Request $request){

        $idInd = $request->get('_idInd',null);
        $escalas = eEscala::getEscalas()->toArray();
        $indicadores = eIndicador::getSubCriterios()->toArray();
        $descripciones= [];

        foreach($indicadores as $indicador){
            if($indicador->ID_SUBCRITERIO==$idInd){                
                $descripciones= array($escalas[0]->NOMBRE.' '.$indicador->DESCRIPCION_1,$escalas[1]->NOMBRE.' '.$indicador->DESCRIPCION_2,$escalas[2]->NOMBRE.' '.$indicador->DESCRIPCION_3,$escalas[3]->NOMBRE.' '.$indicador->DESCRIPCION_4);
                break;
            }
        }
        return $descripciones;
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
    public function categorias() {
        return view('rubricas.categorias');
    }
}
