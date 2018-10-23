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

		<!-- Modal de Calificacion -->

		<div class="modal fade bs-example-modal-lg text-center"  role="dialog" tabindex="-1"
		id="modalCalificacion" data-keyboard="false" data-backdrop="static"
		aria-labelledby="gdridfrmnuavaUO" data-focus-on="input:first">
		<div class="customModal modal-dialog modal-lg" style="width: 400px; height: 300px" >
			<div class="modal-content" style="top: 40%">
				<div class="modal-header" style="padding-left: 0px; padding-right: 0px">
					<button type="button" class="close" data-dismiss="modal"
					aria-label="Close" style="padding-right: 10px">
					<span aria-hidden="true">&times;</span>
				</button>

				<h1 class="reportsTitle mainTitle">Alumno a Calificar: Daniela Argumanis</h1>
				<p class="pText" style="text-align: center">Criterio A: Matemáticas </p>
			</div>
			<div class="modal-body" style="padding-top: 0px; padding-left: 20px; padding-right: 20px; padding-bottom: 20px">
				<div class="row" style="padding-top: 10px;padding-bottom: 20px;">
					<div class="col-xs-6 text-left">
						<i class="fa fa-angle-left" style="padding-right: 5px"> <span class="pText">Criterio A</span></i> 
					</div>
					<div class="col-xs-6 text-right">
						<span class="pText">Criterio B</span><i class="fa fa-angle-right" style="padding-left: 5px"></i>
					</div>
				</div>

