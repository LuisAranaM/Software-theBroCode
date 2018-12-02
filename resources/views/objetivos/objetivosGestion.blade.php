@extends('Layouts.layout')
@section('pageTitle', 'Gestión de Objetivos')
@section('content')
@section('js-libs')
<script type="text/javascript"  src="{{ URL::asset('js/objetivos/objetivos.js') }}"></script>
<script type="text/javascript"  src="{{ URL::asset('js/objetivos/configuracion.js') }}"></script>
@stop
<?php 
$modoSoloLectura=in_array(Auth::user()->ID_ROL,App\Entity\Usuario::getModoLectura());

?>
<div class="customBody">

	<div class="row">
		<div class="col-md-8 col-sm-6">
			<h1 class="mainTitle"> Gestión de Objetivos </h1>
		</div>
	</div>

	@if((count($objetivosSos)!=0) and (count($objetivosEos)!=0))
	<div class="row">
		<div class="col-md-12 col-xs-12" style="text-align: right">
			<button type="button" class="customButtonLarge customButtonRubr btn btn-success btn-lg pText" id="btnCopiarConfiguracionObj" style="border-color: transparent"> Copiar Configuración</button>
		</div>
	</div>
	<!--<a id="btnCopiarConfiguracion" style="cursor: pointer;">Copiar configuración de semestre pasado (solo mostrar cuando está vacío rubricas)</a>-->
	@endif


	@include('flash::message')
	<div class="row">
		<div class="col-sm-6 col-xs-12">
			<div class="x_panel" style="padding: 20px" >
				<form action="" method="">
					{{ csrf_field() }}
					<div class="table-responsive" style="min-height: 100px; max-height: 300px;  overflow:auto;">
						<table class="table table-striped jambo_table bulk_action">
							<thead >
								<tr class="headings" style="background-color: #005b7f; color: white; font-family: Segoe UI	">
									<th class="pText column-title" style="border: none">Objetivos del Estudiante</th>
									<th class="pText column-title" style="border: none; text-align: center;"></th>
								</tr>
							</thead>


							<tbody class="text-left" id="listaSOS">
								@foreach($objetivosEstudiante as $so)
								<tr class="even pointer" id="columnaX">
									<td class="pText <?php echo (!$modoSoloLectura? 'editSo' :'' );?> " idSOS="{{$so->ID_SOS}}" nombreSOS="{{$so->NOMBRE}}" style="background-color: white;color: #72777a;text-align: left;vertical-align: center;cursor: pointer">{{$so->NOMBRE}}</td>

									<td class="pText" style="background-color: white; color: #72777a;text-align: center;vertical-align: center;">
										<i id="editSo" idSOS="{{$so->ID_SOS}}" nombreSOS="{{$so->NOMBRE}}" ></i>
										@if(!$modoSoloLectura)
										<i idSOS="{{$so->ID_SOS}}" nombreSOS="{{$so->NOMBRE}}" class="elimSo fas fa-trash fa-md" style=" cursor: pointer"></i>
										@endif
											<!--<label>
												<input type="checkbox" class="form-check-input checkSo" 
												name="checkSelectso[]" value="{{$so->ID_SOS}}" style="text-align: center;"><span class="pText label-text "></span>
											</label>-->
										</td>
									</tr>
									@endforeach
								</tbody>
							</table>
						</div>

					</form>
					@if(!$modoSoloLectura)
					<div id="btnsGuardar" class="text-center" style="border-color: transparent">
						<!--<button id="btnAgregarSos" class="btn btn-success pText customButtonThin" >Agregar</button>-->
						<button type="button" id="btnAgregarSos" class=" btn pText customButtonThin" style="color: white; width: 150px; height: 50px; font-size: 13px">Agregar Objetivo <br> del Estudiante</button>
					</div>
					@endif
				</div>
			</div>

			<div class="col-sm-6 col-xs-12" >
				<div class="x_panel" style="padding: 20px">


					<div class="table-responsive" style="min-height:100px; max-height: 300px; overflow:auto;">
						<table class="table table-striped jambo_table bulk_action">
							<thead >
								<tr class="headings" style="background-color: #005b7f; color: white; font-family: Segoe UI">
									<th class="pText column-title" style="border: none">Objetivos Educacionales</th>
									<th class="pText column-title" style="border: none; text-align: center;"></th>


								</tr>
							</thead>


							<tbody class="text-left" id="listaSOS">
								@foreach($objetivosEducacionales as $eo)
								<tr class="even pointer" id="columnaX">
									<td class="pText <?php echo (!$modoSoloLectura? 'editEo' :'' );?> " idEOS="{{$eo->ID_EOS}}" nombreEOS="{{$eo->NOMBRE}}" style="background-color: white;color: #72777a;text-align: left;vertical-align: center;cursor: pointer">{{$eo->NOMBRE}}</td>

									<td class="pText" style="background-color: white; color: #72777a;text-align: center;vertical-align: center;" >
										<i id="editEo" idEOS="{{$eo->ID_EOS}}" nombreEOS="{{$eo->NOMBRE}}" ></i>
										@if(!$modoSoloLectura)
										<i idEOS="{{$eo->ID_EOS}}" nombreEOS="{{$eo->NOMBRE}}" class="elimEo fas fa-trash fa-md" style=" cursor: pointer"</i>
										@endif
											<!--<label>
												<input type="checkbox" class="form-check-input checkSo" 
												name="checkSelectso[]" value="{{$eo->ID_EOS}}" style="text-align: center;"><span class="pText label-text "></span>
											</label>-->
										</td>

									</tr>
									@endforeach
								</tbody>
							</table>

						</div>
						@if(!$modoSoloLectura)
						<div id="btnsGuardar" class="text-center" style="border-color: transparent">
							<button id="btnAgregarEos" class=" btn pText customButtonThin" style="color: white; width: 150px; height: 50px; font-size: 13px">Agregar Objetivo <br> Educacional</button>
						</div>
						@endif
					</div>
				</div>


			</div>
		</div>
		<!--MODAL SOS-->
		<div class="modal fade bs-example-modal-lg text-center" role="dialog" tabindex="-1" id="modalAgregarObjetivosSOS" data-keyboard="false" data-backdrop="static" aria-labelledby="gdridfrmnuavaUO" data-focus-on="input:first">
			<div class="modalObjetivos modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal"
						aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					<!--<label  class="reportsTitle mainTitle modal-title" style="padding-top: 10px" id="ModalTitle" name="codigoHorario" type="text" value=""></label>-->
					<h4 id="gridSystemModalLabel" class="reportsTitle mainTitle modal-title" style="padding-top: 10px" id="gridSystemModalLabel">Agregar Objetivo del Estudiante</h4>
				</div>
				<hr style="padding: 0px; margin-top: 0px; margin-bottom: 0px; width: 80%">
				<div class="modal-body"> 
					<div class="container-fluid" style="">
						<form id="frmAgregarCursos" action="" method="POST">
							{{ csrf_field() }}
							<div class="tile coursesModalBox" style="padding-bottom: 20px;">

								<div id="filasCat"class="row rowFinal2">
									<div class="col-xs-12">
										<p style="font-size: 16px; font-family: segoe UI semibold; text-align: left; color: black">Detalles del Objetivo del Estudiante</p>
									</div>
									<div class="col-xs-12">
										<textarea type="text" id="txtSos" class="descripcionSos form-control pText customInput" name="nombresos2" placeholder="Descripción" rows="3" cols="30" style="resize: none;" ></textarea>   
									</div>

								</div>
							</div>

							<div id="btnsResultado" class="modal-footer">
								<div class="row" style="padding-top: 5px; text-align: center; display: flex;justify-content: center;">
									<div class="col-md-4">
										<button id="btnAgregarSosModal" class = "btn btn-success pText customButton" type="button" value = "Cargar" name="cargar">Guardar</button>
									</div>

								</div>
							</div>

						</form>
					</div>
				</div>
			</div>

			<!-- /.modal-content -->
		</div>
		<!-- /.modal-dialog -->
	</div>
	<!-- /.modal -->


	<!--MODAL EOS-->
	<div class="modal fade bs-example-modal-lg text-center" role="dialog" tabindex="-1" id="modalAgregarObjetivosEOS" data-keyboard="false" data-backdrop="static" aria-labelledby="gdridfrmnuavaUO" data-focus-on="input:first">
		<div class="modalObjetivos modal-dialog" >
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"
					aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<!--<label  class="reportsTitle mainTitle modal-title" style="padding-top: 10px" id="ModalTitle" name="codigoHorario" type="text" value=""></label>-->
				<h4 id="gridSystemModalLabel" class="reportsTitle mainTitle modal-title" style="padding-top: 10px" id="gridSystemModalLabel">Agregar Objetivo Educacional</h4>
			</div>
			<hr style="padding: 0px; margin-top: 0px; margin-bottom: 0px; width: 80%">
			<div class="modal-body"> 
				<div class="container-fluid" style="">
					<form id="frmAgregarCursos" action="" method="POST">
						{{ csrf_field() }}
						<div class="tile coursesModalBox" style="padding-bottom: 20px;">

							<div id="filasCat"class="row rowFinal2">
								<div class="col-xs-12">
									<p style="font-size: 16px; font-family: segoe UI semibold; text-align: left; color: black">Detalles del Objetivo Educacional</p>
								</div>
								<div class="col-xs-12">
									<textarea type="text" id="txtEos" class="descripcionSos form-control pText customInput" name="nombreeos2" placeholder="Descripción" rows="3" cols="30" style="resize: none;" ></textarea>   
								</div>

							</div>
						</div>

						<div id="btnsResultado" class="modal-footer">
							<div class="row" style="padding-top: 5px; text-align: center; display: flex;justify-content: center;">
								<div class="col-md-4">
									<button id="btnAgregarEosModal" class = "btn btn-success pText customButton" type="button" value = "Cargar" name="cargar">Guardar</button>
								</div>

							</div>
						</div>

					</form>
				</div>
			</div>
		</div>

		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
