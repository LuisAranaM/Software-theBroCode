<!-- Required Stylesheets -->
<!--<link href="public/css/bootstrap.css" rel="stylesheet">-->
@extends('Layouts.layout')

@section('js-libs')
<!-- Required Javascript -->
<script type="text/javascript"  src="{{ URL::asset('js/horarios/horarios.js') }}"></script>

@stop

@section('pageTitle', 'Horarios y Criterios')
@section('content')
<div id="idCurso" data-field-id="{{$idCurso}}" ></div>
<div id="nombreCurso" data-field-id="{{$nombreCurso}}" ></div>
<div id="codCurso" data-field-id="{{$codCurso}}" ></div>

<div class="customBody">
  <div class="row">
    <div class="col-md-8 col-sm-6">
      @if($codCurso===null)
      <h1 class="mainTitle" ><a href="{{route('cursos.gestion')}}"> Gestionar Cursos </a> > Horarios y Criterios</h1>
      @else
      <h1 class="mainTitle" ><a href="{{route('cursos.gestion')}}"> Gestionar Cursos </a> > <a href=""> {{$codCurso}} - {{$nombreCurso}}</a></h1>
      @endif
    </div>
  </div>
@include('flash::message')
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
            <a href="#" data-target="modalCargarAlumnos" data-toggle="modal" >
              <button type="button" class="btn btn-success btn-lg pText customButton btnCargarAlumnos2"
               data-curso = "{{ $codCurso }}" 
               > Cargar Alumnos</button>
            </a>
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
        <a class="" href="{{ route('profesor.alumnos') }}?idCurso={{$idCurso}}&idHorario={{$h->ID_HORARIO}}&vistaProc=horarios">
          <div class="x_content bs-example-popovers courseContainer">
            <div class="courseButton alert alert-success alert-dismissible fade in" role="alert">
              <button type="button" class="closeHorario close" data-dismiss="alert" aria-label="Close" idHorario="{{$h->ID_HORARIO}}" nombreHorario="{{$h->NOMBRE_HORARIO}}"><span aria-hidden="true">×</span>

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
  @php ($idInd = array())
  @php ($idRes = array())
  @php ($i = 0)
  @foreach($indicadores as $indicador)
  @php ($idInd[$i] = $indicador->ID_INDICADOR)
  @php ($idRes[$i] = $indicador->ID_RESULTADO)
  @php ($i = $i + 1)
  @endforeach

  @if($codCurso!=null)
  <div class="row">
    <div class=" x_panel tile coursesBox">
      <div class="row">
        <div class="col-xs-12">
          <h1 class="secondaryTitle mainTitle">Resultados del Estudiantes / Indicadores de Desempeño</h1>
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
          @if(in_array($resultado->ID_RESULTADO, $idRes))
          @php ($flagfirst = 1)
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
                    @foreach($indicadores as $indicador)
                    @php ($countId = $countId + 1)
                    @if($resultado->ID_RESULTADO==$indicador->ID_RESULTADO)
                    <li role="presentation" class=""><a href="#tab_content{{$countId}}" class="primero{{$flagfirst}}" id="home-tab" role="tab" data-toggle="tab" aria-expanded="false">Indicador {{$resultado->NOMBRE}}{{$indicador->VALORIZACION}}</a>
                    </li>
                    @php ($flagfirst = 0 )
                    @endif
                    @endforeach
                  </ul>
                  <div id="myTabContent" class="tab-content">
                    @php ($countId = 0)
                    @foreach($indicadores as $indicador)
                    @php ($countId = $countId + 1 )
                    @if($resultado->ID_RESULTADO==$indicador->ID_RESULTADO)
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
          @endif
          @endforeach
          <!-- Terminan los acordion -->
        </div>
      </div>
      <!-- asdasd-->


      <!-- MODAL PARA AGREGAR INDICADORES-->
      <div class="modal fade bs-example-modal-lg text-center" role="dialog" tabindex="-1"
      id="modalResultados" data-keyboard="false" data-backdrop="static"
      aria-labelledby="gdridfrmnuavaUO" data-focus-on="input:first">
      <div class="customModal modal-dialog modal-lg" style="width: 600px; height: 300px" >
       <div class="modal-content" style="top: 40%">
        <div class="modal-header" style="padding-left: 0px; padding-right: 0px">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="padding-right: 10px">
            <span aria-hidden="true">&times;</span>
          </button>
          <h1 class="reportsTitle mainTitle">Lista de Resultados e Indicadores</h1>
        </div>
        <div class="modal-body" style="padding-top: 0px; padding-left: 20px; padding-right: 20px; padding-bottom: 20px">

          <div class="accordion" id="accordionM" role="tablist" aria-multiselectable="true">
            <div class="panel">
              <div class="" role="tabpanel" data-example-id="togglable-tabs">
                <!-- tab de los resultados-->
                <ul id="myTabM" class="nav nav-tabs bar_tabs" role="tablist">
                  @php ($nres = 0)
                  @foreach($todoResultados as $resultado)
                  @php ($nres = $nres + 1 )
                  <li role="presentation" class=""><a href="#tab_contentM{{$nres}}" id="home-tabM{{$nres}}" role="tab" data-toggle="tab" aria-expanded="false">{{$resultado->NOMBRE}}</a>
                  </li>
                  @endforeach
                </ul>
                <!-- contenido de cada tab de resultados (indicadores)-->
                <div id="myTabContent" class="tab-content">
                  @php ($nres = 0)
                  @foreach($todoResultados as $resultado)
                  @php ($nres = $nres + 1 )
                  <div role="tabpanel" class="tab-pane fade" id="tab_contentM{{$nres}}" aria-labelledby="home-tabM{{$nres}}">
                    <table class="table table-striped jambo_table bulk_action">
                      <!-- checkbox para seleccionar todos-->
                      <tbody class="text-left">
                        <tr class="even pointer">
                          <td class="a-center"  style="background-color: white; padding-right: 0px">
                           <div class="form-check" style="padding-left: 10px; width: 20px">
                            <label>
                              <input class="selectAll" idResultado="{{$resultado->ID_RESULTADO}}" type="checkbox"> <span class="pText label-text "></span>
                            </label>
                          </div>
                        </td>
                        <td style="background-color: white; padding-top: 12px; color: #72777a;">Seleccionar todos</td>
                      </td>
                    </tr>
                    <!-- checkbox de cada indicador-->
                    @foreach($todoIndicadores as $indicador)
                    @if($resultado->ID_RESULTADO==$indicador->ID_RESULTADO)
                    <tr class="even pointer">
                      <td class="a-center"  style="background-color: white; padding-right: 0px">
                       <div class="form-check" style="padding-left: 10px; width: 20px">
                        <label>
                          <input type="checkbox" class="get_valor checkbox_class{{$resultado->ID_RESULTADO}}" value="{{$indicador->ID_INDICADOR}}"  @if(in_array($indicador->ID_INDICADOR, $idInd)) checked=checked @endif> <span class="pText label-text "></span>
                        </label>
                      </div>
                    </td>
                    <td class="pText" style="background-color: white; padding-top: 12px; color: #72777a;">{{$resultado->NOMBRE}}{{$indicador->VALORIZACION}}: {{$indicador->NOMBRE}}</td>
                  </td>
                </tr>
                @endif
                @endforeach
                <!-- fin checkbox de cada indicador-->
              </tbody>
              
            </table>
          </div>
          @endforeach

        </div>

      </div>
    </div>

  </div>
  <!-- Terminan los acordion -->
  <!-- botones de actualizar y cancelar -->
  <div class="modal-footer footerButtons" style="padding-right: 0px; padding-left: 5px;">
    <button id="btnActualizarIndicadores" class="btn btn-success pText customButton" idCurso="{{$idCurso}}">Actualizar</button>
    <button id="btnCancelarIndicadores" class="btn btn-success pText customButton">Cancelar</button> 
  </div>
  <!-- fin de botones de actualizar y cancelar  -->
