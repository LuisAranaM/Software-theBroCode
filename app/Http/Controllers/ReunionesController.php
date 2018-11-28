<?php

namespace App\Http\Controllers;
use App\Entity\PlanesDeMejora as PlanesDeMejora;
use App\Entity\Semestre;
use App\Entity\Acta as Acta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use App\Entity\Base\Entity;
use DB;
use response;



class ReunionesController extends Controller
{
    //

    public function reunionesGestion() {    
        return view('reuniones.reuniones')
        ->with('semestres',Semestre::getSemestres())
        ->with('documentos',PlanesDeMejora::buscarDocumentos());
    }
    function resultadosFiltroDocs(Request $request){

        //flash('Se ha generado el reporte de resultados por ciclo correctamente.')->success();
        return PlanesDeMejora::resultadosFiltroDocs($request->get('anhoInicio'),$request->get('semIni'),$request->get('anhoFin'),$request->get('semFin'));
        
    }
    public function store(Request $request){
        $tipoDoc = $request->get('tipoDoc', null); //ver si es acta o plan el value
        $ciclo = $request->get('ciclo', null);
        $semestre = explode( '-', $ciclo );
        $file = $request->file('archivo');
        #$semestre_actual = Entity::getIdSemestre();
        $semestreActual = Entity::getIdSemestre();
        $especialidad = Entity::getEspecialidadUsuario();
        //dd($especialidad);
        $usuario = Auth::user();
        $idUsuario = Auth::id();
        $nameOfFile = pathinfo(Input::file('archivo')->getClientOriginalName(), PATHINFO_FILENAME);
        $extensionOfFile = pathinfo(Input::file('archivo')->getClientOriginalName(), PATHINFO_EXTENSION);  //Get extension of file
        //dd($nameOfFile,$extensionOfFile);
        $file->storePubliclyAs('upload', $nameOfFile.'.'.$extensionOfFile, 'public');
        //dd($file);
        //dd("HOLA");
        $path = base_path() . '\public\upload' . '\\' . $nameOfFile.'.'.$extensionOfFile ;
        $fecha = date("Y-m-d H:i:s");

        //dd($semestre);
        #creationg array for data
        $data = array('RUTA'=>$path, 'FECHA_REGISTRO'=>$fecha, 'FECHA_ACTUALIZACION'=>$fecha, 'USUARIO_MODIF'=>$idUsuario,'ESTADO'=>1, 'NOMBRE'=>$nameOfFile.'.'.$extensionOfFile,'ID_SEMESTRE'=>$semestreActual,'ID_ESPECIALIDAD'=>$especialidad, 'DOCUMENTO_ANHO'=>$semestre[0], 'DOCUMENTO_SEMESTRE'=>$semestre[1],'TIPO_DOCUMENTO'=>$tipoDoc);
        //dd($data);
        $idProyecto = DB::table('DOCUMENTOS_REUNIONES')->insertGetId(
            $data
        );
        
        
        flash('Se ha subido el archivo de forma correcta.')->success();
        return back();
    }

    public function descargarDocumentosReuniones(Request $request){      
        //dd($request->all(),$request->get('botonSubmit',null));  

        $tipo=$request->get('botonSubmit',null);
        $checks=$request->get('checkDocs',null);

        if($checks!=NULL){
            //Funciones
            if($tipo=="Elim"){
               // dd('Elim');
                $files = array();
                $cant = 0;
                foreach ($checks as $key => $value) {
                    //dd($value);
                    //
                    //dd(public_path());
                    $file= public_path(). "/upload//".$value;
                    /*NO BORRAR esto es para eliminar fisicamente el archivo

                    $dirHandle = opendir(public_path(). "/upload/");
                    $dir = public_path(). "/upload/";
                    while ($file = readdir($dirHandle)) {
                        if($file==$value) {
                            unlink($dir.'/'.$file);
                        }
                    }
                    closedir($dirHandle);
                    */
                    //Esto es para cambiar el estado a cero
                    //dd($file);
                    //dd("HOLI",$request->all());
                    DB::table('DOCUMENTOS_REUNIONES')
                    ->where('NOMBRE', '=',$value)
                    ->update(['ESTADO' => 0]);
                    $cant = $cant + 1;
                } 
                flash('Se ha eliminado '.$cant.' archivo(s) de forma correcta.')->success();
                return back();

            }else{
                //dd('Desc');
                try{

                    $dirHandle = opendir(public_path(). "/upload//");
                    $dir = public_path(). "/upload//";
                    $valueComprimido = public_path(). "/upload/comprimido.zip";
                    $aux = 0;
                    while ($file = readdir($dirHandle)) {
                        if($aux == 3){
                            //dd($file);
                        }
                        if($file=="comprimido.zip") {
                            //dd("Elimina el comprimido");
                            unlink($dir.'//'.$file);
                        }
                        $aux= $aux + 1;
                    }
                    //dd($aux);
                    closedir($dirHandle);
                }catch(Exception $e){

                }

                $files = array();
                foreach ($checks as $key => $value) {
                    $file= public_path(). "/upload/".$value;
                    //dd($file);
                    array_push($files, $file);
                } 
                //dd($files);
                //$files = glob(public_path('js/*'));

                

                \Zipper::make(public_path('/upload/comprimido.zip'))->add($files)->close();
                return response()->download(public_path('/upload/comprimido.zip'));
            }
        }
        else{
            //alert('No se ha seleccionado ningún documento para descargar.');
            //flash('No se ha seleccionado ningún documento para descargar.')->success();
            return back();
        }
        /*$checks=$request->get('checkDocumentos',null);
        
        $doc = new PlanesDeMejora();           
        
        if($doc->agregarAcreditar($checks,Auth::id())){
            flash('Las cursos a acreditar se registraron correctamente.')->success();
        } else {
            flash('Hubo un error al registrar los cursos a acreditar.')->error();
        }
        return back();
*/
    }
}
