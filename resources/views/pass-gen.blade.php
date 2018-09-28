@extends('Layouts.layoutlogin')

@section('content')

<form method="post" action="{{ route('pass.save') }}" >
    <h1>Generar Contraseña</h1>
    <div class="form-group">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input class="form-control" placeholder="Usuario" type="text" name="usuario">
    </div>
    <div class="form-group">
        <input class="form-control" type="text" name="pass" placeholder="Contraseña" value="{{$pass}}">
    </div>
    <div class="form-group">
        <button class="btn btn-default" type="submit">Actualizar</button>
    </div>

    <div class="clearfix"></div>
</form> 
@stop