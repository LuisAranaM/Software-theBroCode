@extends('Layouts.layout')
@section('pageTitle', 'Principal')
@section('content')
@section('js-libs')
<script type="text/javascript"  src="{{ URL::asset('js/rubricas/rubricasjs.js') }}"></script>
@stop

<div class="customBody">

	<div class="row">
		<div class="col-md-8 col-sm-6">
			<h1 class="mainTitle" ><a href="{{route('rubricas.gestion')}}"> Lista de resultados </a> > <a href=""> Categorias del Resultado {{$resultado}}</a></h1>
		</div>
	</div>
	<div class="row">
		@foreach ($categorias as $categoria) 
		<div class="col-md-4 col-xs-6">
			<div class="x_panel tile coursesBox">
				<!-- INDICADORES CARGADOS DE LA BD -->
				<div id="filasInd" class="row rowFinal" style="padding-bottom: 0px">
					<div class="row">

						<h1 class="secondaryTitle mainTitle">{{$categoria->NOMBRE}}</h1>
					</div>					
					<?php $count = 1; ?>
					@foreach ($indicadoresTodos[$categoria->ID_CATEGORIA] as $indicador) 

					

					<div class="row">
						<hr>
						<div class="col-xs-9">
							<p class="pText" style="font-weight: bold; color: black">{{$resultado}}.{{$count}}</p>
						</div>
						<div class="col-xs-3" style="text-align: right">
							<i class="indicadorEdit fa fa-pencil fa-lg" style="color: #005b7f; cursor: pointer " id ="EditarIndicador"></i>
							<i class="indicadorTrash fa fa-trash fa-lg" style="color: #005b7f; padding-left: 2px; cursor: pointer"></i>
						</div>
						<div class="col-xs-12">
							<p class="pText">{{$indicador->NOMBRE}}</p>
						</div>
					</div>
					<?php $count = $count +1; ?>
					@endforeach					
					<hr>
					<div class="row text-center">
						<p id="{{$categoria->ID_CATEGORIA}}" class="pText agregarIndicador" style="color: #005b7f; cursor: pointer">Agregar nuevo indicador</p>
					</div>
				</div>
			</div>
		</div>
		@endforeach
		
	</div>
	<!-- END CURSOS CARGADOS DE LA BD-->     

</div>


<!-- Modal de Nuevo Curso -->

<div class="modal fade bs-example-modal-lg text-center" role="dialog" tabindex="-1"
id="modalIndicador" data-keyboard="false" data-backdrop="static"
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
			<div class="tile coursesModalBox" style="padding-bottom: 20px;">

				<div id="filasDesc" class="row rowFinal2">
					<div class="col-xs-12">
						<p style="font-size: 16px; font-family: segoe UI semibold; text-align: left; color: black">Indicador</p>
					</div>
					<div class="col-xs-6" style="padding-bottom: 6px; padding-right: 5px">
						<input type="text" id="txt" class="form-control pText customInput" name="codigoIndicador" placeholder="Orden" value="">     
					</div>
					<div class="col-xs-6" style="padding-bottom: 6px; padding-left: 5px">
						<input type="text" id="txt" class="nombreIndicador form-control pText customInput" name="codigoIndicador" placeholder="Nombre" value="">     
					</div>
					<div class="col-xs-12" style="padding-bottom: 6px">
						<textarea type="text" id="txtIndicador" class="descripcionIndicador form-control pText customInput" name="descripcionIndicador" placeholder="Descripción" rows="3" cols="30" style="resize: none" ></textarea>       
					</div>

					<div class="col-xs-12" style="padding-top: 20px !important; padding-left: 10px;">
						<p style="font-size: 16px; font-family: segoe UI semibold; text-align: left; color: black">Valorizaciones</p>
					</div>
					<div class="col-xs-6" style="padding-bottom: 6px; padding-right: 5px">

						<textarea type="text" id="txt" class="form-control pText customInput" name="nombre" placeholder="Orden" rows="1" cols="30" style="resize: none" ></textarea>       

					</div>
					<div class="col-xs-6" style="padding-bottom: 6px; padding-left: 5px">

						<textarea type="text" id="txt" class="form-control pText customInput" name="nombre" placeholder="Nombre" rows="1" cols="30" style="resize: none;" ></textarea>       

					</div>

					<div class="col-xs-12">
						<textarea type="text" id="txtDescripcion" class="desc form-control pText customInput" name="nombre" placeholder="Descripción" rows="3" cols="30" style="resize: none;" ></textarea>       
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
						<button id="btnAgregarIndicador" class = "customButton btn btn-success pText upload-file" style="padding-right: 5px; padding-left: 5px;" type="submit" name="submit">Cargar</button>
					</div>
					<div class="col-md-4">
						<button type="reset" class="btn btn-success pText customButton" data-dismiss="modal"
						aria-label="Close">Cancelar</button>
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


@stop

@section('js-scripts')


@stop