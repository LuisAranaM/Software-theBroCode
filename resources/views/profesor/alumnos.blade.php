@extends('Layouts.layout')
@section('pageTitle', 'Principal')
@section('content')
@section('js-libs')
<script type="text/javascript"  src="{{ URL::asset('js/alumnos/alumnos.js') }}"></script>
<script type="text/javascript"  src="{{ URL::asset('js/steps/jquery.steps.js') }}"></script>
<script type="text/javascript"  src="{{ URL::asset('js/steps/jquery.steps.min.js') }}"></script>
@stop

@php ($idInd = array())
@php ($i = 0)
@foreach($indicadores as $indicador)
@php ($idInd[$i] = $indicador->ID_INDICADOR)
@php ($i = $i + 1)
@endforeach
<!--La variable $indicadores contiene 'ID_RESULTADO', 'NOMBRE','ID_INDICADOR' -->
<div class="customBody">

	<div class="row">
		<div class="col-md-8 col-sm-6">
			<h1 class="mainTitle">{{$curso[0]->CODIGO_CURSO}} - {{$horario[0]->NOMBRE}}</h1>
		</div>

		<div class="col-md-4 col-sm-6 form-group top_search" >
			<div class="input-group">
				<input id="buscarAlumno" type="text" class="form-control searchText" placeholder="Alumno...">
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
									
                  <th class="pText column-title" style="border: none"> </th>
                  <th class="pText column-title" style="border: none"> </th>
                  <!--para cada resultado-->
                  @foreach($resultados as $resultado)
                  <th class="pText column-title" style="border: none">{{$resultado->NOMBRE}}</th>
                  @endforeach 

								</tr>
							</thead>
							<!--CargarCurso-->
							
							<tbody class="text-left" id="listaAlumnos">
								@foreach($alumnos as $alumno)
								<tr class="even pointer" id="">
									<form action="{{ route('proyecto.store') }}" method="post" enctype="multipart/form-data">
										{{ csrf_field() }}
										<td class="pText" style="background-color: white; padding-top: 12px; color: #72777a;text-align: center;vertical-align: center;">{{$alumno->CODIGO}} </td>
                    {{-- Karla, aca encierra el form en el foreach y en vez del codigo hardcodeado pon la variable que representa al codigo del alumno en la línea de abajo de INPUT, igual con horario--}}
										<td class="pText" style="background-color: white; padding-top: 12px; color: #72777a;text-align: center;vertical-align: center;">{{$alumno->NOMBRES}} {{$alumno->APELLIDO_PATERNO}} {{$alumno->APELLIDO_MATERNO}}</td>
										<input type="text" name="codAlumno" value="{{$alumno->CODIGO}}" hidden>{{-- aca cambias el value="20140445" por la  variable codigo, NO EL NAME POR FAVOR--}}
										<input type="text" name="horario" value="{{$horario[0]->ID_HORARIO}}" hidden>{{-- aca cambias el value="0842" por la  variable horario, NO EL NAME POR FAVOR--}}
										<td class="pText" style="background-color: white; padding-top: 12px; color: #72777a;text-align: center;vertical-align: center;"><input type="file" name="archivo" id = "file"></td>    

                        
                    <td class="pText" style="background-color: white; padding-top: 12px; color: #72777a">
                      <button type = "submit" class = "btn btn-success btn-lg pText customButton">Cargar <i class="fa fa-upload" style="padding-left: 5px"></i> </button>
                    </td>
                        @foreach($projects as $project)                        

                          @if($project->ID_PROYECTO == $alumno->ID_PROYECTO2)
                            
                            <td class="pText" style="background-color: white; padding-top: 12px; color: #72777a;text-align: center;vertical-align: center;"><a href="{{URL::asset('upload/'.$project->NOMBRE)}}" download="{{$project->NOMBRE}}" style="text-decoration: underline;">{{$project->NOMBRE}}<i class="fa fa-download" style="padding-left: 5px"></i> </a></td>
                            @break

                          @endif

                         @endforeach
                  </form>
                  @foreach($resultados as $resultado)
                    <td id="{{$resultado->ID_RESULTADO}}" idCurso="{{$curso[0]->ID_CURSO}}" idResultado="{{$resultado->ID_RESULTADO}}" idAlumno="{{$alumno->ID_ALUMNO}}" codAlumno ="{{$alumno->CODIGO}}" nombreAlumno="{{$alumno->NOMBRES}} {{$alumno->APELLIDO_PATERNO}} {{$alumno->APELLIDO_MATERNO}}" class="pText AbrirCalificacion view" style="background-color: white; padding-top: 12px; color: #72777a;text-align: center;vertical-align: center;">
                      <i class=" fa fa-check-square-o"></i>

                  @endforeach
                </tr>


                @endforeach
              </tbody>
            </table>

          </div>

        </div>
      </div>
    </div>
  </div>
  <div class="row">
   <a href="{{route('profesor.calificar')}}" class="pText"><i class="fa fa-arrow-circle-left" aria-hidden="true"></i> Retornar a la vista de cursos</a>
 </div>


<div id="post_modal" class="modal fade">
 <div class="modal-dialog">
  <div class="modal-content"> 
   <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h4 class="modal-title">Post Details</h4>
   </div>
   <div class="modal-body" id="post_detail">

   </div>
   <div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
   </div>
  </div>
 </div>
</div>






 <!-- Modal Alumno a Evaluar-->

 <div class="modal fade bs-example-modal-lg text-center" role="dialog" tabindex="-1"
 id="modalCalificacion" data-keyboard="false" data-backdrop="static"
 aria-labelledby="gdridfrmnuavaUO" data-focus-on="input:first">
 <div class="customModal modal-dialog modal-lg" style="width: 600px; height: 300px" >
  <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal"
      aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
    <h4 class="reportsTitle mainTitle modal-title" style="padding-top: 10px; text-align: center;" id="gridSystemModalLabel">  Alumno a Evaluar: </h4>
    <h4 id="alumnoACalificar" class="reportsTitle mainTitle modal-title" style="text-align: center;" id="gridSystemModalLabel"></h4>
  </div>
  <hr style="padding: 0px; margin-top: 0px; margin-bottom: 0px; width: 80%">
  
  <div class="row" style="padding-top: 20px;margin: 10px;">

   <div class="col-xs-6 text-left">
    <i class="fa fa-angle-left" style="padding-right: 5px"> <span class="pText">Resultado A</span></i> 
  </div>

  <div class="col-xs-6 text-right">
    <span class="pText">Resultado B</span><i class="fa fa-angle-right" style="padding-left: 5px"></i>
  </div>
</div>

<div class="modal-body">

<div class="row" style="padding-top: 20px;margin: 10px;">

 <div class="col-xs-6 text-left">
  <i class="fa fa-angle-left" style="padding-right: 5px"> <span class="pText">Anterior Alumno</span></i> 
</div>

<div class="col-xs-6 text-right">
  <span class="pText">Siguiente Alumno</span><i class="fa fa-angle-right" style="padding-left: 5px"></i>
</div>
</div>

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