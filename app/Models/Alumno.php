<?php

/**
 * Created by Reliese Model.
 * Date: Sun, 30 Sep 2018 22:12:14 +0000.
 */

namespace App\Models;

use DB;
use Log;
use App\Entity\Base\Entity;
use App\Models\Especialidad as Especialidad;
use App\Models\Alumno as Alumno;
use App\Models\Horario as Horario;
use Illuminate\Support\Facades\Auth;
use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Alumno
 * 
 * @property int $ID_ALUMNO
 * @property string $NOMBRES
 * @property string $APELLIDO_PATERNO
 * @property string $APELLIDO_MATERNO
 * @property string $CODIGO
 * @property \Carbon\Carbon $FECHA_REGISTRO
 * @property \Carbon\Carbon $FECHA_ACTUALIZACION
 * @property int $USUARIO_MODIF
 * @property int $ESTADO
 * 
 * @property \Illuminate\Database\Eloquent\Collection $horarios
 *
 * @package App\Models
 */
class Alumno extends Eloquent
{
	protected $primaryKey = 'ID_ALUMNO';
	public $timestamps = false;

	protected $casts = [
		'USUARIO_MODIF' => 'int',
		'ESTADO' => 'int'
	];

	protected $dates = [
		'FECHA_REGISTRO',
		'FECHA_ACTUALIZACION'
	];

	protected $fillable = [
		'NOMBRES',
		'APELLIDO_PATERNO',
		'APELLIDO_MATERNO',
		'CODIGO',
		'FECHA_REGISTRO',
		'FECHA_ACTUALIZACION',
		'USUARIO_MODIF',
		'ESTADO'
	];

    static function trace($cad){
        $output = new \Symfony\Component\Console\Output\ConsoleOutput();
        $output->writeln("<info>".$cad."</info>");
    }

    static function existeAlumno(&$codigo, &$alumnos){
        foreach($alumnos as $x)
            if($x->CODIGO == $codigo) return true;
        return false;
    }

	public function horarios()
	{
		return $this->belongsToMany(\App\Models\Horario::class, 'alumnos_has_horarios', 'ID_ALUMNO', 'ID_HORARIO')
					->withPivot('ID_PROYECTO', 'ID_SEMESTRE', 'FECHA_REGISTRO', 'FECHA_ACTUALIZACION', 'USUARIO_MODIF', 'ESTADO');
	}

    static function fix($cad){
        $cad = lcfirst($cad);
        return ucwords($cad);
    }

