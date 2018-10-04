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
          <button id="btnCargarCursos" type="button" class="btn btn-success btn-lg pText customButton">Cargar Cursos</button>
          <button id="btnCargarHorario" type="button" class="btn btn-success btn-lg pText customButton">Cargar Horario</button>
          <button id="btnCargarAlumnos" type="button" class="btn btn-success btn-lg pText customButton">Cargar Alumnos</button>
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

<div class="modal fade bs-example-modal-lg text-center" role="dialog" tabindex="-1"
id="modalCursos" data-keyboard="false" data-backdrop="static"
aria-labelledby="gdridfrmnuavaUO" data-focus-on="input:first">
<div class="customModal modal-dialog modal-lg" style="width: 400px; height: 300px" >
  <div class="modal-content" style="top: 40%">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal"
      aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
    <h4 id="gridSystemModalLabel" class="reportsTitle mainTitle modal-title" style="padding-top: 10px" id="gridSystemModalLabel">Seleccionar Cursos a Evaluar</h4>
  </div>
  <hr style="padding: 0px; margin-top: 0px; margin-bottom: 0px; width: 80%">
  <div class="modal-body">
    <div class="container-fluid">
      <form id="frmAgregarCursos">
        <div class="tile coursesModalBox">
          <div class="col-xs-12 form-group top_search" >
            <div class="input-group">
              <input id="txtCursoBuscar" type="text" class="form-control searchText" placeholder="Curso...">
              <span class="input-group-btn">
                <button class="btn btn-default searchButton" type="button" id="btnBuscarCurso">
                  <i class="fa fa-spinner fa-spin fa-fw fa-1x margin-bottom hidden"></i>
                  <i class="fa fa-search"></i>
                </button>
              </span>
            </div>
          </div>

        </div>

        <!--Esto se debe de volver a generar por AJAX-->
        <!--
        <div class="table-responsive">
          <table class="table table-striped jambo_table bulk_action">
            <thead >
              <tr class="headings" style="background-color: #005b7f; color: white; font-family: Segoe UI">
                <th class="pText column-title" style="border: none"></th>
                <th class="pText column-title" style="border: none"> Código</th>
                <th class="pText column-title" style="border: none">Curso</th>
                <th class="pText bulk-actions" colspan="7">
                  <a class="antoo" style="color:#fff; font-weight:500;">Bulk Actions ( <span class="action-cnt"> </span> ) <i class="fa fa-chevron-down"></i></a>
                </th>
              </tr>
            </thead>

            <tbody class="text-left">
              <tr class="even pointer">
                <td class="a-center"  style="background-color: white; padding-right: 0px">
                 <div class="form-check" style="padding-left: 10px; width: 20px">
                  <label>
                    <input type="checkbox" checked="" > <span class="pText label-text "></span>
                  </label>
                </div>
              </td>
              <td class="pText" style="background-color: white; padding-top: 12px; color: #72777a;">ING220</td>
              <td class="pText" style="background-color: white; padding-top: 12px; color: #72777a">Ética Profesional</td>            
            </tr>
          </tbody>
        </table>
      </div>
    -->

    <ul id="listaCursos" class="list-unstyled top_profiles scroll-view hidden" style="height: auto;" >
      <li class="media event cargando-resultados">
        <div class="media-body">
          <p style="text-align: center;"><i class="fa fa-spinner fa-spin fa-fw"></i></p>
        </div>
      </li>
      <li class="media event sin-resultados hidden">
        <div class="media-body">
          <p style="text-align: center;">No se encontraron cursos</p> 
        </div>
      </li>
    </ul>
    <div id="btnsAgregarCurso" class="modal-footer hidden">
      <div class="text-center" style="padding-top: 0px; padding-bottom: 10px">

        <button id="btnAgregar" class="btn btn-success pText customButtonThin">Agregar</button>
        <button id="btnCancelar" class="btn btn-success pText customButtonThin">Cancelar</button> 
      </div>
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
          <button id="btnCancelarModal" class="btn btn-success pText customButtonThin">Cancelar</button>

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