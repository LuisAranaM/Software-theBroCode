@extends('Layouts.layout')
@section('pageTitle', 'Principal')
@section('content')
@section('js-libs')
<script type="text/javascript"  src="{{ URL::asset('js/cursos/cursosjs.js') }}"></script>
@stop

<div class="customBody">

	<div class="row">
		<div class="col-md-8 col-sm-6">
			<h1 class="mainTitle">Ingeniería de Software - H0381</h1>
		</div>

		<div class="col-md-4 col-sm-6 form-group top_search" >
			<div class="input-group">
				<input type="text" class="form-control searchText" placeholder="Curso...">
				<span class="input-group-btn">
					<button class="btn btn-default searchButton" type="button">Buscar</button>
				</span>
			</div>
		</div>
	</div>
	<div class="row">

		<!--BLOQUE IZQUIERDA-->
			<div class="x_panel tile coursesBox ">
				<div class="row rowFinal">
					<div class="row" style="padding-bottom: 10px">
						<div class="col-xs-9" >
							<h1 class="secondaryTitle mainTitle">Seleccione un alumno a calificar</h1>
						</div>
						<div class="col-xs-3 text-right no-padding">
							<button id="btnCargarAlumnos" type="button" class="btn btn-success btn-lg pText customButton">Subir Proyectos</button>
						</div>  
					</div>

					<div class="row">
						<div class="table-responsive">
							<table class="table table-striped jambo_table bulk_action">
								<thead >
									<tr class="headings" style="background-color: #005b7f; color: white; font-family: Segoe UI">
										<th class="pText column-title" style="border: none"> Código</th>
										<th class="pText column-title" style="border: none">Nombre</th>
										<th class="pText column-title" style="border: none">Proyecto</th>
										<th class="pText column-title" style="border: none">A</th>
										<th class="pText column-title" style="border: none">B</th>
										<th class="pText column-title" style="border: none">C</th>
									</tr>
								</thead>

								<tbody class="text-left">
									<tr class="even pointer">
										<td class="pText" style="background-color: white; padding-top: 12px; color: #72777a;">20140445</td>
										<td class="pText" style="background-color: white; padding-top: 12px; color: #72777a">Daniela Argumanis</td>           
										<td class="pText" style="background-color: white; padding-top: 12px; color: #72777a; text-decoration: underline"><a>InformeDani.pdf</a></td>  
										<td class="pText" style="background-color: white; padding-top: 12px; color: #72777a">4</td>  
										<td class="pText" style="background-color: white; padding-top: 12px; color: #72777a">4</td>   
										<td class="pText" style="background-color: white; padding-top: 12px; color: #72777a">4</td> 
									</tr>
									<tr class="even pointer">
										<td class="pText" style="background-color: white; padding-top: 12px; color: #72777a;">20140000</td>
										<td class="pText" style="background-color: white; padding-top: 12px; color: #72777a">Daniel Chapi</td>           
										<td class="pText" style="background-color: white; padding-top: 12px; color: #72777a; text-decoration: underline"><a>InformeChapo.pdf</a></td>  
										<td class="pText" style="background-color: white; padding-top: 12px; color: #72777a">1</td>  
										<td class="pText" style="background-color: white; padding-top: 12px; color: #72777a">1</td>   
										<td class="pText" style="background-color: white; padding-top: 12px; color: #72777a">1</td> 
									</tr>
									<tr class="even pointer">
										<td class="pText" style="background-color: white; padding-top: 12px; color: #72777a;">20141342</td>
										<td class="pText" style="background-color: white; padding-top: 12px; color: #72777a">Karla Pedraza</td>           
										<td class="pText" style="background-color: white; padding-top: 12px; color: #72777a; text-decoration: underline"><a>InformeKP.pdf</a></td>  
										<td class="pText" style="background-color: white; padding-top: 12px; color: #72777a">4</td>  
										<td class="pText" style="background-color: white; padding-top: 12px; color: #72777a">4</td>   
										<td class="pText" style="background-color: white; padding-top: 12px; color: #72777a">4</td> 
									</tr>
									<tr class="even pointer">
										<td class="pText" style="background-color: white; padding-top: 12px; color: #72777a;">20140445</td>
										<td class="pText" style="background-color: white; padding-top: 12px; color: #72777a">Daniela Argumanis</td>           
										<td class="pText" style="background-color: white; padding-top: 12px; color: #72777a; text-decoration: underline"><a>InformeDani.pdf</a></td>  
										<td class="pText" style="background-color: white; padding-top: 12px; color: #72777a">4</td>  
										<td class="pText" style="background-color: white; padding-top: 12px; color: #72777a">4</td>   
										<td class="pText" style="background-color: white; padding-top: 12px; color: #72777a">4</td> 
									</tr>
									<tr class="even pointer">
										<td class="pText" style="background-color: white; padding-top: 12px; color: #72777a;">20140000</td>
										<td class="pText" style="background-color: white; padding-top: 12px; color: #72777a">Daniel Chapi</td>           
										<td class="pText" style="background-color: white; padding-top: 12px; color: #72777a; text-decoration: underline"><a>InformeChapo.pdf</a></td>  
										<td class="pText" style="background-color: white; padding-top: 12px; color: #72777a">1</td>  
										<td class="pText" style="background-color: white; padding-top: 12px; color: #72777a">1</td>   
										<td class="pText" style="background-color: white; padding-top: 12px; color: #72777a">1</td> 
									</tr>
									<tr class="even pointer">
										<td class="pText" style="background-color: white; padding-top: 12px; color: #72777a;">20141342</td>
										<td class="pText" style="background-color: white; padding-top: 12px; color: #72777a">Karla Pedraza</td>           
										<td class="pText" style="background-color: white; padding-top: 12px; color: #72777a; text-decoration: underline"><a>InformeKP.pdf</a></td>  
										<td class="pText" style="background-color: white; padding-top: 12px; color: #72777a">4</td>  
										<td class="pText" style="background-color: white; padding-top: 12px; color: #72777a">4</td>   
										<td class="pText" style="background-color: white; padding-top: 12px; color: #72777a">4</td> 
									</tr>
									<tr class="even pointer">
										<td class="pText" style="background-color: white; padding-top: 12px; color: #72777a;">20140445</td>
										<td class="pText" style="background-color: white; padding-top: 12px; color: #72777a">Daniela Argumanis</td>           
										<td class="pText" style="background-color: white; padding-top: 12px; color: #72777a; text-decoration: underline"><a>InformeDani.pdf</a></td>  
										<td class="pText" style="background-color: white; padding-top: 12px; color: #72777a">4</td>  
										<td class="pText" style="background-color: white; padding-top: 12px; color: #72777a">4</td>   
										<td class="pText" style="background-color: white; padding-top: 12px; color: #72777a">4</td> 
									</tr>
									<tr class="even pointer">
										<td class="pText" style="background-color: white; padding-top: 12px; color: #72777a;">20140000</td>
										<td class="pText" style="background-color: white; padding-top: 12px; color: #72777a">Daniel Chapi</td>           
										<td class="pText" style="background-color: white; padding-top: 12px; color: #72777a; text-decoration: underline"><a>InformeChapo.pdf</a></td>  
										<td class="pText" style="background-color: white; padding-top: 12px; color: #72777a">1</td>  
										<td class="pText" style="background-color: white; padding-top: 12px; color: #72777a">1</td>   
										<td class="pText" style="background-color: white; padding-top: 12px; color: #72777a">1</td> 
									</tr>
									<tr class="even pointer">
										<td class="pText" style="background-color: white; padding-top: 12px; color: #72777a;">20141342</td>
										<td class="pText" style="background-color: white; padding-top: 12px; color: #72777a">Karla Pedraza</td>           
										<td class="pText" style="background-color: white; padding-top: 12px; color: #72777a; text-decoration: underline"><a>InformeKP.pdf</a></td>  
										<td class="pText" style="background-color: white; padding-top: 12px; color: #72777a">4</td>  
										<td class="pText" style="background-color: white; padding-top: 12px; color: #72777a">4</td>   
										<td class="pText" style="background-color: white; padding-top: 12px; color: #72777a">4</td> 
									</tr>
									<tr class="even pointer">
										<td class="pText" style="background-color: white; padding-top: 12px; color: #72777a;">20140445</td>
										<td class="pText" style="background-color: white; padding-top: 12px; color: #72777a">Daniela Argumanis</td>           
										<td class="pText" style="background-color: white; padding-top: 12px; color: #72777a; text-decoration: underline"><a>InformeDani.pdf</a></td>  
										<td class="pText" style="background-color: white; padding-top: 12px; color: #72777a">4</td>  
										<td class="pText" style="background-color: white; padding-top: 12px; color: #72777a">4</td>   
										<td class="pText" style="background-color: white; padding-top: 12px; color: #72777a">4</td> 
									</tr>
									<tr class="even pointer">
										<td class="pText" style="background-color: white; padding-top: 12px; color: #72777a;">20140000</td>
										<td class="pText" style="background-color: white; padding-top: 12px; color: #72777a">Daniel Chapi</td>           
										<td class="pText" style="background-color: white; padding-top: 12px; color: #72777a; text-decoration: underline"><a>InformeChapo.pdf</a></td>  
										<td class="pText" style="background-color: white; padding-top: 12px; color: #72777a">1</td>  
										<td class="pText" style="background-color: white; padding-top: 12px; color: #72777a">1</td>   
										<td class="pText" style="background-color: white; padding-top: 12px; color: #72777a">1</td> 
									</tr>
									<tr class="even pointer">
										<td class="pText" style="background-color: white; padding-top: 12px; color: #72777a;">20141342</td>
										<td class="pText" style="background-color: white; padding-top: 12px; color: #72777a">Karla Pedraza</td>           
										<td class="pText" style="background-color: white; padding-top: 12px; color: #72777a; text-decoration: underline"><a>InformeKP.pdf</a></td>  
										<td class="pText" style="background-color: white; padding-top: 12px; color: #72777a">4</td>  
										<td class="pText" style="background-color: white; padding-top: 12px; color: #72777a">4</td>   
										<td class="pText" style="background-color: white; padding-top: 12px; color: #72777a">4</td> 
									</tr>
								</tbody>
							</table>
						</div>

				</div>
			</div>
		</div>

		<!--BLOQUE DERECHA-->
			<div class="no-padding x_panel tile coursesBox" >
				<div class="row rowFinal" style="padding-bottom: 0px">
					<div class="row" style="padding-bottom: 0px">
						<h1 class="reportsTitle mainTitle">Alumno a Calificar: Daniela Argumanis</h1>
						<p class="pText" style="text-align: center; font-style: italic"> Criterio A: Matemáticas </p>
						<div class="btn-group btn-group-justified" data-toggle="buttons">
							<label class="btn btn-primary active">
								<input type="radio" class="sr-only" id="viewMode0" name="viewMode" value="0" checked>
								<span class="docs-tooltip" data-toggle="tooltip" title="View Mode 0">
									A1
								</span>
							</label>
							<label class="btn btn-primary">
								<input type="radio" class="sr-only" id="viewMode1" name="viewMode" value="1">
								<span class="docs-tooltip" data-toggle="tooltip" title="View Mode 1">
									1
								</span>
							</label>
							<label class="btn btn-primary">
								<input type="radio" class="sr-only" id="viewMode2" name="viewMode" value="2">
								<span class="docs-tooltip" data-toggle="tooltip" title="View Mode 2">
									2
								</span>
							</label>
							<label class="btn btn-primary">
								<input type="radio" class="sr-only" id="viewMode3" name="viewMode" value="3">
								<span class="docs-tooltip" data-toggle="tooltip" title="View Mode 3">
									3
								</span>
							</label>
							<label class="btn btn-primary">
								<input type="radio" class="sr-only" id="viewMode3" name="viewMode" value="3">
								<span class="docs-tooltip" data-toggle="tooltip" title="View Mode 3">
									4
								</span>
							</label>
							<label class="btn btn-primary">
								<input type="radio" class="sr-only" id="viewMode3" name="viewMode" value="3">
								<span class="docs-tooltip" data-toggle="tooltip" title="View Mode 3">
									<i class="fa fa-caret-up"></i>
								</span>
							</label>
						</div>
						<div >
							<p class="smallText" style="padding:15px; padding-top: 8px">Diseña algoritmos para la resolución de un problema identificado. <br>

								1: Ser capaz de leer código fuente en lenguaje de alto nivel y entender parcialmente el algoritmo <br>
								2: Ser capaz de leer código fuente en lenguaje de alto nivel y entender el algoritmo <br>
								3: Tener la capacidad de modificar un algoritmo <br>
							4: Desarrollar el algoritmo nuevo a partir de una especificación</p>
						</div>
						<div class="btn-group btn-group-justified" data-toggle="buttons">
							<label class="btn btn-primary active">
								<input type="radio" class="sr-only" id="viewMode0" name="viewMode" value="0" checked>
								<span class="docs-tooltip" data-toggle="tooltip" title="View Mode 0">
									A2
								</span>
							</label>
							<label class="btn btn-primary">
								<input type="radio" class="sr-only" id="viewMode1" name="viewMode" value="1">
								<span class="docs-tooltip" data-toggle="tooltip" title="View Mode 1">
									1
								</span>
							</label>
							<label class="btn btn-primary">
								<input type="radio" class="sr-only" id="viewMode2" name="viewMode" value="2">
								<span class="docs-tooltip" data-toggle="tooltip" title="View Mode 2">
									2
								</span>
							</label>
							<label class="btn btn-primary">
								<input type="radio" class="sr-only" id="viewMode3" name="viewMode" value="3">
								<span class="docs-tooltip" data-toggle="tooltip" title="View Mode 3">
									3
								</span>
							</label>
							<label class="btn btn-primary">
								<input type="radio" class="sr-only" id="viewMode3" name="viewMode" value="3">
								<span class="docs-tooltip" data-toggle="tooltip" title="View Mode 3">
									4
								</span>
							</label>
							<label class="btn btn-primary">
								<input type="radio" class="sr-only" id="viewMode3" name="viewMode" value="3">
								<span class="docs-tooltip" data-toggle="tooltip" title="View Mode 3">
									<i class="fa fa-caret-down"></i>
								</span>
							</label>
						</div>
						<div class="btn-group btn-group-justified" data-toggle="buttons">
							<label class="btn btn-primary active">
								<input type="radio" class="sr-only" id="viewMode0" name="viewMode" value="0" checked>
								<span class="docs-tooltip" data-toggle="tooltip" title="View Mode 0">
									A3
								</span>
							</label>
							<label class="btn btn-primary">
								<input type="radio" class="sr-only" id="viewMode1" name="viewMode" value="1">
								<span class="docs-tooltip" data-toggle="tooltip" title="View Mode 1">
									1
								</span>
							</label>
							<label class="btn btn-primary">
								<input type="radio" class="sr-only" id="viewMode2" name="viewMode" value="2">
								<span class="docs-tooltip" data-toggle="tooltip" title="View Mode 2">
									2
								</span>
							</label>
							<label class="btn btn-primary">
								<input type="radio" class="sr-only" id="viewMode3" name="viewMode" value="3">
								<span class="docs-tooltip" data-toggle="tooltip" title="View Mode 3">
									3
								</span>
							</label>
							<label class="btn btn-primary">
								<input type="radio" class="sr-only" id="viewMode3" name="viewMode" value="3">
								<span class="docs-tooltip" data-toggle="tooltip" title="View Mode 3">
									4
								</span>
							</label>
							<label class="btn btn-primary">
								<input type="radio" class="sr-only" id="viewMode3" name="viewMode" value="3">
								<span class="docs-tooltip" data-toggle="tooltip" title="View Mode 3">
									<i class="fa fa-caret-down"></i>
								</span>
							</label>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<a href="{{route('profesor.calificar')}}" class="pText"><i class="fa fa-arrow-circle-left" aria-hidden="true"></i> Retornar a la vista de cursos</a>
	</div>


</div>

</div>






</div>


@stop

@section('js-scripts')


@stop