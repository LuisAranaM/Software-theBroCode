@extends('Layouts.layout')
@section('pageTitle', 'Carga Archivos')
@section('js-libs')   
@stop

@section('content')

	<form action = "ImportClients" method = "post" enctype = "multipart/form-data">
		<label> Upload file : </label>
		<input type = "file" name = "file" />
		<input type = "hidden" value = "{{ csrf_token() }}" name = "_token" />
		<input type = "submit" value = "Upload">
	</form>

@stop

@section('js-scripts')

@stop