<!-- /.modal -->




<div class="modal fade bs-example-modal-lg text-center" role="dialog" tabindex="-1" id="modalConfiguracionObj" data-keyboard="false" data-backdrop="static" aria-labelledby="gdridfrmnuavaUO" data-focus-on="input:first">
	<div class="modalResultados customModal modal-dialog modal-lg" >
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"
				aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
			<h4 class="mainTitle modal-title" style="padding-top: 10px" id="gridSystemModalLabel">Copiar Configuración de Objetivos</h4>
		</div>
		<hr style="padding: 0px; margin-top: 0px; margin-bottom: 0px; width: 80%">
		<div class="modal-body"> 
			<div class="container-fluid" style="">
				<form id="frmAgregarCursos" action="" method="POST">
					{{ csrf_field() }}
					<div class="tile coursesModalBox" style="padding-bottom: 20px;">

						<div id="filasCat"class="row">
							<div class="col-xs-12">
								<p style="font-size: 16px; font-family: segoe UI semibold; text-align: left; color: black">Selecciona el semestre para copiar la configuración:</p>
							</div>
							<div class="col-xs-12">
								<select class="form-control" id="cboSemestreConfiguracion">
									<option>Seleccionar una opción</option>
									@foreach($semestres as $semestre)
									<option value="{{$semestre->ID_SEMESTRE}}" semestre="{{$semestre->SEMESTRE}}">{{$semestre->SEMESTRE}}</option>
									@endforeach
								</select>
							</div>

						</div>
					</div>

					<div class="modal-footer">
						<div class="row" style="padding-top: 5px; text-align: center; display: flex;justify-content: center;">
							<div class="col-md-4">
								<button id="btnMostrarConfiguracionObj" class = "btn btn-success pText customButton btn-lg" type="button" value = "Cargar" name="cargar" style="width:160px !important">Mostrar Configuración</button>
							</div>

						</div>
					</div>

				</form>
			</div>
		</div>
	</div>

	<!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->
