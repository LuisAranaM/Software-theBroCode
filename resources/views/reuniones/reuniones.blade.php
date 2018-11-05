@extends('Layouts.layout')
@section('pageTitle', 'Principal')
@section('content')
@section('js-libs')
<script type="text/javascript"  src="{{ URL::asset('js/avisos/avisos.js') }}"></script>
@stop

<div class="customBody">

	<div class="row">
		<div class="col-md-8 col-sm-6">
			<h1 class="mainTitle"> Gestionar Documentos de Reuniones</h1>
		</div>
	</div>



	<div class="row">
		<div class=" x_panel tile coursesBox">
			
			<div class="row x_panel" >
				<div class="col-md-2">
					<label class="pText">Semestre inicio:</label>
				</div>

				<div class="col-md-2">
					<input type="text" id="txt" class="form-control pText customInput" 
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
					<input type="text" id="txt" class="form-control pText customInput" 
					name="semestreFin" placeholder="" value="">  
				</div>

				<div class="col-md-1">
					<select name="semIni">
						<option value="1">1</option>
						<option value="2">2</option>
					</select>
				</div>

				<div class="col-md-2">
					<button id="btnBuscat" class="btn btn-success pText customButtonThin">Agregar</button>
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
									<th class="pText column-title" style="border: none">Seleccionar</th>
								</tr>
							</thead>
							<!--CargarCurso-->

							<tbody class="text-left" id="listaDocumentos">

								<tr class="even pointer" id="">
									<form>

										<td class="pText" style="background-color: white; padding-top: 12px; color: #72777a;text-align: center;vertical-align: center;">2017-1</td>
										<td class="pText" style="background-color: white; padding-top: 12px; color: #72777a;text-align: center;vertical-align: center;">Plan de Mejora</td>
										<td><input type="checkbox" name="select"></td>
									</form>

								</tr>

							</tbody>
						</table>

					</div>
				</div>

			</div>

			<div class="row">
				<div class="col-sm-3">
					<button id="btnDescargarDoc" class="btn btn-success pText customButtonReuniones">Descargar Documento</button>
				</div>
				<div class="col-sm-3">
					<button id="btnEliminarDoc" class="btn btn-success pText customButtonReuniones">Eliminar Documento</button>
				</div>
			</div>

		</div>
	</div>
	

	


</div>


@stop

@section('js-scripts')


@stop