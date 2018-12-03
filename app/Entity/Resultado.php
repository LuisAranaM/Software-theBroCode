<?php

namespace App\Entity;

use \Illuminate\Pagination\LengthAwarePaginator as Paginator;
use Jenssegers\Date\Date as Carbon;
use App\Models\Resultado as mResultado;
use App\Models\Semestre as mSemestre;

class Resultado extends \App\Entity\Base\Entity {

    protected $_nombre;
    protected $_descripcion;
    protected $_fechaRegistro;
    protected $_fechaActualizacion;
    protected $_usuarioModif;
    protected $_estado;
    
    public function setFromAuth($resultado) {
        $this->setValue('_nombre',$resultado->NOMBRE);
        $this->setValue('_descripcion',$resultado->DESCRIPCION);
        $this->setValue('_idEspecialidad',$indicador->ID_ESPECIALIDAD);
        $this->setValue('_idSemestre',$indicador->ID_SEMESTRE);
        $this->setValue('_fechaRegistro',$resultado->FECHA_REGISTRO);
        $this->setValue('_fechaActualizacion',$resultado->FECHA_ACTUALIZACION);
        $this->setValue('_usuarioModif',$resultado->USUARIO_MODIF);
        $this->setValue('_estado',$resultado->ESTADO);        
    }   

    static function getResultados() {
        $model = new mResultado();
        return mResultado::getResultados(self::getIdSemestre(),self::getEspecialidadUsuario())->get();
    }

    static function getResultadosBySemestre($idSemestre) {
        $model = new mResultado();
        return mResultado::getResultados($idSemestre,self::getEspecialidadUsuario())->get();
    }
    
    static function getResultadosbyIdCurso($idCurso,$idResultado=null,$orden=null) {
        $model = new mResultado();
        //dd(self::getIdSemestre(),self::getEspecialidadUsuario());
        return mResultado::getResultadosbyIdCurso($idCurso,self::getIdSemestre(),self::getEspecialidadUsuario(),$idResultado,$orden);
    }

    static function insertResultado($nombre, $desc){
        $model =new mResultado();
        return $model->insertResultado($nombre,$desc,self::getIdSemestre(),self::getEspecialidadUsuario());
    }

    static function updateResultado($id, $nombre, $desc){
        $model = new mResultado();
        $model->updateResultado($id,$nombre,$desc);
    }
    static function deleteResultado($id){
        $model = new mResultado();
        $model->deleteResultado($id);
    }

    static function getInformacionRubrica($idSemestre){
        
        $model= new mResultado();
        $infoRubrica=$model->getInformacionRubrica($idSemestre,self::getEspecialidadUsuario())->get();
        $resultados=array();

        $idResultado='';
        $idCategoria='';
        $idIndicador='';
        $contRes=0;
        $contCat=0;
        $contInd=0;
        $contDesc=0;
        $indicadorNuevo=array();
        $descripcionNueva=array();
        $categoriaNueva=array();
        $resultadoNuevo=array();
        foreach ($infoRubrica as $fila) {
            //dd($fila);
            if($idResultado!=$fila->ID_RESULTADO){
                if($contRes>0){ 
                    $indicadorNuevo['DESCRIPCIONES'][]=$descripcionNueva;
                    $categoriaNueva['INDICADORES'][]=$indicadorNuevo;
                    $resultadoNuevo['CATEGORIAS'][]=$categoriaNueva;
                    $resultados[]=$resultadoNuevo;
                }
                $resultadoNuevo=array();
                //$categoriasResultado=array();
                $resultadoNuevo=['ID_RESULTADO'=>$fila->ID_RESULTADO,
                                'RESULTADO'=>$fila->NOMBRE_RES,
                                'DESCRIPCION'=>$fila->DESCRIPCION_RES,
                                'CATEGORIAS'=>[]];
                $idResultado=$fila->ID_RESULTADO;
                $contRes++;
                //Nuevo arreglo de resultados
            }
            if($idCategoria!=$fila->ID_CATEGORIA){
                if($contCat>0 and $fila->ID_RESULTADO==$categoriaNueva['ID_RESULTADO']) {
                    $indicadorNuevo['DESCRIPCIONES'][]=$descripcionNueva;
                    $categoriaNueva['INDICADORES'][]=$indicadorNuevo;
                    $resultadoNuevo['CATEGORIAS'][]=$categoriaNueva;
                }
                $categoriaNueva=array();
                //$categoriasResultado=array();
                $categoriaNueva=['ID_RESULTADO'=>$fila->ID_RESULTADO,
                                'ID_CATEGORIA'=>$fila->ID_CATEGORIA,
                                'NOMBRE_CATEGORIA'=>$fila->NOMBRE_CAT,
                                'INDICADORES'=>[]];
                $idCategoria=$fila->ID_CATEGORIA;
                $contCat++;
                //Nuevo arreglo de resultados
            }
            if($idIndicador!=$fila->ID_INDICADOR){
                if($contInd>0 and $fila->ID_CATEGORIA==$indicadorNuevo['ID_CATEGORIA']){ 
                    $indicadorNuevo['DESCRIPCIONES'][]=$descripcionNueva;
                    $categoriaNueva['INDICADORES'][]=$indicadorNuevo;
                }
                $indicadorNuevo=array();
                //$categoriasResultado=array();
                $indicadorNuevo=[
                                //'ID_RESULTADO'=>$fila->ID_RESULTADO,
                                'ID_CATEGORIA'=>$fila->ID_CATEGORIA,
                                'ID_INDICADOR'=>$fila->ID_INDICADOR,
                                'NOMBRE_INDICADOR'=>$fila->NOMBRE_IND,
                                'VALORIZACION'=>$fila->VAL_IND,
                                'DESCRIPCIONES'=>[]];
                $idIndicador=$fila->ID_INDICADOR;
                $contInd++;
                //Nuevo arreglo de resultados
            }
            //Aquí las descripciones siempre existen
            if($contDesc>0 and $fila->ID_INDICADOR==$descripcionNueva['ID_INDICADOR'])
                $indicadorNuevo['DESCRIPCIONES'][]=$descripcionNueva;
            $descripcionNueva=array();
            $descripcionNueva=[
                //'ID_RESULTADO'=>$fila->ID_RESULTADO,
                //'ID_CATEGORIA'=>$fila->ID_CATEGORIA,
                'ID_INDICADOR'=>$fila->ID_INDICADOR,
                'ID_DESCRIPCION'=>$fila->ID_DESCRIPCION,
                'NOMBRE_DESCRIPCION'=>$fila->NOMBRE_DES,
                'VALORIZACION'=>$fila->VAL_DES,
                'NOMBRE_VALORIZACION'=>$fila->NOMB_VAL_DES];
            $contDesc++;

        }
        //Último resultado
        if($descripcionNueva!=NULL){
            $indicadorNuevo['DESCRIPCIONES'][]=$descripcionNueva;
            $categoriaNueva['INDICADORES'][]=$indicadorNuevo;
            $resultadoNuevo['CATEGORIAS'][]=$categoriaNueva;
            $resultados[]=$resultadoNuevo;
        }

        return $resultados;
    }

