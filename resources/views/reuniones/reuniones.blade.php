@extends('Layouts.layout')
@section('pageTitle', 'Principal')
@section('content')
@section('js-libs')
<script type="text/javascript"  src="{{ URL::asset('js/reuniones/reuniones.js') }}"></script>
@stop

<div class="customBody">

	<div class="row">
		<div class="col-md-8 col-sm-6">
			<h1 class="mainTitle"> Gestionar Documentos de Reuniones</h1>
		</div>
	</div>


@include('flash::message')
	<div class="row">
		<form id="frmAgregarDocs" action="{{route('descDocs')}}" method="POST">
			{{ csrf_field() }}
			<div class=" x_panel tile coursesBox">

				<div class="row x_panel" style="text-align: center;" >
					<div class="col-md-2">
						<label class="pText">Semestre inicio:</label>
					</div>

					<div class="col-md-2">
						<input type="text" id="txt" class="form-control pText customInputDocsReuniones"  style="width: 70px;" 
						name="semestreInicio" placeholder="" value="">  
					</div>

					<div class="col-md-1">
						<select name="semIni">
							<option value="1">1</option>
							<option value="2">2</option>
						</select>
					</div>

					<div class="col-md-2">
						<label class="pText">Semestre fin:</label>
					</div>

					<div class="col-md-2">
						<input type="text" id="txt" class="form-control pText customInputDocsReuniones"   style="width: 70px;"
						name="semestreFin" placeholder="" value="">  
					</div>

					<div class="col-md-1">
						<select name="semIni">
							<option value="1">1</option>
							<option value="2">2</option>
						</select>
					</div>

					<div class="col-md-2">
						<button id="btnBuscarDocs" class="btn btn-success pText customButtonThin">Buscar</button>
					</div>

				</div>

				<div class="row">
					<h2 class="">Documentos</h2>
					<div class="col-md-8">
						<div class="table-responsive">
							<table class="table table-striped jambo_table bulk_action">
								<thead >
									<tr class="headings" style="background-color: #005b7f; color: white; font-family: Segoe UI">
										<th class="pText column-title" style="border: none">Semestre</th>
										<th class="pText column-title" style="border: none">Tipo</th>
										<th class="pText column-title" style="border: none">Nombre</th>
										<th class="pText column-title" style="border: none">Seleccionar</th>
									</tr>
								</thead>
								<!--CargarCurso-->

								<tbody class="text-left" id="listaDocumentos">
									@foreach($documentos as $documento)
									<tr class="even pointer" id="">


										<td class="pText" style="background-color: white; padding-top: 12px; color: #72777a;text-align: center;vertical-align: center;">{{$documento->DOCUMENTO_ANHO}}-{{$documento->DOCUMENTO_SEMESTRE}}</td>
										@if($documento->TIPO_DOCUMENTO == "acta")
										<td class="pText" style="background-color: white; padding-top: 12px; color: #72777a;text-align: center;vertical-align: center;">Acta de Reunión</td>
										@else
										<td class="pText" style="background-color: white; padding-top: 12px; color: #72777a;text-align: center;vertical-align: center;">Plan de Mejora</td>
										@endif
										<td class="pText" style="background-color: white; padding-top: 12px; color: #72777a;text-align: center;vertical-align: center;"><a href="{{URL::asset('upload/'.$documento->NOMBRE)}}" download="{{$documento->NOMBRE}}" style="text-decoration: underline;">{{$documento->NOMBRE}}<i class="fa fa-download" style="padding-left: 5px"></i> </a></td>

										<td>
											<label>
												<input type="checkbox" class="form-check-input checkDoc" 
												name="checkDocs[]" value="{{$documento->NOMBRE}}" style="text-align: center;" >
												<span class="pText label-text "></span>
											</label>
										</td>

									</tr>
									@endforeach
								<!---
									
								<tr class="even pointer" id="">
									<form>

										<td class="pText" style="background-color: white; padding-top: 12px; color: #72777a;text-align: center;vertical-align: center;">2017-1</td>
										<td class="pText" style="background-color: white; padding-top: 12px; color: #72777a;text-align: center;vertical-align: center;">Acta de Reunón</td>
										
										<td><input type="checkbox" name="select"></td>
									</form>

								</tr>
								<tr class="even pointer" id="">
									<form>

										<td class="pText" style="background-color: white; padding-top: 12px; color: #72777a;text-align: center;vertical-align: center;">2017-1</td>
										<td class="pText" style="background-color: white; padding-top: 12px; color: #72777a;text-align: center;vertical-align: center;">Plan de Mejora</td>
										<td><input type="checkbox" name="select"></td>
									</form>

								</tr>
								<tr class="even pointer" id="">
									<form>

										<td class="pText" style="background-color: white; padding-top: 12px; color: #72777a;text-align: center;vertical-align: center;">2018-1</td>
										<td class="pText" style="background-color: white; padding-top: 12px; color: #72777a;text-align: center;vertical-align: center;">Plan de Mejora</td>
										<td><input type="checkbox" name="select"></td>
									</form>

								</tr>
							-->

						</tbody>
					</table>

				</div>
			</div>
			<div class="col-md-4">
				<div class=" x_panel tile coursesBox" id="ModalCargar" style="text-align: center; cursor: pointer;">
					<h2 class="">Cargar Documentos</h2> <i class="fa fa-upload" style="font-size: 30px;"></i> 
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-sm-3">
				<button id="btnDescargarDoc" class="btn btn-success pText customButtonReuniones" name="botonSubmit" value="Desc">Descargar Documento</button>
			</div>
			<div class="col-sm-3">
				<button id="btnEliminarDoc" class="btn btn-success pText customButtonReuniones" name="botonSubmit" value="Elim">Eliminar Documento</button>
			</div>
		</div>

	</div>
