<?php

/**
 * Created by Reliese Model.
 * Date: Sun, 30 Sep 2018 22:12:14 +0000.
 */

namespace App\Models;
use DB;
use Log;
use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Proyecto
 * 
 * @property int $ID_PROYECTO
 * @property mediumblob $PROYECTO
 * @property \Carbon\Carbon $FECHA_REGISTRO
 * @property \Carbon\Carbon $FECHA_ACTUALIZACION
 * @property int $USUARIO_MODIF
 * @property int $ESTADO
 * 
 * @property \Illuminate\Database\Eloquent\Collection $alumnos_has_horarios
 *
 * @package App\Models
 */
class Proyecto extends Eloquent
{
    protected $primaryKey = 'ID_PROYECTO';
    public $timestamps = false;

    protected $casts = [
        'ID_SEMESTRE'=>'int',
        'ID_ESPECIALIDAD'=>'int',
        'PROYECTO' => 'mediumblob',
        'USUARIO_MODIF' => 'int',
        'ESTADO' => 'int'
    ];

    protected $dates = [
        'FECHA_REGISTRO',
        'FECHA_ACTUALIZACION'
    ];

    protected $fillable = [
        'PROYECTO',
        'FECHA_REGISTRO',
        'FECHA_ACTUALIZACION',
        'USUARIO_MODIF',
        'ESTADO'
    ];

    public function alumnos_has_horarios()
    {
        return $this->hasMany(\App\Models\AlumnosHasHorario::class, 'ID_PROYECTO', 'id_proyecto');
    }
    static public function getRutaProyectos($idHorario){
        $ans = DB::table('PROYECTOS')
        ->join('ALUMNOS_HAS_HORARIOS', 'ALUMNOS_HAS_HORARIOS.ID_PROYECTO', '=', 'PROYECTOS.ID_PROYECTO')
        ->select('PROYECTOS.*')
        ->where('ALUMNOS_HAS_HORARIOS.ID_HORARIO','=',$idHorario)
        ->orderBy('FECHA_ACTUALIZACION', 'desc')
        ->get()->toArray();
        return $ans;
    }

    function agregarMasivo($dataSubir){

        DB::beginTransaction();
        $status = true;

        try {

            foreach ($dataSubir as $data) {
                $proyecto=$data['PROYECTO'];
                $alumno=$data['ALUMNO'];

                $idProyecto = DB::table('PROYECTOS')->insertGetId($proyecto);
                $alumno['ID_PROYECTO']=$idProyecto;
            //Update
                DB::table('ALUMNOS_HAS_HORARIOS')
                ->where('ID_ALUMNO','=',$alumno['ID_ALUMNO'])
                ->where('ID_SEMESTRE','=',$alumno['ID_SEMESTRE'])
                ->where('ID_ESPECIALIDAD','=',$alumno['ID_ESPECIALIDAD'])
                ->where('ID_HORARIO','=',$alumno['ID_HORARIO'])
                ->update(['ESTADO'=>0,'FECHA_ACTUALIZACION'=>$alumno['FECHA_ACTUALIZACION']]);
                //dd($proyecto,$alumno);
                DB::table('ALUMNOS_HAS_HORARIOS')->insert($alumno);
            }

            DB::commit();
        } catch (\Exception $e) {
            Log::error('BASE_DE_DATOS|' . $e->getMessage());
            $status = false;
            DB::rollback();
        }
        return $status;
        //dd($sql->get());
    }
}
