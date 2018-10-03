@extends('Layouts.layout')
@section('pageTitle', 'Principal')
@section('content')
@section('js-libs')
<script type="text/javascript"  src="{{ URL::asset('js/rubricas/rubricasjs.js') }}"></script>
@stop

<div class="customBody">
  <div class="row">
    <div class="col-md-8 col-sm-6">
      <h1 class="mainTitle"> GESTIÓN DE RÚBRICAS </h1>
    </div>
    <div class="col-md-4 col-sm-6" style="text-align: right">
      <button type="button" class="btn btn-success btn-lg pText customButtonRubr"> Guardar Rúbrica </button>
      <button type="button" class="btn btn-success btn-lg pText customButtonRubr"> Descargar Rúbrica </button>
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
<!--el contenedor grande-->
<div class="row">

  <div class="x_panel collapsed">
    <div class="x_title">
      <div class="row">
        <div class="row">
          <div class="col-md-3">
            <h2>Código </h2>    
          </div>
          <div class="col-md-2">
            <input type="text" id="txtCodigoResultado" class="form-control pText" name="" id="txtcodigo" required="required">     
          </div>
        </div>
        <div class="row">
          <div class="col-md-3">
            <h2>Resultado </h2>     
          </div>
          <div class="col-md-6">
            <input type="text" id="txtResultado" class="form-control pText" name="" id="txtcodigo" required="required">     
          </div>
          <div class="col-sm-3">
            <ul class="nav navbar-right panel_toolbox">
              <li class="dropdown">
              </li>
              <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                <li><a class="close-link"><i class="fa fa-close"></i></a>
                </li>
              </ul>
            </div>
          </div>
        </div>
        <div class="clearfix"></div>
      </div>
      <div class="x_content" style="display: block; text-align: center;">
        <form class="form-horizontal form-label-left">

          <div class="x_panel collapsed">
            <div class="x_title">
              <div class="row">
                <div class="col-xs-3">
                  <h6 class="black-color pText" style="text-align: left;">CATEGORÍA</h6>
                </div>
                <div class="col-xs-6">
                 <input type="text" id="txtCategoria" class="form-control pText" name="" id="txtcodigo" required="required">    
               </div>
               <div class="col-sm-3">
                 <ul class="nav navbar-right panel_toolbox">
                  <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                  </li>
                  <li><a class="close-link"><i class="fa fa-close"></i></a>
                  </li>
                </ul>
              </div>

            </div> 

            <div class="clearfix"></div>
          </div>
          <div class="x_content">

            <form id="demo-form2" data-parsley-validate="" class="form-horizontal form-label-left" novalidate="">


              <div class="x_panel">
                <div class="x_title">
                  <div class="row" style="padding-bottom: 10px;">
                    <label id="labelResultado" class="control-label col-md-3 col-sm-3 col-xs-3" style="text-align: left; padding-right: 10px; width: 50px">A1</label>
                    <div class="col-md-9 col-sm-9 col-xs-9">
                      <input type="text" id="txtIndicador" class="form-control pText" name="" id="txtcodigo" required="required">
                    </div>
                  </div>
                  <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </li>

                    <li><a class="close-link"><i class="fa fa-close"></i></a>
                    </li>
                  </ul>
                  <div class="clearfix"></div>
                </div>
                <div class="x_content">
                  <br>
                  <form id="demo-form2" data-parsley-validate="" class="form-horizontal form-label-left" novalidate="">
                    <div class="form-group">

                      <div class="row" style="padding-bottom: 10px; padding-top: 10px;">
                        <div class="col-xs-3">
                          <input type="text" id="txtIndCalif1" class="form-control pText" name="" id="txtcodigo" required="required">
                        </div>
                        <div class="col-xs-6 form-group" style="padding-left: 0px;">
                          <textarea id="txtIndCalifDescrip1" class="textarea form-control" name="texto" rows="4" cols="20"></textarea>
                        </div>
                      </div>
                      <div class="row" style="padding-bottom: 10px; padding-top: 10px;">
                        <div class="col-xs-3">
                          <input type="text" id="txtIndCalif2" class="form-control pText" name="" id="txtcodigo" required="required">
                        </div>
                        <div class="col-xs-6 form-group" style="padding-left: 0px;">
                          <textarea id="txtIndCalifDescrip2" class="textarea form-control" name="texto" rows="4" cols="20"></textarea>
                        </div>
                      </div>
                      <div class="row" style="padding-bottom: 10px; padding-top: 10px;">
                        <div class="col-xs-3">
                          <input type="text" id="txtIndCalif3" class="form-control pText" name="" id="txtcodigo" required="required">
                        </div>
                        <div class="col-xs-6 form-group" style="padding-left: 0px;">
                          <textarea id="txtIndCalifDescrip3" class="textarea form-control" name="texto" rows="4" cols="20"></textarea>
                        </div>
                      </div>
                      <div class="row" style="padding-bottom: 10px; padding-top: 10px;">
                        <div class="col-xs-3">
                          <input type="text" id="txtIndCalif4" class="form-control pText" name="" id="txtcodigo" required="required">
                        </div>
                        <div class="col-xs-6 form-group" style="padding-left: 0px;">
                          <textarea id="txtIndCalifDescrip4" class="textarea form-control" name="texto" rows="4" cols="20"></textarea>
                        </div>
                      </div>
                    </div>

                  </form>
                </div>
              </div>

              <div class="row">
                <div class="x_content bs-example-popovers courseContainer">
                  <div id ="CargarCurso" class="addCourseButton alert alert-success alert-dismissible fade in" role="alert">
                    <button type="button" class="close" aria-label="Close"><span aria-hidden="true">+</span>
                    </button>
                    <p class="pText"> Agregar Nuevo Indicador </p>
                  </div>
                </div>
              </div>



            </form>
          </div>
        </div>
        <div class="row">
          <div class="x_content bs-example-popovers courseContainer">
            <div id ="CargarCurso" class="addCourseButton alert alert-success alert-dismissible fade in" role="alert">
              <button type="button" class="close" aria-label="Close"><span aria-hidden="true">+</span>
              </button>
              <p class="pText"> Agregar Nueva Categoría </p>
            </div>
          </div>
        </div>
        


      </form>
    </div>
  </div>

</div>

<div class="row">
 <div class="x_content bs-example-popovers courseContainer">
  <div id ="CargarCurso" class="addCourseButton alert alert-success alert-dismissible fade in" role="alert">
    <button type="button" class="close" aria-label="Close"><span aria-hidden="true">+</span>
    </button>
    <p class="pText"> AGREGAR NUEVO RESULTADO </p>
  </div>
</div>
</div>

</div>



</div>
@stop

@section('js-scripts')


@stop
