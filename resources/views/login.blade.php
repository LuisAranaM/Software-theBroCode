@extends('Layouts.layoutLogin')
@section('pageTitle', 'Login')
@section('content')

<div class="col-md-12 col-sm-12 col-xs-12">
<img src="{{ URL::asset('img/logo.png') }}" alt="logoRubriK" style="height: 121.5px;width: 321.5px">
</div>
<form method="POST" action="{{ route('login.attempt') }}" >
    <div class="form-group">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input  class="form-control" placeholder="Usuario" type="text" required="" name="usuario">
        <input class="form-control" placeholder="Contraseña" type="password" required="" name="pass">
    </div>
    <div class="form-group">
        <button class="btn btn-primary" type="submit" style="font-size: 14px">Ingresar</button>
    </div>

    <div class="clearfix"></div>

    <div>
        <h4>Pontificia Universidad Católica del Perú</h4>
        <p>Contacto: thebrodecode@pucp.pe</p>
    </div>
    
</form> 
@stop