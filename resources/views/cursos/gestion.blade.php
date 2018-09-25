@extends('Layouts.layout')
@section('pageTitle', 'Principal')
@section('content')

<div class="customBody">

  <div class="row">
    <div class="col-md-8 col-sm-6">
      <h1 class="mainTitle"> Gestionar Cursos </h1>
    </div>

    <div class="col-md-4 col-sm-6 form-group top_search" >
      <div class="input-group" style="text-align: right">
        <input type="text" class="form-control searchText" placeholder="Curso...">
        <span class="input-group-btn">
          <button class="btn btn-default searchButton" type="button">Buscar</button>
        </span>
      </div>
    </div>
  </div>
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

    <div class="col-xs-6" >
      <h1 class="secondaryTitle mainTitle">Cursos a Acreditar </h1>
    </div>


    <div class="col-xs-6" style="text-align: right">
      <button type="button" class="btn btn-success btn-lg pText customButton" style="width: 120px">Cargar Horario</button>
      <button type="button" class="btn btn-success btn-lg pText customButton" style="width: 120px">Cargar Alumnos  </button>
    </div>  

    <div class="x_content bs-example-popovers">
      <div class="alert alert-success alert-dismissible fade in courseButton" role="alert" style="background-color: white; color: #00626e; border-color: #c1e2fc;">
        <button type="button" class="close" aria-label="Close"><span aria-hidden="true">+</span>
        </button>
        <p class="pText"> Agregar Nuevo Curso </p>
      </div>
    </div>

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



  </div>
</div>

</div>
@stop

@section('js-scripts')


@stop