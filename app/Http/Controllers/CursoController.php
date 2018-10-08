<?php

namespace App\Http\Controllers;
use App\Entity\Usuario as Usuario;
use App\Entity\Curso as Curso;
use App\Entity\Horario as Horario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
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
    {   
        return view('cursos.gestion')
            ->with('cursos',Curso::getCursosAcreditacion());
    }
    
    public function progresoGestion() {         
        $horarios=[];
        $cursos = Curso::getCursos();
        foreach ($cursos as $curso){
            $idCurso = $curso->ID_CURSO;
            $horarios[$idCurso] = Horario::getHorarios($idCurso);
        }
          return view('cursos.progreso')
                ->with('idCurso',$idCurso)
                ->with('horarios',$horarios)
                ->with('cursos',Curso::getCursos());
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
    
    public function store(Request $request)
    {
        //get file
        $upload = $request->file('upload-file');
        $filePath = $upload->getRealPath();
        //open and read
        $file=fopen($filePath, 'r');

        $header = fgetcsv($file);

        dd($header);

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
