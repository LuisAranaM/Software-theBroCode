<!-- Required Stylesheets -->
<!--<link href="public/css/bootstrap.css" rel="stylesheet">-->
@extends('Layouts.layout')

@section('js-libs')
<!-- Required Javascript -->
<script type="text/javascript" src="{{ URL::asset('js/jquery-3.2.1.min') }}"></script>
<script type="text/javascript" src="{{ URL::asset('js/bootstrap-treeview.min') }}"></script>
<script type="text/javascript"  src="{{ URL::asset('js/horarios/horarios.js') }}"></script>

@stop

@section('pageTitle', 'Principal')
@section('content')
<div id="idCurso" data-field-id="{{$idCurso}}" ></div>
<div id="nombreCurso" data-field-id="{$nombreCurso}}" ></div>
<div id="codCurso" data-field-id="{{$codCurso}}" ></div>

<div class="customBody">
  <div class="row">
    <div class="col-md-8 col-sm-6">
      @if($codCurso===null)
      <h1 class="mainTitle">Horarios y Criterios</h1>
      @else
      <h1 class="mainTitle">{{$codCurso}} {{$nombreCurso}}</h1>
      @endif

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
          <button id="btnCargarAlumnos" type="button" class="btn btn-success btn-lg pText customButton">Cargar Alumnos  </button>
        </div>  
      </div>

      <div class="x_content bs-example-popovers courseContainer">

        <div id="btnAgregarHorario" class="addCourseButton alert alert-success alert-dismissible fade in" role="alert"  style="cursor:pointer">

          <button id="btnAgregarHorario" type="button" class="close" aria-label="Close"><span aria-hidden="true">+</span>
          </button>
          <p class="pText"> Agregar Nuevo Horario </p>
        </div>
      </div>
      <div id="listHorarios">
        @foreach($horarios as $h)
        @if($h->ESTADO===1)
        <a class="" href="{{ route('profesor.alumnos') }}?idCurso={{$idCurso}}&idHorario={{$h->ID_HORARIO}}">
          <div class="x_content bs-example-popovers courseContainer">
            <div class="courseButton alert alert-success alert-dismissible fade in" role="alert">
              <button type="button" class="closeHorario close" data-dismiss="alert" aria-label="Close" codigoHorario="{{$h->ID_HORARIO}}" nombreHorario="{{$h->NOMBRE_HORARIO}}"><span aria-hidden="true">×</span>

              </button>
              <p class="pText">{{$h->NOMBRE_HORARIO}} - {{$h->NOMBRE_PROFESOR}}</p>
            </div>
          </div>
        </a>

        @endif
        @endforeach
      </div>
    </div>  
    @endif
  </div>


  @if($codCurso!=null)
  <div class="row">
    <div class=" x_panel tile coursesBox">
      <div class="row">
        <div class="col-xs-12">
          <h1 class="secondaryTitle mainTitle">Resultados del Estudiantes / Indicadores de Desempeño</h1>
        </div>
      </div>
    </div>
    
    <!-- Boton  -->
    <div class="row" style="margin-left: 0px; margin-right: 0px">
      <div id="btnAgregarResultado"  class="x_content bs-example-popovers courseContainer"  style="cursor:pointer">
        <div class="addCourseButton alert alert-success alert-dismissible fade in" role="alert">
          <button type="button" id="btnAgregarResultado" class="close" aria-label="Close"><span aria-hidden="true">+</span>
          </button>
          <p class="pText"> Elección de Resultados e indicadores</p>
        </div>
      </div>
    </div>
    <!-- Resultados e indicadores -->
    <div class="row" style="margin-left: 0px; margin-right: 0px">
      <!-- start accordion -->
      <div class="accordion" id="accordion" role="tablist" aria-multiselectable="true">
        @php ($nres = 0)
        @foreach($resultados as $resultado)
        @php ($nres = $nres + 1 )
        <div class="panel">
          <a class="panel-heading collapsed" role="tab" id="heading{{$nres}}" data-toggle="collapse" data-parent="#accordion" href="#collapse{{$nres}}" aria-expanded="false" aria-controls="collapse{{$nres}}">
            <h4 class="panel-title">Resultado {{$resultado->NOMBRE}}</h4>
          </a>
          <div id="collapse{{$nres}}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading{{$nres}}" aria-expanded="false" style="height: 0px;">
            <div class="panel-body">
              <div class="" role="tabpanel" data-example-id="togglable-tabs">
                <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                  @php ($countId = 0)
                  @php ($count = 0)
                  @foreach($indicadores as $indicador)
                  @php ($countId = $countId + 1 )
                  @if($resultado->ID_RESULTADO==$indicador->ID_RESULTADO)
                  @php ($count = $count + 1 )
                  <li role="presentation" class=""><a href="#tab_content{{$countId}}" id="home-tab" role="tab" data-toggle="tab" aria-expanded="false">Indicador {{$resultado->NOMBRE}}{{$count}}</a>
                  </li>
                  @endif
                  @endforeach
                </ul>
                <div id="myTabContent" class="tab-content">
                  @php ($count = 0)
                  @php ($countId = 0)
                  @foreach($indicadores as $indicador)
                  @php ($countId = $countId + 1 )
                  @if($resultado->ID_RESULTADO==$indicador->ID_RESULTADO)
                  @php ($count = $count + 1 )
                  <div role="tabpanel" class="tab-pane fade" id="tab_content{{$countId}}" aria-labelledby="home-tab">
                    <p>{{$indicador->NOMBRE}}</p>
                  </div>
                  @endif
                  @endforeach
                </div>
              </div>
            </div>
          </div>
        </div>
        @endforeach
        <!-- Terminan los acordion -->
      </div>
    </div>
    <!-- asdasd-->

    
    <div class="modal fade bs-example-modal-lg text-center" role="dialog" tabindex="-1"
    id="modalResultados" data-keyboard="false" data-backdrop="static"
    aria-labelledby="gdridfrmnuavaUO" data-focus-on="input:first">
    <div class="customModal modal-dialog modal-lg" style="width: 400px; height: 300px" >
     <div class="modal-content" style="top: 40%">
      <div class="modal-header" style="padding-left: 0px; padding-right: 0px">
       <button type="button" class="close" data-dismiss="modal"
       aria-label="Close" style="padding-right: 10px">
       <span aria-hidden="true">&times;</span>
     </button>

     <h1 class="reportsTitle mainTitle">Lista de Resultados e Indicadores</h1>
   </div>
   <div class="modal-body" style="padding-top: 0px; padding-left: 20px; padding-right: 20px; padding-bottom: 20px">

    <!--<div id="tree">

    </div>-->

    

     <div id="treeview-checkable" class="treeview">
        <ul class="list-group">
          <li class="list-group-item node-treeview-checkable search-result" data-nodeid="0" style="color:#D9534F;background-color:undefined;">
            <span class="icon expand-icon glyphicon glyphicon-minus"></span>
            <span class="icon check-icon glyphicon glyphicon-unchecked"></span>Parent 1</li>
          
          <li class="list-group-item node-treeview-checkable node-checked" data-nodeid="1" style="color:undefined;background-color:undefined;"><span class="indent"></span>
              <span class="icon expand-icon glyphicon glyphicon-plus"></span>
              <span class="icon check-icon glyphicon glyphicon-unchecked"></span>Child 1</li>

          <li class="list-group-item node-treeview-checkable node-checked" data-nodeid="4" style="color:undefined;background-color:undefined;"><span class="indent"></span>
             <span class="icon glyphicon"></span>
             <span class="icon check-icon glyphicon glyphicon-checuncheckedk"></span>Child 2</li>

          <li class="list-group-item node-treeview-checkable" data-nodeid="5" style="color:undefined;background-color:undefined;"><span class="icon glyphicon"></span>
            <span class="icon check-icon glyphicon glyphicon-unchecked"></span>Parent 2</li>

          <li class="list-group-item node-treeview-checkable" data-nodeid="6" style="color:undefined;background-color:undefined;"><span class="icon glyphicon"></span>
             <span class="icon check-icon glyphicon glyphicon-unchecked"></span>Parent 3</li>

          <li class="list-group-item node-treeview-checkable" data-nodeid="7" style="color:undefined;background-color:undefined;"><span class="icon glyphicon"></span>
            <span class="icon check-icon glyphicon glyphicon-unchecked"></span>Parent 4</li>

          <li class="list-group-item node-treeview-checkable" data-nodeid="8" style="color:undefined;background-color:undefined;"><span class="icon glyphicon"></span>
            <span class="icon check-icon glyphicon glyphicon-unchecked"></span>Parent 5</li>
          </ul>
  
                  </div>

    

  </div>
