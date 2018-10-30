@extends('Layouts.layout')
@section('pageTitle', 'Carga Archivos')
@section('js-libs')   
@stop

@section('content')
	{{--
	<form action = "ImportClients" method = "post" enctype = "multipart/form-data">
		<label> Upload file : </label>
		<input type = "file" name = "file" />
		<input type = "hidden" value = "{{ csrf_token() }}" name = "_token" />
		<input type = "submit" value = "Upload">
	</form>
	
	<form action = "{{url('upload')}}" method = "post" enctype = "multipart/form-data">
		{{csrf_field()}}
		<div class = "form-group">
			<label for="upload-file"> Upload</label>
			<input type = "file" name = "upload-file" class="form-control">
		</div>
		<label> Upload file : </label>
		<input class = "btn btn-success" type="submit" value = "Upload image" name="submit">
	</form>
	--}}
@stop

@section('js-scripts')

@stop

