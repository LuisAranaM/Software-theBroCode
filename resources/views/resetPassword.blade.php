@extends('Layouts.layoutLogin')
@section('pageTitle', 'Recuperar Contraseña')
@section('content')

<div class="panel boxshadow" style="margin-left: -90px; margin-top: -65px; width: 512px; height: 640px; padding-top: 50px">
<div class="col-md-12 col-sm-12 col-xs-12">
<img src="{{ URL::asset('img/logo2.png') }}" alt="logoRubriK" style="height: 121.5px;width: 321.5px;margin-top: 80px;margin-bottom: 10px">
</div>

<form method="POST" action="{{ route('pass.reset.post') }}" style="margin-top: 10px;margin-bottom: 10px;" >
    <div class="form-group">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <p>Te enviaremos un correo para ayudarte a recuperar tu contraseña</p>
        <input  class="form-control" placeholder="Usuario o Correo Electrónico" type="text" required="" name="usuario" style="margin-left: 100px; width: 300px">    
    </div>
    @include('flash::message')
    <div class="form-group">
        <button class="btn btn-primary" type="submit" style="font-size: 14px; width: 300px">Recuperar Contraseña</button>
    </div>

    <div class="clearfix"></div>

    <div>
        <h4>Pontificia Universidad Católica del Perú</h4>
        <p>Contacto: rubrik-pucp@gmail.com</p>
    </div>
    
</form>
</div>
@stop

@section('js-scripts')

@stop