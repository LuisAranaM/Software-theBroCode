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
    
    static function updatePassword($usuario,$password){
        //dd("HOLA");
        $hoy=Carbon::now();
        return DB::table('USUARIOS')
             ->where('USUARIO','=',$usuario)
            ->update(['PASS' => Hash::make($password),'FECHA_ACTUALIZACION'=>$hoy]);
    }
    public function updateNewPassword($usuario,$password){
        return DB::table('USUARIOS')
             ->where('USUARIO','=',$usuario)
            ->update(['PASS' => Hash::make($password)]);
    }
    public function verifyPassword($usuario,$apassword){
        $sql = DB::table('USUARIOS AS US')
               ->where('USUARIO', '=', $usuario)
               ->where('ESTADO','=','1');
         
        //El usuario encontrado es la primera coincidencia (usuario es unico)     
        $usuario = $sql->first();
        //La función Hash::check() se encarga de confirmar si dos cadenas encriptadas son iguales
        return Hash::check($apassword, $usuario->PASS);
    }

    public function getIdUsuario($codUsuario){
        $sql = DB::table('USUARIOS')
                ->select('ID_USUARIO')
                ->where('USUARIO','=',$codUsuario)
                ->where('ESTADO','=',1);

    }
}