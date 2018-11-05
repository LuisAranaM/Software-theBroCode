@extends('Layouts.layout')

@section('js-libs')
<!-- Required Javascript -->
<script src="canvas/canvasjs.min.js"></script>
<!--<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.3/Chart.min.js"></script>-->
<script type="text/javascript"  src="{{ URL::asset('js/reportes/Chart.min.js') }}"></script>
<script type="text/javascript"  src="{{ URL::asset('js/reportes/reportes.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('js/k/custom.js') }}"></script>
@stop

@section('pageTitle', 'Principal')

@section('content')
<div class="customBody">

  <div class="col-md-8 col-sm-6">
    <h1 class="mainTitle"> Reportes </h1>
  </div>

  <!-- Inicio de Reportes -->
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
            <div class="row">
              <div class="groupBoxOptions">
                <div class="form-check">
                  <label>
                    <input type="checkbox" checked=""> <span class="pText label-text ">Comparar con semestre anterior</span>
                  </label>
                </div>
              </div>
              <button id="btnGraficoRxC" type="button" class="btn btn-success btn-lg pText customButton" style="width: 120px">Generar Gráfico  </button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Seccion 2: Cursos x Resultado -->
    <div class="col-md-6">
      <div class=" x_panel tile coursesBox">
        <div class="row">
          <div class="col-xs-6">
            <img class= "imageBox" src= "{{ URL::asset('img/report1.PNG') }}" >
          </div>
          <div class="col-xs-6 text-center">
            <h1 class="reportsTitle mainTitle">Cursos x Resultado </h1>
            <div class="row">
              <div class="groupBoxOptions">
                <div class="form-check">
                  <label>
                    <input type="checkbox" checked=""> <span class="pText label-text">Comparar con semestre anterior</span>
                  </label>
                </div>
              </div>
              <button id="btnGraficoResultadosCurso" type="button" class="btn btn-success btn-lg pText customButton" style="width: 120px">Generar Gráfico  </button>
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
            <h1 class="reportsTitle mainTitle">Indicadores x Resultado </h1>
            <div class="row" style="padding-bottom: 20px; padding-top: 20px;">
              <button type="button" class="btn btn-success btn-lg pText customButton" style="width: 120px">Generar Gráfico  </button>
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
          <select id="heard" class="form-control" required>
            <option value="">2018-2</option>
            <option value="press">2018-1</option>
            <option value="net">2017-2</option>
            <option value="mouth">2017-1</option>
          </select>
        </div>
      </div>
      <!-- Fin Combo box -->

      <!-- Cuerpo del modal -->
      <div class="modal-body" style="padding-top: 0px; padding-bottom: 20px; padding-left: 50px; padding-right: 50px">
        <div class="row">
          <div class="x_content">
            <canvas id="myChart" width="400" height="400"></canvas>
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
            <button id="btnDescargarReportes" class="btn btn-success pText customButtonLarge" style="padding-right: 5px; padding-left: 5px">Descargar Reporte</button>
          </a>
        </div>
      </div>
      <!-- Fin Botones inferiores del modal -->
    </div>
    <!-- Fin Contenido del modal -->
  </div>
</div>
<!-- Fin Modal Resultados x Ciclo-->

<!-- ******* 2. Modal Curso x Resultado ******* -->
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
          <select id="heard" class="form-control" required>
            <option value="">2018-2</option>
            <option value="press">2018-1</option>
            <option value="net">2017-2</option>
            <option value="mouth">2017-1</option>
          </select>
        </div>
      </div>
      <!-- Fin Combo box -->

      <!-- Cuerpo del modal -->
      <div class="modal-body" style="padding-top: 0px; padding-bottom: 20px">
        <div class="row">
          <div class="x_content">
            <canvas id="myChart" width="400" height="400"></canvas>
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
            <button id="btnDescargarReportes" class="btn btn-success pText customButtonLarge" style="padding-right: 5px; padding-left: 5px">Descargar Reporte</button>
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
<div id = "modalIxR" class="modal fade bs-example-modal-lg text-center" role="dialog" tabindex="-1"
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
          <select id="heard" class="form-control" required>
            <option value="">2018-2</option>
            <option value="press">2018-1</option>
            <option value="net">2017-2</option>
            <option value="mouth">2017-1</option>
          </select>
        </div>
      </div>
      <!-- Fin Combo box -->

      <!-- Cuerpo del modal -->
      <div class="modal-body" style="padding-top: 0px; padding-bottom: 20px">
        <div class="row">
          <div class="x_content">
            <canvas id="myChart" width="400" height="400"></canvas>
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
            <button id="btnDescargarReportes" class="btn btn-success pText customButtonLarge" style="padding-right: 5px; padding-left: 5px">Descargar Reporte</button>
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
<div id = "modalCH" class="modal fade bs-example-modal-lg text-center" role="dialog" tabindex="-1"
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
          <select id="heard" class="form-control" required>
            <option value="">2018-2</option>
            <option value="press">2018-1</option>
            <option value="net">2017-2</option>
            <option value="mouth">2017-1</option>
          </select>
        </div>
      </div>
      <!-- Fin Combo box -->

      <!-- Cuerpo del modal -->
      <div class="modal-body" style="padding-top: 0px; padding-bottom: 20px">
        <div class="row">
          <div class="x_content">
            <canvas id="myChart" width="400" height="400"></canvas>
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
            <button id="btnDescargarReportes" class="btn btn-success pText customButtonLarge" style="padding-right: 5px; padding-left: 5px">Descargar Reporte</button>
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