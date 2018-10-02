@extends('Layouts.layout')
@section('pageTitle', 'Principal')
@section('content')

<div class="customBody">
  <div class="row">
    <div class="col-md-8 col-sm-6">
      <h1 class="mainTitle"> GESTIÓN DE RÚBRICAS </h1>
    </div>

    <div class="col-md-4 col-sm-6" style="text-align: right">
      <button type="button" class="btn btn-success btn-lg pText customButtonRubr"> Descargar Rúbricas </button>
    </div>
  </div>
<!--<div class="">
	<label>
		<div class="form-group">
      <label>
        <input type="checkbox" class="js-switch" checked /> <span class="pText"> Copiar configuración del semestre anterior </span>
      </label>
    </div>
  </label>
</div>
-->

<div class="row">

  <div class="x_panel">
    <div class="x_title">
      <div class="row">
        <div class="col-md-3">
          <h2>Resultado </h2>     
        </div>
        <div class="col-md-3">
          <input type="text" class="form-control pText" name="empresabean.codempresa" id="txtcodigo" required="required">     
        </div>
        <div class="col-md-3">
          <h2>Código </h2>    
        </div>
        <div class="col-md-2">
          <input type="text" class="form-control pText" name="empresabean.codempresa" id="txtcodigo" required="required">     
        </div>
        <div class="col-md-1">
          <ul class="nav navbar-right panel_toolbox">
            <li class="dropdown">
            </li>
            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
            </li>
          </ul>    
        </div>
      </div>
      <div class="clearfix"></div>
    </div>
    <div class="x_content" style="display: block;">
      <br>
      <form class="form-horizontal form-label-left">

        <div class="form-group">
          <label class="control-label col-md-3 col-sm-3 col-xs-3">A1</label>
          <div class="col-md-9 col-sm-9 col-xs-9">
            <input type="text" class="form-control pText" name="empresabean.codempresa" id="txtcodigo" required="required">
          </div>
        </div>
        <div class="form-group">
          <div class="row" style="padding-bottom: 10px; padding-top: 10px;">
            <div class="col-md-1 col-sx-1">
              <input type="text" class="form-control pText" name="empresabean.codempresa" id="txtcodigo" required="required">
            </div>
            <div class="col-md-5  col-sx-5">
              <input type="text" class="form-control pText" name="empresabean.codempresa" id="txtcodigo" required="required">
            </div>
            <div class="col-md-1  col-sx-1">
              <input type="text" class="form-control pText" name="empresabean.codempresa" id="txtcodigo" required="required">
            </div>
            <div class="col-md-5  col-sx-5">
              <input type="text" class="form-control pText" name="empresabean.codempresa" id="txtcodigo" required="required">
            </div>
            
          </div>
          <div class="row" style="padding-bottom: 10px; padding-top: 10px;">
             <div class="col-md-1">
              <input type="text" class="form-control pText" name="empresabean.codempresa" id="txtcodigo" required="required">
            </div>
            <div class="col-md-5">
              <input type="text" class="form-control pText" name="empresabean.codempresa" id="txtcodigo" required="required">
            </div>
            <div class="col-md-1">
              <input type="text" class="form-control pText" name="empresabean.codempresa" id="txtcodigo" required="required">
            </div>
            <div class="col-md-5">
              <input type="text" class="form-control pText" name="empresabean.codempresa" id="txtcodigo" required="required">
            </div>
          </div>

      </form>
    </div>
  </div>
  
</div>
</div>



</div>
@stop

@section('js-scripts')


@stop
