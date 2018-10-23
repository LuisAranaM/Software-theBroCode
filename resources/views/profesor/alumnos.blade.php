@extends('Layouts.layout')
@section('pageTitle', 'Principal')
@section('content')
@section('js-libs')
<script type="text/javascript"  src="{{ URL::asset('js/alumnos/alumnos.js') }}"></script>
@stop

<div class="customBody">

	<div class="row">
		<div class="col-md-8 col-sm-6">
			<h1 class="mainTitle">{{$curso[0]->CODIGO_CURSO}} - {{$horario[0]->NOMBRE}}</h1>
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
									
									<th class="pText column-title" style="border: none"> </th>
									<th class="pText column-title" style="border: none">A</th>
									<th class="pText column-title" style="border: none">B</th>
									<th class="pText column-title" style="border: none">C</th>
								</tr>
							</thead>
							<!--CargarCurso-->
							
							<tbody class="text-left">
								@foreach($alumnos as $alumno)
								<tr class="even pointer" id="">
									<form action="{{ route('proyecto.store') }}" method="post" enctype="multipart/form-data">
										{{ csrf_field() }}
										<td class="pText" style="background-color: white; padding-top: 12px; color: #72777a;">{{$alumno->CODIGO}} </td>{{-- Karla, aca encierra el form en el foreach y en vez del codigo hardcodeado pon la variable que representa al codigo del alumno en la línea de abajo de INPUT, igual con horario--}}
										<td class="pText" style="background-color: white; padding-top: 12px; color: #72777a">{{$alumno->NOMBRES}} {{$alumno->APELLIDO_PATERNO}} {{$alumno->APELLIDO_MATERNO}}</td>
										<input type="text" name="codAlumno" value="{{$alumno->CODIGO}}" hidden>{{-- aca cambias el value="20140445" por la  variable codigo, NO EL NAME POR FAVOR--}}
										<input type="text" name="horario" value="{{$horario[0]->NOMBRE}}" hidden>{{-- aca cambias el value="0842" por la  variable horario, NO EL NAME POR FAVOR--}}
										<td class="pText" style="background-color: white; padding-top: 12px; color: #72777a"><input type="file" name="archivo" id = "file"></td>  
										<td class="pText" style="background-color: white; padding-top: 12px; color: #72777a"><button type = "submit" class = "btn btn-success btn-lg pText customButton">Cargar <i class="fa fa-upload" style="padding-left: 5px"></i> </button></td>
                  </form>
                  <td id="AbrirCalificacion" class="pText" style="background-color: white; padding-top: 12px; color: #72777a">4</td>  
                  <td class="pText" style="background-color: white; padding-top: 12px; color: #72777a">4</td>   
                  <td class="pText" style="background-color: white; padding-top: 12px; color: #72777a">4</td> 
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


 <!-- Modal de Nuevo Curso -->

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
    <h4 id="gridSystemModalLabel" class="reportsTitle mainTitle modal-title" style="padding-top: 10px; text-align: center;" id="gridSystemModalLabel">Alumno a evaluar: <br>Daniela argumanis Escalante</h4>
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
  <div class="accordion" id="accordion" role="tablist" aria-multiselectable="true">
    <div class="panel">
      <a class="panel-heading collapsed" role="tab" id="headingOne" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
        <div class="row">
          <div class="col-xs-3">
            <div class="text-left">
              <p class="smallText" style="padding-left:15px; padding-right: 15px; padding-top: 8px">A2. <br>

              </div>
            </div>
            <div class="col-xs-9">
              <div class="text-left" >
                <p class="smallText" style="padding-left:15px; padding-right: 15px; padding-top: 8px">Diseña algoritmos para la resolución de un problema identificado. <br>

                </div>
              </div>
            </div>
          </a>
          <div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne" aria-expanded="false" style="height: 0px;">
            <div class="panel-body">
              <div class="row" style="padding-top: 10px; padding-bottom: 10px;">
                <div class="btn-group btn-group-justified" data-toggle="buttons">

                  <label class="btnCriteria btn btn-primary active" onclick="new PNotify({
                    title: 'New Thing',
                    text: 'Just to let you know, something happened.',
                    type: 'info',
                    styling: 'bootstrap3'
                  });">
                  <input type="radio" class="sr-only" id="viewMode1" name="viewMode" value="1">
                  <span class="docs-tooltip" data-toggle="tooltip" title="View Mode 1">
                    1
                  </span>
                </label>
                <label class="btnCriteria btn btn-primary" onclick="new PNotify({
                  title: 'New Thing',
                  text: 'Just to let you know, something happened.',
                  type: 'info',
                  styling: 'bootstrap3'
                });">
                <input type="radio" class="sr-only" id="viewMode2" name="viewMode" value="2">
                <span class="docs-tooltip" data-toggle="tooltip" title="View Mode 2">
                  2
                </span>
              </label>
              <label class="btnCriteria btn btn-primary" onclick="new PNotify({
                title: 'New Thing',
                text: 'Just to let you know, something happened.',
                type: 'info',
                styling: 'bootstrap3'
              });">
              <input type="radio" class="sr-only" id="viewMode3" name="viewMode" value="3">
              <span class="docs-tooltip" data-toggle="tooltip" title="View Mode 3">
                3
              </span>
            </label>
            <label class="btnCriteria btn btn-primary" onclick="new PNotify({
              title: 'New Thing',
              text: 'Just to let you know, something happened.',
              type: 'info',
              styling: 'bootstrap3'
            });">
            <input type="radio" class="sr-only" id="viewMode3" name="viewMode" value="3">
            <span class="docs-tooltip" data-toggle="tooltip" title="View Mode 3">
              4
            </span>
          </label>
        </div>
      </div>   

    </div>
  </div>
