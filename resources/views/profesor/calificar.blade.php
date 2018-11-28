@extends('Layouts.layout')
@section('pageTitle', 'Calificar Alumnos')
@section('content')
@section('js-libs')
<script type="text/javascript"  src="{{ URL::asset('js/cursos/cursosjs.js') }}"></script>
@stop


<?php
  $modoProfesor=Auth::user()->ID_ROL==App\Entity\Usuario::ROL_PROFESOR?true:false;
?>

<div class="customBody">

  @if($modoProfesor)
  <input type="text" id="ultimoAviso" value="<?php 
  $desc='';
  if($ultimoAviso!=NULL) 
  foreach ($ultimoAviso as $a) {
    $desc = $a->DESCRIPCION. '-' . $desc;
  }
  echo ($desc);
  ?>" hidden>
  @endif
  <div class="row">
    <div class="col-md-8 col-sm-6">
      <h1 class="mainTitle"> Seleccione horario a calificar</h1>
    </div>

    <div class="col-md-4 col-sm-6 form-group top_search" >
      <div class="input-group">
        <input id="busquedaCurso" type="text" class="form-control searchText" placeholder="Curso...">
        <span class="input-group-btn">
          <button class="btn btn-default searchButton" type="button">Buscar</button>
        </span>
      </div>
    </div>
  </div>
  @include('flash::message')
  <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="x_panel" style="background-color: #5281a8">
        <h2 style="color: white">Progreso Total</h2>
        <div class="col-lg-1 col-md-2 col-xs-12" >
          <p style="color: white" class="pText" style="margin-bottom: 0px">Cursos</p>
        </div>
        <div class="col-lg-9 col-md-7 col-sm-9 col-xs-7" style="padding-bottom: 0">
          <div class="widget_summary" >
            <div class="w_center w_55" style="width: 100%">
              <div class="progress" style="margin-bottom: 0px">
                <div class="progress-bar bg-green" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="100%; background-color: #005b7f !important; border: none !important">
                  <span class="sr-only">60% Complete</span>
                </div>
              </div>
            </div>
          </div>
          <div class="no-padding">
            @if (4 > 0)
            <p style="color: white" class="barText pText">4% de avance - 4/10 cursos calificados</p>
            @endif
            @if (10 == 0)
            <p style="color: white" class="barText pText">No hay cursos cargados</p>
            @endif
          </div>

        </div>
      </div>
    </div>
    @foreach($cursos as $c)
    @if(count($c["horarios"])>0)


    <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="x_panel">
        <div class="x_title">
          <h2>{{$c["curso"]->NOMBRE}}</h2>
          <ul class="nav navbar-right panel_toolbox">
            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
            </li>
          </ul>
          <div class="clearfix"></div>
        </div>
        <div class="x_content" style="display: block;">
          @foreach($c["horarios"] as $h)

          <div class="row">

            <div class="col-lg-1 col-md-2 col-xs-12" >
              <p class="pText" style="margin-bottom: 0px">H-{{$h["horario"]->NOMBRE}}</p>
            </div>
            <div class="col-lg-9 col-md-7 col-sm-9 col-xs-7" style="padding-bottom: 0">
              <div class="widget_summary" >
                <div class="w_center w_55" style="width: 100%">
                  <div class="progress" style="margin-bottom: 0px">
                    <div class="progress-bar bg-green" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: {{ $h["avance"]  }}%; background-color: #005b7f !important; border: none !important">
                      <span class="sr-only">60% Complete</span>
                    </div>
                  </div>
                </div>
              </div>
              <div class="no-padding">
                @if ($h["alumnosTotal"] > 0)
                <p class="barText pText">{{ $h["avance"] }}% de avance -  {{ $h["alumnosCalif"] }}/{{ $h["alumnosTotal"] }} alumnos calificados</p>
                @endif
                @if ($h["alumnosTotal"] == 0)
                <p class="barText pText">No hay alumnos cargados</p>
                @endif
              </div>
            </div>
            <div class="col-lg-2 col-md-3 col-sm-3 col-xs-5 text-right">
              @if($h["alumnosTotal"] == 0)
              <a href="#" data-target="modalCargarAlumnos" data-toggle="modal" >
                <button type="button" class="btn btn-success btn-lg pText customButton btnCargarAlumnos2"
                data-id = "{{$h["horario"]->ID_HORARIO}}" 
                data-horario ="{{$h["horario"]->NOMBRE}}"
                > Cargar Alumnos</button>
              </a>
              <!--
              <button type="button" class="btn btn-success btn-lg pText customButton btnCargarAlumnos2">Cargar Alumnos</button>
            -->
            @endif
            @if($h["alumnosTotal"] != 0)
            <a href="{{route('profesor.alumnos')}}?idCurso={{$c['curso']->ID_CURSO}}&idHorario={{$h['horario']->ID_HORARIO}}&vistaProc=calificar">
              <button type="button" class="btn btn-success btn-lg pText customButton">Calificar</button>
            </a>
            @endif
          </div>
        </div>

        @endforeach




      </div>
    </div>
  </div>
  @endif
  @endforeach
  





</div>

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
          <form id="upload_form" action = "{{url('/subir-excels/uploadAlumnos')}}"
          method = "post" enctype = "multipart/form-data">
          {{csrf_field()}}
          <div class = "form-group">
            <input type = "file" name = "upload-file" class="form-control image" style="border-color: white">
          </div>
          <div class="row" style="padding-top: 20px; text-align: center; display: flex;justify-content: center;">
            <div class="col-md-4">
              <input id="bookId" name="codigoHorario" type="hidden">
              <input id="horario" name="horario" type="hidden">
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



@stop

@section('js-scripts')
<script type="text/javascript">
  //PNotify
  $( document ).ready(function() {
    var variableText=$('#ultimoAviso').val();
    var avisos = variableText.split('-');

    for (i = 0; i < avisos.length; i++) {
          console.log(avisos[i]);
    if (avisos[i]!=''){(new PNotify({
      title: 'Aviso',
      text: avisos[i],
      hide: true,
      sticker: false,
      nonblock: {
        nonblock: true
      },
      styling: 'bootstrap3',
      addclass: 'pnotify-center' //dark
    }));}
    }
  });
</script>

@stop