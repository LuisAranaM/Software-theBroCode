@extends('Layouts.layout')

@section('js-libs')
<!-- Required Javascript -->

<!--<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.3/Chart.min.js"></script>-->
<script type="text/javascript"  src="{{ URL::asset('js/reportes/Chart.min.js') }}"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.4/jspdf.min.js"></script>
<script type="text/javascript"  src="{{ URL::asset('js/reportes/reportes.js') }}"></script>
@stop

@section('pageTitle', 'Principal')

@section('content')
<div class="customBody">

  <div class="col-md-8 col-sm-6">
    <h1 class="mainTitle"> Reportes </h1>
  </div>

  <!-- Inicio de Reportes -->
  @include('flash::message')
  <div class="row">
    <!-- Seccion 1: Resultados x Ciclo -->
    <div class="col-md-6">
      <div class=" x_panel tile coursesBox">
        <div class="row">
          <div class="col-xs-6">
            <img class= "imageBox" src= "{{ URL::asset('img/report1.PNG') }}" >
          </div>
          <div class="col-xs-6 text-center">
            <h1 class="reportsTitle mainTitle">Resultados x Ciclo </h1>
            <div class="row"><!--
              <div class="groupBoxOptions">
                <div class="form-check">
                  <label>
                    <input type="checkbox" checked=""> <span class="pText label-text ">Comparar con semestre anterior</span>
                  </label>
                </div>
              </div>-->
              <div class="row" style="padding-bottom: 20px; padding-top: 20px;">

                <button id="btnGraficoRxC" type="button" class="btn btn-success btn-lg pText customButton" style="width: 120px">Generar Gráfico  </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Seccion 2: Resultados x Curso-->
    <div class="col-md-6">
      <div class=" x_panel tile coursesBox">
        <div class="row">
          <div class="col-xs-6">
            <img class= "imageBox" src= "{{ URL::asset('img/report1.PNG') }}" >
          </div>
          <div class="col-xs-6 text-center">
            <h1 class="reportsTitle mainTitle"> Resultados x Curso </h1>
            <div class="row"><!--
              <div class="groupBoxOptions">
                <div class="form-check">
                  <label>
                    <input type="checkbox" checked=""> <span class="pText label-text">Comparar con semestre anterior</span>
                  </label>
                </div>
              </div>-->
              <div class="row" style="padding-bottom: 20px; padding-top: 20px;">

                <button id="btnGraficoResultadosCurso" type="button" class="btn btn-success btn-lg pText customButton" style="width: 120px">Generar Gráfico  </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="row">
    <!-- Seccion 3: Indicadores x Resultado -->
    <div class="col-md-6">
      <div class=" x_panel tile coursesBox">
        <div class="row">
          <div class="col-xs-6">
            <img class= "imageBox" src= "{{ URL::asset('img/report1.PNG') }}" >
          </div>
          <div class="col-xs-6 text-center">
            <h1 class="reportsTitle mainTitle">Cursos x Resultado </h1>
            <div class="row" style="padding-bottom: 20px; padding-top: 20px;">
              <button id="btnGraficoIndicadoresResultado" type="button" class="btn btn-success btn-lg pText customButton" style="width: 120px">Generar Gráfico  </button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Seccion 4: Consolidado historico -->
    <div class="col-md-6">
      <div class=" x_panel tile coursesBox">
        <div class="row">
          <div class="col-xs-6">
            <img class= "imageBox" src= "{{ URL::asset('img/report1.PNG') }}" >
          </div>
          <div class="col-xs-6 text-center">
            <h1 class="reportsTitle mainTitle">Consolidado Histórico </h1>
            <div class="row" style="padding-bottom: 20px; padding-top: 20px;">
              <button id="btnGraficoConsolidado" type="button" class="btn btn-success btn-lg pText customButton" style="width: 120px">Generar Gráfico  </button>
            </div>
          </div>
        </div>
      </div>
    </div>


  </div>
</div>

<!-- Modales -->