    function copiarRubrica($idSemestreCopiar,$idUsuario){
        $model=new mResultado();
        $rubrica=self::getInformacionRubrica($idSemestreCopiar);

        if ($model->copiarRubrica(self::getIdSemestre(),self::getEspecialidadUsuario(),$rubrica,$idUsuario)){
            return true;
        }else{
            $this->setMessage('Hubo un error en el servidor de base de datos');
            return false;
        }

    }


   
    static function cambiosRubricas(){
        $rubSemActual = self::getInformacionRubrica(self::getIdSemestre());
        //dd($rubSemActual);
        $anho = mSemestre::getAnhoCiclo(self::getIdSemestre())->first()->ANHO;
        $ciclo = mSemestre::getAnhoCiclo(self::getIdSemestre())->first()->CICLO;
        //dd($anho,$ciclo);
    
        //dd($semestres);
        if ($ciclo == 1) {
            $anho -= 1;
            $ciclo = 2;
        }
        else{
            $ciclo -=1;
        }
        //dd($anho,$ciclo);
        $idSemestreAnterior = mSemestre::getIdSemestre2($anho,$ciclo)->first()->ID_SEMESTRE;
        //dd($idSemestreAnterior);
        $rubSemAnterior = self::getInformacionRubrica($idSemestreAnterior);
        //dd($rubSemAnterior);
        $resultadosNuevos = [];
        $resultadosMantenidos = [];
        $resultadoEliminados = [];

        //dd($rubSemAnterior,$rubSemActual);
        $resultadosSemAnterior = [];
        $resultadosSemActual = [];

        foreach ($rubSemActual as $key ) {
            $dataResultado = [];
            $dataResultado['RESULTADO'] = $key['RESULTADO'];
            $dataResultado['DESCRIPCION'] = $key['DESCRIPCION'];
            array_push(($resultadosSemActual),$dataResultado);
        }

        foreach ($rubSemAnterior as $key ) {
            $dataResultado = array();
            $dataResultado['RESULTADO'] = $key['RESULTADO'];
            $dataResultado['DESCRIPCION'] = $key['DESCRIPCION'];
            array_push(($resultadosSemAnterior),$dataResultado);
        }

        //dd($resultadosSemAnterior, $resultadosSemActual);
        
        foreach($rubSemAnterior as $resultadosAnterior){
            foreach ($rubSemActual as $resultadosActual) {
                $dataResultado = [];
                //$res=$resultadosActual['DESCRIPCION'] != $resultadosAnterior['DESCRIPCION'];
                //dd($res);
                //los que no camiban
                if($resultadosActual['DESCRIPCION'] == $resultadosAnterior['DESCRIPCION']){
                    $dataResultado['RESULTADO'] = $resultadosActual['RESULTADO'];
                    $dataResultado['DESCRIPCION'] = $resultadosActual['DESCRIPCION'];
                    array_push($resultadosMantenidos,$dataResultado);
                    break;                    
                }
            }
        }

        
        foreach($rubSemActual as $resultadosActual){
            foreach ($resultadosMantenidos as $resultadoMantenido) {
                if($resultadosActual['RESULTADO'] == $resultadoMantenido['RESULTADO']){
                    //dd("holis");
                    $resultadosActual['RESULTADO'] = "0";
                    //dd($resultadosActual);
                    
                }
            }
        }
        dd($rubSemActual);

        foreach($rubSemActual as $resultadosActual){
            $dataResultado = [];
            if($resultadosActual['RESULTADO'] != "0"){
                $dataResultado['RESULTADO'] = $resultadosActual['RESULTADO'];
                $dataResultado['DESCRIPCION'] = $resultadosActual['DESCRIPCION'];
                array_push($resultadosNuevos,$dataResultado);

            }
        }



        dd($resultadosMantenidos,$resultadosNuevos);


        

    }


}