<?php

namespace App\Http\Controllers;
use App\Entity\Curso as Curso;
use App\Entity\Horario as Horario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use Excel;

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
            ->with('cursos',Curso::getCursos());
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
        return Curso::buscarCursos($request->get('cursoBuscar',null));
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    
    public function store(Request $request)
    {
        
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
