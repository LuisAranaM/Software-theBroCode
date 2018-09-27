@extends('Layouts.layout')
@section('pageTitle', 'Principal')
@section('content')

<div class="customBody">
  <div class="row">
    <div class="col-md-8 col-sm-6">
      <h1 class="mainTitle">Progreso de Medición</h1>
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

  <div class="row">
    <div class=" x_panel tile coursesBox">

      <div class="row">
        <div class="col-md-11" >
          <h1 class="secondaryTitle mainTitle" style="text-align: left">INF223  Ingeniería de Software </h1>
        </div>

        <div class="col-md-1" style="text-align: right; font-size: 20px"> 
          <i class="fa fa-caret-up"></i>
        </div>
      </div>
      <div class="row">
        <div class="col-md-3" >
          <p class="pText" style="margin-bottom: 0px">H0381 - Edison Flores</p>
        </div>
        <div class="col-md-9" style="padding-bottom: 0">
          <div class="widget_summary" >
            <div class="w_center w_55" style="width: 100%">
              <div class="progress" style="margin-bottom: 0px">
                <div class="progress-bar bg-green" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 66%; background-color: #00626E !important; border-color: #00626E !important">
                  <span class="sr-only">60% Complete</span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-offset-3 no-padding">
        <p class="barText pText">55% de avance - 11/30 alumnos calificados</p>
      </div>

      <div class="row">
        <div class="col-md-3" >
          <p class="pText" style="margin-bottom: 0px">H0382 - Christian Cueva</p>
        </div>
        <div class="col-md-9" style="padding-bottom: 0">
          <div class="widget_summary" >
            <div class="w_center w_55" style="width: 100%">
              <div class="progress" style="margin-bottom: 0px">
                <div class="progress-bar bg-green" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 66%;background-color: #00626E !important; border-color: #00626E !important">
                  <span class="sr-only">60% Complete</span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-offset-3 no-padding">
        <p class="barText pText">55% de avance - 11/30 alumnos calificados</p>
      </div>

      <div class="row">
        <div class="col-md-11" >
          <h1 class="secondaryTitle mainTitle" style="text-align: left">INF333 Desarrollo de Programas 1 </h1>
        </div>

        <div class="col-md-1" style="text-align: right; font-size: 20px"> 
          <i class="fa fa-caret-down"></i>
        </div>
      </div>
      <div class="row">
        <div class="col-md-11" >
          <h1 class="secondaryTitle mainTitle" style="text-align: left">INF444 Desarrollo de Programas 2 </h1>
        </div>

        <div class="col-md-1" style="text-align: right; font-size: 20px"> 
          <i class="fa fa-caret-down"></i>
        </div>
      </div>
      <div class="row">
        <div class="col-md-11" >
          <h1 class="secondaryTitle mainTitle" style="text-align: left">IND111 Ética Profesional</h1>
        </div>

        <div class="col-md-1" style="text-align: right; font-size: 20px"> 
          <i class="fa fa-caret-down"></i>
        </div>
      </div>
    </div>
    <div>


    </div>  
  </div>





</div>
@stop

@section('js-scripts')


@stop