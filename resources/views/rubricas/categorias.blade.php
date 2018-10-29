@extends('Layouts.layout')
@section('pageTitle', 'Principal')
@section('content')
@section('js-libs')
<script type="text/javascript"  src="{{ URL::asset('js/rubricas/rubricasjs.js') }}"></script>
@stop

<div class="customBody">

	<div class="row">
		<div class="col-md-8 col-sm-6">
			<h1 class="mainTitle" ><a href="{{route('rubricas.gestion')}}">Lista de Resultados</a> > <a>Categorías del Resultado A</a></h1>
		</div>

	</div>

	<div class="row">
		<div class="col-md-4 col-xs-6">
			<div class="x_panel tile coursesBox">
				<!-- CURSOS CARGADOS DE LA BD -->
				<div class="row rowFinal" style="padding-bottom: 0px">
					<div class="row">
						<h1 class="secondaryTitle mainTitle">Matemáticas</h1>
					</div>

					
					<div class="row">
						<hr>
						<div class="col-xs-9">
							<p class="pText" style="font-weight: bold; color: black">A.1.</p>
						</div>
						<div class="col-xs-3" style="text-align: right">
							<i id ="EditarIndicador" class="edit fa fa-pencil fa-lg" style="color: #005b7f" ></i>
							<i class="fa fa-trash fa-lg" style="color: #005b7f; padding-left: 2px; cursor: pointer"></i>
						</div>
						<div class="col-xs-12">
							<p class="pText">(*) Aplica conceptos lógicos para la resolucion de problemas</p>
						</div>
					</div>
					
					<div class="row">
						<hr>
						<div class="col-xs-9">
							<p class="pText" style="font-weight: bold; color: black">A.2.</p>

						</div>
						<div class="col-xs-3" style="text-align: right">
							<i class="edit fa fa-pencil fa-lg" style="color: #005b7f" id ="EditarIndicador"></i>
							<i class="fa fa-trash fa-lg" style="color: #005b7f; padding-left: 2px; cursor: pointer"></i>
						</div>
						<div class="col-xs-12">
							<p class="pText">Diseña algoritmos para la resolución de un problema identificado</p>
						</div>
					</div>
					
					<div class="row">
						<hr>
						<div class="col-xs-9">
							<p class="pText" style="font-weight: bold; color: black">A.3.</p>
						</div>
						<div class="col-xs-3" style="text-align: right">
							<i class="edit fa fa-pencil fa-lg" style="color: #005b7f" id ="EditarIndicador"></i>
							<i class="fa fa-trash fa-lg" style="color: #005b7f; padding-left: 2px; cursor: pointer"></i>
						</div>
						<div class="col-xs-12">
							<p class="pText">Utiliza lenguajes de programación para implementar algoritmos sean diseñados por él o por cualquier otra persona</p>
						</div>

					</div>
					<hr>
					<div class="row text-center">
						<p class="pText"  id ="AgregarIndicador" style="color: #005b7f" data-id="Agregar Nuevo Indicador">Agregar nuevo indicador</p>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-4 col-xs-6">
			<div class="x_panel tile coursesBox">
				<!-- CURSOS CARGADOS DE LA BD -->
				<div class="row rowFinal" style="padding-bottom: 0px">
					<div class="row">
						<h1 class="secondaryTitle mainTitle">Ingeniería Informática</h1>
					</div>

					<div class="row">
						<hr>
						<div class="col-xs-9">
							<p class="pText" style="font-weight: bold; color: black">A.1.</p>
						</div>
						<div class="col-xs-3" style="text-align: right">
							<i class="edit fa fa-pencil fa-lg" style="color: #005b7f"></i>
							<i class="fa fa-trash fa-lg" style="color: #005b7f; padding-left: 2px; cursor: pointer"></i>
						</div>
						<div class="col-xs-12">
							<p class="pText">(*) Aplica conceptos lógicos para la resolucion de problemas</p>
						</div>
					</div>
					
					<div class="row">
						<hr>
						<div class="col-xs-9">
							<p class="pText" style="font-weight: bold; color: black">A.2.</p>

						</div>
						<div class="col-xs-3" style="text-align: right">
							<i id ="EditarIndicador" class="edit fa fa-pencil fa-lg" style="color: #005b7f"></i>
							<i class="fa fa-trash fa-lg" style="color: #005b7f; padding-left: 2px; cursor: pointer"></i>
						</div>
						<div class="col-xs-12">
							<p class="pText">Diseña algoritmos para la resolución de un problema identificado</p>
						</div>
					</div>
					<hr>
					<div class="row text-center">
						<p class="pText"  id ="CargarCurso" style="color: #005b7f">Agregar nuevo indicador</p>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- END CURSOS CARGADOS DE LA BD-->     

