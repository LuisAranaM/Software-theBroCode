<?php

namespace App\Entity\Base;
use Illuminate\Support\Facades\Auth;
use App\Models\Especialidad as mEspecialidad;
use App\Models\Semestre as mSemestre;

class Entity {

    protected $_message;
    
    function getValue($propertie) {
        if (property_exists($this, $propertie)) {
            return $this->{$propertie};
        } else {
            return false;
        }
    }

    function getMessage() {
        return $this->_message;
    }
	
    function filterValue($value, $valueDefault = '') {
        return ($value === '' ? ($valueDefault === '' ? NULL : $valueDefault) : $value);
    }

    function setMessage($message) {
        $this->_message = $message;
    }

    function setValue($properti, $value) {
        $propsFormat = $this->setFormatValue();
        if (in_array($properti, $propsFormat)) {
            $this->$properti = $value;
        } else {
            trigger_error('El Key <b>"' . $properti . '"</b> no coinciden con las propiedades de la clase ', E_USER_ERROR);
            exit;
        }
    }

    function getValues() {
        $cl = new \ReflectionClass($this);
        $props = $cl->getProperties(\ReflectionProperty::IS_PROTECTED);
        foreach ($props as $prop) {
            $propsFormat[$prop->getName()] = $this->{$prop->getName()};
        }
        return $propsFormat;
    }

    function setValues($data) {
        if ($data != NULL && is_array($data)) {
            $propsFormat = $this->setFormatValue();
            foreach ($data as $index => $value) {
                if (in_array($index, $propsFormat)) {
                    $this->$index = $value;
                } else {
                    trigger_error('El Key <b>"' . $index . '"</b> no coinciden con las propiedades de la clase ', E_USER_ERROR);
                    exit;
                }
            }
        }
    }

    function setFormatValue() {
        $cl = new \ReflectionClass($this);
        $props = $cl->getProperties(\ReflectionProperty::IS_PROTECTED);
        foreach ($props as $prop) {
            $propsFormat[] = $prop->getName();
        }
        return $propsFormat;
    }

    protected function cleanArray($data) {
        foreach ($data as $index => $value) {
            if ($value === 0)
                continue;
            if ($value === '' || $value == '') {
                unset($data[$index]);
            } else {
                if ($value === 'NULL') {
                    $data[$index] = null;
                }
            }
        }
        return $data;
    }

    public static function getIdSemestre(){
        $model= new mSemestre();
        //return $model->getIdSemestre();
        //return config('app.id_semestre');
        return env('ID_SEMESTRE');
    }


   public static function getSemestre(){
        $model= new mSemestre();
        return $model->getCiclo(self::getIdSemestre())->first()->SEMESTRE;
    }

    public static function getSemestreByIdSemestre($idSemestre){
        $model= new mSemestre();
        return $model->getCiclo($idSemestre)->first()->SEMESTRE;
    }

    public static function getEspecialidadUsuario(){
        //dd(Auth::user());
        $model=new mEspecialidad();
        return  $model->getEspecialidadUsuario(Auth::id())->ID_ESPECIALIDAD;

    }

    public static function getNombreEspecialidadUsuario(){
        //dd(Auth::user());
        $model=new mEspecialidad();
        return  $model->getEspecialidadUsuario(Auth::id())->NOMBRE_ESPECIALIDAD;

    }

    public static function getUsuarioCompleto(){
        return  Auth::user();

    }
}
