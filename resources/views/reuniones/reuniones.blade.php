@extends('Layouts.layout')
@section('pageTitle', 'Principal')
@section('content')
@section('js-libs')
<script type="text/javascript"  src="{{ URL::asset('js/reuniones/reuniones.js') }}"></script>
@stop

<div class="customBody">

	@include('flash::message')
	<div class="row">
		<div class="col-md-8 col-sm-6">
			<h1 class="mainTitle"> Gestionar Histórico de Documentos de Reuniones</h1>
		</div>
	</div>


	@include('flash::message')
	<div class="row">
		<form id="frmAgregarDocs" action="{{route('descDocs')}}" method="POST">
			{{ csrf_field() }}
			<div class=" x_panel tile coursesBox">
				<div class="row">
					<div class="col-xs-12" >
						<h1 class="secondaryTitle mainTitle">Buscar documentos</h1>
					</div>
					<div class="col-xs-12">  
						<div id="rangoSemestres" class="no-padding" style="display: inline-block">
							<label class="semLabel pText" style="padding-top: 5px; margin-right: 10px">Semestre inicial:</label>
							<select name="semIni" id="semIni"  class="form-control" style="width: 100px; display: inline-block; font-size: 14px; margin-right: 20px; padding-top: 5px">

								<option value=""></option>
								@foreach($semestres as $semestre)
									<option value="{{$semestre->ID_SEMESTRE}}">{{$semestre->SEMESTRE}}</option>
								@endforeach
							</select>
						</div>
						<div id="rangoSemestres" class="no-padding" style="display: inline-block">
							<label class="semLabel pText" style="padding-top: 5px; margin-right: 10px" >Semestre final:</label>
							<select name="semFin" id="semFin" class="form-control" style="width: 100px; margin-right: 20px; display: inline-block; font-size: 14px; padding-top: 5px">
								<option value=""></option>
								@foreach($semestres as $semestre)
									<option value="{{$semestre->ID_SEMESTRE}}">{{$semestre->SEMESTRE}}</option>
								@endforeach
							</select>
						</div>
						<div id="btnBuscarDocs" style="display: inline-block; cursor:pointer">
							<i class="fa fa-search fa-lg"></i>          
						</div>    

					</div>

				</div>

				<div class="row" style="padding-top: 20px; padding-bottom: 10px">
					<div class="col-sm-9">
						<h1 class="secondaryTitle mainTitle">Seleccione los documentos a descargar o eliminar</h1>
					</div>
					<div class="col-sm-3 text-right">
						<button  id="ModalCargar" class="customButtonReuniones btn btn-success pText" type="button">Nuevo Documento <i class="fa fa-upload" style="padding-left: 5px"></i></button>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-12">
						<div class="table-responsive"  style="height:300px;overflow:auto; position: relative">
							<table class="table table-striped jambo_table bulk_action">
								<thead >
									<tr class="headings" style="background-color: #005b7f; color: white; font-family: Segoe UI">
										<th class="pText column-title" style="border: none; text-align: center">Semestre</th>
										<th class="pText column-title" style="border: none; text-align: center">Tipo</th>
										<th class="pText column-title" style="border: none; text-align: center">Nombre</th>
										<th class="pText column-title" style="border: none; text-align: center">Seleccionar</th>
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
										<td class="pText" style="background-color: white; padding-top: 12px; color: #72777a;text-align: center;vertical-align: center"><a href="{{URL::asset('upload/'.$documento->NOMBRE)}}" download="{{$documento->NOMBRE}}" style="text-decoration: underline;">{{$documento->NOMBRE}}<i class="fa fa-download" style="padding-left: 5px"></i> </a></td>

										<td style="background-color: white; text-align: center;vertical-align: center">
											<label>
												<input type="checkbox" class="form-check-input checkDoc" 
												name="checkDocs[]" value="{{$documento->NOMBRE}}" style="text-align: center;" >
												<span class="pText label-text "></span>
											</label>
										</td>

									</tr>
									@endforeach
								</tbody>
							</table>

						</div>
					</div>

				</div>
				<div class="row text-center" style="padding-top: 10px">
					<button id="btnDescargarDoc" class="customButtonReuniones btn btn-success pText" name="botonSubmit" value="Desc" style="margin-right: 10px">Descargar Documentos</button>
					<button id="btnEliminarDoc" class="customButtonReuniones btn btn-success pText" name="botonSubmit" value="Elim">Eliminar Documentos</button>

				</div>
			</div>
		</form>

	</div>

	<!-- Modal de Cargar Documentos -->

	<div class="modal fade bs-example-modal-lg text-center" role="dialog" tabindex="-1"
	id="modalCargarDocsReuniones" data-keyboard="false" data-backdrop="static"
	aria-labelledby="gdridfrmnuavaUO" data-focus-on="input:first" >
	<div class="customModal modal-dialog modal-lg ">
		<div class="modal-content" style="top: 30%; padding-bottom: 10px">
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
					<label class="pText">Tipo de documento</label>
					<select name="tipoDoc" class="form-control" style="width: 150px; margin-left: 10px; display: inline-block; font-size: 14px">
						<option value="acta">Acta de Reunión</option>
						<option value="plan">Plan de Mejora</option>
					</select>
				</div>
				<div class="row" style="padding: 10px;">
					<label class="pText">Semestre de creación</label>
					<select name="ciclo" class="form-control" style="width: 100px; margin-left: 10px; display: inline-block; font-size: 14px">
						<option value=""></option>
								@foreach($semestres as $semestre)
									<option value="{{$semestre->SEMESTRE}}">{{$semestre->SEMESTRE}}</option>
								@endforeach
					</select>
				</div>
				<div class="row" style="padding-bottom: 30px;">
					<div class="container-fluid text-center">
						<div class="dropzone" style="min-height: 100px; height: 190px; width: 350px; border: 2px dashed #ccc; display: inline-block; background-color: white; margin-top: 10px; margin-bottom: 10px">
							<i class="fa fa-5x fa-cloud-upload" style="color: #ccc; height: 100px; padding: 10px"></i>
							<p class="pText">Arrastra y suelta un archivo <br> o <br> 

								<div class = "form-group">
									<input type="file" name="archivo" id = "file" class="form-control image" style="border-color: white">
								</div>
								<div class="row" style="padding-top: 10px; text-align: center; display: flex;justify-content: center;">
									<div class="col-md-12">
										<input id="btnCargarHorariosModal" class = "btn btn-success pText customButtonReuniones upload-file" type="submit" value = "Cargar Documento" name="submit">
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