<!-- Holi -->
      <div class="row">
        <!-- start accordion -->
        <div class="accordion" id="accordion" role="tablist" aria-multiselectable="true">
          <div class="panel">
            <a class="panel-heading collapsed" role="tab" id="headingOne" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
              <h4 class="panel-title">Calificación seleccionada: 3</h4>
            </a>
            <div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne" aria-expanded="false" style="height: 0px;">
              <div class="panel-body">
                <div class="" role="tabpanel" data-example-id="togglable-tabs">
                  <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                    <li role="presentation" class=""><a href="#tab_content1" id="home-tab" role="tab" data-toggle="tab" aria-expanded="false">1</a>
                    </li>
                    <li role="presentation" class=""><a href="#tab_content2" role="tab" id="profile-tab" data-toggle="tab" aria-expanded="false">2</a>
                    </li>
                    <li role="presentation" class=""><a href="#tab_content3" role="tab" id="profile-tab2" data-toggle="tab" aria-expanded="true">3</a>
                    </li>
                    <li role="presentation" class=""><a href="#tab_content4" role="tab" id="profile-tab3" data-toggle="tab" aria-expanded="true">4</a>
                    </li>
                  </ul>
                  <div id="myTabContent" class="tab-content">
                    <div role="tabpanel" class="tab-pane fade" id="tab_content1" aria-labelledby="home-tab">
                      <p>Raw denim you probably haven't heard of them jean shorts Austin. Nesciunt tofu stumptown aliqua, retro synth master cleanse. Mustache cliche tempor, williamsburg carles vegan helvetica. Reprehenderit butcher retro keffiyeh dreamcatcher
                      synth. Cosby sweater eu banh mi, qui irure terr.</p>
                    </div>
                    <div role="tabpanel" class="tab-pane fade" id="tab_content2" aria-labelledby="profile-tab">
                      <p>Food truck fixie locavore, accusamus mcsweeney's marfa nulla single-origin coffee squid. Exercitation +1 labore velit, blog sartorial PBR leggings next level wes anderson artisan four loko farm-to-table craft beer twee. Qui photo
                      booth letterpress, commodo enim craft beer mlkshk aliquip</p>
                    </div>
                    <div role="tabpanel" class="tab-pane fade " id="tab_content3" aria-labelledby="profile-tab">
                      <p>xxFood truck fixie locavore, accusamus mcsweeney's marfa nulla single-origin coffee squid. Exercitation +1 labore velit, blog sartorial PBR leggings next level wes anderson artisan four loko farm-to-table craft beer twee. Qui photo
                      booth letterpress, commodo enim craft beer mlkshk </p>
                    </div>
                    <div role="tabpanel" class="tab-pane fade " id="tab_content4" aria-labelledby="profile-tab">
                      <p>xxxFood truck fixie locavore, accusamus mcsweeney's marfa nulla single-origin coffee squid. Exercitation +1 labore velit, blog sartorial PBR leggings next level wes anderson artisan four loko farm-to-table craft beer twee. Qui photo
                      booth letterpress, commodo enim craft beer mlkshk </p>
                    </div>
                  </div>
                </div>

              </div>
            </div>
          </div>
          <div class="panel">
            <a class="panel-heading collapsed" role="tab" id="headingTwo" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
              <h4 class="panel-title">Calificación seleccionada: 1</h4>
            </a>
            <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo" aria-expanded="false" style="height: 0px;">
              <div class="panel-body">
                <div class="" role="tabpanel" data-example-id="togglable-tabs">
                  <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                    <li role="presentation" class=""><a href="#tab_content11" id="home-tab" role="tab" data-toggle="tab" aria-expanded="false">1</a>
                    </li>
                    <li role="presentation" class=""><a href="#tab_content22" role="tab" id="profile-tab" data-toggle="tab" aria-expanded="false">2</a>
                    </li>
                    <li role="presentation" class=""><a href="#tab_content33" role="tab" id="profile-tab2" data-toggle="tab" aria-expanded="true">3</a>
                    </li>
                     <li role="presentation" class=""><a href="#tab_content44" role="tab" id="profile-tab3" data-toggle="tab" aria-expanded="true">4</a>
                    </li>
                  </ul>
                  <div id="myTabContent" class="tab-content">
                    <div role="tabpanel" class="tab-pane fade" id="tab_content11" aria-labelledby="home-tab">
                      <p>Raw denim you probably haven't heard of them jean shorts Austin. Nesciunt tofu stumptown aliqua, retro synth master cleanse. Mustache cliche tempor, williamsburg carles vegan helvetica. Reprehenderit butcher retro keffiyeh dreamcatcher
                      synth. Cosby sweater eu banh mi, qui irure terr.</p>
                    </div>
                    <div role="tabpanel" class="tab-pane fade" id="tab_content22" aria-labelledby="profile-tab">
                      <p>Food truck fixie locavore, accusamus mcsweeney's marfa nulla single-origin coffee squid. Exercitation +1 labore velit, blog sartorial PBR leggings next level wes anderson artisan four loko farm-to-table craft beer twee. Qui photo
                      booth letterpress, commodo enim craft beer mlkshk aliquip</p>
                    </div>
                    <div role="tabpanel" class="tab-pane fade " id="tab_content33" aria-labelledby="profile-tab">
                      <p>xxFood truck fixie locavore, accusamus mcsweeney's marfa nulla single-origin coffee squid. Exercitation +1 labore velit, blog sartorial PBR leggings next level wes anderson artisan four loko farm-to-table craft beer twee. Qui photo
                      booth letterpress, commodo enim craft beer mlkshk </p>
                    </div>
                    <div role="tabpanel" class="tab-pane fade " id="tab_content44" aria-labelledby="profile-tab">
                      <p>xxxFood truck fixie locavore, accusamus mcsweeney's marfa nulla single-origin coffee squid. Exercitation +1 labore velit, blog sartorial PBR leggings next level wes anderson artisan four loko farm-to-table craft beer twee. Qui photo
                      booth letterpress, commodo enim craft beer mlkshk </p>
                    </div>
                  </div>
                </div>

              </div>
            </div>
          </div>
          <div class="panel">
            <a class="panel-heading collapsed" role="tab" id="headingThree" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
              <h4 class="panel-title">Calificación seleccionada: Sin seleccionar</h4>
            </a>
            <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree" aria-expanded="false" style="height: 0px;">
              <div class="panel-body">
                <div class="" role="tabpanel" data-example-id="togglable-tabs">
                  <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                    <li role="presentation" class=""><a href="#tab_content111" id="home-tab" role="tab" data-toggle="tab" aria-expanded="false">1</a>
                    </li>
                    <li role="presentation" class=""><a href="#tab_content222" role="tab" id="profile-tab" data-toggle="tab" aria-expanded="false">2</a>
                    </li>
                    <li role="presentation" class=""><a href="#tab_content333" role="tab" id="profile-tab2" data-toggle="tab" aria-expanded="true">3</a>
                    </li>
                     <li role="presentation" class=""><a href="#tab_content444" role="tab" id="profile-tab3" data-toggle="tab" aria-expanded="true">4</a>
                    </li>
                  </ul>
                  <div id="myTabContent" class="tab-content">
                    <div role="tabpanel" class="tab-pane fade" id="tab_content111" aria-labelledby="home-tab">
                      <p>Raw denim you probably haven't heard of them jean shorts Austin. Nesciunt tofu stumptown aliqua, retro synth master cleanse. Mustache cliche tempor, williamsburg carles vegan helvetica. Reprehenderit butcher retro keffiyeh dreamcatcher
                      synth. Cosby sweater eu banh mi, qui irure terr.</p>
                    </div>
                    <div role="tabpanel" class="tab-pane fade" id="tab_content222" aria-labelledby="profile-tab">
                      <p>Food truck fixie locavore, accusamus mcsweeney's marfa nulla single-origin coffee squid. Exercitation +1 labore velit, blog sartorial PBR leggings next level wes anderson artisan four loko farm-to-table craft beer twee. Qui photo
                      booth letterpress, commodo enim craft beer mlkshk aliquip</p>
                    </div>
                    <div role="tabpanel" class="tab-pane fade" id="tab_content333" aria-labelledby="profile-tab">
                      <p>xxFood truck fixie locavore, accusamus mcsweeney's marfa nulla single-origin coffee squid. Exercitation +1 labore velit, blog sartorial PBR leggings next level wes anderson artisan four loko farm-to-table craft beer twee. Qui photo
                      booth letterpress, commodo enim craft beer mlkshk </p>
                    </div>
                    <div role="tabpanel" class="tab-pane fade" id="tab_content444" aria-labelledby="profile-tab">
                      <p>xxxFood truck fixie locavore, accusamus mcsweeney's marfa nulla single-origin coffee squid. Exercitation +1 labore velit, blog sartorial PBR leggings next level wes anderson artisan four loko farm-to-table craft beer twee. Qui photo
                      booth letterpress, commodo enim craft beer mlkshk </p>
                    </div>

                  </div>
                </div>

              </div>
            </div>
          </div>
        </div>
        <!-- end of accordion -->

      </div>

      <!-- asdasd-->

				<div class="row" style="padding-top: 20px">
					
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
		<!-- /.modal-dialog -->
	</div>
	<!-- /.modal -->


</div>

</div>






</div>


@stop

@section('js-scripts')


@stop