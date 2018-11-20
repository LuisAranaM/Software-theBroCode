@extends('Layouts.layout')

@section('js-libs')
<link href="{{ URL::asset('css/bootstrap-datepicker.min.css') }}" rel="stylesheet" type="text/css" >
<script type="text/javascript" src="{{ URL::asset('js/bootstrap-datepicker.min.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('js/bootstrap-datepicker.es.min.js') }}"></script>
<script type="text/javascript"  src="{{ URL::asset('js/semestres/semestre.js') }}"></script>


@stop

@section('content')
@section('pageTitle', 'Administrador - Semestres')


<div class="customBody">

	<div class="row">
		<div class="col-md-8 col-sm-6">
			<h1 class="mainTitle"> Gestionar Semestres </h1>
		</div>
	</div>
	@include('flash::message')
	<div class="row">
		<div class="col-md-6 col-sm-6">			
			<div class="x_panel">
				<div class="x_title">
					<h2>Semestres</h2>
					<div class="clearfix"></div>
				</div>
				<div class="x_content">
					<table class="table table-striped jambo_table">
						<thead>
							<tr class="headings">
								<td style="vertical-align:middle;text-align:center">Semestre</td>
								<td style="vertical-align:middle;text-align:center">Inicio</td>
								<td style="vertical-align:middle;text-align:center">Fin</td>
								<td style="vertical-align:middle;text-align:center">Alerta</td>
								<td style="vertical-align:middle;text-align:center"></td>
								<td style="vertical-align:middle;text-align:center"></td>
							</tr>
						</thead>
						<tbody>
							@if(count($semestres)>0)
							@foreach($semestres as $semestre)
							<tr>
								<td style="vertical-align:middle;text-align:center">{{$semestre->SEMESTRE}}</td>
								<td style="vertical-align:middle;text-align:center">{{$semestre->FECHA_INICIO}}</td>
								<td style="vertical-align:middle;text-align:center">{{$semestre->FECHA_FIN}}</td>
								<td style="vertical-align:middle;text-align:center">{{$semestre->FECHA_ALERTA}}</td>
								<td style="vertical-align:middle;text-align:center"><a href="#"><i class="fa fa-edit" style="font-size: 20px"></i></a></td>
								<td style="vertical-align:middle;text-align:center"><a href="#"><i class="fa fa-trash" style="font-size: 20px"></i></a></td>
							</tr>
							@endforeach
							@else
							<tr>
								<td colspan="10">No se encontraron resultados</td>
							</tr>
							@endif
						</tbody>
					</table>


				</div>
			</div>
			<div class="x_panel">
				<div class="x_title">
					<h2>Seleccionar semestre actual</h2>
					<div class="clearfix"></div>
				</div>
				<div class="x_content">
					<div class="col-md-9 col-sm-9 col-xs-12">
						<select class="form-control" id="semestreAct">


							<option value="">Elige un semestre</option>
							@foreach($semestres as $semestre)
							<option value="{{$semestre->ID_SEMESTRE}}" ciclo="{{$semestre->SEMESTRE}}"" {{($semestre->ID_SEMESTRE == $semestreActual)? 'selected="selected"':''}}>{{$semestre->SEMESTRE}}</option>
							@endforeach
						</select>
					</div>
				</div>
			</div>
		</div>

		<div class="col-md-6 col-sm-6">
			<div class=" x_panel">
				<div class="x_title">
					<h2>Nuevo Semestre</h2>
					<div class="clearfix"></div>
				</div>
				<div class="x_content">
					<form id="frmNuevoSemestre" method="POST" action="{{route('administrador.semestre.crear')}}" style="margin-top: 10px;margin-bottom: 10px;" autocomplete="off">
						<div class="form-group">
							<input style="margin-bottom: 0px;" type="hidden" name="_token" value="{{ csrf_token() }}">
						</div>
						<div class="form-group col-md-4">
							<label>Año</label>
							<input style="margin-bottom: 0px;"  class="form-control formatInputNumber" placeholder="Año" type="text" name="anho" value="">
						</div>
						<div class="form-group col-md-4">
							<label>Ciclo</label>
							<input style="margin-bottom: 0px;"  class="form-control formatInputNumber" placeholder="Ciclo" type="text" name="ciclo" value="">
						</div>
						<div class="form-group col-md-4">
							<label>Fecha Inicio</label>
							<div class="input-group" style="width: 130px;">	        	                     
								<div class="input-group-addon styleAddOn"><i class="fa fa-calendar"></i></div>
								<input class="form-control dfecha"  type="text" id="txtFechaInicio" name="fInicio" placeholder="Fecha inicio">
							</div>
						</div>
						<div class="form-group col-md-4">
							<label>Fecha Fin</label>
							<div class="input-group" style="width: 130px;">	        	                     
								<div class="input-group-addon styleAddOn"><i class="fa fa-calendar"></i></div>
								<input class="form-control dfecha"  type="text" id="txtFechaFin" name="fFin" placeholder="Fecha fin">
							</div>
						</div>
						<div class="form-group col-md-4">
							<label>Fecha Alerta</label>
							<div class="input-group" style="width: 130px;">	        	                     
								<div class="input-group-addon styleAddOn"><i class="fa fa-calendar"></i></div>
								<input class="form-control dfecha"  type="text" id="txtFechaAlerta" name="fAlerta" placeholder="Fecha alerta">
							</div>
						</div>
						<div class="form-group col-md-6">
							<button class="btn btn-primary" type="submit" style="font-size: 14px">Registrar</button>
						</div>

					</form>


				</div>
			</div>
			<div class=" x_panel">
				<div class="x_title">
					<h2>Editar Semestre</h2>
					<div class="clearfix"></div>
				</div>
				<div class="x_content">

					<form id="frmNuevoSemestre" method="POST" action="{{route('administrador.semestre.editar')}}" style="margin-top: 10px;margin-bottom: 10px;" autocomplete="off">
						<div class="form-group">
							<input style="margin-bottom: 0px;" type="hidden" name="_token" value="{{ csrf_token() }}">
						</div>
						<div class="form-group col-md-4">
							<label>Año</label>
							<input style="margin-bottom: 0px;"  class="form-control formatInputNumber" placeholder="Año" type="text" name="anho" value="">
						</div>
						<div class="form-group col-md-4">
							<label>Ciclo</label>
							<input style="margin-bottom: 0px;"  class="form-control formatInputNumber" placeholder="Ciclo" type="text" name="ciclo" value="">
						</div>
						<div class="form-group col-md-4">
							<label>Fecha Inicio</label>
							<div class="input-group" style="width: 130px;">	        	                     
								<div class="input-group-addon styleAddOn"><i class="fa fa-calendar"></i></div>
								<input class="form-control dfecha"  type="text" id="txtFechaInicio" name="fInicio" placeholder="Fecha inicio">
							</div>
						</div>
						<div class="form-group col-md-4">
							<label>Fecha Fin</label>
							<div class="input-group" style="width: 130px;">	        	                     
								<div class="input-group-addon styleAddOn"><i class="fa fa-calendar"></i></div>
								<input class="form-control dfecha"  type="text" id="txtFechaFin" name="fFin" placeholder="Fecha fin">
							</div>
						</div>
						<div class="form-group col-md-4">
							<label>Fecha Alerta</label>
							<div class="input-group" style="width: 130px;">	        	                     
								<div class="input-group-addon styleAddOn"><i class="fa fa-calendar"></i></div>
								<input class="form-control dfecha"  type="text" id="txtFechaAlerta" name="fAlerta" placeholder="Fecha alerta">
							</div>
						</div>
						<div class="form-group col-md-6">
							<button class="btn btn-primary" type="submit" style="font-size: 14px">Actualizar</button>
						</div>

					</form>

				</div>
			</div>
		</div>
	</div>

</div>

@stop

@section('js-scripts')

@stop