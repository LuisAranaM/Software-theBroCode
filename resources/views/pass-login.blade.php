@extends('Layouts.layoutLogin')

@section('content')

<form method="post" action="{{ route('pass.attempt') }}" >
    <h1>Ingreso Rubrik</h1>
    <div class="form-group">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input class="form-control" placeholder="Usuario" type="text" name="usuario">
    </div>
    <div class="form-group">
        <input class="form-control" placeholder="Contraseña" required="" type="password" name="pass">
    </div>
    <div class="form-group">
        <button class="btn btn-default" type="submit">Ingresar</button>
    </div>
</form> 
@stop