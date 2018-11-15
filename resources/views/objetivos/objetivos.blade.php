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
	@include('flash::message')
	<div class="row">
		<div class="x_panel">
			<form action="{{ route('objetivos.guardar') }}" method="POST">
				{{ csrf_field() }}
				<div class="table-responsive">
					<table class="table table-striped jambo_table bulk_action">
						<thead >
							<tr class="headings" style="background-color: #005b7f; color: white; font-family: Segoe UI">
								<th class="pText column-title" style="border: none;text-align:center; width: 70%">SO</th>
								@foreach($objetivosEducacionales as $eo)
								<th class="pText column-title" style="border: none;text-align:center;width:10% ">EO{{$eo->ID_EOS}}</th>
								@endforeach


							</tr>
						</thead>
						<!--CargarCurso-->

						<tbody class="text-left" id="listaSOS">
							@foreach($objetivosEstudiante as $so)
							<tr class="even pointer" id="columnaX">
								<td class="pText" style="background-color: white;color: #72777a;text-align: left;vertical-align: center;">{{$so->NOMBRE}}</td>
								@foreach($objetivosEducacionales as $eo)								
								<td class="pText" style="background-color: white; color: #72777a;text-align: center;vertical-align: center;">
									<label>
										<input type="checkbox" class="form-check-input checkSosHasEos" 
										name="checkSosHasEos[]" value="{{$so->ID_SOS}}-{{$eo->ID_EOS}}" style="text-align: center;" 
										<?php 
										$attr='';
											foreach ($casillasChecks as $casilla) {
												if($casilla->ID_SOS==$so->ID_SOS){
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
				<div id="btnsGuardar" class="modal-footer" style="border-color: transparent; padding-top: 20px;">
					<div class="row" style="text-align: center; padding-top: 10px">
						<div class="col-md-12">
							<button id="btnGuardarSosEos" class="btn btn-success pText customButtonThin" >Actualizar</button>
						</div>
					</div>

				</div>
			</form>

		</div>
	</div>
	
	



</div>


@stop

@section('js-scripts')


@stop