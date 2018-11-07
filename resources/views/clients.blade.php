@extends('Layouts.layout')
@section('pageTitle', 'Carga Archivos')
@section('js-libs')   
@stop

@section('content')

	<h1>Lista de cursos</h1>
	<table>
		<tr>
			<th>codigo</th>
			<th>nombre</th>
		</tr>
		@foreach($clients as $c)
		<tr>
			<td>{{ $c->codigo }}</td>
			<td>{{ $c->nombre }}</td>
		</tr>
		@endforeach
	</table>

@stop

@section('js-scripts')

@stop

