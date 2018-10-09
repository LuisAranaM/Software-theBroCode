@extends('Layouts.layout')
@section('pageTitle', 'Principal')
@section('content')
@section('js-libs')
<script type="text/javascript"  src="{{ URL::asset('js/cursos/cursosjs.js') }}"></script>
@stop

<div class="customBody">

  <div class="row">
    <div class="col-md-8 col-sm-6">
      <h1 class="mainTitle"> Seleccione horario a calificar</h1>
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
      
      <!--SOFTWARE-->
      <div class="row rowFinal">

        <div class="row">
        <div class="col-md-11" >
          <h1 class="secondaryTitle mainTitle">Ingeniería de Software</h1>
        </div>

        <div class="col-md-1" style="text-align: right; font-size: 20px"> 
          <i class="fa fa-caret-up"></i>
        </div>
        </div>
        <div class="row">
        
        <div class="col-md-1" >
          <p class="pText" style="margin-bottom: 0px">H-0381</p>
        </div>
        <div class="col-md-9" style="padding-bottom: 0">
          <div class="widget_summary" >
            <div class="w_center w_55" style="width: 100%">
              <div class="progress" style="margin-bottom: 0px">
                <div class="progress-bar bg-green" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 66%; background-color: #005b7f !important; border: none !important">
                  <span class="sr-only">60% Complete</span>
                </div>
              </div>
            </div>
          </div>
          <div class="no-padding">
          <p class="barText pText">55% de avance - 11/30 alumnos calificados</p>
        </div>
        </div>
        <div class="col-md-2">
          <button id="btnCargarCursos" type="button" class="btn btn-success btn-lg pText customButton">Calificar</button>
        </div>
      </div>

      <div class="row">

        <div class="col-md-1" >
          <p class="pText" style="margin-bottom: 0px">H-0381</p>
        </div>
        <div class="col-md-9" style="padding-bottom: 0">
          <div class="widget_summary" >
            <div class="w_center w_55" style="width: 100%">
              <div class="progress" style="margin-bottom: 0px">
                <div class="progress-bar bg-green" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%; background-color: #005b7f !important; border: none !important">
                  <span class="sr-only">60% Complete</span>
                </div>
              </div>
            </div>
          </div>
          <div class="no-padding">
          <p class="barText pText">No hay alumnos cargados</p>
        </div>
        </div>
        <div class="col-md-2">
          <button id="btnCargarCursos" type="button" class="btn btn-success btn-lg pText customButton">Cargar Alumnos</button>
        </div>
      </div>
    </div>
      <!--DP1-->
      <div class="row rowFinal">

        <div class="row">

        <div class="col-md-11" >
          <h1 class="secondaryTitle mainTitle">Desarrollo de Programas 1</h1>
        </div>

        <div class="col-md-1" style="text-align: right; font-size: 20px"> 
          <i class="fa fa-caret-up"></i>
        </div>
        </div>

        <div class="row">
        
        <div class="col-md-1" >
          <p class="pText" style="margin-bottom: 0px">H-0481</p>
        </div>
        <div class="col-md-9" style="padding-bottom: 0">
          <div class="widget_summary" >
            <div class="w_center w_55" style="width: 100%">
              <div class="progress" style="margin-bottom: 0px">
                <div class="progress-bar bg-green" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 66%; background-color: #005b7f !important; border: none !important">
                  <span class="sr-only">60% Complete</span>
                </div>
              </div>
            </div>
          </div>
          <div class="no-padding">
          <p class="barText pText">55% de avance - 11/30 alumnos calificados</p>
        </div>
        </div>
        <div class="col-md-2">
          <button id="btnCargarCursos" type="button" class="btn btn-success btn-lg pText customButton">Calificar</button>
        </div>
      </div>

      <div class="row">
        
        <div class="col-md-1" >
          <p class="pText" style="margin-bottom: 0px">H-0481</p>
        </div>
        <div class="col-md-9" style="padding-bottom: 0">
          <div class="widget_summary" >
            <div class="w_center w_55" style="width: 100%">
              <div class="progress" style="margin-bottom: 0px">
                <div class="progress-bar bg-green" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 66%; background-color: #005b7f !important; border: none !important">
                  <span class="sr-only">60% Complete</span>
                </div>
              </div>
            </div>
          </div>
          <div class="no-padding">
          <p class="barText pText">55% de avance - 11/30 alumnos calificados</p>
        </div>
        </div>
        <div class="col-md-2">
          <button id="btnCargarCursos" type="button" class="btn btn-success btn-lg pText customButton">Calificar</button>
        </div>
      </div>

    </div>

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



</div>


@stop

@section('js-scripts')


@stop