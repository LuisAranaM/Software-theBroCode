@extends('Layouts.layout')

@section('js-libs')
<script type="text/javascript"  src="{{ URL::asset('js/horarios/horariosjs.js') }}"></script>

@stop

@section('pageTitle', 'Principal')
@section('content')

<div class="customBody">
  <div class="row">
    <div class="col-md-8 col-sm-6">
      <h1 class="mainTitle"> INF555 Desarrollo de Programas 2 </h1>
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
    <div class="row">
      <div class="col-xs-6" >
        <h1 class="secondaryTitle mainTitle" style="text-align: left">Gestionar Horarios </h1>
      </div>

      <div class="col-sm-6 col-xs-6" style="text-align: right">
        <button type="button" class="btn btn-success btn-lg pText customButton" style="width: 120px">Cargar Alumnos  </button>
      </div>  
    </div>

    <div class="x_content bs-example-popovers courseContainer">
      <div id="btnAgregarHorario" class="alert alert-success alert-dismissible fade in courseButton" role="alert" style="background-color: white; color: #00626e; border-color: #c1e2fc;">
        <button type="button" class="close" aria-label="Close"><span aria-hidden="true">+</span>
        </button>
        <p class="pText"> Agregar Nuevo Horario </p>
      </div>
    </div>

    <div class="x_content bs-example-popovers courseContainer">
      <div class="alert alert-success alert-dismissible fade in courseButton" role="alert" style="background-color: #d3eafd; color: #00626e; border-color: #c1e2fc;">
        <button type="button" class="close " data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
        </button>
        <p class="pText"> H222 - Freddy Paz</p>
      </div>
    </div>

    <div class="x_content bs-example-popovers courseContainer">
      <div class="alert alert-success alert-dismissible fade in courseButton" role="alert" style="background-color: #d3eafd; color: #00626e; border-color: #c1e2fc;">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
        </button>
        <p class="pText"> H223 - Miguel Guanira </p>
      </div>
    </div>

    <div class="x_content bs-example-popovers courseContainer">
      <div class="courseButton alert alert-success alert-dismissible fade in " role="alert" style="background-color: #d3eafd; color: #00626e; border-color: #c1e2fc;">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
        </button>
        <p class="pText"> H223 - Alejandro Bello </p>
      </div>
    </div>
  </div>
</div>

<div class="row">
  <div class=" x_panel tile coursesBox">
    <div class="col-xs-12" >
      <h1 class="secondaryTitle mainTitle" style="text-align: left">Resultados del Estudiantes / Indicadores de Desempeño</h1>
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
        <label id="btnAgregarCriterios" class="btn btn-primary" style="background-color: #00626E; border-color: #004d54; width: 1px">
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
</div>



</div>
<!-- Modal para Agregar Horarios -->

<div class="modal fade bs-example-modal-lg" role="dialog" tabindex="-1"
id="modalHorarios" data-keyboard="false" data-backdrop="static"
aria-labelledby="gdridfrmnuavaUO" data-focus-on="input:first">
<div class="modal-dialog modal-lg" style="width: 400px;">
  <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal"
      aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
    <h4 class="modal-title" id="gridSystemModalLabel">Seleccionar Horarios</h4>
  </div>
  <div class="modal-body">
    <div class="container-fluid">
      <form id="frmCursos">      
        <div class="row rowModal">
          <div class="col-md-10">
            <h1 class="black-color pText">INF555 Desarrollo de Programas 2</h1>
          </div>
        </div>
        <div class="row rowModal">
          <div class="col-md-8">
            <h6 class="black-color pText">Seleccionar Horario</h6>
          </div>
        </div>
      </form>
      <div class="modal-footer footerButtons" style="padding-right: 0px; padding-left: 5px;">
        <button id="btnAgregar" class="btn btn-success pText customButton">Agregar</button>
        <button id="btnEliminar" class="btn btn-success pText customButton">Eliminar</button>
        <button id="btnCancelar" class="btn btn-success pText customButton">Cancelar</button> 
      </div>
    
    </div>
  </div>
</div>
<!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->
</div>
<!-- /.modal -->


<!-- Modal para Agregar Criterios-->

<div class="modal fade bs-example-modal-lg" role="dialog" tabindex="-1"
id="modalCriterios" data-keyboard="false" data-backdrop="static"
aria-labelledby="gdridfrmnuavaUO" data-focus-on="input:first">
<div class="modal-dialog modal-lg" style="width: 400px;">
  <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal"
      aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
    <h4 class="modal-title" id="gridSystemModalLabel">Seleccionar Criterios</h4>
  </div>
  <div class="modal-body">
    <div class="container-fluid">
      <form id="frmCursos">      
        <div class="row rowModal">
          <div class="col-md-10">
            <h1 class="black-color pText">Seleccionar indicadores a evaluar</h1>
          </div>
        </div>

        <div class="col-md-12">
          <div class="btn-group btn-group-justified" data-toggle="buttons" >
            <label class="btn btn-primary active"  style="background-color: #00626E; border-color: #004d54">
              <input type="radio" class="sr-only" id="viewMode1" name="viewMode" value="1">
              <span class="docs-tooltip" data-toggle="tooltip" title="View Mode 1">
                A
              </span>
            </label>
            <label class="btn btn-primary" style="background-color: #00626E; border-color: #004d54">
              <input type="radio" class="sr-only" id="viewMode1" name="viewMode" value="1">
              <span class="docs-tooltip" data-toggle="tooltip" title="View Mode 1">
                B
              </span>
            </label>
            <label class="btn btn-primary" style="background-color: #00626E; border-color: #004d54">
              <input type="radio" class="sr-only" id="viewMode1" name="viewMode" value="1">
              <span class="docs-tooltip" data-toggle="tooltip" title="View Mode 1">
                C
              </span>
            </label>
          </label>
        </div>
        <div class="modal-footer footerButtons" style="padding-right: 0px; padding-left: 5px;">
        <button id="btnAgregar" class="btn btn-success pText customButton">Seleccionar todo</button>
     </div>
        <div class=" x_panel tile modalCriteriosBox">
          <div class="col-md-12">
            <div class="groupBoxOptions">
            <div class="form-check">
              <label>
                <input type="checkbox" checked=""> <span class="pText label-text">A1. Matemáticas: Aplica conceptos lógicos para la resolucion de problemas</span>
              </label>
              <label>
                <input type="checkbox" checked=""> <span class="pText label-text">A1. Matemáticas: Aplica conceptos lógicos para la resolucion de problemas</span>
              </label>
              
            </div>
        </div>
      </form>
      
      <div class="modal-footer footerButtons" style="padding-right: 0px; padding-left: 5px;">
        <button id="btnAgregar" class="btn btn-success pText customButton">Agregar</button>
     </div>
    </div>
  </div>
</div>
<!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->
</div>
<!-- /.modal -->

@stop

@section('js-scripts')


@stop