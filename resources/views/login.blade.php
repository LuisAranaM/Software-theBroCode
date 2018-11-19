@extends('Layouts.layoutLogin')
@section('pageTitle', 'Login')
@section('content')

<div class="panel boxshadow" style="margin-left: -90px; margin-top: -65px; width: 512px; height: 640px; padding-top: 50px">
<div class="col-md-12 col-sm-12 col-xs-12">
<img src="{{ URL::asset('img/logo2.png') }}" alt="logoRubriK" style="height: 121.5px;width: 321.5px">
</div>
<a href="{{ route('login.google') }}" class="btn btn-primary" style="font-size: 16px; margin-top: 60px; margin-bottom: 40px; width: 300px"><i class="fa fa-google"></i> Ingresar con Google</a>
<form method="POST" action="{{ route('login.attempt') }}" style="margin-top: 10px;margin-bottom: 10px;" >
    <div class="form-group">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <p style= "margin-top: -35px; margin-left: -10px">o</p>
        <div class="lefthr"><hr style="margin-top: -21px; margin-bottom: 15px; margin-left: 100px;width: 130px"></div>
        <div class="righthr"><hr style="margin-top: -21px; margin-bottom: 15px; margin-left: -130px;width: 130px"></div>
        <input  class="form-control" placeholder="Usuario o Correo Electrónico" type="text" required="" name="usuario" style="margin-left: 100px; width: 300px">
        <input class="form-control" style="margin-bottom: 5px; margin-left: 100px;width: 300px" placeholder="Contraseña" type="password" required="" name="pass" onKeyPress=" capLock(event) ">
        <div id="caplock" style=" visibility:hidden ">El bloqueo de mayúsculas está activado</div>    
    </div>
    <div class="form-group">
        <button class="btn btn-primary" type="submit" style="font-size: 14px; width: 300px">Ingresar</button>
    </div>

    <div class="clearfix"></div>

    <div>
        <h4>Pontificia Universidad Católica del Perú</h4>
        <p>Contacto: thebrodecode@pucp.pe</p>
    </div>
    
</form>
</div>
@stop

@section('js-scripts')

@stop