</div>
</div>
<!-- /.modal-content -->
<!-- /.modal-dialog -->

<!--<div class="row" style="margin-bottom: 30px">-->

      <!--<div class="col-md-3 pText">
        Holi
      </div>
      
      <div class="col-md-8">
        <div class="btn-group btn-group-justified" data-toggle="buttons" >
          <label class="btn btn-primary" style="background-color: #00626E; border-color: #004d54">
            <input type="radio" class="sr-only" id="viewMode1" name="viewMode" value="1">
            <span class="docs-tooltip" data-toggle="tooltip" title="View Mode 1">

            </span>
          </label>

          </label>
        </div>
      </div>
      <div class="col-md-1">
        <label codigoCriterio="asdasdasd" nombreCriterio="dsdasd" class=" btn btn-primary" style="background-color: #00626E; border-color: #004d54">
          <input type="radio" class="sr-only" id="viewMode1" name="viewMode" value="1">
          <span class="docs-tooltip" data-toggle="tooltip" title="View Mode 1">
              +
           </span>
        </label>
      </div> -->

      <!--</div>-->

    </div>
  </div>

  @endif
  <a href="{{route('cursos.gestion')}}" class="pText"><i class="fa fa-arrow-circle-left" aria-hidden="true"></i> Retornar a la gestión de cursos</a>


