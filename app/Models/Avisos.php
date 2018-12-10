<?php

/**
 * Created by Reliese Model.
 * Date: Sun, 30 Sep 2018 22:12:14 +0000.
 */

namespace App\Models;
use DB;
use Reliese\Database\Eloquent\Model as Eloquent;
use Jenssegers\Date\Date as Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log as Log;

/**
 * Class Criterio
 * 
 * @property int $ID_RESULTADO
 * @property int $ID_ESPECIALIDAD
 * @property int $ID_SEMESTRE
 * @property string $NOMBRE
 * @property \Carbon\Carbon $FECHA_REGISTRO
 * @property \Carbon\Carbon $FECHA_ACTUALIZACION
 * @property int $USUARIO_MODIF
 * @property int $ESTADO
 * 
 * @property \App\Models\Especialidade $especialidade
 * @property \App\Models\Semestre $semestre
 * @property \Illuminate\Database\Eloquent\Collection $subcriterios
 *
 * @package App\Models
 */
class Avisos extends Eloquent
{
	static function getAvisos($idSem,$idEsp) {
		//dd($idSem);
        $sql = DB::table('AVISOS')
                //->select('DESCRIPCION', DB::Raw('CONVERT(FECHA_INICIO,DATE) AS FECHA_INICIO'), DB::Raw('CONVERT(FECHA_FIN,DATE) AS FECHA_FIN'))
        		->select('ID_AVISO', 'DESCRIPCION', DB::Raw('DATE_FORMAT(FECHA_INICIO, "%m/%d/%Y") AS FECHA_INICIO'), DB::Raw('DATE_FORMAT(FECHA_FIN, "%m/%d/%Y") AS FECHA_FIN'))
                ->where('ESTADO','=',1)
                ->where('ID_SEMESTRE','=',$idSem)
             	->where('ID_ESPECIALIDAD','=',$idEsp)
             	->orderBy('ID_AVISO', 'desc');
        //dd($sql->get());
        return $sql;

	}

    static function getAvisosActuales($idSem,$idEsp) {
        //dd($idSem);
        $sql = DB::table('AVISOS')
                //->select('DESCRIPCION', DB::Raw('CONVERT(FECHA_INICIO,DATE) AS FECHA_INICIO'), DB::Raw('CONVERT(FECHA_FIN,DATE) AS FECHA_FIN'))
                ->select('ID_AVISO', 'DESCRIPCION', DB::Raw('DATE_FORMAT(FECHA_INICIO, "%m/%d/%Y") AS FECHA_INICIO'), DB::Raw('DATE_FORMAT(FECHA_FIN, "%m/%d/%Y") AS FECHA_FIN'))
                ->where('ESTADO','=',1)
                ->where('ID_SEMESTRE','=',$idSem)
                ->where('ID_ESPECIALIDAD','=',$idEsp)
                ->where('FECHA_INICIO', '<=', now())
                ->where('FECHA_FIN', '>=', now())
                ->orderBy('ID_AVISO', 'desc')
                ->get();
        //dd($sql->get());
        return $sql;

    }

	public function insertAviso($desc,$fechaIni,$fechaFin, $idSem, $idEsp){
		DB::beginTransaction();
        $id=-1;
        try {
            $aviso=['DESCRIPCION' => $desc,
                'FECHA_INICIO' => $fechaIni,
                'FECHA_FIN' => $fechaFin,
                'ID_SEMESTRE' => $idSem,
                'ID_ESPECIALIDAD' => $idEsp,
                'FECHA_REGISTRO' => Carbon::now(),
                'FECHA_ACTUALIZACION' => Carbon::now(),     
                'USUARIO_MODIF' => Auth::id(),      
                 'ESTADO' => 1];
            $id = DB::table('AVISOS')->insertGetId(
		    	$aviso);
            DB::commit();
        } catch (\Exception $e) {
            Log::error('BASE_DE_DATOS|' . $e->getMessage());
            DB::rollback();
        }
        if($id>0)
            $this->enviarMailAvisos($aviso,Auth::user(),$idEsp);
		return $id;
	}

function enviarMailAvisos($aviso,$coordinador,$idEspecialidad){
    $usuarios=DB::Table('USUARIOS AS US')
        ->select(DB::Raw("CONCAT(US.NOMBRES ,' ',US.APELLIDO_PATERNO,' ',US.APELLIDO_MATERNO) 
                AS NOMBRES_COMPLETOS"),'US.CORREO')
        ->leftJoin('USUARIOS_HAS_ESPECIALIDADES AS UHE',function($join){
            $join->on('UHE.ID_USUARIO','=','US.ID_USUARIO');
        })
        ->where('UHE.ID_ESPECIALIDAD','=',$idEspecialidad)
        ->where('US.ID_ROL','=',4)
        ->where('US.ESTADO','=',1)->get();
    dd($usuarios);
    foreach ($usuarios as $usuario) {
        
        $data=array(
            'nombresCompletos'=>$usuario->NOMBRES_COMPLETOS,
            'nombreCoordinador'=>$coordinador->NOMBRES.' '.$coordinador->APELLIDO_PATERNO.' '.$coordinador->APELLIDO_MATERNO,
            'descripcion'=>$aviso['DESCRIPCION'],
            'fechaInicio'=>$aviso['FECHA_INICIO'],
            'fechaFin'=>$aviso['FECHA_FIN'],
            'email'=>$usuario->CORREO,
        );

        \Mail::send('emails.avisos',$data,function($message)use($data){
            $message->from('rubrik.pucp@gmail.com','RubriK PUCP');
            $message->to($data['email'])->subject('Se ha registrado un anuncio');
        });
    }
}

	public function eliminarAviso($idAviso){
		//dd("DEBUG");
		DB::beginTransaction();
        $status = true;
       
        try {
            DB::table('AVISOS')
                ->where('ID_AVISO','=',$idAviso)
                ->update(['ESTADO'=>0]);
            DB::commit();
        } catch (\Exception $e) {
            Log::error('BASE_DE_DATOS|' . $e->getMessage());
            $status = false;
            DB::rollback();
        }
        return $status;
	}
	
}
