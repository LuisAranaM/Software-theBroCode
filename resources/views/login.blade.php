@extends('Layouts.layoutLogin')
@section('pageTitle', 'Login')
@section('content')
<img src="img/barney.gif" border="0" alt="barney" style="position: relative;
 right: 80px;">  
<form method="GET" action="{{route('prueba')}}" >
    <h1>theBroCode</h1>
    <div class="form-group">
        <input  class="form-control" placeholder="Username" type="text" required="" >
        <input class="form-control" placeholder="Password" type="password" required="">
    </div>
    <div class="form-group">
        <button class="btn btn-primary" type="submit" style="font-size: 14px">Ingresar</button>
    </div>

    <div class="separator">
        

        <div class="clearfix"></div>
        <br />

        <div>
            <h4>Pontificia Universidad Católica del Perú</h4>
            <p>Contacto: luis.arana@pucp.pe</p>
        </div>
    </div>
</form> 
@stop