<?php
namespace App\Models;
use DB;
use Log;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Hash;
use Jenssegers\Date\Date as Carbon;
use OwenIt\Auditing\Contracts\Auditable;

class Usuario extends Authenticatable implements Auditable{
    use \OwenIt\Auditing\Auditable;
    /**
 * Class Usuario
 * 
 * @property int $ID_USUARIO
 * @property int $ID_ROL
 * @property string $USUARIO
 * @property string $PASS
 * @property string $CORREO
 * @property \Carbon\Carbon $FECHA_REGISTRO
 * @property \Carbon\Carbon $FECHA_ACTUALIZACION
 * @property int $USUARIO_MODIF
 * @property int $ESTADO
 * @property string $NOMBRES
 * @property string $APELLIDO_PATERNO
 * @property string $APELLIDO_MATERNO
 * 
 * @property \App\Models\Role $role
 * @property \Illuminate\Database\Eloquent\Collection $especialidades_has_profesores
 * @property \Illuminate\Database\Eloquent\Collection $profesores_has_horarios
 *
 * @package App\Models
 */
    
    protected $table = 'USUARIOS';
    
    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey ='ID_USUARIO';

        /**
     * The name of the "created at" column.
     *
     * @var string
     */
        public $timestamps = false;

        protected $casts = [
            'ID_ROL' => 'int',
            'USUARIO_MODIF' => 'int',
            'ESTADO' => 'int'
        ];

        protected $dates = [
            'FECHA_REGISTRO',
            'FECHA_ACTUALIZACION'
        ];

        protected $fillable = [
           'USUARIO',
           'PASS',
           'CORREO',
           'FECHA_REGISTRO',
           'FECHA_ACTUALIZACION',
           'USUARIO_MODIF',
           'ESTADO',
           'NOMBRES',
           'APELLIDO_PATERNO',
           'APELLIDO_MATERNO',
       ];
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [
        'USUARIO',
        'PASS',
        'ID_ROL',
        'NOMBRES',
        'APELLIDO_PATERNO',
        'APELLIDO_MATERNO'
    ];
    //protected $username = 'REGISTRO';

    public function rol()
    {
        return $this->belongsTo(\App\Models\Rol::class, 'ID_ROL');
    }

    public function usuarios_has_especialidades()
    {
        return $this->hasMany(\App\Models\UsuariosHasEspecialidades::class, 'ID_USUARIO', 'id_usuario');
    }

    public function profesores_has_horarios()
    {
        return $this->hasMany(\App\Models\ProfesoresHasHorario::class, 'ID_USUARIO', 'id_usuario');
    }

    public function getAuthPassword () {
        return $this->PASS;
    }
    public function getRememberToken()
    {
        if (! empty($this->TOKEN)) {
            return $this->TOKEN;
        }
    }
    /**
     * Set the token value for the "remember me" session.
     *
     * @param  string  $value
     * @return void
     */
    public function setRememberToken($value)
    {
        if (! empty($this->TOKEN)) {
            $this->TOKEN = $value;
        }
    }
    public function hasRol($rol){
        return in_array($rol, [$this->ID_ROL]);
    }
    static function getUsuario($usuario){
        $sql=DB::table('USUARIOS')
        ->select()
        ->where('USUARIO','=',$usuario);
        //dd($sql);
        return $sql;
    }


