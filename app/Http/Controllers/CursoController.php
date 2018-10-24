<?php

namespace App\Http\Controllers;

use App\Entity\Base\Entity;
use App\Entity\Curso as Curso;
use App\Entity\Horario as Horario;
use DB;
use App\Entity\Usuario as Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;

use Illuminate\Support\Facades\Redirect;

use Excel;
use Validator;


class CursoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    

    public function index()

    {//dd(Curso::buscarCursos());
        return view('cursos.gestion')
            ->with('cursos',Curso::getCursosAcreditacion())
            ->with('cursosBuscar',Curso::buscarCursos(null,false));
    }
    
    public function progresoGestion() {

        $horarios=[];
        $cursos = Curso::getCursosAcreditacion();
        foreach ($cursos as $curso){
            $idCurso = $curso->ID_CURSO;
            $horarios[$idCurso] = Horario::getHorarios($idCurso);
        }
          return view('cursos.progreso')
                ->with('idCurso',$idCurso)
                ->with('horarios',$horarios)
                ->with('cursos',Curso::getCursosAcreditacion());
    }

    public function subirExcels(){
        return view('subirExcels');
    }

    public function upload(){
        return view('upload');
    }


    public function ExportClients(){
        Excel::create('clients',function($excel){
            $excel->sheet('clients',function($sheet){
                // argumento -> blade
                $sheet->loadView('ExportClients');
            });
        })->export('xlsx');
    }

    public function ImportClients(){
        //dd("HOLA");
        $file = Input::file('file');
        $file_name = $file->getClientOriginalName();
        $file->move('files',$file_name);
        $results = Excel::load('files/'.$file_name, function($reader){
            $reader->all();
        })->get();
        //return view('/login');
        return view('clients',['clients' => $results]);
    }

    public function buscarCursos(Request $request){

        return Curso::buscarCursos($request->get('termino',$request->get('cursoBuscar',null)));
    }

    public function agregarCursosAcreditacion(Request $request){      
        //dd($request->all());  
        $checks=$request->get('checkCursos',null);
        
        $curso = new Curso();           
        
        if($curso->agregarAcreditar($checks,Auth::id())){
            flash('Las cursos a acreditar se registraron correctamente.')->success();
        } else {
            flash('Hubo un error al registrar los cursos a acreditar.')->error();
        }
        return back();

    }

    public function eliminarCursoAcreditacion(Request $request){        
        
        $validator = Validator::make($request->all(), [
            'codigoCurso' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(array_flatten($validator->errors()->getMessages()), 404);
        }

        $curso = new Curso();          

        if($curso->eliminarAcreditar($request->get('codigoCurso'),Auth::id())){
            flash('El curso se eliminó con éxito')->success();
        } else {
            flash('Hubo un error al tratar de eliminar el curso')->error();
        }
        return back();


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
    public function showForm(){
        return view('upload');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    

    public function store(Request $request){
        if($request->hasFile('upload-file')){
            $path = $request->file('upload-file')->getRealPath();
            $data = \Excel::load($path)->get();
            $fecha = date("Y-m-d H:i:s");
            $usuario = Auth::user();
            $id_usuario = Auth::id();
            $semestre_actual = Entity::getIdSemestre();
            $especialidad = Entity::getEspecialidadUsuario();
            if($data->count()){
                foreach ($data as $key => $value) {
                    $lista_cursos[] = ['CODIGO_CURSO'=>$value->clave, 'NOMBRE'=>$value->curso, 'ID_ESPECIALIDAD'=>$especialidad, 'ID_SEMESTRE'=>$semestre_actual, 'FECHA_REGISTRO'=> $fecha,
                                        'FECHA_ACTUALIZACION'=> $fecha,'USUARIO_MODIF'=>$id_usuario, 'ESTADO'=>1, 'ESTADO_ACREDITACION'=>0];
                }
                if(!empty($lista_cursos)){
                    #Curso::insert($lista_cursos);
                    DB::table('CURSOS')->insert($lista_cursos);
                    \Session::flash('Éxito', '¡Excel importado con éxito, cursos actualizados!');
                }
            }
        }
        else{
            \Session::flash('Error', 'No existe archivo excel para ser importado');
        }
        return Redirect::back();
        // //get file
        // $upload = $request->file('upload-file');
        // $filePath = $upload->getRealPath();
        // //open and read
        // $file=fopen($filePath, 'r');

        // $header = fgetcsv($file);

        // //dd($header);
        // //validate
        // $escapedHeader=[];
        // foreach ($header as $key => $value) {
        //     $lheader=strtolower($value);
        //     $escapedItem=preg_replace('/[^a-z]/', '', $lheader);
        //     array_push($escapedHeader, $escapedItem);
        // }

        // //looping 
        
        // while($columns = fgetcsv($file)){
        //     if($columns[0]==""){
        //         continue;
        //     }
        //     foreach ($columns as $key => &$value) {
        //         $value = preg_replace('/\D/', '', $value);
        //     }
        //     $data = array_combine($escapedHeader, $columns);
        //     //setting type
        //     foreach ($data as $key => &$value) {
        //         $value = ($key=="zip" || $key =="month")?(integer)$value:(string)$value;
        //     }
        //     //table update
        //     $date = date("Y-m-d", time());

        //     $nombre = $data['nombre'];
        //     $CODIGO_CURSO = $data['codigocurso'];
        //     $FECHA_REGISTRO = $date;
        //     $FECHA_ACTUALIZACION = $date;
        //     $ESTADO_ACREDITACION = 1;
        //     $USUARIO_MODIF = 1;
        //     $ESTADO = 1;

        //     $curso = Curso::updateOrCreate(['nombre'=>$nombre]);
        //     $curso->CODIGO_CURSO = $CODIGO_CURSO;
        //     $curso->FECHA_REGISTRO = $date;
        //     $curso->FECHA_ACTUALIZACION = $date;
        //     $curso->ESTADO_ACREDITACION = 1;
        //     $curso->USUARIO_MODIF = 1;
        //     $curso->ESTADO = 1;
        /*    $curso->save();
            
        
        }*/
        

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
