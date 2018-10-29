@extends('Layouts.layout')

@section('js-libs')
<!-- Required Javascript -->
<script type="text/javascript"  src="{{ URL::asset('js/reportes/reportes.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('js/k/custom.js') }}"></script>
@stop

@section('pageTitle', 'Principal')

@section('content')



<div class="customBody">

  <div class="col-md-8 col-sm-6">
    <h1 class="mainTitle"> Reportes </h1>
  </div>

  <div class="row">
    <div class="col-md-6">
      <div class=" x_panel tile coursesBox">
        <div class="row">
          <div class="col-xs-6">
            <img class= "imageBox" src="{{ URL::asset('img/report1.PNG') }}" >
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
              <button id="btnGraficoCxR" type="button" class="btn btn-success btn-lg pText customButton" style="width: 120px">Generar Gráfico  </button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-md-6">
      <div class=" x_panel tile coursesBox">
        <div class="row">
          <div class="col-xs-6">
            <img class= "imageBox" src="{{ URL::asset('img/report1.PNG') }}">
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
              <button type="button" class="btn btn-success btn-lg pText customButton" style="width: 120px">Generar Gráfico  </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="row">
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

    <div class="col-md-6">
      <div class=" x_panel tile coursesBox">
        <div class="row">
          <div class="col-xs-6">
           <img class= "imageBox" src="{{ URL::asset('img/report1.PNG') }}" >
         </div>
         <div class="col-xs-6 text-center">
          <h1 class="reportsTitle mainTitle">Consolidado Histórico </h1>
          <div class="row" style="padding-bottom: 20px; padding-top: 20px;">
            <button type="button" class="btn btn-success btn-lg pText customButton" style="width: 120px">Generar Gráfico  </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</div>

<!-- Modal para ver reporte de Resultados por Ciclo 
<div class="modal fade bs-example-modal-lg" role="dialog" tabindex="-1"
  data-keyboard="false" data-backdrop="static" aria-labelledby="gdridfrmnuavaUO" data-focus-on="input:first">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <div  style="padding-top: 10px; padding-left: 20px">
          <a href="" class="pText">
          <i class="fa fa-arrow-circle-left" aria-hidden="true"></i>
          Regresar
          </a>
          <button id="cerrarModalCxR" type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
          </button>
        </div>
        <h4 class="modal-title text-center" id="myModalLabel">Gráfico de criterios por ciclo</h4>
      </div>

      <div class="modal-body text-center">
        <div class="x_content">
          <!--<div id="myfirstchart" style="height: 250px;"></div>-->
          <!-->
          <div class="row">
            <div id="myfirstchart" style="height: 350px; -webkit-tap-highlight-color: transparent; user-select: none;position: relative; background-color: transparent;" _echarts_instance_="ec_1540778072451"><div style="position: relative; overflow: hidden; width: 780px; height: 350px; cursor: default;"><canvas width="975" height="437" data-zr-dom-id="zr_0" style="position: absolute; left: 0px; top: 0px; width: 780px; height: 350px; user-select: none; -webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></canvas></div><div style="position: absolute; display: none; border-style: solid; white-space: nowrap; z-index: 9999999; transition: left 0.4s cubic-bezier(0.23, 1, 0.32, 1) 0s, top 0.4s cubic-bezier(0.23, 1, 0.32, 1) 0s; background-color: rgba(0, 0, 0, 0.5); border-width: 0px; border-color: rgb(51, 51, 51); border-radius: 4px; color: rgb(255, 255, 255); font: 14px/21px Arial, Verdana, sans-serif; padding: 5px; left: 592px; top: 96.6px;">10?<br><span style="display:inline-block;margin-right:5px;border-radius:10px;width:9px;height:9px;background-color:#26B99A"></span>sales : 20<br><span style="display:inline-block;margin-right:5px;border-radius:10px;width:9px;height:9px;background-color:#34495E"></span>purchases : 18.8</div></div>
          </div>
        
        </div>
      </div>
    </div>
  </div>
</div>

<-->

<div id = "modalCxR" class="modal fade bs-example-modal-lg text-center" role="dialog" tabindex="-1"
id="modalCursos" data-keyboard="false" data-backdrop="static"
aria-labelledby="gdridfrmnuavaUO" data-focus-on="input:first">
<div class="modal-dialog modal-lg" style="width: 600px">
  <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal"
      aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
    <h4 id="gridSystemModalLabel" class="reportsTitle mainTitle modal-title" style="padding-top: 10px" id="gridSystemModalLabel">Resultados en el Ciclo</h4>
  </div>
  <hr style="padding: 0px; margin-top: 0px; margin-bottom: 0px; width: 80%">

  <div class="row" style="padding-top: 10px; padding-bottom: 0px">
    <div class="col-xs-offset-8 col-xs-3">
    <select id="heard" class="form-control" required>
      <option value="">2018-2</option>
      <option value="press">Press</option>
      <option value="net">Internet</option>
      <option value="mouth">Word of mouth</option>
    </select>
    </div>
  </div>

  <div class="modal-body" style="padding-top: 0px">
    <img  src="{{ URL::asset('img/report1.PNG') }}" style="width: 500px">
  </div>
</div>
</div>
</div>


@stop

@section('js-scripts')


@stop