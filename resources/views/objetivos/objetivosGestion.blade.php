@extends('Layouts.layout')
@section('pageTitle', 'Principal')
@section('content')
@section('js-libs')
<script type="text/javascript"  src="{{ URL::asset('js/objetivos/objetivos.js') }}"></script>
@stop

<div class="customBody">

	<div class="row">
		<div class="col-md-8 col-sm-6">
			<h1 class="mainTitle"> Gestión de Objetivos </h1>
		</div>
	</div>
	@include('flash::message')
	<div class="row">
		<div class="x_panel">
			<div class="row">
				<div class="col-md-6">
					<form action="" method="">
						{{ csrf_field() }}
						<div class="table-responsive" style="height:300px;overflow:auto;">
							<table class="table table-striped jambo_table bulk_action">
								<thead >
									<tr class="headings" style="background-color: #005b7f; color: white; font-family: Segoe UI">
										<th class="pText column-title" style="border: none">Objetivos del Estudiante</th>
										<th class="pText column-title" style="border: none">Seleccionar</th>
									</tr>
								</thead>


								<tbody class="text-left" id="listaSOS">
									@foreach($objetivosEstudiante as $so)
									<tr class="even pointer" id="columnaX">
										<td class="pText editSo" idSOS="{{$so->ID_SOS}}" nombreSOS="{{$so->NOMBRE}}" style="background-color: white;color: #72777a;text-align: left;vertical-align: center;cursor: pointer">{{$so->NOMBRE}}</td>

										<td class="pText" style="background-color: white; color: #72777a;text-align: center;vertical-align: center;">
											<i id="editSo" idSOS="{{$so->ID_SOS}}" nombreSOS="{{$so->NOMBRE}}" ></i>
											<i idSOS="{{$so->ID_SOS}}" nombreSOS="{{$so->NOMBRE}}" class="elimSo fa fa-trash fa-lg" style=" cursor: pointer"></i>

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
						<div id="btnsGuardar" class="modal-footer" style="border-color: transparent; padding-top: 20px;">
							<div class="row" style="text-align: center; padding-top: 10px">
								<div class="col-md-12">
									<!--<button id="btnAgregarSos" class="btn btn-success pText customButtonThin" >Agregar</button>-->
									<button type="button" id="btnAgregarSos" class=" btn pText customButtonThin" style="color: white; width: 200px;">Agregar Obj. Estudiante</button>
								</div>
							</div>

						</div>
					</form>
				</div>

				<div class="col-md-6">


					<div class="table-responsive" style="height:300px;overflow:auto;">
						<table class="table table-striped jambo_table bulk_action">
							<thead >
								<tr class="headings" style="background-color: #005b7f; color: white; font-family: Segoe UI">
									<th class="pText column-title" style="border: none">Objetivos Educacionales</th>
									<th class="pText column-title" style="border: none">Seleccionar</th>


								</tr>
							</thead>


							<tbody class="text-left" id="listaSOS">
								@foreach($objetivosEducacionales as $eo)
								<tr class="even pointer" id="columnaX">
									<td class="pText editEo" idEOS="{{$eo->ID_EOS}}" nombreEOS="{{$eo->NOMBRE}}" style="background-color: white;color: #72777a;text-align: left;vertical-align: center;cursor: pointer">{{$eo->NOMBRE}}</td>

									<td class="pText" style="background-color: white; color: #72777a;text-align: center;vertical-align: center;" >
									<i id="editEo" idEOS="{{$eo->ID_EOS}}" nombreEOS="{{$eo->NOMBRE}}" ></i>
									<i idEOS="{{$eo->ID_EOS}}" nombreEOS="{{$eo->NOMBRE}}" class="elimEo fa fa-trash fa-lg" style=" cursor: pointer"</i>
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
						<div id="btnsGuardar" class="modal-footer" style="border-color: transparent; padding-top: 20px;">
							<div class="row" style="text-align: center; padding-top: 10px">
								<div class="col-md-12">
									<button id="btnAgregarEos" class=" btn pText customButtonThin" style="color: white; width: 200px;">Agregar Obj. Educacionales</button>
								</div>
							</div>

						</div>
					</div>

				</div>


			</div>
		</div>
		<!--MODAL SOS-->
		<div class="modal fade bs-example-modal-lg text-center" role="dialog" tabindex="-1" id="modalAgregarObjetivosSOS" data-keyboard="false" data-backdrop="static" aria-labelledby="gdridfrmnuavaUO" data-focus-on="input:first">
			<div class="customModal modal-dialog modal-lg" style="width: 500px; height: 300px" >
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
			<div class="customModal modal-dialog modal-lg" style="width: 500px; height: 300px" >
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

</div>


@stop

@section('js-scripts')


@stop