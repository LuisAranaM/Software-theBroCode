@extends('Layouts.layout')
@section('pageTitle', 'Principal')
@section('content')

<style type="text/css">
  .boxHeightWidht{
    height: 200px;width: 80%;margin-left: 50px;
  }
</style>
<div class="row tile_count" style="margin-top: 100px;">
  <table class="table table-striped jambo_table" style="width: 700px;margin-left: 220px;">
    <thead>
        <tr class="headings">
            <th style="text-align: center;">Código</th>
            <th style="text-align: center;">Curso</th>
            <th style="text-align: center;">Avance</th>
            <th style="text-align: center;">Profesor</th>
        </tr>
    </thead>
    <tbody>
      @foreach($cursos as $curso)
        <tr>
          <td style="text-align: center;">{{$curso['CODIGO']}}</td>
          <td style="text-align: center;">{{$curso['CURSO']}}</td>
          <td style="text-align: center;">
            <div class="progress">
              <div class="progress-bar progress-bar-striped active" role="progressbar"
              aria-valuenow="{{number_format($curso['AVANCE']/$curso['TOTAL']*100,0,'.',',')}}" aria-valuemin="0" aria-valuemax="100" style="width:{{number_format($curso['AVANCE']/$curso['TOTAL']*100,0,'.',',')}}%">
                <!--{{number_format($curso['AVANCE']/$curso['TOTAL']*100,0,'.',',')}}%-->
                {{$curso['AVANCE']}}/{{$curso['TOTAL']}}
              </div>
            </div>
          </td>
          <td style="text-align: center;">{{$curso['PROFESOR']}}</td>
        </tr>      
      @endforeach             
    </tbody>
  </table>
</div>
          <!-- /top tiles -->

<div class="row">

  <div class="col-md-6 col-sm-6 col-xs-12">
    <div class="x_panel tile boxHeightWidht">
      <div class="x_title">
        <h2 style="font-size: 20px">Reportes</h2>
        <ul class="nav navbar-right panel_toolbox">
          <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
          </li>
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
            <ul class="dropdown-menu" role="menu">
              <li><a href="#">Settings 1</a>
              </li>
              <li><a href="#">Settings 2</a>
              </li>
            </ul>
          </li>
          <li><a class="close-link"><i class="fa fa-close"></i></a>
          </li>
        </ul>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <div class="dashboard-widget-content">
          
            <li style="font-size: 18px"><a href="#"> Consolidados por Ciclo</a>
            <i class="fa fa-calendar-o"></i>
            </li>
            <br>
            <li style="font-size: 18px"><a href="#"> Estadísticas por Ciclo</a>
            <i class="fa fa-bar-chart-o"></i>
            </li>
          
        </div>
      </div>
    </div>
  </div>
  
  <div class="col-md-6 col-sm-6 col-xs-12">
    <div class="x_panel tile boxHeightWidht">
      <div class="x_title">
        <h2 style="font-size: 20px">Documentos de Reuniones</h2>
        <ul class="nav navbar-right panel_toolbox">
          <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
          </li>
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
            <ul class="dropdown-menu" role="menu">
              <li><a href="#">Settings 1</a>
              </li>
              <li><a href="#">Settings 2</a>
              </li>
            </ul>
          </li>
          <li><a class="close-link"><i class="fa fa-close"></i></a>
          </li>
        </ul>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <div class="dashboard-widget-content">
            <li style="font-size: 18px"><a href="#">Actas de Reunión</a>
            <i class="fa fa-file"></i>
            </li>
            <br>
            <li style="font-size: 18px"><a href="#">Última Acta</a>
            <i class="fa fa-download"></i>  
            </li>
        </div>
      </div>
    </div>
  </div>
</div>
  
<br>
<br>
<br>
<br>
@stop

@section('js-scripts')

@stop