@extends('Layouts.layout')
@section('pageTitle', 'Principal')
@section('content')

<div class="customBody">
  <div class="row">
    <div class="col-md-8 col-sm-6">
      @if($codCurso===null)
      <h1 class="mainTitle">Horarios y Criterios</h1>
      @else
      <h1 class="mainTitle">{{$codCurso}} {{$nombreCurso}}</h1>
      @endif

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

  @if($codCurso===null)
  <div class=" x_panel tile coursesBox">
        <h1 class="messageText no-padding">Debe Seleccionar un Curso</h1>
  </div> 

  @else

  <div class=" x_panel tile coursesBox">
    <div class="row">
      <div class="col-xs-6" >
        <h1 class="secondaryTitle mainTitle">Gestionar Horarios </h1>
      </div>

      <div class="col-sm-6 col-xs-6 text-right">
        <button type="button" class="btn btn-success btn-lg pText customButton">Cargar Alumnos  </button>
      </div>  
    </div>

    <div class="x_content bs-example-popovers courseContainer">
      <div class="addCourseButton alert alert-success alert-dismissible fade in" role="alert">
        <button type="button" class="close" aria-label="Close"><span aria-hidden="true">+</span>
        </button>
        <p class="pText"> Agregar Nuevo Horario </p>
      </div>
    </div>

    @foreach($horario as $h)
    <div class="x_content bs-example-popovers courseContainer">
      <div class="courseButton alert alert-success alert-dismissible fade in" role="alert">
        <button type="button" class="close " data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
        </button>
        <p class="pText">{{$h->NOMBRE_HORARIO}} - {{$h->NOMBRE_PROFESOR}}</p>
      </div>
    </div>
    @endforeach
  </div>  
  @endif
</div>


@if($codCurso!=null)
<div class="row">
  <div class=" x_panel tile coursesBox">
    <div class="col-xs-12" >
      <h1 class="secondaryTitle mainTitle">Resultados del Estudiantes / Indicadores de Desempeño</h1>
    </div>

    

    <!--Criterio 1-->
    <div class="row" style="margin-bottom: 30px">
      <div class="col-md-3 pText">
        Criterio A: Matemáticas
      </div>
      <div class="col-md-9">
        <div class="btn-group btn-group-justified" data-toggle="buttons" >
          <label class="btn btn-primary active"  style="background-color: #00626E; border-color: #004d54">
            <input type="radio" class="sr-only" id="viewMode1" name="viewMode" value="1">
            <span class="docs-tooltip" data-toggle="tooltip" title="View Mode 1">
              B
            </span>
          </label>
          <label class="btn btn-primary" style="background-color: #00626E; border-color: #004d54">
            <input type="radio" class="sr-only" id="viewMode1" name="viewMode" value="1">
            <span class="docs-tooltip" data-toggle="tooltip" title="View Mode 1">
              B2
            </span>
          </label>
          <label class="btn btn-primary" style="background-color: #00626E; border-color: #004d54">
            <input type="radio" class="sr-only" id="viewMode1" name="viewMode" value="1">
            <span class="docs-tooltip" data-toggle="tooltip" title="View Mode 1">
              B2
            </span>
          </label>
        </label>
        <label class="btn btn-primary" style="background-color: #00626E; border-color: #004d54; width: 1px">
          <input type="radio" class="sr-only" id="viewMode1" name="viewMode" value="1">
          <span class="docs-tooltip" data-toggle="tooltip" title="View Mode 1">
            +
          </span>
        </label>
      </div>
    </div>
  </div>

  <!--Criterio 2-->
  <div class="row">
    <div class="col-md-3 pText">
      Criterio A: Matemáticas
    </div>
    <div class="col-md-9">
      <div class="btn-group btn-group-justified" data-toggle="buttons">
        <label class="btn btn-primary" style="background-color: #00626E; border-color: #004d54">
          <input type="radio" class="sr-only" id="viewMode1" name="viewMode" value="1">
          <span class="docs-tooltip" data-toggle="tooltip" title="View Mode 1">
            B2
          </span>
        </label>
        <label class="btn btn-primary" style="background-color: #00626E; border-color: #004d54">
          <input type="radio" class="sr-only" id="viewMode1" name="viewMode" value="1">
          <span class="docs-tooltip" data-toggle="tooltip" title="View Mode 1">
            B2
          </span>
        </label>
        <label class="btn btn-primary" style="background-color: #00626E; border-color: #004d54">
          <input type="radio" class="sr-only" id="viewMode1" name="viewMode" value="1">
          <span class="docs-tooltip" data-toggle="tooltip" title="View Mode 1">
            B2
          </span>
        </label>
      </div>
    </div>
  </div>


</div>

@endif

</div>
@stop

@section('js-scripts')


@stop