<?php

namespace App\Http\Controllers;
use App\Entity\PlanesDeMejora as PlanesDeMejora;
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
        ->with('documentos',PlanesDeMejora::buscarDocumentos());
    }
    function resultadosFiltroDocs(Request $request){

        //flash('Se ha generado el reporte de resultados por ciclo correctamente.')->success();
        return PlanesDeMejora::resultadosFiltroDocs($request->get('anhoInicio'),$request->get('semIni'),$request->get('anhoFin'),$request->get('semFin'));
        
    }
    public function store(Request $request){
        $tipoDoc = $request->get('tipoDoc', null); //ver si es acta o plan el value
        $ano = $request->get('ano', null);
        $semestre = $request->get('semestre', null);
        $file = $request->file('archivo');
        #$semestre_actual = Entity::getIdSemestre();
        $semestreActual = Entity::getIdSemestre();
        $especialidad = Entity::getEspecialidadUsuario();
        //dd($especialidad);
        $usuario = Auth::user();
        $idUsuario = Auth::id();
        $nameOfFile = pathinfo(Input::file('archivo')->getClientOriginalName(), PATHINFO_FILENAME);
        $extensionOfFile = pathinfo(Input::file('archivo')->getClientOriginalName(), PATHINFO_EXTENSION);  //Get extension of file
        $file->storePubliclyAs('upload', $nameOfFile.'.'.$extensionOfFile, 'public');
        //dd("HOLA");
        $path = base_path() . '\public\upload' . '\\' . $nameOfFile.'.'.$extensionOfFile ;
        $fecha = date("Y-m-d H:i:s");

        //dd($semestre);
        #creationg array for data
        $data = array('RUTA'=>$path, 'FECHA_REGISTRO'=>$fecha, 'FECHA_ACTUALIZACION'=>$fecha, 'USUARIO_MODIF'=>$idUsuario,'ESTADO'=>1, 'NOMBRE'=>$nameOfFile.'.'.$extensionOfFile,'ID_SEMESTRE'=>$semestreActual,'ID_ESPECIALIDAD'=>$especialidad, 'DOCUMENTO_ANHO'=>$ano, 'DOCUMENTO_SEMESTRE'=>$semestre,'TIPO_DOCUMENTO'=>$tipoDoc);
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

                foreach ($checks as $key => $value) {
                    $file= public_path(). "/upload/".$value;
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
                    DB::table('DOCUMENTOS_REUNIONES')
                    ->where('RUTA', $file)
                    ->update(['ESTADO' => 0]);


                    return back();
                } 

            }else{
                //dd('Desc');
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
