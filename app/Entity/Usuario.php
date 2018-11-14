<?php

namespace App\Entity;

use App\Models\Usuario as mUsuario;
use \Illuminate\Pagination\LengthAwarePaginator as Paginator;
use DB;

class Usuario extends \App\Entity\Base\Entity {

    const ROL_ADMINISTRADOR = 1;
    const ROL_COORDINADOR = 2;
    const ROL_ASISTENTE = 3;
    const ROL_PROFESOR = 4;
        
    const ITEMS_PER_PAGE = 15;

    protected $_usuario;
    protected $_rol;
    protected $_nombres;
    protected $_apellidoPaterno;
    protected $_apellidoMaterno;
    protected $_correo;
    protected $_fechaRegistro;
    protected $_fechaActualizacion;
    protected $_usuarioModif;
    protected $_estado;

    public function setFromAuth($user) {
        $this->setValue('_usuario',$user->USUARIO);
        $this->setValue('_rol',$user->ID_ROL);
        $this->setValue('_nombres',$user->NOMBRES);
        $this->setValue('_apellidoPaterno',$user->APELLIDO_PATERNO);
        $this->setValue('_apellidoMaterno',$user->APELLIDO_MATERNO);
        $this->setValue('_correo',$user->CORREO);
        $this->setValue('_fechaRegistro',$user->FECHA_REGISTRO);
        $this->setValue('_fechaActualizacion',$user->FECHA_ACTUALIZACION);
        $this->setValue('_usuarioModif',$user->USUARIO_MODIF);
        $this->setValue('_estado',$user->ESTADO);        
    }   

    static function getUsuario($usuario){
        $model = new mUsuario();      
        return $model->getUsuario($usuario)->first();
    }
    /*
        PODEMOS GENERAR MÉTODOS PARA LISTAR A LOS PROFESORES EN GENERAL O POR ESPECIALIDAD
     */

    static function redirectRol($rol) {
        //dd($rol);
        $urlAdmin = 'administrador.principal';
        $urlCoordinador = 'cursos.gestion';
        $urlAsistente = 'cursos.gestion';
        $urlProfesor = 'profesor.calificar';
        
        switch ($rol) {
            case self::ROL_ADMINISTRADOR:
                return $urlAdmin;
            case self::ROL_COORDINADOR:
                return $urlCoordinador;
            case self::ROL_ASISTENTE:
                return $urlAsistente;
            case self::ROL_PROFESOR:
                return $urlProfesor;
            default:
                return 'prueba';
        }
    }
   
    static function getUsuarios() {
        return [
            self::ROL_ADMINISTRADOR,
            self::ROL_COORDINADOR,
            self::ROL_ASISTENTE,
            self::ROL_PROFESOR
        ];
    }   

    static function getCoordinadorAsistente() {
        return [self::ROL_COORDINADOR, self::ROL_ASISTENTE];
    }


    public function actualizarContrasena($usuario,$apassword,$npassword){

        $model = new mUsuario();
        if (!($model->verificarContrasena($usuario,$apassword))){
            $this->setMessage('La contraseña ingresada no coincide con la original');
            return false;
        }
        else{
            $model->actualizarContrasena($usuario,$npassword);
            $this->setMessage('La contraseña fue cambiada exitosamente');
            return true;
        }

    }

    static function updateMasive(){
        $model = new mUsuario();
        $model->updateMasive();
    }

    public function getIdUsuario($codUsuario){
        $model = new mUsuario();
        return $model->getIdUsuario($codUsuario);
    }

}