</div>
<div class="panel">
  <a class="panel-heading collapsed" role="tab" id="headingTwo" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
    <div class="row">
      <div class="col-xs-3">
        <div class="text-left" >
          <p class="smallText" style="padding-left:15px; padding-right: 15px; padding-top: 8px">A2. <br>

          </div>
        </div>
        <div class="col-xs-9">
          <div class="text-left" >
            <p class="smallText" style="padding-left:15px; padding-right: 15px; padding-top: 8px">Diseña algoritmos para la resolución de un problema identificado. <br>

            </div>
          </div>
        </div>
      </a>
      <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo" aria-expanded="false" style="height: 0px;">
        <div class="panel-body">

          <div class="row" style="padding-top: 10px; padding-bottom: 10px;">
            <div class="btn-group btn-group-justified" data-toggle="buttons">

              <label class="btnCriteria btn btn-primary active" onclick="new PNotify({
                title: 'New Thing',
                text: 'Just to let you know, something happened.',
                type: 'info',
                styling: 'bootstrap3'
              });">
              <input type="radio" class="sr-only" id="viewMode1" name="viewMode" value="1">
              <span class="docs-tooltip" data-toggle="tooltip" title="View Mode 1">
                1
              </span>
            </label>
            <label class="btnCriteria btn btn-primary" onclick="new PNotify({
              title: 'New Thing',
              text: 'Just to let you know, something happened.',
              type: 'info',
              styling: 'bootstrap3'
            });">
            <input type="radio" class="sr-only" id="viewMode2" name="viewMode" value="2">
            <span class="docs-tooltip" data-toggle="tooltip" title="View Mode 2">
              2
            </span>
          </label>
          <label class="btnCriteria btn btn-primary" onclick="new PNotify({
            title: 'New Thing',
            text: 'Just to let you know, something happened.',
            type: 'info',
            styling: 'bootstrap3'
          });">
          <input type="radio" class="sr-only" id="viewMode3" name="viewMode" value="3">
          <span class="docs-tooltip" data-toggle="tooltip" title="View Mode 3">
            3
          </span>
        </label>
        <label class="btnCriteria btn btn-primary" onclick="new PNotify({
          title: 'New Thing',
          text: 'Just to let you know, something happened.',
          type: 'info',
          styling: 'bootstrap3'
        });">
        <input type="radio" class="sr-only" id="viewMode3" name="viewMode" value="3">
        <span class="docs-tooltip" data-toggle="tooltip" title="View Mode 3">
          4
        </span>
      </label>
    </div>
  </div>  

</div>
</div>
</div>
<div class="panel">
  <a class="panel-heading collapsed" role="tab" id="headingThree" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
    <div class="row">
      <div class="col-xs-3">
        <div class="text-left" >
          <p class="smallText" style="padding-left:15px; padding-right: 15px; padding-top: 8px">A3. <br>

          </div>
        </div>
        <div class="col-xs-9">
          <div class="text-left" >
            <p class="smallText" style="padding-left:15px; padding-right: 15px; padding-top: 8px">Diseña algoritmos para la resolución de un problema identificado. <br>

            </div>
          </div>
        </div>
      </a>
      <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree" aria-expanded="false" style="height: 0px;">
        <div class="panel-body">
         <div class="row" style="padding-top: 10px; padding-bottom: 0px;">
          <div class="btn-group btn-group-justified" data-toggle="buttons">

            <label class="btnCriteria btn btn-primary active" onclick="new PNotify({
              title: 'New Thing',
              text: 'Just to let you know, something happened.',
              type: 'info',
              styling: 'bootstrap3'
            });">
            <input type="radio" class="sr-only" id="viewMode1" name="viewMode" value="1">
            <span class="docs-tooltip" data-toggle="tooltip" title="View Mode 1">
              1
            </span>
          </label>
          <label class="btnCriteria btn btn-primary" onclick="new PNotify({
            title: 'New Thing',
            text: 'Just to let you know, something happened.',
            type: 'info',
            styling: 'bootstrap3'
          });">
          <input type="radio" class="sr-only" id="viewMode2" name="viewMode" value="2">
          <span class="docs-tooltip" data-toggle="tooltip" title="View Mode 2">
            2
          </span>
        </label>
        <label class="btnCriteria btn btn-primary" onclick="new PNotify({
          title: 'New Thing',
          text: 'Just to let you know, something happened.',
          type: 'info',
          styling: 'bootstrap3'
        });">
        <input type="radio" class="sr-only" id="viewMode3" name="viewMode" value="3">
        <span class="docs-tooltip" data-toggle="tooltip" title="View Mode 3">
          3
        </span>
      </label>
      <label class="btnCriteria btn btn-primary" onclick="new PNotify({
        title: 'New Thing',
        text: 'Just to let you know, something happened.',
        type: 'info',
        styling: 'bootstrap3'
      });">
      <input type="radio" class="sr-only" id="viewMode3" name="viewMode" value="3">
      <span class="docs-tooltip" data-toggle="tooltip" title="View Mode 3">
        4
      </span>
    </label>
  </div>
</div>

</div>
</div>
</div>
</div>

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

</div>


<!--

onclick="new PNotify({
                                  title: 'Sticky Info',
                                  text: 'Sticky Info... I\'m not even gonna make a joke.',
                                  type: 'info',
                                  hide: false,
                                  styling: 'bootstrap3'
                              });"
                            -->



                          </div>


                          @stop

                          @section('js-scripts')


                          @stop