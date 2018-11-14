<?php

namespace App\Http\Controllers;

use App\Entity\Sos as eSos;
use App\Entity\Eos as eEos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use App\Entity\Base\Entity;
use DB;


class ObjetivosEducacionalesController extends Controller
{
    public function objetivosGestion() {    
        return view('objetivos.objetivos')
        ->with('objetivosEstudiante',eSos::getObjetivosEstudiante())
        ->with('objetivosEducacionales',eEos::getObjetivosEducacionales());
    }
}
