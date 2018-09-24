@extends('Layouts.layout')
@section('pageTitle', 'Principal')
@section('content')

<div class="customBody">

  <h1 class="mainTitle"> Gestionar Cursos </h1>
<!--<div class="">
	<label>
		<div class="form-group">
      <label>
        <input type="checkbox" class="js-switch" checked /> <span class="pText"> Copiar configuración del semestre anterior </span>
      </label>
    </div>
  </label>
</div>
-->

<div class="row">
  <div class=" x_panel tile coursesBox">
    <div class="title_right">
      <div class="col-md-4 col-sm-4 col-xs-12 form-group top_search">
        <div class="input-group">
          <input type="text" class="form-control searchText" placeholder="Curso...">
          <span class="input-group-btn">
            <button class="btn btn-default searchButton" type="button">Buscar</button>
          </span>
        </div>
      </div>
    </div>

    <div class="col-md-5"></div>

      <button type="button" class="btn btn-success btn-lg pText customButton">Cargar Horario</button>


      <button type="button" class="btn btn-success btn-lg pText customButton">Cargar Alumnos  </button>

    <div class="x_content bs-example-popovers">
      <div class="alert alert-success alert-dismissible fade in courseButton" role="alert" style="background-color: #d3eafd; color: #00626e; border-color: #c1e2fc;">
        <button type="button" class="close " data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
        </button>
        <p class="pText"> INF222 Tesis 2 </p>
      </div>
    </div>

    <div class="x_content bs-example-popovers ">
      <div class="alert alert-success alert-dismissible fade in courseButton" role="alert" style="background-color: #d3eafd; color: #00626e; border-color: #c1e2fc;">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
        </button>
        <p class="pText"> INF444 Desarrollo de Programas 1 </p>
      </div>
    </div>

    <div class="x_content bs-example-popovers ">
      <div class="courseButton alert alert-success alert-dismissible fade in " role="alert" style="background-color: #d3eafd; color: #00626e; border-color: #c1e2fc;">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
        </button>
        <p class="pText"> INF555 Desarrollo de Programas 2 </p>
      </div>
    </div>

    <div class="col-xs-12 text-center no-padding">
      <hr style="margin-top: 20px; margin-bottom: 20px; border-color: #eeeeee">
      <p class="pText">Agregar curso</p>
    </div>


  </div>
</div>

</div>
@stop

@section('js-scripts')


@stop