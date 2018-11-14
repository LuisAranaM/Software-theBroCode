@extends('Layouts.layout')
@section('pageTitle', 'Principal')
@section('content')
@section('js-libs')
<script type="text/javascript"  src="{{ URL::asset('js/avisos/avisos.js') }}"></script>
@stop

<div class="customBody">

	<div class="row">
		<div class="col-md-8 col-sm-6">
			<h1 class="mainTitle"> Objetivos Educacionales </h1>
		</div>
	</div>
	@include('flash::message')

	
	



</div>


@stop

@section('js-scripts')


@stop