@extends('Layouts.layout')

@section('js-libs')

<script type="text/javascript"  src="{{ URL::asset('js/especialidades/especialidades.js') }}"></script>


@stop

@section('content')
@section('pageTitle', 'Gestionar Especialidades')


<div class="customBody">

	<div class="row">
		<div class="col-md-8 col-sm-6">
			<h1 class="mainTitle"> Gestionar Especialidades </h1>
		</div>
	</div>
	@include('flash::message')
	<div class="row">
		<div class="col-md-6 col-sm-6 col-xs-12">			
			<div class="x_panel">
				<div class="x_title">
					<h2>Especialidades</h2>
					<div class="clearfix"></div>
				</div>
				<div class="x_content">
					<table class="table table-striped jambo_table">
						<thead>
							<tr class="headings">
								<td style="vertical-align:middle;text-align:center">Especialidad</td>
								<td style="vertical-align:middle;text-align:center">Fecha de Creación</td>
								<td style="vertical-align:middle;text-align:center"></td>
								<td style="vertical-align:middle;text-align:center"></td>
							</tr>
						</thead>
						<tbody>
							@if(count($especialidades)>0)
							@foreach($especialidades as $especialidad)
							<tr idEspecialidad="{{$especialidad->ID_ESPECIALIDAD}}" nombEspecialidad="{{$especialidad->NOMBRE}}">
								<td style="vertical-align:middle;text-align:center">{{$especialidad->NOMBRE}}</td>
								<td style="vertical-align:middle;text-align:center">{{$especialidad->FECHA_REGISTRO}}</td>
								<td style="vertical-align:middle;text-align:center"><i class="fas fa-pen editarEspecialidad" style="font-size: 16px;cursor: pointer;"></td>
								<td style="vertical-align:middle;text-align:center"><i class="fas fa-trash eliminarEspecialidad" style="font-size: 16px;cursor: pointer;"></td>
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
		</div>

		<div class="col-md-6 col-sm-6 col-xs-12">
			<div class=" x_panel">
				<div class="x_title">
					<h2>Nueva Especialidad</h2>
					<div class="clearfix"></div>
				</div>
				<div class="x_content">
					<form id="frmNuevaEspecialidad" method="POST" action="{{route('administrador.especialidad.crear')}}" autocomplete="off">
						<div class="form-group">
							<input style="margin-bottom: 0px;" type="hidden" name="_token" value="{{ csrf_token() }}">
						</div>
						<div class="form-group">
							<label>Especialidad</label>
							<input style="margin-bottom: 0px;"  class="form-control" placeholder="Especialidad" type="text" name="especialidad" value="">
						</div>
						<div class="form-group">
							<button class="btn btn-primary" type="submit" style="font-size: 14px">Registrar</button>
						</div>

					</form>


				</div>
			</div>
		</div>
	</div>

</div>


<!--Editar Semestre-->
	<div class="modal fade bs-example-modal-lg text-center" role="dialog" tabindex="-1"
	id="modalEditarEspecialidad" data-keyboard="false" data-backdrop="static"
	aria-labelledby="gdridfrmnuavaUO" data-focus-on="input:first" >
	<div class="modalSemestre modal-dialog modal-lg ">
		<div class="modal-content" style="top: 20%">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"
				aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
			<h4 class="reportsTitle mainTitle modal-title" style="padding-top: 10px" id="gridSystemModalLabel">Editar Semestre</h4>
		</div>
		<hr style="padding: 0px; margin-top: 0px; margin-bottom: 0px; width: 80%">
		<div class="modal-body">
			<div class="container-fluid text-center">
				<form id="frmEditarEspecialidad" method="POST" action="{{route('administrador.especialidad.editar')}}" style="margin-top: 10px;margin-bottom: 10px;" autocomplete="off">
						<div class="form-group">
							<input style="margin-bottom: 0px;" type="hidden" name="_token" value="{{ csrf_token() }}">
						</div>
							<input type="text" name="idEspecialidad" hidden="">
						<div class="form-group">
							<label>Especialidad</label>
							<input style="margin-bottom: 0px;"  class="form-control" placeholder="Especialidad" type="text" name="nombEspecialidadEditar" value="">
						</div>
						<div class="form-group">
							<button class="btn btn-primary" type="submit" style="font-size: 14px">Actualizar</button>
						</div>

					</form>
			</div>
		</div>
	</div>
	<!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->
</div>
@stop

@section('js-scripts')

@stop