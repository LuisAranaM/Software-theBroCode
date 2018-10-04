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
  </div>

  <div class="row">
    <div class=" x_panel tile coursesBox">

      <div class="row">
        <div class="col-xs12">
          <button id="btnCargarCursos" type="button" class="btn btn-success btn-lg pText customButton">Cargar Cursos</button>
          <button id="btnCargarHorario" type="button" class="btn btn-success btn-lg pText customButton">Cargar Horario</button>
          <button id="btnCargarAlumnos" type="button" class="btn btn-success btn-lg pText customButton">Cargar Alumnos</button>
        </div>  
      </div>
    </div>
  </div>

</div>


<!-- Modal de Cargar Alumnos y Horarios -->

<div class="modal fade bs-example-modal-lg text-center" role="dialog" tabindex="-1"
id="modalCargar" data-keyboard="false" data-backdrop="static"
aria-labelledby="gdridfrmnuavaUO" data-focus-on="input:first" >
<div class="customModal modal-dialog modal-lg ">
  <div class="modal-content" style="top: 30%">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal"
      aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
    <h4 id="CargarCursos" class="reportsTitle mainTitle modal-title" style="padding-top: 10px" id="gridSystemModalLabel">Cargar Cursos</h4>
    <h4 id="CargarHorarios" class="reportsTitle mainTitle modal-title" style="padding-top: 10px" id="gridSystemModalLabel">Cargar Horarios</h4>
    <h4 id="CargarAlumnos" class="reportsTitle mainTitle modal-title" style="padding-top: 10px" id="gridSystemModalLabel">Cargar Alumnos</h4>
  </div>
  <hr style="padding: 0px; margin-top: 0px; margin-bottom: 0px; width: 80%">
  <div class="modal-body">
    <div class="container-fluid text-center">
      <div class="dropzone" style="min-height: 100px; height: 180px; width: 300px; border: 2px dashed #ccc; display: inline-block; background-color: white; margin-top: 10px; margin-bottom: 10px">
        <i class="fa fa-5x fa-cloud-upload" style="color: #ccc; height: 100px; padding: 10px"></i>
        <p class="pText">Arrastra y suelta un archivo <br> o <br> 
            <!--
            <span style="text-decoration: underline"> Carga un archivo desde documentos </span></p>
          -->
          <input type="file" name="Carga un archivo desde documentos" /> 
        </div>

        <div style="padding-top: 10px; padding-bottom: 10px">
        <!--      
          <form id="btnCargarCursosModal" action="ImportClients" method="post" enctype="multipart/form-data">
            <input id="btnCargarCursosModal" class="btn btn-success pText customButtonThin" type="submit" value="Cargar" />
            <button id="btnCancelarModal" class="btn btn-success pText customButtonThin">Cancelar</button>
          </form>

          <form id="btnCargarHorariosModal" action="" method="" enctype="">
            <button id="btnCargarHorariosModal" class="btn btn-success pText customButtonThin" type="submit">Cargar</button> 
            <button id="btnCancelarModal" class="btn btn-success pText customButtonThin">Cancelar</button>
          </form>

          <form id="btnCargarAlumnosModal" action="" method="" enctype="">
            <button id="btnCargarAlumnosModal" class="btn btn-success pText customButtonThin" >Cargar</button>
            <button id="btnCancelarModal" class="btn btn-success pText customButtonThin">Cancelar</button>
          </form>
        -->
        <form action="ImportClients" method="post" enctype="multipart/form-data"  >
          <button id="btnCargarCursosModal"  class="btn btn-success pText customButtonThin"> Cargar</button>
          <button id="btnCargarHorariosModal"  class="btn btn-success pText customButtonThin" >Cargar</button> 
          <button id="btnCargarAlumnosModal"  class="btn btn-success pText customButtonThin" >Cargar</button>
          <button type="reset" id="btnCancelarModal" class="btn btn-success pText customButtonThin">Cancelar</button>

        </form>



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