<!-- ******* 1. Modal Resultados x Ciclo ******* -->
<div id = "modalRxC" class="modal fade bs-example-modal-lg text-center" role="dialog" tabindex="-1"
id="modalCursos" data-keyboard="false" data-backdrop="static"
aria-labelledby="gdridfrmnuavaUO" data-focus-on="input:first">
<div class="modal-dialog modal-lg" style="width: 600px;">

  <!-- Contenido del modal -->
  <div class="modal-content">
    <!-- Cabeza del modal -->
    <div class="modal-header">
      <i class="fa fa-home left"></i>
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
      <h4 id="gridSystemModalLabel" class="reportsTitle mainTitle modal-title" style="padding-top: 10px">Resultados en el Ciclo</h4>
    </div>
    <!-- Fin Cabeza del modal -->
    
    <hr style="padding: 0px; margin-top: 0px; margin-bottom: 0px; width: 80%">

    <!-- Combo box -->
    <form id="form" action="{{route('exportar.reporte1')}}">
      <div class="row" style="padding-top: 10px; padding-bottom: 0px; padding-right: 1px">
        <div class="col-xs-offset-8 col-xs-3">
          <select name="idSemestre" id="ciclos1" class="ciclos form-control" required>
          </select>
        </div>
      </div>
      <!-- Fin Combo box -->

      <!-- Cuerpo del modal -->
      <div class="modal-body" style="padding-top: 0px; padding-bottom: 20px; padding-left: 50px; padding-right: 50px">
        <div class="row">
          <div class="x_content">
            <canvas id="graficoResultadoxCiclo" width="400" height="400"></canvas>
          </div> 
        </div>
      </div>
      <!-- Fin Cuerpo del modal -->

      <hr style="padding: 0px; margin-top: 0px; margin-bottom: 0px; width: 80%">

      <!-- Botones inferiores del modal -->
      <div class="row" style="padding-top: 5px; padding-bottom: 10px; text-align: center; display: flex;justify-content: center;">
        <div class="col-md-4 text-left">
          <a id="btnDescargarGraficos1" class="btn btn-success pText customButtonLarge" style="padding-right: 5px; padding-left: 5px">Descargar Gráfico</a>
        </div>
        <div class="col-md-4 text-right">
          <button type="submit" id="btnDescargarReportes1" class="btn btn-success pText customButtonLarge" style="padding-right: 5px; padding-left: 5px">Descargar Reporte</button>
        </div>
      </div>
    </form>
    <!-- Fin Botones inferiores del modal -->
    
  </div>
  <!-- Fin Contenido del modal -->
</div>
</div>
<!-- Fin Modal Resultados x Ciclo-->

<!-- ******* 1.2. Modal Indicadores x Resultado ******* -->
<div id = "modalIxR" class="modal fade bs-example-modal-lg text-center" role="dialog" tabindex="-1"
id="modalCursos" data-keyboard="false" data-backdrop="static"
aria-labelledby="gdridfrmnuavaUO" data-focus-on="input:first">
<div class="modal-dialog modal-lg" style="width: 600px;">

  <!-- Contenido del modal -->
  <div class="modal-content">
    <!-- Cabeza del modal -->
    <div class="modal-header">
      <a href="#modalRxC" data-toggle="modal" data-dismiss="modal"><i id="btnAtrasIxR" class="fa fa-chevron-left left"></i></a>
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
      <h4 id="gridSystemModalLabel" class="reportsTitle mainTitle modal-title" style="padding-top: 10px">Indicadores por Resultado</h4>
    </div>
    <!-- Fin Cabeza del modal -->
    
    <hr style="padding: 0px; margin-top: 0px; margin-bottom: 0px; width: 80%">

    <form id="form" action="{{route('exportar.reporte1')}}">
      <!-- Combo box Ciclo -->
        <!-- <div class="row" style="padding-top: 10px; padding-bottom: 0px; padding-right: 1px">
          <div class="col-xs-offset-8 col-xs-3">
            <select name="idSemestre" id="ciclos3" class="ciclos form-control" required>
            </select>
          </div>
        </div> -->
        <!-- Fin Combo box -->

        <!-- Combo box Resultado -->
        <div class="row" style="padding-top: 10px; padding-bottom: 0px; padding-right: 1px">
          <div class="col-xs-offset-8 col-xs-3">
            <select id="cboResultados" class="resultados form-control" required>
            </select>
          </div>
        </div>
        <!-- Fin Combo box -->

        <!-- Cuerpo del modal -->
        <div class="modal-body" style="padding-top: 0px; padding-bottom: 20px; padding-left: 50px; padding-right: 50px">
          <div class="row">
            <div class="x_content">
              <canvas id="graficoIndicadoresxResultado" width="400" height="400"></canvas>
            </div> 
          </div>
        </div>
        <!-- Fin Cuerpo del modal -->

        <hr style="padding: 0px; margin-top: 0px; margin-bottom: 0px; width: 80%">

        <!-- Botones inferiores del modal -->
        <div class="row" style="padding-top: 5px; padding-bottom: 10px; text-align: center; display: flex;justify-content: center;">
          <div class="col-md-4 text-right">
            <a id="btnDescargarGraficos12" class="btn btn-success pText customButtonLarge" style="padding-right: 5px; padding-left: 5px">Descargar Gráfico</a>
          </div>
          <div class="col-md-4 text-left">
            <button type="submit" id="btnDescargarReportes1" class="btn btn-success pText customButtonLarge" style="padding-right: 5px; padding-left: 5px">Descargar Reporte</button>
          </div>
        </div>
        <!-- Fin Botones inferiores del modal -->
      </form>
    </div>
    <!-- Fin Contenido del modal -->
  </div>