</div>


<!-- Modal de Nuevo Curso -->

<div class="modal fade bs-example-modal-lg text-center" role="dialog" tabindex="-1"
id="modalCursos" data-keyboard="false" data-backdrop="static"
aria-labelledby="gdridfrmnuavaUO" data-focus-on="input:first">
<div class="customModal modal-dialog modal-lg" style="width: 500px; height: 300px" >
	<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal"
			aria-label="Close">
			<span aria-hidden="true">&times;</span>
		</button>

		<label  class="reportsTitle mainTitle modal-title" style="padding-top: 10px" id="ModalTitle" name="codigoHorario" type="text" value=""></label>
		
	</div>
	<hr style="padding: 0px; margin-top: 0px; margin-bottom: 0px; width: 80%">

	<div class="modal-body"> 
		<div class="container-fluid" style="">
			<form id="frmAgregarCursos" action="{{route('agregar.acreditacion')}}" method="POST">
				{{ csrf_field() }}
				<div class="tile coursesModalBox" style="padding-bottom: 20px;">

					<div class="row rowFinal2">
						<div class="col-xs-12">
							<p style="font-size: 16px; font-family: segoe UI semibold; text-align: left; color: black">Nombre de Indicador</p>
						</div>
						<div class="col-xs-12" style="padding-bottom: 6px">
							<input type="text" id="txtCodigoResultado" class="form-control pText customInput" name="codigo" placeholder="Nombre" >     
						</div>
						<div class="col-xs-12" style="padding-top: 20px !important; padding-left: 10px;">
							<p style="font-size: 16px; font-family: segoe UI semibold; text-align: left; color: black">Valorizaciones</p>
						</div>
						<div class="col-xs-12" style="padding-bottom: 6px">

							<textarea type="text" id="txtCategoria" class="form-control pText customInput" name="nombre" placeholder="Código de valorización" rows="1" cols="30" style="resize: none;" ></textarea>       

						</div>

						<div class="col-xs-12">
							<textarea type="text" id="txtCategoria" class="form-control pText customInput" name="nombre" placeholder="Descripción de la valorización" rows="3" cols="30" style="resize: none;" ></textarea>       
						</div>
							<div class="col-lg-6 col-xs-5 text-left" style="padding-top: 15px">
								<p class="pText">Agregar nueva valorización</p>
							</div>
							<div class="col-md-2 col-sm-2 text-left" style="padding-top: 10px; margin-left: -40px">
								<i class="fa fa-plus-circle fa-2x" style="color: #005b7f; padding-top: 2px"></i>
							</div>				
					</div>
				</div>

				<div id="btnsAgregarCurso" class="modal-footer">
					<div class="row" style="padding-top: 5px; text-align: center; display: flex;justify-content: center;">
						<div class="col-md-4">
							<input id="btnCargarAlumnosModal" class = "btn btn-success pText customButton upload-file" style="padding-right: 5px; padding-left: 5px;" type="submit" value = "Cargar" name="submit">
						</div>
						<div class="col-md-4">
							<button type="reset" id="btnCancelarModalAlumnos" class="btn btn-success pText customButton" style="padding-right: 5px; padding-left: 5px;">Cancelar</button>
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


@stop

@section('js-scripts')


@stop