    static function getUsuariosGestion($filtros=[]){
        $sql=DB::table('USUARIOS AS US')
        ->select('US.ID_USUARIO','US.USUARIO','US.CORREO',
            'US.NOMBRES' ,'US.APELLIDO_PATERNO','US.APELLIDO_MATERNO',
            DB::Raw("CONCAT(US.NOMBRES ,' ',US.APELLIDO_PATERNO,' ',US.APELLIDO_MATERNO) 
                AS NOMBRES_COMPLETOS"),'US.PERFIL','ROL.NOMBRE AS ROL_USUARIO','ROL.ID_ROL','ES.ID_ESPECIALIDAD', 'ES.NOMBRE AS ESPECIALIDAD_USUARIO', 'US.ESTADO AS FLG_ACTIVO')    
        ->leftJoin('ROLES AS ROL',function($join){
            $join->on('US.ID_ROL','=','ROL.ID_ROL');
        })
        ->leftJoin('USUARIOS_HAS_ESPECIALIDADES AS UE',function($join){
            $join->on('UE.ID_USUARIO','=','US.ID_USUARIO');
        })
        ->leftJoin('ESPECIALIDADES AS ES',function($join){
            $join->on('ES.ID_ESPECIALIDAD','=','UE.ID_ESPECIALIDAD');
        })
        ->where('US.ESTADO','=',$filtros['estado'])
        ->orderBy('ROL.NOMBRE','ASC')
        ->orderBy(DB::Raw("CONCAT(US.CORREO,US.NOMBRES ,' ',US.APELLIDO_PATERNO,' ',US.APELLIDO_MATERNO)"),'ASC');

        if (isset($filtros['rol'])){
            $sql = $sql->where('US.ID_ROL','=',$filtros['rol']);
        }
        if (isset($filtros['especialidad'])){
            $sql = $sql->where('UE.ID_ESPECIALIDAD','=',$filtros['especialidad']);
        }
        if (isset($filtros['usuario'])){
            $sql = $sql->where('US.USUARIO','like','%'.$filtros['usuario'].'%');
        }
        if (isset($filtros['email'])){
            $sql = $sql->where('US.CORREO','like','%'.$filtros['email'].'%');
        }
        if (isset($filtros['nombres'])){
            $sql = $sql->where(DB::Raw("CONCAT(US.NOMBRES ,' ',US.APELLIDO_PATERNO,' ',US.APELLIDO_MATERNO)"),'like','%'.$filtros['nombres'].'%');
        }
        //dd($sql);
        return $sql;
    }


    static function getCorreo($correo){
        $sql=DB::table('USUARIOS')
        ->select()
        ->where('CORREO','=',$correo)
        ->where('ESTADO','=',1);
        //dd($sql);
        return $sql;
    }

    static function verificarCuentaRecuperar($usuarioCorreo){
        $sql=DB::table('USUARIOS')
            ->select()
            ->where('ESTADO','=',1);
        if(strpos($usuarioCorreo,"@")==false){
            $sql=$sql->where('USUARIO','=',$usuarioCorreo);
        }
        else{
            $sql=$sql->where('CORREO','=',$usuarioCorreo);
        }

        return $sql->count();
    } 

    static function obtenerCorreoUsuario($usuarioCorreo){
        $sql=DB::table('USUARIOS')
            ->select()
            ->where('ESTADO','=',1);
        if(strpos($usuarioCorreo,"@")==false){
            $sql=$sql->where('USUARIO','=',$usuarioCorreo);
        }
        else{
            $sql=$sql->where('CORREO','=',$usuarioCorreo);
        }

        return $sql->first()->CORREO;
    } 
    
    static function verificarUsuario($usuario,$flgEditar=null){
        $sql=DB::table('USUARIOS')
        ->select()
        ->where('CORREO','=',$usuario['CORREO'])
        ->orWhere('USUARIO','=',$usuario['USUARIO']);

        $verificar=0;
        if($flgEditar){
            foreach($sql->get() as $fila){
                if ($fila->ID_USUARIO==$usuario['ID_USUARIO'])
                    $verificar=1;
            }
        //dd($sql->get(),$verificar);
            if ($verificar) return 0;
        }
           
        //dd($sql->get());
        if($sql->count()>0){
            if ($sql->first()->CORREO==$usuario['CORREO'])
                return 2;
            else return 1;
        }
        else return 0;

        //return $sql->count();
    }

    static function updateFoto($idUsuario,$usuarioGoogle){
        $hoy=Carbon::now();
        $sql=DB::table('USUARIOS')                
        ->where('ID_USUARIO','=',$idUsuario)
        ->update(['PERFIL' => $usuarioGoogle['IMAGEN_PERFIL'],'FECHA_ACTUALIZACION'=>$hoy]);
        return true;
    }
    static function updateMasive(){
        $usuarios = DB::table('USUARIOS AS US')->select('US.USUARIO')
        ->where('ID_ROL','=',4)
        ->whereNull('PASS')
        ->get();
        //dd($usuarios);
        foreach ($usuarios as $usuario) {
            DB::table('USUARIOS') 
            ->where('USUARIO','=',$usuario->USUARIO)
            ->update(['PASS' => Hash::make($usuario->USUARIO)]);
        }
    }
    
    static function updatePassword($correo,$password){
        //dd("HOLA");
        $hoy=Carbon::now();
        return DB::table('USUARIOS')
        ->where('CORREO','=',$correo)
        ->update(['PASS' => Hash::make($password),'FECHA_ACTUALIZACION'=>$hoy]);
    }
    public function actualizarContrasena($idUsuario,$password){
        return DB::table('USUARIOS')
        ->where('ID_USUARIO','=',$idUsuario)
        ->update(['PASS' => Hash::make($password),'FECHA_ACTUALIZACION'=>Carbon::now(),'USUARIO_MODIF'=>$idUsuario]);
    }
    public function verificarContrasena($idUsuario,$apassword){
        $sql = DB::table('USUARIOS AS US')
        ->where('ID_USUARIO', '=', $idUsuario)
        ->where('ESTADO','=','1');

        //El usuario encontrado es la primera coincidencia (usuario es unico)     
        $usuario = $sql->first();
        //La función Hash::check() se encarga de confirmar si dos cadenas encriptadas son iguales
        return Hash::check($apassword, $usuario->PASS);
    }

    public function getIdUsuario($codUsuario,$correo){
        $sql = DB::table('USUARIOS')
        ->select('ID_USUARIO')
        ->where('USUARIO','=',$codUsuario)
        ->orWhere('CORREO','=',$correo);

        return $sql;

    }

    function crearCuentaRubrik($usuario,$usuarioEspecialidad){
        //dd(Carbon::now());    
        DB::beginTransaction();
        $status = true;

        try {
            $idUsuario=DB::table('USUARIOS')->insertGetId($usuario);
            $usuarioEspecialidad['ID_USUARIO']=$idUsuario;
            $usuarioEspecialidad['USUARIO_MODIF']=$idUsuario;
            if($usuario['ID_ROL']!=1){
                DB::table('USUARIOS_HAS_ESPECIALIDADES')->insert($usuarioEspecialidad);
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
    function recuperarContrasena($correo,$pass){
        //dd(Carbon::now());    
        DB::beginTransaction();
        $status = true;

        try {
            DB::table('USUARIOS')
            ->where('CORREO','=',$correo)
            ->update(['PASS'=>Hash::make($pass)]);
            DB::commit();
        } catch (\Exception $e) {
            Log::error('BASE_DE_DATOS|' . $e->getMessage());
            $status = false;
            DB::rollback();
        }
        return $status;
        //dd($sql->get());
    }

    function editarCuentaRubrik($usuario,$usuarioEspecialidad){
        //dd(Carbon::now());    
        DB::beginTransaction();
        $status = true;

        try {
            DB::table('USUARIOS')
            ->where('ID_USUARIO','=',$usuario['ID_USUARIO'])
            ->update(['ID_ROL'=>$usuario['ID_ROL'],
                'USUARIO' =>$usuario['USUARIO'],           
                'CORREO' =>$usuario['CORREO'],            
                'FECHA_ACTUALIZACION'=>$usuario['FECHA_ACTUALIZACION'],
                'USUARIO_MODIF'=>$usuario['USUARIO_MODIF'],      
                'NOMBRES' =>$usuario['NOMBRES'],           
                'APELLIDO_PATERNO'=>$usuario['APELLIDO_PATERNO'],   
                'APELLIDO_MATERNO' =>$usuario['APELLIDO_MATERNO']]
            );

            if($usuario['ID_ROL']!=1){
                DB::table('USUARIOS_HAS_ESPECIALIDADES')
                ->where('ID_USUARIO','=',$usuarioEspecialidad['ID_USUARIO'])
                ->update(
                    ['ID_ESPECIALIDAD'=>$usuarioEspecialidad['ID_ESPECIALIDAD'],    
                    'FECHA_ACTUALIZACION'=>$usuarioEspecialidad['FECHA_ACTUALIZACION'],
                    'USUARIO_MODIF'=>$usuarioEspecialidad['USUARIO_MODIF']]    
                );
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

    function activarUsuarios($checks,$usuarioModif){
        DB::beginTransaction();
        $status = true;

        try {
            foreach($checks as $check){
                //dd($check);
                $usuario=DB::table('USUARIOS')
                        ->where('ID_USUARIO','=',$check)->first();
                DB::table('USUARIOS')
                ->where('ID_USUARIO','=',$check)
                ->update(['ESTADO'=>1,
                    'PASS'=>Hash::make($usuario->USUARIO),
                    'FECHA_ACTUALIZACION'=>Carbon::now(),
                    'USUARIO_MODIF'=>$usuarioModif]);
                $dataUsuario=[
                    'NOMBRES'=>$usuario->NOMBRES,
                    'APELLIDO_PATERNO'=>$usuario->APELLIDO_PATERNO,
                    'APELLIDO_MATERNO'=>$usuario->APELLIDO_MATERNO,
                    'CORREO'=>$usuario->CORREO,
                    'USUARIO'=>$usuario->USUARIO,
                ];
                $this->enviarMail($dataUsuario);
            }
            DB::commit();
        } catch (\Exception $e) {
            Log::error('BASE_DE_DATOS|' . $e->getMessage());
            $status = false;
            DB::rollback();
        }
        return $status;
    }

function enviarMail($usuario){
    $data=array(
        'nombresCompletos'=>$usuario['NOMBRES'].' '.$usuario['APELLIDO_PATERNO'].' '.$usuario['APELLIDO_MATERNO'],
        'email'=>$usuario['CORREO'],
        'usuario'=>$usuario['USUARIO'],
        'password'=>$usuario['USUARIO'],
    );
    \Mail::send('emails.welcome',$data,function($message)use($data){
        $message->from('rubrik.pucp@gmail.com','RubriK PUCP');
        $message->to($data['email'])->subject('Bienvenido a RubriK');
    });
}
    function eliminarCuentaRubrik($idUsuario,$usuarioModif){
        //dd(Carbon::now());    
        DB::beginTransaction();
        $status = true;

        try {
            DB::table('USUARIOS')
            ->where('ID_USUARIO','=',$idUsuario)
            ->update(['ESTADO'=>0,
                'FECHA_ACTUALIZACION'=>Carbon::now(),
                'USUARIO_MODIF'=>$usuarioModif]);
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