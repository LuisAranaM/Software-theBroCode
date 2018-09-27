@extends('Layouts.layout')
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
</div>

@stop

@section('js-scripts')


@stop