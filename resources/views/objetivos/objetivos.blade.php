@extends('Layouts.layout')
@section('pageTitle', 'Mapeo de Objetivos')
@section('content')
@section('js-libs')
<script type="text/javascript"  src="{{ URL::asset('js/avisos/avisos.js') }}"></script>
@stop
<?php 
$contEos=count($objetivosEducacionales);

$modoSoloLectura=in_array(Auth::user()->ID_ROL,App\Entity\Usuario::getModoLectura());
$numEo=1;

?>
<div class="customBody">

	<div class="row">
		<div class="col-md-8 col-sm-6">
			<h1 class="mainTitle"> Objetivos Educacionales </h1>
		</div>
	</div>
	@include('flash::message')
	@if(count($objetivosEducacionales)>0)

	<div class="row">
		<div class="x_panel" style="padding: 20px">
			<form action="{{ route('objetivos.guardar') }}" method="POST">
				{{ csrf_field() }}
				<div class="table-responsive">
					<table class="table table-striped jambo_table bulk_action">
						<thead >
							<tr class="headings" style="background-color: #005b7f; color: white; font-family: Segoe UI">
								<th class="pText column-title" style="border: none;text-align:center; width: 60%">Resultados del Estudiante</th>
								@foreach($objetivosEducacionales as $eo)
								<th class="pText column-title" style="border: none;text-align:center;width:40/{{$contEos}}% ">OE{{$numEo++}}</th>
								@endforeach


							</tr>
						</thead>
						<!--CargarCurso-->

						<tbody class="text-left" id="listaSOS">
							@foreach($objetivosEstudiante as $so)
							<tr class="even pointer" id="columnaX">
								<td class="pText" style="background-color: white;color: #72777a;vertical-align: center;">{{$so->DESCRIPCION}}</td>
								@foreach($objetivosEducacionales as $eo)								
								<td class="pText" style="background-color: white; color: #72777a;text-align: center;vertical-align: center;">
									<label>
										<input <?php echo($modoSoloLectura? 'disabled' :'');?> type="checkbox" class="form-check-input checkSosHasEos" 
										name="checkSosHasEos[]" value="{{$so->ID_RESULTADO}}-{{$eo->ID_EOS}}" style="text-align: center;" 
										<?php 
										$attr='';
										foreach ($casillasChecks as $casilla) {
											if($casilla->ID_SOS==$so->ID_RESULTADO){
												if($casilla->ID_EOS==$eo->ID_EOS){
													$attr='checked';
												}
											}

										}

										echo($attr);?>
										>
										<span class="pText label-text "></span>
									</label>
								</td>
								@endforeach

							</tr>
							@endforeach
						</tbody>
					</table>

				</div>
				@if(!$modoSoloLectura)
				<div id="btnsGuardar" style="border-color: transparent">
					<div class="row text-center">
						<button id="btnGuardarSosEos" class="btn btn-success pText customButton" >Actualizar <i class="fas fa-sync-alt" style="padding-left: 6px"> </i></button>
					</div>

				</div>
				@endif
			</form>

		</div>
	</div>
	@endif
	
	



</div>


@stop

@section('js-scripts')


@stop