</div>

<!-- Modal de Cargar Alumnos y Horarios -->

<div id="modalCargar" class="modal fade bs-example-modal-lg text-center" role="dialog" tabindex="-1"  data-keyboard="false" data-backdrop="static" aria-labelledby="gdridfrmnuavaUO" data-focus-on="input:first" >
  <div class="customModal modal-dialog modal-lg ">
    <div class="modal-content" style="top: 30% !important;">
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
          <p class="pText">Arrastra y suelta un archivo <br> o <br> <span style="text-decoration: underline"> Carga un archivo desde documentos </span></p>
        </div>

        <div style="padding-top: 10px; padding-bottom: 10px">
          <button id="btnCargarCursosModal" class="btn btn-success pText customButtonThin" >Cargar</button>
          <button id="btnCargarHorariosModal" class="btn btn-success pText customButtonThin" >Cargar</button> 
          <button id="btnCargarAlumnosModal" class="btn btn-success pText customButtonThin" >Cargar</button>
          <button id="btnCancelarModal" class="btn btn-success pText customButtonThin">Cancelar</button>
        </div>

      </div>
    </div>
  </div>
  <!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->
</div>
<!-- /.modal -->


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
    <h4 class="reportsTitle mainTitle modal-title" id="gridSystemModalLabel">Seleccionar Horarios</h4>
  </div>
  <div class="modal-body">
    <div class="container-fluid">
      <h6 class="reportsTitle mainTitle modal-title">{{$codCurso}} {{$nombreCurso}}</h6>
      <form id="frmCursosModal">
        <div class="table-responsive">
          <table class="table table-striped jambo_table bulk_action">
            <thead >
              <tr class="headings" style="background-color: #005b7f; color: white; font-family: Segoe UI">
                <th class="pText column-title" style="border: none"></th>
                <th class="pText column-title" style="border: none">Horario</th>
                <th class="pText column-title" style="border: none">Profesor</th>
                <th class="pText bulk-actions" colspan="7">
                  <a class="antoo" style="color:#fff; font-weight:500;">Bulk Actions ( <span class="action-cnt"> </span> ) <i class="fa fa-chevron-down"></i></a>
                </th>
              </tr>
            </thead>
            @foreach($horarios as $horario)
            <tbody class="text-left">
              <tr class="even pointer">
                <td class="a-center"  style="background-color: white; padding-right: 0px">
                 <div class="form-check" style="padding-left: 10px; width: 20px">
                  <label>
                    <input value="{{$horario->ID_HORARIO}}" class="get_value" type="checkbox" @if($horario->ESTADO===1) checked=checked @endif> <span class="pText label-text "></span>
                  </label>
                </div>
              </td>
              <td class="pText" style="background-color: white; padding-top: 12px; color: #72777a;">{{$horario->NOMBRE_HORARIO}}</td>
              <td class="pText" style="background-color: white; padding-top: 12px; color: #72777a">{{$horario->NOMBRE_PROFESOR}}</td>
            </td>
            @endforeach
          </tr>
        </tbody>
      </table>

    </div> 
  </form>
  <div class="modal-footer footerButtons" style="padding-right: 0px; padding-left: 5px;">
    <button id="btnActualizarHorarios" class="btn btn-success pText customButton">Actualizar</button>
    <button id="btnCancelarHorarios" class="btn btn-success pText customButton">Cancelar</button> 
  </div>

