<?php
namespace App\Model;
use DB;
use Log;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Hash;
use Jenssegers\Date\Date as Carbon;
class Usuario extends Authenticatable{
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
    
    
    protected $fillable = [
        'USUARIO',
        'PASS',
        'ID_ROL',
        'NOMBRES',
        'APELLIDO_PATERNO',
        'APELLIDO_MATERNO'
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
    public function hasRole($rol){
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
}