    static function uploadAlumnosDeCurso(&$data, $idCurso){
        
        try{
            $fecha = date("Y-m-d H:i:s");
            $usuario = Auth::user();
            $idEspecialidad = Entity::getEspecialidadUsuario();
            $id_usuario = Auth::id();
            $idSemestre = Entity::getIdSemestre(); 
            $idProyecto = 1; 
            $especialidades = Especialidad::getEspecialidades();
            $nombreEspecialidad = Especialidad::getNombreEspecialidad($idEspecialidad);
            $alumnos = Alumno::getAlumnos($idSemestre, $idEspecialidad);
            $horariosValidos = Horario::getHorariosByCodCurso($idSemestre, $idEspecialidad, $idCurso);
            $cont = 0;

            /* Arreglos a llenar*/
            $alumnosNuevos = array();
            $alumnosExistentes = array();
            $alumnosGiles = array(); // Los alumnos que se quedan fuera porque no pertenecen a ningun horario
            $alumnosPorHorario = array();
            // Cada elemento de esto es una estructura que tiene 
            // 1. Un horario
            // 2. Un arreglo de alumnos
            
            /* Iterar por cada dato */
            foreach ($data as $key => $value) {
                // verificar si alumno ya existe
                if(existeAlumno($value->alumno,$alumnos)){
                    $alumnosExistentes[] = ['ID_SEMESTRE' => $idSemestre,
                                            'ID_ESPECIALIDAD' => $idEspecialidad,
                                            'NOMBRES' => Alumno::getNombre($value->nombre),
                                            'APELLIDO_PATERNO' => Alumno::getApellidoPaterno($value->nombre),
                                            'APELLIDO_MATERNO' => Alumno::getApellidoMaterno($value->nombre),
                                            'CODIGO' => $value->alumno,
                                            'FECHA_REGISTRO' => $fecha,
                                            'FECHA_ACTUALIZACION' => $fecha,
                                            'USUARIO_MODIF' => $usuario,
                                            'ESTADO' => 1];
                }else{
                    $alumnosNuevos[] = ['ID_SEMESTRE' => $idSemestre,
                                        'ID_ESPECIALIDAD' => Alumno::getIdEspecialidad($especialidades,$value->especialidad),
                                        'NOMBRES' => Alumno::getNombre($value->nombre),
                                        'APELLIDO_PATERNO' => Alumno::getApellidoPaterno($value->nombre),
                                        'APELLIDO_MATERNO' => Alumno::getApellidoMaterno($value->nombre),
                                        'CODIGO' => $value->alumno,
                                        'FECHA_REGISTRO' => $fecha,
                                        'FECHA_ACTUALIZACION' => $fecha,
                                        'USUARIO_MODIF' => $usuario,
                                        'ESTADO' => 1];
                }
                
                if($value->horario != $nombreHorario) continue;
                $cont++;
                $nombre = $this->getNombre($value->nombre);
                $apellidoPaterno = $this->getApellidoPaterno($value->nombre);
                $apellidoMaterno = $this->getApellidoMaterno($value->nombre);
                $codigo = $value->alumno;
                if(DB::table('ALUMNOS')->where('CODIGO', $value->alumno)->doesntExist()){
                    // insertar alumno en la bd
                    DB::table('ALUMNOS')->insert(
                        ['NOMBRES' => $nombre,
                         'APELLIDO_PATERNO' => $apellidoPaterno,
                         'APELLIDO_MATERNO' => $apellidoMaterno,
                         'CODIGO' => $codigo,
                         'FECHA_REGISTRO' => $fecha,
                         'FECHA_ACTUALIZACION' => $fecha,
                         'ID_SEMESTRE'=>$semestre_actual,
                         'ID_ESPECIALIDAD'=>$especialidad,
                         'USUARIO_MODIF' => $usuario['ID_USUARIO'],
                         'ESTADO' => 1
                        ]);
                }
                                   
                $q = DB::table('ALUMNOS')
                            ->select('ID_ALUMNO')
                            ->where('CODIGO', '=', $codigo )->get()->toArray();
                //$this->trace('HOLIS2');
                $idAlumno = (int)($q[0]->ID_ALUMNO);
                $cond = DB::table('ALUMNOS_HAS_HORARIOS')->
                whereRaw('ID_ALUMNO = ? AND ID_HORARIO = ? AND ID_PROYECTO = ? AND ID_SEMESTRE = ?',
                    [$idAlumno,$idHorario,$idProyecto,$semestre_actual])->doesntExist();

                if($cond){
                    $lista[] = ['ID_ALUMNO' => $idAlumno,
                                'ID_HORARIO' => $idHorario,
                                'ID_PROYECTO' => $idProyecto,
                                'ID_SEMESTRE' => $semestre_actual,
                                'FECHA_REGISTRO' => $fecha,
                                'ID_SEMESTRE'=>$semestre_actual,
                                'ID_ESPECIALIDAD'=>$especialidad,
                                'FECHA_ACTUALIZACION' => $fecha,
                                'USUARIO_MODIF' => $usuario['ID_USUARIO'],
                                'ESTADO' => 1];
                }
            }
            if(!empty($lista))
                DB::table('ALUMNOS_HAS_HORARIOS')->insert($lista);
            
            if($cont == 0){
                $this->trace('No se subio nada');
                return 1;
            }
        }catch(Exception $e){
                return 1;
        }
        return 0;
    }

