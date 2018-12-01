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
use App\Models\AlumnosHasHorario as AlumnoHasHorario;
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

    static function existeAlumno($codigo, &$alumnos){
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

    static function getIdEspecialidad(&$especialidades, $especialidad){
        foreach($especialidades as $x){
            if($x->NOMBRE == $especialidad)
                return $x->ID_ESPECIALIDAD;
        }
        return 1;
    }

    static function horarioValido(&$horariosValidos, $horario){
        foreach($horariosValidos as $x){
            if($x->NOMBRE == $horario)
                return true;
        }
        return false;
    }

    static function getNombre($cad){
        $i = 0; $n = strlen($cad);
        for(; $i < $n && $cad[$i] != ','; $i++);
        $ans = '';
        for($i++; $i < $n; $i++)
            $ans .= $cad[$i];
        return $ans;
    }

    static function getApellidoPaterno($cad){
        $esp = 0; $ans = '';
        for($i = 0; $i < strlen($cad) && $cad[$i] != ','; $i++)
            if($cad[$i] == ' ') $esp++;
        if($esp == 1){
            for($i = 0; $i < strlen($cad) && $cad[$i] != ' '; $i++)
                $ans .= $cad[$i];
        }else{
            for($i = 0; $i < strlen($cad) && $cad[$i] != ','; $i++)
                $ans .= $cad[$i];
        }
        return $ans;
    }

    static function getApellidoMaterno($cad){
        $esp = 0; $ans = '';
        for($i = 0; $i < strlen($cad) && $cad[$i] != ','; $i++)
            if($cad[$i] == ' ') $esp++;
        if($esp == 1){
            $i = 0;
            for(; $i < strlen($cad) && $cad[$i] != ' '; $i++);
            for($i++; $i < strlen($cad) && $cad[$i] != ','; $i++)
                $ans .= $cad[$i];
        }
        return $ans;
    }

    static function isNumeric($x){
        for($i = 0; $i < strlen($x); $i++)
            if(!is_numeric($x[$i])) return false;
        return true;
    }

    static function build(&$alumnosPorHorario, &$horariosValidos){
        foreach($horariosValidos as $x){
            if(Alumno::isNumeric($x->NOMBRE)) $nombreHorario = (int)($x->NOMBRE);
            else $nombreHorario = $x->NOMBRE;
            $alumnosPorHorario[$nombreHorario] = array();
            $alumnosPorHorario[$nombreHorario]["idHorario"] = $nombreHorario;
            $alumnosPorHorario[$nombreHorario]["codigoHorario"] = $nombreHorario;
            $alumnosPorHorario[$nombreHorario]["alumnos"] = array();
        }
    }

    static function getIdAlumno($codigo, &$alumnos){
        foreach($alumnos as $x)
            if($x->CODIGO == $codigo) return $x->ID_ALUMNO;
        return -1;
    }

    static function uploadAlumnosDeCurso(&$data, $idCurso, &$alumnosNuevos, &$alumnosExistentes, 
                                            &$alumnosBaneados, &$alumnosPorHorario){
        try{
            $fecha = date("Y-m-d H:i:s");
            $usuario = Auth::user();
            $idEspecialidad = Entity::getEspecialidadUsuario();
            $id_usuario = Auth::id();
            $idSemestre = Entity::getIdSemestre(); 
            $idProyecto = 1;
            $alumnos_has_horarios = AlumnosHasHorario::getAll($idSemestre);
            $especialidades = Especialidad::getEspecialidadess();
            $nombreEspecialidad = Especialidad::getNombreEspecialidad($idEspecialidad);
            $alumnos = Alumno::getAlumnos($idSemestre, $idEspecialidad);
            $horariosValidos = Horario::getHorariosByCodCurso($idSemestre, $idEspecialidad, $idCurso);
            $cont = 0;
            Alumno::build($alumnosPorHorario,$horariosValidos);

            /* Iterar por cada dato */
            foreach ($data as $key => $value) {
                $alumno = ['ID_SEMESTRE' => $idSemestre,
                            'ID_ESPECIALIDAD' => Alumno::getIdEspecialidad($especialidades,Alumno::fix($value->especialidad)),
                            'NOMBRES' => Alumno::getNombre(Alumno::fix($value->nombre)),
                            'APELLIDO_PATERNO' => Alumno::getApellidoPaterno(Alumno::fix($value->nombre)),
                            'APELLIDO_MATERNO' => Alumno::getApellidoMaterno(Alumno::fix($value->nombre)),
                            'CODIGO' => $value->alumno,
                            'FECHA_REGISTRO' => $fecha,
                            'FECHA_ACTUALIZACION' => $fecha,
                            'USUARIO_MODIF' => $usuario,
                            'ESTADO' => 1,
                            'ID_ALUMNO' => Alumno::getIdAlumno($value->alumno, $alumnos)];

                // verificar si alumno ya existe
                if(Alumno::existeAlumno($value->alumno,$alumnos)){
                    $alumnosExistentes[] = $alumno;
                }else{
                    $alumnosNuevos[] = $alumno;
                }
                
                if(Alumno::horarioValido($horariosValidos,$value->horario)){
                    // alumno sera agregado a este horario
                    foreach($alumnosPorHorario as $it){
                        $x = (int)($value->horario);
                        if($it["codigoHorario"] == $x){
                            $alumnosPorHorario[$x]["alumnos"][] = $alumno;
                            break;
                        }
                    }
                }else{
                    $alumnosBaneados[] = $alumno;
                }
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