</div>


<div class="modal fade bs-example-modal-lg text-center" role="dialog" tabindex="-1" id="modalConfiguracionMObjostrar" data-keyboard="false" data-backdrop="static" aria-labelledby="gdridfrmnuavaUO" data-focus-on="input:first" style="overflow-y: scroll;">
	<div class="customModal modal-dialog modal-lg" style="width: 1200px; height: 300px;" >
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"
				aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>

			<h4 class="mainTitle modal-title" style="padding-top: 10px" id="tituloModalConfirmacion"></h4>

		</div>
		<hr style="padding: 0px; margin-top: 0px; margin-bottom: 0px; width: 80%">
		<div class="modal-body"> 
			<div class="container-fluid" style="">
				<form id="frmCopiarConfiguracion" action="{{route('configuracionObj.copiar')}}" method="POST">
					{{ csrf_field() }}
					<div class="tile coursesModalBox" style="padding-bottom: 20px;" id="interiorConfirmacion">


					</div>
					<input type="hidden" name="idSemestreConfirmado" id="idSemestreConfirmado">

					<div class="modal-footer">
						<div class="row" style="padding-top: 5px; text-align: center; display: flex;justify-content: center;">
							<div class="col-md-4">
								<button id="btnAceptarCopiaObj" class = "btn btn-success pText customButton btn-lg" type="submit" style="width: 160px !important" >Copiar Configuración</button>
							</div>

						</div>
					</div>

				</form>
			</div>
		</div>
	</div>

	<!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->

</div>

</div>
<?php $nombreEspecialidad=App\Entity\Especialidad::getNombreEspecialidadUsuario(); ?>
<input type="hidden" value="{{$nombreEspecialidad}}" id="nombreEspecialidad">
@stop

@section('js-scripts')


@stop