</div>
<!-- Fin Modal Indicadores x Resultado -->

<!-- ******* 2. Modal Resultados x Curso ******* -->
<div id = "modalResultadosCurso" class="modal fade bs-example-modal-lg text-center" role="dialog" tabindex="-1"
id="modalCursos" data-keyboard="false" data-backdrop="static"
aria-labelledby="gdridfrmnuavaUO" data-focus-on="input:first">
<div class="modal-dialog modal-lg" style="width: 600px; height: 800px">

  <!-- Contenido del modal -->
  <div class="modal-content">
    <!-- Cabeza del modal -->
    <div class="modal-header">
      <i class="fa fa-home left"></i>
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
      <h4 id="gridSystemModalLabel" class="reportsTitle mainTitle modal-title" style="padding-top: 10px">Resultados por Curso</h4>
    </div>
    <!-- Fin Cabeza del modal -->
    
    <hr style="padding: 0px; margin-top: 0px; margin-bottom: 0px; width: 80%">

    <!-- Combo box -->
    <div class="row" style="padding-top: 10px; padding-bottom: 0px; padding-right: 1px">
      <div class="col-xs-offset-8 col-xs-3">
        <select id="ciclos2" class="ciclos form-control" required>
        </select>
      </div>
    </div>

    <div class="row" style="padding-top: 10px; padding-bottom: 0px; padding-right: 1px">
      <div class="col-xs-offset-8 col-xs-3">
        <select id="cursos2" class="cursos form-control" required>
        </select>
      </div>
    </div>
    <!-- Fin Combo box -->

    <!-- Cuerpo del modal -->
    <div class="modal-body" style="padding-top: 0px; padding-bottom: 20px">
      <div class="row">
        <div class="x_content">
          <canvas id="graficoResultadosxCurso" width="400" height="400"></canvas>
        </div> 

      </div>
    </div>
    <!-- Fin Cuerpo del modal -->

    <hr style="padding: 0px; margin-top: 0px; margin-bottom: 0px; width: 80%">

    <!-- Botones inferiores del modal -->
    <div class="row" style="padding-top: 5px; padding-bottom: 10px; text-align: center; display: flex;justify-content: center;">
      <div class="col-md-4 text-right">
        <a id="btnDescargarGraficos2" class="btn btn-success pText customButtonLarge" style="padding-right: 5px; padding-left: 5px">Descargar Gráfico</a>
      </div>
      <div class="col-md-4 text-left">
        <a href="{{route('exportar.reporte2')}}">
          <button id="btnDescargarReportes2" class="btn btn-success pText customButtonLarge" style="padding-right: 5px; padding-left: 5px">Descargar Reporte</button>
        </a>
      </div>
    </div>
    <!-- Fin Botones inferiores del modal -->
  </div>
  <!-- Fin Contenido del modal -->
</div>
</div>
<!-- Fin Modal Curso x Resultado -->

