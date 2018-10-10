<?php

namespace App\Http\Controllers;
use App\Entity\Criterio as eCriterio;
use App\Entity\Categoria as eCategoria;
use App\Entity\Subcriterio as eSubcriterio;
<<<<<<< HEAD
use App\Entity\EscalaCalificacion as eEscala;

=======
>>>>>>> AranaBranch

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

<<<<<<< HEAD
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
=======
    public function rubricasGestion() {        
        $categorias=[];
        $subcriterios=[];
        $criterios = eCriterio::getCriterios();
        foreach ($criterios as $criterio){
            $idCrit = $criterio->ID_CATEGORIA;
            $categoriasNoValid = eCategoria::getCategorias($idCrit);
            if(count($categoriasNoValid)!=0){
                $categorias[$idCrit] = $categoriasNoValid;
                foreach($categorias[$idCrit] as $categoria){
                    $idCat = $categoria->ID_CRITERIO;
                    $subcriteriosNoValid =eSubcriterio::getSubCriterios($idCat);
                    if(count($subcriteriosNoValid)!= 0){
                        $lastIdCat = $idCat;
                        $subcriterios[$idCat] = $subcriteriosNoValid;
                        foreach($subcriterios[$idCat] as $subcriterio){
                            $idSubCriterio = $subcriterio->ID_SUBCRITERIO;
                        }  
                    }                 
                }  
            }            
        } 
        //dd($categorias);
        return view('rubricas.gestion')
        ->with('lastIdCrit',$idCrit)
        ->with('lastIdCat',$idCat)
        ->with('criterios',$criterios)
        ->with('ultimoCriterio',$criterios[count($criterios)-1])
        ->with('ultimaCategoria',$categorias[count($criterios)][count($categorias[count($criterios)])-1])
        ->with('ultimoSubcriterio',$subcriterios[$lastIdCat][count($subcriterios[$lastIdCat])-1]);
>>>>>>> AranaBranch
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
<<<<<<< HEAD
    }
    public function actualizarResultados(Request $request){
        $codigoRes = $request->get('_codRes', null);
        $nombreRes = $request->get('_descRes', null);

        $idResultado = eCriterio::insertCriterio($codigoRes,$nombreRes);

        return $idResultado;
    }
    public function actualizarCategorias(Request $request){
        $categoria = $request->get('_descCat', null);
        $idRes = $request->get('resultado',null);
        $idCat = eCategoria::insertCategoria(1,1,$categoria, $idRes);
        return $idCat;
    }
    public function actualizarIndicadores(Request $request){
        $indicador = $request->get('_descInd', null);
        $idCat = $request->get('_idCat',null);
        $idInd = eSubcriterio::insertSubCriterio($idCat,1,1,$indicador, null,null,null,null);

        return $idInd;
    }
    public function actualizarEscalas(Request $request){
        $escala = $request->get('_escala', null);
        $descripcion = $request->get('_descripcion',null);
        $idInd = $request->get('_idInd',null);
        $indicador = eSubcriterio::getSubCriterioId($idInd)->toArray()[0];
        if(is_null($indicador->DESCRIPCION_1)){
            $indicador->DESCRIPCION_1=$descripcion;
        }else if(is_null($indicador->DESCRIPCION_2)){
            $indicador->DESCRIPCION_2=$descripcion;          
        }else if(is_null($indicador->DESCRIPCION_3)){
            $indicador->DESCRIPCION_3=$descripcion;          
        }else if(is_null($indicador->DESCRIPCION_4)){
            $indicador->DESCRIPCION_4=$descripcion;       
        }
        eSubcriterio::updateSubcriterio($indicador);
        //obtener indicador y verificar si tiene las descripciones
        //updateamos la primera descripcion que este en null

        return;
    }
    public function refrescarResultados(Request $request){

        $resultados = eCriterio::getCriterios()->toArray();

        return $resultados;
    }
    public function refrescarCategorias(Request $request){

        $idRes = $request->get('_idRes',null);
        $categorias = eCategoria::getCategoriasId($idRes)->toArray();

        return $categorias;
    }
    public function refrescarIndicadores(Request $request){

        $idCat = $request->get('_idCat',null);
        $indicadores = eSubcriterio::getSubCriteriosId($idCat)->toArray();

        return $indicadores;
    }

    public function refrescarEscalas(Request $request){

        $idInd = $request->get('_idInd',null);
        $escalas = eEscala::getEscalas()->toArray();
        $indicadores = eSubcriterio::getSubCriterios()->toArray();
        $descripciones= [];

        foreach($indicadores as $indicador){
            if($indicador->ID_SUBCRITERIO==$idInd){                
                $descripciones= array($escalas[0]->NOMBRE.' '.$indicador->DESCRIPCION_1,$escalas[1]->NOMBRE.' '.$indicador->DESCRIPCION_2,$escalas[2]->NOMBRE.' '.$indicador->DESCRIPCION_3,$escalas[3]->NOMBRE.' '.$indicador->DESCRIPCION_4);
                break;
            }
        }
        return $descripciones;
    }
=======

    }

>>>>>>> AranaBranch
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
