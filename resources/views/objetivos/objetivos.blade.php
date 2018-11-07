@extends('Layouts.layout')
@section('pageTitle', 'Principal')
@section('content')
@section('js-libs')
<script type="text/javascript"  src="{{ URL::asset('js/avisos/avisos.js') }}"></script>
@stop

<div class="customBody">

	<div class="row">
		<div class="col-md-8 col-sm-6">
			<h1 class="mainTitle"> Objetivos Educacionales </h1>
		</div>
	</div>

	<div class="row">
				<h2 class="">Documentos</h2>
				<div class="col-md-8">
					<div class="table-responsive">
						<table class="table table-striped jambo_table bulk_action">
							<thead >
								<tr class="headings" style="background-color: #005b7f; color: white; font-family: Segoe UI">
									<th class="pText column-title" style="border: none">Capacidades-EOS</th>
									<th class="pText column-title" style="border: none">EOS1</th>
									<th class="pText column-title" style="border: none">EOS2</th>
									<th class="pText column-title" style="border: none">EOS3</th>
								</tr>
							</thead>
							<!--CargarCurso-->

							<tbody class="text-left" id="listaDocumentos">
								@foreach($documentos as $documento)
									<tr class="even pointer" id="">
										<form>

											<td class="pText" style="background-color: white; padding-top: 12px; color: #72777a;text-align: center;vertical-align: center;">{{$documento->DOCUMENTO_ANHO}}-{{$documento->DOCUMENTO_SEMESTRE}}</td>
											@if($documento->TIPO_DOCUMENTO == "acta")
												<td class="pText" style="background-color: white; padding-top: 12px; color: #72777a;text-align: center;vertical-align: center;">Acta de Reunión</td>
											@else
												<td class="pText" style="background-color: white; padding-top: 12px; color: #72777a;text-align: center;vertical-align: center;">Plan de Mejora</td>
											@endif
											<td class="pText" style="background-color: white; padding-top: 12px; color: #72777a;text-align: center;vertical-align: center;"><a href="{{URL::asset('upload/'.$documento->NOMBRE)}}" download="{{$documento->NOMBRE}}" style="text-decoration: underline;">{{$documento->NOMBRE}}<i class="fa fa-download" style="padding-left: 5px"></i> </a></td>
											
											<td><input type="checkbox" name="select"></td>
										</form>
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



</div>


@stop

@section('js-scripts')


@stop