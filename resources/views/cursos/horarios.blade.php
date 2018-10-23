@extends('Layouts.layout')

@section('js-libs')
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

        <div class="addCourseButton alert alert-success alert-dismissible fade in" role="alert">

          <button id="btnAgregarHorario" type="button" class="close" aria-label="Close"><span aria-hidden="true">+</span>
          </button>
          <p class="pText"> Agregar Nuevo Horario </p>
        </div>
      </div>
      <div id="listHorarios">
        @foreach($horario as $h)
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

      <!--Criterio 1-->
      <div class="row">
        <div class="x_content bs-example-popovers courseContainer">

          <div class="addCourseButton alert alert-success alert-dismissible fade in" role="alert">

            <button id="btnAgregarResultado" type="button" class="close" aria-label="Close"><span aria-hidden="true">+</span>
            </button>
            <p class="pText"> Agregar Nuevo Horario </p>
          </div>
        </div>
      </div>
      <!-- Holi -->
      <div class="row">
        <!-- start accordion -->
        <div class="accordion" id="accordion" role="tablist" aria-multiselectable="true">
          <div class="panel">
            <a class="panel-heading collapsed" role="tab" id="headingOne" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
              <h4 class="panel-title">Collapsible Group Items #1</h4>
            </a>
            <div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne" aria-expanded="false" style="height: 0px;">
              <div class="panel-body">
                <div class="" role="tabpanel" data-example-id="togglable-tabs">
                  <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                    <li role="presentation" class=""><a href="#tab_content1" id="home-tab" role="tab" data-toggle="tab" aria-expanded="false">Home</a>
                    </li>
                    <li role="presentation" class=""><a href="#tab_content2" role="tab" id="profile-tab" data-toggle="tab" aria-expanded="false">Profile</a>
                    </li>
                    <li role="presentation" class="active"><a href="#tab_content3" role="tab" id="profile-tab2" data-toggle="tab" aria-expanded="true">Profile</a>
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
                    <div role="tabpanel" class="tab-pane fade active in" id="tab_content3" aria-labelledby="profile-tab">
                      <p>xxFood truck fixie locavore, accusamus mcsweeney's marfa nulla single-origin coffee squid. Exercitation +1 labore velit, blog sartorial PBR leggings next level wes anderson artisan four loko farm-to-table craft beer twee. Qui photo
                      booth letterpress, commodo enim craft beer mlkshk </p>
                    </div>
                  </div>
                </div>

              </div>
            </div>
          </div>
          <div class="panel">
            <a class="panel-heading collapsed" role="tab" id="headingTwo" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
              <h4 class="panel-title">Collapsible Group Items #2</h4>
            </a>
            <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo" aria-expanded="false" style="height: 0px;">
              <div class="panel-body">
                <div class="" role="tabpanel" data-example-id="togglable-tabs">
                  <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                    <li role="presentation" class=""><a href="#tab_content1" id="home-tab" role="tab" data-toggle="tab" aria-expanded="false">Home</a>
                    </li>
                    <li role="presentation" class=""><a href="#tab_content2" role="tab" id="profile-tab" data-toggle="tab" aria-expanded="false">Profile</a>
                    </li>
                    <li role="presentation" class="active"><a href="#tab_content3" role="tab" id="profile-tab2" data-toggle="tab" aria-expanded="true">Profile</a>
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
                    <div role="tabpanel" class="tab-pane fade active in" id="tab_content3" aria-labelledby="profile-tab">
                      <p>xxFood truck fixie locavore, accusamus mcsweeney's marfa nulla single-origin coffee squid. Exercitation +1 labore velit, blog sartorial PBR leggings next level wes anderson artisan four loko farm-to-table craft beer twee. Qui photo
                      booth letterpress, commodo enim craft beer mlkshk </p>
                    </div>
                  </div>
                </div>

              </div>
            </div>
          </div>
          <div class="panel">
            <a class="panel-heading collapsed" role="tab" id="headingThree" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
              <h4 class="panel-title">Collapsible Group Items #3</h4>
            </a>
            <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree" aria-expanded="false" style="height: 0px;">
              <div class="panel-body">
                <div class="" role="tabpanel" data-example-id="togglable-tabs">
                  <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                    <li role="presentation" class=""><a href="#tab_content1" id="home-tab" role="tab" data-toggle="tab" aria-expanded="false">Home</a>
                    </li>
                    <li role="presentation" class=""><a href="#tab_content2" role="tab" id="profile-tab" data-toggle="tab" aria-expanded="false">Profile</a>
                    </li>
                    <li role="presentation" class="active"><a href="#tab_content3" role="tab" id="profile-tab2" data-toggle="tab" aria-expanded="true">Profile</a>
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
                    <div role="tabpanel" class="tab-pane fade active in" id="tab_content3" aria-labelledby="profile-tab">
                      <p>xxFood truck fixie locavore, accusamus mcsweeney's marfa nulla single-origin coffee squid. Exercitation +1 labore velit, blog sartorial PBR leggings next level wes anderson artisan four loko farm-to-table craft beer twee. Qui photo
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

      <!-- inicio Modal agregar resultados/indicadores por curso-->
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
     </div>
     <div class="modal-body" style="padding-top: 0px; padding-left: 20px; padding-right: 20px; padding-bottom: 20px">
      
      <div class="container">
