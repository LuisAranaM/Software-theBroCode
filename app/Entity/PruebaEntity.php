<?php

namespace App\Entity;

use \Illuminate\Pagination\LengthAwarePaginator as Paginator;
use App\Model\PruebaModel as mPrueba;
use Jenssegers\Date\Date as Carbon;

class PruebaEntity extends \App\Entity\Base\Entity {

    static function getCursos() {
        $model = new mPrueba();
        return mPrueba::getCursos()->get();
    }
	
	static function getHorarios($idCurso) {
        $model = new mPrueba();
        return mPrueba::getHorarios($idCurso)->get();
    }
}
