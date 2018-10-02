@extends('Layouts.layout')
@section('pageTitle', 'Principal')
@section('content')
@section('js-libs')
<script type="text/javascript"  src="{{ URL::asset('js/cursos/cursosjs.js') }}"></script>
@stop

<div class="customBody">

  <div class="row">
    <div class="col-md-8 col-sm-6">
      <h1 class="mainTitle"> Gestionar Cursos </h1>
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
  <div class=" x_panel tile coursesBox">

    <div class="row">
      <div class="col-xs-6" >
        <h1 class="secondaryTitle mainTitle">Cursos a Acreditar </h1>
      </div>

      <div class="col-xs-6 text-right">
        <button id="btnCargarHorario" type="button" class="btn btn-success btn-lg pText customButton">Cargar Horario</button>
        <button id="btnCargarAlumnos" type="button" class="btn btn-success btn-lg pText customButton">Cargar Alumnos  </button>
      </div>  
    </div>

    <div class="x_content bs-example-popovers courseContainer">
      <div id ="CargarCurso" class="addCourseButton alert alert-success alert-dismissible fade in" role="alert">
        <button type="button" class="close" aria-label="Close"><span aria-hidden="true">+</span>
        </button>
        <p class="pText"> Agregar Nuevo Curso </p>
      </div>
    </div>

    @foreach($cursos as $curso)
    <div class="x_content bs-example-popovers courseContainer" >
      <a class="" href="{{ route('cursos.horarios') }}?id={{$curso->ID_CURSO}}&nombre={{$curso->NOMBRE}}&codigo={{$curso->CODIGO_CURSO}}">
      <div class="courseButton alert alert-success alert-dismissible fade in courseButton" role="alert">
          <button type="button" class="close " data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
          </button>
          <p class="pText">{{$curso->CODIGO_CURSO}} {{$curso->NOMBRE}}</p>
      </div> 
      </a>
      
    </div>
    @endforeach



  </div>
</div>

</div>




<!-- Modal de Nuevo Curso -->

<div class="modal text-center fade bs-example-modal-lg" role="dialog" tabindex="-1"
id="modalCursos" data-keyboard="false" data-backdrop="static"
aria-labelledby="gdridfrmnuavaUO" data-focus-on="input:first">
<div class="customModal modal-dialog modal-lg">
  <div class="modal-content" style="top: 100px !important">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal"
      aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
    <h4 class="modal-title" id="gridSystemModalLabel">CREAR NUEVO CURSO A EVALUAR</h4>
  </div>
  <div class="modal-body">
    <div class="container-fluid">
      <form id="frmCursos">
        <div class=" x_panel tile coursesModalBox">
          <div class="row rowModal">
            <div class="col-md-8">
              <h6 class="black-color pText">CODIGO</h6>
            </div>
            <div class="col-md-4">
              <input type="text" class="form-control"
              name="empresabean.codempresa" id="txtcodigo"
              required="required"/>
            </div>
          </div>
          <div class="row rowModal">
            <div class="col-md-4">
              <h6 class="black-color pText">NOMBRE</h6>
            </div>
            <div class="col-md-8">
              <input type="text" class="form-control pText"
              name="empresabean.descripcion" id="txtdescripcion"
              required="required" />
            </div>
          </div>
          <div class="row">
            <div class="col-md-4">
              <button id="btnActualizar" class="btn btn-success pText customButtonModal">ACTUALIZAR</button>
            </div>
          </div>
        </div>
        <div class="row" id="idEstado">
          <div class="col-md-4">
            <h6 class="black-color pText">BUSCAR CURSO</h6>
          </div>
        </div>
        <div class="col-md-8 col-sm-4 form-group top_search" >
          <div class="input-group" style="text-align: right">
            <input type="text" class="form-control searchText" placeholder="Curso...">
            <span class="input-group-btn">
              <button class="btn btn-default searchButton" type="button">Buscar</button>
            </span>
          </div>
        </div>

      </form>

      <div class="modal-footer footerButtons" style="padding-right: 0px; padding-left: 5px;">
        <button id="btnAgregar" class="btn btn-success pText customButton">AGREGAR</button>
        <button id="btnEliminar" class="btn btn-success pText customButton">ELIMINAR</button>
        <button id="btnCancelar" class="btn btn-success pText customButton">CANCELAR</button> 
      </div>

    </div>
  </div>
</div>
<!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->
</div>
<!-- /.modal -->


<!-- Modal de Cargar Alumnos y Horarios -->

<div class="modal fade bs-example-modal-lg text-center" role="dialog" tabindex="-1"
id="modalCargar" data-keyboard="false" data-backdrop="static"
aria-labelledby="gdridfrmnuavaUO" data-focus-on="input:first" >
<div class="customModal modal-dialog modal-lg ">
  <div class="modal-content" style="top: 30% !important;">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal"
      aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
    <h4 id="CargarHorarios" class="reportsTitle mainTitle modal-title" style="padding-top: 10px" id="gridSystemModalLabel">Cargar Horarios</h4>
    <h4 id="CargarAlumnos" class="reportsTitle mainTitle modal-title" style="padding-top: 10px" id="gridSystemModalLabel">Cargar Alumnos</h4>
  </div>
  <hr style="padding: 0px; margin-top: 0px; margin-bottom: 0px; width: 80%">
  <div class="modal-body">
    <div class="container-fluid text-center">
      <div class="dropzone" style="min-height: 100px; height: 180px; width: 300px; border: 2px dashed #ccc; display: inline-block; background-color: white; margin-top: 10px; margin-bottom: 10px">
          <i class="fa fa-5x fa-cloud-upload" style="color: #ccc; height: 100px; padding: 10px"></i>
          <p class="pText">Arrastra y suelta un archivo <br> o <br> <span style="text-decoration: underline"> Carga un archivo desde documentos </span></p>
      </div>

      <div style="padding-top: 10px; padding-bottom: 10px">
        <button id="btnCargar" class="btn btn-success pText customButtonThin" >Cargar</button>
        <button id="btnCancelar" class="btn btn-success pText customButtonThin">Cancelar</button> 
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