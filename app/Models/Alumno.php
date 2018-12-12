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

    static function horarioValido(&$horariosValidos, $horario, &$idHorario){
        foreach($horariosValidos as $x){
            if($x->NOMBRE == $horario){
                $idHorario = $x->ID_HORARIO;
                return true;
            }
        }
        return false;
    }

    static function horarioValidoById(&$horariosValidos, $idHorario){
        foreach($horariosValidos as $x){
            if($x->ID_HORARIO == $idHorario)
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
            $alumnosPorHorario[$nombreHorario]["idHorario"] = $x->ID_HORARIO;
            $alumnosPorHorario[$nombreHorario]["codigoHorario"] = $nombreHorario;
            $alumnosPorHorario[$nombreHorario]["alumnos"] = array();
        }
    }

    static function getIdAlumno($codigo, &$alumnos){
        foreach($alumnos as $x){
            if($x->CODIGO == $codigo) return $x->ID_ALUMNO;
        }
        return -1;
    }

    static function getNombreHorario($id, $horarios){
        foreach($horarios as $h)
            if($h->ID_HORARIO == $id) return $h->NOMBRE;
        return 0;
    }

    static function alumnoEstaEnOtroHorario(&$horarios, &$alumnos_has_horarios, &$alumnosPorHorario, &$alumno, &$idHorario, &$msg){
        // Revisar en el arreglo de alumnos_has_horarios
        Alumno::trace('ALUMNO ACTUAL');
        Alumno::trace($alumno['NOMBRES']);
        foreach($alumnos_has_horarios as $a){
            if($a->ID_ALUMNO == $alumno['ID_ALUMNO'] && $a->ID_HORARIO != $idHorario && $a->ESTADO == 1 ){
                $msg = 'El alumno con codigo ';
                $msg .= $alumno['CODIGO']; 
                $msg .= ' pertenece al horario '; 
                $msg .= Alumno::getNombreHorario($a->ID_HORARIO,$horarios);
                $msg .= ' y se intento colocarlo en el horario ';
                $msg .= Alumno::getNombreHorario($idHorario,$horarios);
                return true;
            }
        }
        // revisar en el arreglo de alumnosPorHorario
        foreach($alumnosPorHorario as $h){
            foreach($h['alumnos'] as $a){
                Alumno::trace('ALUMNO');
                Alumno::trace($a['NOMBRES']);
                Alumno::trace('ESTA EN EL HORARIO');
                Alumno::trace($h['idHorario']);
                if($a['ID_ALUMNO'] == $alumno['ID_ALUMNO'] && $h['idHorario'] != $idHorario){
                    Alumno::trace('FAIL');
                    $msg = 'El alumno con codigo ';
                    $msg .= $alumno['CODIGO'];
                    $msg .= ' se quiere insertar en los horarios ';
                    $msg .= Alumno::getNombreHorario($h['idHorario'],$horarios);
                    $msg .= ' y ';
                    $msg .= Alumno::getNombreHorario($idHorario,$horarios);
                    return true;
                }
            }
        }
        return false;
    }

    static function filtro(&$alumnos_has_horarios, &$horariosValidos){
        $ans = array(); 
        foreach($alumnos_has_horarios as $a){
            if(Alumno::horarioValidoById($horariosValidos, $a->ID_HORARIO))
                $ans[] = $a;
        }
        return $ans;
    }

    static function getIdHorariosValidos(&$horariosValidos){
        $ans = array();
        foreach($horariosValidos as $x)
            $ans[] = $x->ID_HORARIO;
        return $ans;
    }

    static function pertenece($alumno, $nombreHorario, &$alumnos_has_horarios, &$horariosValidos, $idSemestre, $idEspecialidad){
        $idHorario = 0;
        foreach($alumnos_has_horarios as $x){
            Alumno::horarioValido($horariosValidos, $nombreHorario, $idHorario);
            if($x->ID_ALUMNO == $alumno['ID_ALUMNO'] && $x->ID_HORARIO == $idHorario 
                && $x->ID_SEMESTRE == $idSemestre && $x->ID_ESPECIALIDAD == $idEspecialidad)
                return true;
        }
        return false;
    }

    static function estadoCero(&$alumno, &$idHorario, &$alumnos_has_horarios, $idEspecialidad, $idSemestre){
        foreach($alumnos_has_horarios as $x){
            if($x->ID_ALUMNO == $alumno['ID_ALUMNO'] && $x->ID_HORARIO == $idHorario 
                && $x->ID_SEMESTRE == $idSemestre && $x->ID_ESPECIALIDAD == $idEspecialidad && $x->ESTADO == 0)
                return true;
        }
        return false;
    }

    static function uploadAlumnosDeCurso(&$data, $idCurso, &$alumnosNuevos, &$alumnosExistentes, 
                                            &$alumnosBaneados, &$alumnosPorHorario, &$msg){
        try{
            $fecha = date("Y-m-d H:i:s");
            $usuario = Auth::user();
            $idEspecialidad = Entity::getEspecialidadUsuario();
            $id_usuario = Auth::id();
            $idSemestre = Entity::getIdSemestre(); 
            $idProyecto = 1;
            $especialidades = Especialidad::getEspecialidadess();
            $nombreEspecialidad = Especialidad::getNombreEspecialidad($idEspecialidad);
            $alumnos = Alumno::getAlumnos($idSemestre, $idEspecialidad);
            $horariosValidos = Horario::getHorariosByCodCurso($idSemestre, $idEspecialidad, $idCurso);
            $alumnos_has_horarios = AlumnosHasHorario::getAll($idSemestre, $idCurso);
            $alumnos_has_horarios = Alumno::filtro($alumnos_has_horarios, $horariosValidos);
            $alumnos_has_horariosFull = AlumnoHasHorario::getFull($idSemestre, $idCurso);
            $cont = 0;
            Alumno::build($alumnosPorHorario,$horariosValidos);

            /* Iterar por cada dato */
            foreach ($data as $key => $value) {
                if($value->alumno == null) return 1;
                if($value->nombre == null) return 1;
                if($value->horario == null) return 1;
                if($value->especialidad == null) return 1;
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
                
                $idHorario = 0;
                $alumnosDevuelta = array();
                if(Alumno::horarioValido($horariosValidos,$value->horario, $idHorario)){
                    // alumno sera agregado a este horario
                    $x = $value->horario;
                    if(Alumno::isNumeric($x)) $x = (int)$x;
                    /* Nueva funcionalidad : Verificar que un alumno este en solo un horario de un curso */
                    if(Alumno::alumnoEstaEnOtroHorario($horariosValidos, $alumnos_has_horarios, $alumnosPorHorario, $alumno, $idHorario, $msg))
                        return 3;
                    foreach($alumnosPorHorario as $it){
                        if($it["codigoHorario"] == $x){
                            if(!Alumno::pertenece($alumno,$x, $alumnos_has_horarios, $horariosValidos, $idSemestre, $idEspecialidad)){
                                if(Alumno::estadoCero($alumno,$idHorario,$alumnos_has_horariosFull, $idEspecialidad, $idSemestre)) 
                                    $alumnosDevuelta[] = $alumno['ID_ALUMNO'];
                                else $alumnosPorHorario[$x]["alumnos"][] = $alumno;
                            }
                            break;
                        }
                    }
                }else{
                    $alumnosBaneados[] = $alumno;
                }
                $idHorariosValidos = Alumno::getIdHorariosValidos($horariosValidos);
                // Reinsertar aquellos que regresan
                DB::table('ALUMNOS_HAS_HORARIOS')
                    ->wherein('ID_ALUMNO',$alumnosDevuelta)
                    ->where('ID_SEMESTRE','=',$idSemestre)
                    ->where('ID_ESPECIALIDAD','=',$idEspecialidad)
                    ->wherein('ID_HORARIO',$idHorariosValidos)
                    ->update(['ESTADO' => 1]);
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
