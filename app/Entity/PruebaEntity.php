<?php

namespace App\Entity;

use \Illuminate\Pagination\LengthAwarePaginator as Paginator;
use App\Model\PruebaModel as mPrueba;
use Jenssegers\Date\Date as Carbon;

class PruebaEntity extends \App\Entity\Base\Entity {

    static function getPrueba() {
        $model = new mPrueba();
        return mPrueba::getPrueba()->get();
    }

    
}