</div>
</div>
</div>
<!-- /.modal-content -->
<!-- /.modal-dialog -->

</div>
</div>

@endif
<a href="{{route('cursos.gestion')}}" class="pText"><i class="fa fa-arrow-circle-left" aria-hidden="true"></i> Retornar a la gestión de cursos</a>


</div>

<!-- Modal de Cargar Alumnos  -->

<div class="modal fade bs-example-modal-lg text-center" role="dialog" tabindex="-1"
id="modalCargarAlumnos" data-keyboard="false" data-backdrop="static"
aria-labelledby="gdridfrmnuavaUO" data-focus-on="input:first" >
<div class="customModal modal-dialog modal-lg ">
  <div class="modal-content" style="top: 30%">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal"
      aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
    <h4 id="CargarAlumnos" class="reportsTitle mainTitle modal-title" style="padding-top: 10px" id="gridSystemModalLabel">Cargar Alumnos</h4>
  </div>
  <hr style="padding: 0px; margin-top: 0px; margin-bottom: 0px; width: 80%">
  <div class="modal-body">
    <div class="container-fluid text-center">
      <div class="dropzone" style="min-height: 100px; height: 190px; width: 350px; border: 2px dashed #ccc; display: inline-block; background-color: white; margin-top: 10px; margin-bottom: 10px">
        <i class="fa fa-5x fa-cloud-upload" style="color: #ccc; height: 100px; padding: 10px"></i>
        <p class="pText">Arrastra y suelta un archivo <br> o <br> 
          <form id="upload_form" action = "{{url('/subir-excels/uploadAlumnosDeCurso')}}"
          method = "post" enctype = "multipart/form-data">
            {{csrf_field()}}
            <div class = "form-group">
              <input type = "file" name = "upload-file" class="form-control image" style="border-color: white">
            </div>
            <div class="row" style="padding-top: 20px; text-align: center; display: flex;justify-content: center;">
              <div class="col-md-4">
                <input id="codCurso" name="codCurso" type="hidden">
                <input id="btnCargarAlumnosModal" class = "btn btn-success pText customButtonThin upload-file" 
                style="padding-right: 5px; padding-left: 5px;" type="submit" value = "Cargar" name="submit">
              </div>
              <div class="col-md-4">
                <button type="reset" id="btnCancelarModalAlumnos" class="btn btn-success pText customButtonThin" style="padding-right: 5px; padding-left: 5px;">Cancelar</button>
              </div>

            </div>
            
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
        <div class="table-responsive" >
          <table class="table table-striped jambo_table bulk_action" style="margin-bottom: 0px">
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
  <div class="text-center modal-footer" style="padding-right: 0px; padding-left: 0px; border-color: transparent">
    <div class="row" style="padding-top: 5px; text-align: center; display: flex;justify-content: center;">
      <div class="col-md-4">
        <button id="btnActualizarHorarios" class="btn btn-success pText customButtonThin">Actualizar</button>
      </div>
      <div class="col-md-4">
        <button id="btnCancelarHorarios" class="btn btn-success pText customButtonThin">Cancelar</button> 
      </div>
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



@stop

@section('js-scripts')


@stop