@extends('Layouts.layout')
@section('pageTitle', 'Principal')
@section('content')
@section('js-libs')
<script type="text/javascript"  src="{{ URL::asset('js/avisos/avisos.js') }}"></script>
@stop

<div class="customBody">

	<div class="row">
		<div class="col-md-8 col-sm-6">
			<h1 class="mainTitle"> Generar Avisos </h1>
		</div>
	</div>

	<div class="row">
		<div class=" x_panel tile coursesBox">
			<div class="row">
				<div class="x_content bs-example-popovers courseContainer" style="cursor:pointer">
					<div id ="CargarAviso" class="addCourseButton alert alert-success alert-dismissible fade in" role="alert">
						<button type="button" class="close" aria-label="Close" ><span aria-hidden="true">+</span>
						</button>
						<p class="pText"> Agregar Nuevo Aviso </p>
					</div>
				</div>
			</div>
			<div  class="row">
				<div id="listaAvisos"></div>
				@foreach ($avisos as $a) 
				<div class="x_content bs-example-popovers courseContainer" style="cursor:pointer">
					<div class="courseButton alert alert-success alert-dismissible fade in" role="alert">
						<button type="button" class="closeaviso close" data-dismiss="alert" aria-label="Close" codigoaviso="6" fechasaviso="01/25/2018" idAviso="{{$a->ID_AVISO}}"><span aria-hidden="true">×</span>
						</button>
						<p class="pText">{{$a->FECHA_INICIO}} a {{$a->FECHA_FIN}} : {{$a->DESCRIPCION}}</p>
					</div>
				</div>
				@endforeach
				
			</div>

		</div>
	</div>
	

	<!-- Modal de Nuevo Aviso -->

	<div class="modal fade bs-example-modal-lg text-center" role="dialog" tabindex="-1"
	id="modalAvisos" data-keyboard="false" data-backdrop="static"
	aria-labelledby="gdridfrmnuavaUO" data-focus-on="input:first">
	<div class="avisosModal customModal modal-dialog modal-lg" >
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"
				aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
			<h4 id="gridSystemModalLabel" class="reportsTitle mainTitle modal-title" style="padding-top: 10px" id="gridSystemModalLabel">Crear Nuevo Aviso</h4>
		</div>
		<hr style="padding: 0px; margin-top: 0px; margin-bottom: 0px; width: 80%">
		<div class="modal-body">
			<div class="row" style="padding-left: 30px">
				
				<div class="col-sm-6 text-left">
					<label class="pText">Seleccionar el rango de fechas:</label>	
				</div>
				<div class="col-sm-6">
					<form class="form-horizontal">  
						<fieldset>
							<div class="control-group">
								<div class="controls">
									<div class="input-prepend input-group">
										<span class="add-on input-group-addon" ><i class="glyphicon glyphicon-calendar fa fa-calendar"></i></span>
										<input type="text" style="width: 200px; cursor:pointer;" name="daterange" id="daterange" class="form-control" >
									</div>
								</div>
							</div>
						</fieldset>
					</form>
				</div>
				<div class="col-xs-12 text-left" >
					<label class="pText">Texto a mostrar:</label>
				</div>
				<div class="col-xs-12 text-left" style="padding-right: 40px">
					<textarea id="textoAviso" class="descriptionInput customInput" name="texto" rows="3" cols="30" ></textarea>
				</div>

			</div>

			<div id="btnsAgregarCurso" class="modal-footer" style="border-color: transparent; padding-top: 20px;">
				<div class="row" style="text-align: center; padding-top: 10px">
					<div class="col-md-12">
						<button id="btnAgregar" class="btn btn-success pText customButtonThin" >Agregar</button>
					</div>
				</div>

			</div>
		</div>



	</div>
</div>


<!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->
</div>
<!-- /.modal -->



</div>


@stop

@section('js-scripts')


@stop