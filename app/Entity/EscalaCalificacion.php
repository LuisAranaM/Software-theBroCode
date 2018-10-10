<?php

namespace App\Entity;

use \Illuminate\Pagination\LengthAwarePaginator as Paginator;
use App\Models\EscalaCalificacion as mEscalaCalificacion;
use Jenssegers\Date\Date as Carbon;
<<<<<<< HEAD
use Illuminate\Support\Facades\Log as Log;
=======
>>>>>>> AranaBranch

class EscalaCalificacion extends \App\Entity\Base\Entity {

	protected $_fechaRegistro;
    
    function setProperties($data) {
        $this->setValues([
            '_fechaRegistro' => $data->FECHA_REGISTRO,
        ]);
    }

    function setValueToTable() {
        return $this->cleanArray([
            'FECHA_REGISTRO' => $this->_fechaRegistro,
        ]);
    }

<<<<<<< HEAD
    static function getEscalas() {
        return mEscalaCalificacion::getEscalas()->get();
    }

    static function updateEscala($esc1,$esc2,$esc3,$esc4){
        //Falta añadir excepción
        $status = true;
        try {
            mEscalaCalificacion::updateEscala($esc1,$esc2,$esc3,$esc4);
        } catch (Exception $e) {
            Log::error('BASE_DE_DATOS|' . $e->getMessage());
            $status = false;
            DB::rollback();
        }
        return $status;
    }

=======
    
>>>>>>> AranaBranch
}