<!-- ******* 3. Modal Indicadores x Resultado ******* -->
<div id = "modalCxR" class="modal fade bs-example-modal-lg text-center" role="dialog" tabindex="-1"
id="modalCursos" data-keyboard="false" data-backdrop="static"
aria-labelledby="gdridfrmnuavaUO" data-focus-on="input:first">
<div class="modal-dialog modal-lg" style="width: 600px; height: 800px">

  <!-- Contenido del modal -->
  <div class="modal-content">
    <!-- Cabeza del modal -->
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
      <h4 id="gridSystemModalLabel" class="reportsTitle mainTitle modal-title" style="padding-top: 10px">Resultados en el Ciclo</h4>
    </div>
    <!-- Fin Cabeza del modal -->
    
    <hr style="padding: 0px; margin-top: 0px; margin-bottom: 0px; width: 80%">

    <!-- Combo box -->
      <div class="row" style="padding-top: 10px; padding-bottom: 0px; padding-right: 1px">
        <div class="col-xs-offset-8 col-xs-3">
          <select id="ciclos3" class="ciclos form-control" required>
          </select>
        </div>
      </div>
      <div class="row" style="padding-top: 10px; padding-bottom: 0px; padding-right: 1px">
        <div class="col-xs-offset-8 col-xs-3">
          <select id="cboResultados2" class="resultados form-control" required>
          </select>
        </div>
      </div>
      <!-- Fin Combo box -->

      <!-- Cuerpo del modal -->
      <div class="modal-body" style="padding-top: 0px; padding-bottom: 20px">
        <div class="row">
          <div class="x_content">
            <canvas id="graficoCursosxResultado" width="400" height="400"></canvas>
          </div> 
        </div>
      </div>
      <!-- Fin Cuerpo del modal -->

      <hr style="padding: 0px; margin-top: 0px; margin-bottom: 0px; width: 80%">

      <!-- Botones inferiores del modal -->
      <div class="row" style="padding-top: 5px; padding-bottom: 10px; text-align: center; display: flex;justify-content: center;">
        <div class="col-md-4 text-right">
          <button id="btnDescargarGraficos" class="btn btn-success pText customButtonLarge" style="padding-right: 5px; padding-left: 5px">Descargar Gráfico</button>
        </div>
        <div class="col-md-4 text-left">
          <a href="{{route('exportar.reporte1')}}">
            <button id="btnDescargarReportes3" class="btn btn-success pText customButtonLarge" style="padding-right: 5px; padding-left: 5px">Descargar Reporte</button>
          </a>
        </div>
      </div>
      <!-- Fin Botones inferiores del modal -->
    </div>
    <!-- Fin Contenido del modal -->
  </div>
</div>
<!-- Fin Modal Indicadores x Resultado -->

<!-- ******* 4. Modal Consolidado Historico ******* -->
<div id = "modalConsolidado" class="modal fade bs-example-modal-lg text-center" role="dialog" tabindex="-1"
id="modalCursos" data-keyboard="false" data-backdrop="static"
aria-labelledby="gdridfrmnuavaUO" data-focus-on="input:first">
<div class="modal-dialog modal-lg" style="width: 600px; height: 800px">

  <!-- Contenido del modal -->
  <div class="modal-content">
    <!-- Cabeza del modal -->
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
      <h4 id="gridSystemModalLabel" class="reportsTitle mainTitle modal-title" style="padding-top: 10px">Resultados en el Ciclo</h4>
    </div>
    <!-- Fin Cabeza del modal -->
    
    <hr style="padding: 0px; margin-top: 0px; margin-bottom: 0px; width: 80%">

    <!-- Combo box -->
    <div class="row" style="padding-top: 10px; padding-bottom: 0px; padding-right: 1px">
      <div id="ciclos4" class="col-xs-offset-8 col-xs-3">
        <select class="ciclos form-control" required>
        </select>
      </div>
    </div>
    <!-- Fin Combo box -->

    <!-- Cuerpo del modal -->
    <div class="modal-body" style="padding-top: 0px; padding-bottom: 20px">
      <div class="row">
        <div class="x_content">
          <img class="imageBox" src= "{{ URL::asset('img/report1.PNG') }}" style="width: 450px">
        </div> 
      </div>
    </div>
    <!-- Fin Cuerpo del modal -->

    <hr style="padding: 0px; margin-top: 0px; margin-bottom: 0px; width: 80%">

    <!-- Botones inferiores del modal -->
    <div class="row" style="padding-top: 5px; padding-bottom: 10px; text-align: center; display: flex;justify-content: center;">
      <div class="col-md-4 text-right">
        <button id="btnDescargarGraficos" class="btn btn-success pText customButtonLarge" style="padding-right: 5px; padding-left: 5px">Descargar Gráfico</button>
      </div>
      <div class="col-md-4 text-left">
        <a href="{{route('exportar.reporte4')}}">
          <button id="btnDescargarReportes4" class="btn btn-success pText customButtonLarge" style="padding-right: 5px; padding-left: 5px">Descargar Reporte</button>
        </a>
      </div>
    </div>
    <!-- Fin Botones inferiores del modal -->
  </div>
  <!-- Fin Contenido del modal -->
</div>
</div>
<!-- Fin Modal Consolidado Historico -->

@stop

@section('js-scripts')


@stop