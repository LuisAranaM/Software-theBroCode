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
@include('flash::message')


  <div class="row">
    <div class=" x_panel tile coursesBox">
      @foreach($cursos as $c)
      <div class="row">
        <div class="col-xs-11" >
          <h1 class="secondaryTitle mainTitle">{{$c->CODIGO_CURSO}} - {{$c->NOMBRE}}</h1>
        </div>

        <div class="col-xs-1 text-right" style="font-size: 20px"> 

          <i class="fa fa-caret-up"></i>
        </div>
      </div>

        @foreach($horarios[$c->ID_CURSO] as $h)

        <div class="row">

          <div class="col-sm-2 col-xs-3" >
            <p class="pText" style="margin-bottom: 0px">{{$h->NOMBRE_HORARIO}} - {{$h->NOMBRE_PROFESOR}}</p>
          </div>
          <div class="col-sm-10 col-xs-9" style="padding-bottom: 0">
            <div class="widget_summary" >
              <div class="w_center w_55" style="width: 100%">
                <div class="progress" style="margin-bottom: 0px">
                  <div class="progress-bar bg-green" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 66%; background-color: #005b7f !important; border: none !important">

                    <span class="sr-only">60% Complete</span>
                  </div>
                </div>
              </div>
            </div>

            <div class="no-padding">
              <p class="barText pText">55% de avance - 11/30 alumnos calificados</p>
            </div>
          </div>
        
        </div>


        @endforeach

      @endforeach 
  </div>





</div>
@stop

@section('js-scripts')


@stop