<div class="row">

<ul class="checktree">
        <li>
        <input id="administration" type="checkbox" /><label for="administration">Administration</label>
        <ul>
          <li>
            <input id="president" type="checkbox" /><label for="president">President</label>
            <ul>
              <li>
                <input id="manager1" type="checkbox" /><label for="manager1">Manager 1</label>
                <ul>
                  <li><input id="assistantmanager1" type="checkbox" /><label for="assistantmanager1">Assistant Manager 1</label></li>
                  <li><input id="assistantmanager2" type="checkbox" /><label for="assistantmanager2">Assistant Manager 2</label></li>
                  <li><input id="assistantmanager3" type="checkbox" /><label for="assistantmanager3">Assistant Manager 3</label></li>
                </ul>
              </li>
              <li><input id="manager2" type="checkbox" /><label for="manager2">Manager 2</label></li>
              <li><input id="manager3" type="checkbox" /><label for="manager3">Manager 3</label></li>
            </ul>
          </li>
          <li>
            <input id="vicepresident" type="checkbox" /><label for="vicepresident">Vice President</label>
            <ul>
              <li><input id="manager4" type="checkbox" /><label for="manager4">Manager 4</label></li>
              <li><input id="manager5" type="checkbox" /><label for="manager5">Manager 5</label></li>
              <li><input id="manager6" type="checkbox" /><label for="manager6">Manager 6</label></li>
            </ul>
          </li>
        </ul>
      </li>
    </ul>

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
            @foreach($horario as $h)
            <tbody class="text-left">
              <tr class="even pointer">
                <td class="a-center"  style="background-color: white; padding-right: 0px">
                 <div class="form-check" style="padding-left: 10px; width: 20px">
                  <label>
                    <input value="{{$h->ID_HORARIO}}" class="get_value" type="checkbox" @if($h->ESTADO===1) checked=checked @endif> <span class="pText label-text "></span>
                  </label>
                </div>
              </td>
              <td class="pText" style="background-color: white; padding-top: 12px; color: #72777a;">{{$h->NOMBRE_HORARIO}}</td>
              <td class="pText" style="background-color: white; padding-top: 12px; color: #72777a">{{$h->NOMBRE_PROFESOR}}</td>
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

            @foreach($horario as $h)
            <tbody class="text-left">
              <tr class="even pointer">
                <td class="a-center"  style="background-color: white; padding-right: 0px">
                 <div class="form-check" style="padding-left: 10px; width: 20px">
                  <label>
                    <input value="{{$h->ID_HORARIO}}" type="checkbox" @if($h->ESTADO===1) checked=checked @endif> <span class="pText label-text "></span>
                  </label>
                </div>
              </td>
              <td class="pText" style="background-color: white; padding-top: 12px; color: #72777a;">{{$h->NOMBRE_HORARIO}}</td>
              <td class="pText" style="background-color: white; padding-top: 12px; color: #72777a">{{$h->NOMBRE_PROFESOR}}</td>
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