    static function getAlumnos($idSemestre, $idEspecialidad){
        $ans = DB::table('ALUMNOS')
                ->select('*')
                ->where('ID_SEMESTRE','=',$idSemestre)
                ->where('ID_ESPECIALIDAD','=', $idEspecialidad)
                ->where('ESTADO','=',1)
                ->get();
        return $ans;
    }

	static function getAlumnosByHorarioStatic($idHorario){
		$ans = DB::table('ALUMNOS')
            ->join('ALUMNOS_HAS_HORARIOS', 'ALUMNOS.ID_ALUMNO', '=', 'ALUMNOS_HAS_HORARIOS.ID_ALUMNO')
            ->select('ALUMNOS.*')
            ->where('ALUMNOS_HAS_HORARIOS.ID_HORARIO','=',$idHorario)
            ->get();
        return $ans;
	}

	public function getAlumnosByHorario($idHorario){
		$ans = DB::table('ALUMNOS')
            ->join('ALUMNOS_HAS_HORARIOS', 'ALUMNOS.ID_ALUMNO', '=', 'ALUMNOS_HAS_HORARIOS.ID_ALUMNO')
            ->select('ALUMNOS.*')
            ->where('ALUMNOS_HAS_HORARIOS.ID_HORARIO','=',$idHorario)
            ->get();
        return $ans;
	}

	public function insertarIndicadoresxAlumno($datosAlumno){
		DB::table('INDICADORES_HAS_ALUMNOS_HAS_HORARIOS')->insertarIndicadoresxAlumno($datosAlumno);
	}

	function calificarAlumnos($registro){
        //dd($registro);    
        DB::beginTransaction();
        $status = true;
       
        try {
            DB::table('INDICADORES_HAS_ALUMNOS_HAS_HORARIOS')
                ->where('ID_ALUMNO','=',$registro['ID_ALUMNO'])
				->where('ID_HORARIO','=',$registro['ID_HORARIO'])
				->where('ID_INDICADOR','=',$registro['ID_INDICADOR'])
				->where('ID_CATEGORIA','=',$registro['ID_CATEGORIA'])
				//->where('ID_RESULTADO','=',$registro['ID_RESULTADO'])
				//->where('ID_DESCRIPCION','=',$registro['ID_DESCRIPCION'])
				->where('ID_SEMESTRE','=',$registro['ID_SEMESTRE'])
				->where('ID_ESPECIALIDAD','=',$registro['ID_ESPECIALIDAD'])
				//->where('ESTADO','=',1)
				->delete();
                /*->update(['ESTADO'=>0,
                        'FECHA_ACTUALIZACION'=>$registro['FECHA_ACTUALIZACION'],
                        'USUARIO_MODIF'=>$registro['USUARIO_MODIF']]);*/

            DB::table('INDICADORES_HAS_ALUMNOS_HAS_HORARIOS')->insert($registro);   

            DB::commit();
        } catch (\Exception $e) {
            Log::error('BASE_DE_DATOS|' . $e->getMessage());
            $status = false;
            DB::rollback();
        }
        //dd($status);
        return $status;
        //dd($sql->get());
    }


    function eliminarAlumnoHorario($registro){
        //dd($registro);    
        DB::beginTransaction();
        $status = true;
       
        try {
           DB::table('ALUMNOS_HAS_HORARIOS')
            ->where('ID_ALUMNO','=',$registro['ID_ALUMNO'])
            ->where('ID_SEMESTRE','=',$registro['ID_SEMESTRE'])
            ->where('ID_ESPECIALIDAD','=',$registro['ID_ESPECIALIDAD'])
            ->where('ID_HORARIO','=',$registro['ID_HORARIO'])
            ->update(['ESTADO'=>0,'FECHA_ACTUALIZACION'=>$registro['FECHA_ACTUALIZACION']]);

            DB::commit();
        } catch (\Exception $e) {
            Log::error('BASE_DE_DATOS|' . $e->getMessage());
            $status = false;
            DB::rollback();
        }
        //dd($status);
        return $status;
        //dd($sql->get());
    }


}