</div>
</div>
</div>
<!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->
</div>
<!-- /.modal -->



<!-- Modal para Agregar SUbcriterios-->
<div class="modal fade bs-example-modal-lg" role="dialog" tabindex="-1"
id="modalAgregarSubcriterio" data-keyboard="false" data-backdrop="static"

aria-labelledby="gdridfrmnuavaUO" data-focus-on="input:first">
<div class="modal-dialog modal-lg" style="width: 400px;">
  <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal"
      aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>

    <h4 class="reportsTitle mainTitle modal-title" id="gridSystemModalLabel">Seleccionar Horarios</h4>
  </div>
  <div class="modal-body">
    <div class="container-fluid">
      <h6 class="reportsTitle mainTitle modal-title">{{$codCurso}} {{$nombreCurso}}</h6>
      <form id="frmCursosModal">
        <div class="table-responsive">
          <table class="table table-striped jambo_table bulk_action">
            <thead >
              <tr class="headings" style="background-color: #005b7f; color: white; font-family: Segoe UI">
                <th class="pText column-title" style="border: none"></th>
                <th class="pText column-title" style="border: none">Horario</th>
                <th class="pText column-title" style="border: none">Profesor</th>
                <th class="pText bulk-actions" colspan="7">
                  <a class="antoo" style="color:#fff; font-weight:500;">Bulk Actions ( <span class="action-cnt"> </span> ) <i class="fa fa-chevron-down"></i></a>
                </th>
              </tr>
            </thead>

            @foreach($horarios as $horario)
            <tbody class="text-left">
              <tr class="even pointer">
                <td class="a-center"  style="background-color: white; padding-right: 0px">
                 <div class="form-check" style="padding-left: 10px; width: 20px">
                  <label>
                    <input value="{{$horario->ID_HORARIO}}" type="checkbox" @if($horario->ESTADO===1) checked=checked @endif> <span class="pText label-text "></span>
                  </label>
                </div>
              </td>
              <td class="pText" style="background-color: white; padding-top: 12px; color: #72777a;">{{$horario->NOMBRE_HORARIO}}</td>
              <td class="pText" style="background-color: white; padding-top: 12px; color: #72777a">{{$horario->NOMBRE_PROFESOR}}</td>
            </td>
            @endforeach
          </tr>
        </tbody>
      </table>
    </div> 
  </form>
  <div class="modal-footer footerButtons" style="padding-right: 0px; padding-left: 5px;">
    <button id="btnActualizarHorarios" class="btn btn-success pText customButton">Actualizar</button>
    <button id="btnCancelarHorarios" class="btn btn-success pText customButton">Cancelar</button> 
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