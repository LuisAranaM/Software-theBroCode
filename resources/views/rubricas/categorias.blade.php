@extends('Layouts.layout')
@section('pageTitle', 'Categorías')
@section('content')
@section('js-libs')
<script type="text/javascript"  src="{{ URL::asset('js/rubricas/rubricasjs.js') }}"></script>
@stop

<?php 

$modoSoloLectura=in_array(Auth::user()->ID_ROL,App\Entity\Usuario::getModoLectura());
?>
<div class="customBody">

	<div class="row">
		<div class="col-md-8 col-sm-6">
			<h1 class="mainTitle" ><a href="{{route('rubricas.gestion')}}"> Lista de resultados </a> > <a href=""> Categorias del Resultado {{$resultado}}</a></h1>
		</div>
		<div id="Resultado" value="{{$idRes}}"></div>
		<div id="ResultadoNombre" value="{{$resultado}}"></div>
		<div id= "numDescripciones" value="0"> </div>
		<div id= "uDescripcion" value=""> </div>
		<div id="uNombre" value=""> </div>
		<div id="uValorizacion" value=""> </div>
	</div>
	@include('flash::message')
	<div class="row" >
		@foreach ($categorias as $categoria) 
		<div class="col-md-4 col-xs-6">
			<div class="x_panel tile coursesBox" style="background-color: #dfe3e6; border-radius: 6px; padding: 18px; padding-top: 0px; padding-bottom: 0px" >
				<!-- INDICADORES CARGADOS DE LA BD -->
				<div id="{{$categoria->ID_CATEGORIA}}Ord" cat="{{$categoria->ID_CATEGORIA}}" class="row rowFinal" style="padding-bottom: 0px">
					<div class="row" style="padding-bottom: 10px">
						<h1 class="secondaryTitle mainTitle">{{$categoria->NOMBRE}}</h1>
					</div>
					<div id="{{$categoria->ID_CATEGORIA}}rem">				
						@foreach ($indicadoresTodos[$categoria->ID_CATEGORIA] as $indicador) 
						<div class="indicadorBox row" style="background-color: white; padding: 10px; border-radius: 5px; margin-bottom: 10px; box-shadow: 1px 2px #a9aaaa">
							<div class="col-sm-9 col-xs-8">
								<p class="pText" value="{{$indicador->VALORIZACION}}" style="font-weight: bold; color: #72777a">{{$resultado}}.{{$indicador->VALORIZACION}}</p>
							</div>
							  @if(!$modoSoloLectura)
							<div class="col-sm-3 col-xs-4" style="text-align: right">
								<i id="{{$indicador->ID_INDICADOR}}" class="indicadorEdit fas fa-pen fa-md" style="color: #72777a; cursor: pointer; opacity: 0.7; display: none" id ="EditarIndicador"></i>
								<i id="{{$indicador->ID_INDICADOR}}" class="indicadorTrash fas fa-trash fa-md" style="color: #72777a; padding-left: 6px; cursor: pointer; opacity: 0.7; display: none"></i>
							</div>
							@endif
							<div class="col-xs-12">
								<p class="pText">{{$indicador->NOMBRE}}</p>
							</div>
						</div>
						@endforeach
						
						<div class="row text-left" style="padding-top: 5px">
							@if(!$modoSoloLectura)
							<p id="{{$categoria->ID_CATEGORIA}}" class="pText agregarIndicador" style="color: #72777a; opacity: 0.8; cursor: pointer; font-size: 16px"><i class="fas fa-plus"></i> Agregar nuevo indicador</p>
							@endif
						</div>
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
aria-labelledby="gdridfrmnuavaUO" data-focus-on="input:first" idInd="">
<div class="modalCategorias modal-dialog modal-lg" >
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
			<div class="tile coursesModalBox" style="">

				<div id="filasDesc" class="row rowFinal2">

					<div class="col-xs-6" style="padding-bottom: 6px; padding-right: 5px">
						<p style="font-size: 16px; font-family: segoe UI semibold; text-align: left; color: black">Código</p>
						<input type="text" id="txtOrdenInd" class="ordenIndicador form-control pText customInput" name="codigoIndicador" placeholder="Código del indicador">     
					</div>
					<div class="col-xs-12" style="padding-bottom: 6px">
						<p style="font-size: 16px; font-family: segoe UI semibold; text-align: left; color: black">Descripción</p>
						<textarea type="text" id="txtIndicador" class="descripcionIndicador form-control pText customInput" name="descripcionIndicador" placeholder="Añadir una descripción de este indicador..." rows="3" cols="30" style="resize: none" ></textarea>       
					</div>

					<div id="filasDescs" class="row rowFinal2" style="height:200px; overflow:auto !important; position: relative !important; display: block !important" >
						
						<div class="col-xs-6" style="padding-bottom: 6px; padding-right: 5px">

							<textarea type="text" id="txt" class="descOrd form-control pText customInput" name="nombre" placeholder="Orden" rows="1" cols="30" style="resize: none" ></textarea>       

						</div>
						<div class="col-xs-6" style="padding-bottom: 6px; padding-left: 5px">

							<textarea type="text" id="txt" class="descNom form-control pText customInput" name="nombre" placeholder="Nombre" rows="1" cols="30" style="resize: none;" ></textarea>       

						</div>

						<div class="col-xs-12">
							<textarea type="text" id="txtDescripcion" class="desc form-control pText customInput" name="nombre" placeholder="Descripción" rows="3" cols="30" style="resize: none;" ></textarea>       
						</div>
					</div>
					
				</div>			
			</div>
		</div>

		<div id="btnsAgregarCurso" class="modal-footer">
			<div class="row" style="padding-top: 5px; text-align: center; display: flex;justify-content: center; padding-bottom: 70px">
				<div class="col-md-4">
					<button id="btnAgregarIndicador" class = "customButton btn btn-success pText upload-file" style="padding-right: 5px; padding-left: 5px; " type="submit" name="submit">Guardar</button>
				</div>
				<div class="col-md-4">
					<button type="reset"  class="btn btn-success pText customButton" data-dismiss="modal"
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