<?php

namespace App\Model;

use DB;
use Log;
use Illuminate\Database\Eloquent\Model;
use Jenssegers\Date\Date as Carbon;
class PruebaModel extends Model {

    static function getPrueba() {
        $sql = DB::table('USUARIOS as PRUEBA')
                ->select();
        
        return $sql;
    }

    
}
