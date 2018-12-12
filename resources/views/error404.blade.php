@extends('Layouts.layout')
@section('pageTitle', 'Error 404')
@section('content')
@section('js-libs')
@stop
<div class="customBody">
    <center>
        <h1 class="error-number">404</h1>
        <h2>Lo sentimos pero no encontramos lo que intentas buscar</h2>
        <p>La ruta que intentas buscar no existe</p>
        <img src="{{ URL::asset('img/error404.png') }}" alt="Error404" style="width: 270px;display:block;margin:auto;" />
    </center>
</div>
@stop

@section('js-scripts')
@stop