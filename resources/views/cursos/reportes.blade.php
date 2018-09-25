@extends('Layouts.layout')
@section('pageTitle', 'Principal')
@section('content')



<div class="customBody">

  <div class="col-md-8 col-sm-6">
    <h1 class="mainTitle"> Reportes </h1>
  </div>

  <div class="row">

    <div class="col-xs-6">
      <div class=" x_panel tile coursesBox">
        <div class="row">
          <div class="col-xs-6">
           <img class= "imageBox" src="/img/report1.PNG" >
         </div>
         <div class="col-xs-6 text-center">
          <h1 class="reportsTitle mainTitle">Criterios x Ciclo </h1>
        </div>
      </div>
    </div>
  </div>

  <div class="col-xs-6">
    <div class=" x_panel tile coursesBox">
      <div class="row">
        <div class="col-xs-6">
         <img class= "imageBox" src="/img/report1.PNG" >
       </div>
       <div class="col-xs-6 text-center">
        <h1 class="reportsTitle mainTitle">Cursos x Criterio </h1>
      </div>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-xs-6">
    <div class=" x_panel tile coursesBox">
      <div class="row">
        <div class="col-xs-6">
         <img class= "imageBox" src="/img/report1.PNG" >
       </div>
       <div class="col-xs-6 text-center">
        <h1 class="reportsTitle mainTitle">Subcriterios x Criterio </h1>
      </div>
    </div>
  </div>
</div>
<div class="col-xs-6">
  <div class=" x_panel tile coursesBox">
    <div class="row">
      <div class="col-xs-6">
       <img class= "imageBox" src="/img/report1.PNG" >
     </div>
     <div class="col-xs-6 text-center">
      <h1 class="reportsTitle mainTitle">Consolidado Histórico </h1>
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