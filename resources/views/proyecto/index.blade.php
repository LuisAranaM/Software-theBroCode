@extends('Layouts.layout')
@section('pageTitle', 'Carga Archivos')
@section('js-libs')   
@stop

@section('content')

<div class="customBody">
	<div class="col-md-12 col-sm-12">
      <h1 class="mainTitle"> Subir Archivo </h1>
    </div>
<div class ="ui buttom attached segment"></div>
	<form action="{{ route('proyecto.store') }}" method="post" enctype="multipart/form-data">
		{{ csrf_field() }}
		<input type="file" name="archivo" id = "file">
		<br>
		<button type = "submit" class = "btn btn-success btn-lg pText customButton">Cargar</button>
	</form>
</div>
</div>

@stop

@section('js-scripts')

@stop