</form>
</div>




<!-- Modal de Cargar Documentos -->

<div class="modal fade bs-example-modal-lg text-center" role="dialog" tabindex="-1"
id="modalCargarDocsReuniones" data-keyboard="false" data-backdrop="static"
aria-labelledby="gdridfrmnuavaUO" data-focus-on="input:first" >
<div class="customModal modal-dialog modal-lg ">
	<div class="modal-content" style="top: 30%">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal"
			aria-label="Close">
			<span aria-hidden="true">&times;</span>
		</button>
		<h4 id="CargarDocumentos" class="reportsTitle mainTitle modal-title" style="padding-top: 10px" id="gridSystemModalLabel">Cargar Documentos</h4>
	</div>
	<hr style="padding: 0px; margin-top: 0px; margin-bottom: 0px; width: 80%">
	<div class="modal-body">
		<form id="upload_form" action = "{{ route('reuniones.store') }}" method = "post" enctype = "multipart/form-data">
			{{csrf_field()}}
			<div class="row" style="padding: 10px;">

				<label class="pText">Seleccionar tipo de documento a subir:</label>
				<select name="tipoDoc">
					<option value="acta">Acta de Reunión</option>
					<option value="plan">Plan de Mejora</option>
				</select>
			</div>
			<div class="row" style="padding: 10px;">
				<div class="col-md-8">
					<label class="pText">Seleccionar semestre de creación:</label>
				</div>
				<div class="col-md-2">
					<input type="text" id="txt" class="form-control pText customInputDocsReunionesModal"  style="width: 70px;" 
					name="ano" placeholder="" value=""> 
				</div>	

				<div class="col-md-2">
					<select name="semestre">
						<option value="1">1</option>
						<option value="2">2</option>
					</select>
				</div>	 

			</div>
			<div class="row" style="padding-bottom: 30px;">
				<div class="container-fluid text-center">
					<div class="dropzone" style="min-height: 100px; height: 190px; width: 350px; border: 2px dashed #ccc; display: inline-block; background-color: white; margin-top: 10px; margin-bottom: 10px">
						<i class="fa fa-5x fa-cloud-upload" style="color: #ccc; height: 100px; padding: 10px"></i>
						<p class="pText">Arrastra y suelta un archivo <br> o <br> 

							<div class = "form-group">
								<input type="file" name="archivo" id = "file" class="form-control image" style="border-color: white">
							</div>
							<div class="row" style="padding-top: 20px; text-align: center; display: flex;justify-content: center;">
								<div class="col-md-4">
									<input id="btnCargarHorariosModal" class = "btn btn-success pText customButtonThin upload-file" style="padding-right: 5px; padding-left: 5px;" type="submit" value = "Cargar" name="submit">
								</div>
							</div>






						</div>
					</div>
				</div>
			</form>
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