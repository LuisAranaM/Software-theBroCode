@extends('Layouts.layout')
@section('pageTitle', 'Principal')
@section('content')
@section('js-libs')
<script type="text/javascript"  src="{{ URL::asset('js/rubricas/rubricasjs.js') }}"></script>
@stop
<form method="POST" action="{{ route('actualizar.criterios') }}" >
  <div class="customBody">
<<<<<<< HEAD
    <input type="hidden" name="_token" value="{{ csrf_token() }}" >
    
    <!-- TITULO -->
    <div class="row">
      <div class="col-md-8 col-sm-6">
        <h1 class="mainTitle">Gestionar Rúbricas</h1>
      </div>
      <div class="col-md-4 col-sm-6" style="text-align: right">
        <button type="submit" class="btn btn-success btn-lg pText customButtonLarge customButtonRubr" name="guardar_button" value="guardar"> Guardar Rúbrica </button>
        <button type="button" class="btn btn-success btn-lg pText customButtonLarge customButtonRubr" name="descargar_button" value="descargar"> Descargar Rúbrica </button>
      </div>
    </div>

    <!-- RESULTADOS -->
    <div class="col-xs-12">
      <div id="apRes" class="  x_panel tile coursesBox ">
        <div class="col-md-12 ">
         <h1 class="secondaryTitle mainTitle" >Nuevo Resultado</h1>
       </div>
       <div class="row rowFinal2">
        <div class="col-md-3 inputLeft no-padding">
          <input type="text" id="txtCodigoResultado" class="form-control pText customInput" name="codigo" placeholder="Código" >     
        </div>
        <div class="col-md-9 inputRight no-padding">
          <!--<input type="text" id="txtResultado" class="form-control pText customInput" name="nombre" id="txtcodigo"  placeholder="Descripción" >   -->
          <textarea type="text" id="txtResultado" class="form-control pText customInput" name="nombre" placeholder="Descripción" rows="3" cols="30" style="resize: none;" ></textarea>   
        </div>
      </div>
      <div class="row rowFinal2 text-right">
        <button id="btnAgregarResultado" type="button" class="btn btn-success btn-lg pText customButtonLarge customButtonRubr" name="agregar_resultado" value="agregar"> Agregar Resultado </button>
      </div>
      <div class="col-md-8 col-sm-6">
       <h1 class="secondaryTitle mainTitle" >Lista de Resultados</h1>
     </div>
     <div id="myDIVResultados">
      @if (!is_null($firstR= array_shift($resultados)))
      <div class="x_content bs-example-popovers courseContainer">
          <div id="{{$firstR->ID_CATEGORIA}}" class="courseButton activeButton alert alert-success alert-dismissible fade in" role="alert">
            <button id="btnClose" type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
            </button>
            <p class="pText">{{$firstR->NOMBRE}} {{$firstR->DESCRIPCION}}</p>
          </div>
      </div>
      @endif
      @foreach ($resultados as $resultado) 
      <div class="x_content bs-example-popovers courseContainer">
          <div id="{{$resultado->ID_CATEGORIA}}" class="courseButton alert alert-success alert-dismissible fade in" role="alert">
            <button id="btnClose" type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
            </button>
            <p class="pText">{{$resultado->NOMBRE}} {{$resultado->DESCRIPCION}}</p>
          </div>
      </div>
      @endforeach
    </div>
  </div>
</div>

<!-- CATEGORÍAS -->
<div class="col-xs-12 divcategorias">
  <div id="apCat" class="  x_panel tile coursesBox ">
    <div class="col-md-12 ">
     <h1 class="secondaryTitle mainTitle" >Nueva Categoría</h1>
   </div>
   <div class="row rowFinal2">
    <div class="col-md-12 inputRight no-padding">
      <!--<input type="text" id="txtCategoria" class="form-control pText customInput" name="nombre" id="txtcodigo"  placeholder="Descripción" > -->
      <textarea type="text" id="txtCategoria" class="form-control pText customInput" name="nombre" placeholder="Descripción" rows="3" cols="30" style="resize: none;" ></textarea>       
    </div>
  </div>
  <div class="row rowFinal2 text-right">
    <button id="btnAgregarCategoria" type="button" class="btn btn-success btn-lg pText customButtonLarge customButtonRubr" name="agregar_categoria" value="agregar"> Agregar Categoría </button>
  </div>
  <div class="col-md-8 col-sm-6">
   <h1 class="secondaryTitle mainTitle" >Lista de Categorías</h1>
 </div>
 <div id="myDIVCategorias" class="myDIVCategoriasclass">
  @if (!is_null($firstC= array_shift($categorias)))
  <div class="x_content bs-example-popovers courseContainer">
      <div id="{{$firstC->ID_CRITERIO}}" class="courseButton activeButton alert alert-success alert-dismissible fade in" role="alert">
        <button id="btnClose" type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
        </button>
        <p class="pText">{{$firstC->NOMBRE}}</p>
      </div>
  </div>
  @endif
  @foreach ($categorias as $categoria)
  <div class="x_content bs-example-popovers courseContainer">
      <div id="{{$categoria->ID_CRITERIO}}" class="courseButton alert alert-success alert-dismissible fade in" role="alert">
        <button id="btnClose" type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
        </button>
        <p class="pText">{{$categoria->NOMBRE}}</p>
      </div>
    </a> 
  </div>
  @endforeach

</div>
</div>
</div>


<!-- INDICADORES -->
<div class="col-xs-12 divindicadores">
  <div id= "apInd" class="  x_panel tile coursesBox ">
    <div class="col-md-12 ">
     <h1 class="secondaryTitle mainTitle" >Nuevo Indicador</h1>
   </div>
   <div class="row rowFinal2">
    <div class="col-md-12 inputRight no-padding">
      <!--<input type="text" id="txtResultado" class="form-control pText customInput" name="nombre" id="txtcodigo"  placeholder="Descripción" >    -->
      <textarea id="txtIndicador" class="form-control pText customInput" name="nombre" placeholder="Descripción" rows="3" cols="30" style="resize: none;" ></textarea> 
    </div>
  </div>
  <div class="row rowFinal2 text-right">
    <button id="btnAgregarIndicador" type="button" class="btn btn-success btn-lg pText customButtonLarge customButtonRubr" name="agregar_indicador" value="agregar"> Agregar Indicador </button>
  </div>
  <div class="col-md-8 col-sm-6">
   <h1 class="secondaryTitle mainTitle" >Lista de Indicadores</h1>
 </div>
 <div id="myDIVIndicadores" class="myDIVIndicadoresclass">
  @if (!is_null($firstI= array_shift($indicadores)))
  <div class="x_content bs-example-popovers courseContainer">
      <div id="{{$firstI->ID_SUBCRITERIO}}" class="courseButton activeButton alert alert-success alert-dismissible fade in" role="alert">
        <button id="btnClose" type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
        </button>
        <p class="pText">{{$firstI->NOMBRE}}</p>
      </div>
  </div>
  @endif
  @foreach ($indicadores as $indicador)
  <div class="x_content bs-example-popovers courseContainer">
      <div id="{{$indicador->ID_SUBCRITERIO}}"class="courseButton alert alert-success alert-dismissible fade in" role="alert">
        <button id="btnClose" type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
        </button>
        <p class="pText">{{$indicador->NOMBRE}}</p>
      </div>
  </div>
  @endforeach
</div>
</div>

<!-- VALORIZACIÓN -->
<div class="col-xs-12 divvalorizaciones">
  <div id="apEsc" class="  x_panel tile coursesBox ">
    <div class="col-md-12 ">
     <h1 class="secondaryTitle mainTitle" >Nueva Valorización</h1>
   </div>
   <div class="row rowFinal2">
    <div class="col-md-3 inputLeft no-padding">
      <input type="text" id="txtEscala" class="form-control pText customInput" name="codigo" placeholder="Nivel" >     
    </div>
    <div class="col-md-9 inputRight no-padding">
      <!--<input type="text" id="txtResultado" class="form-control pText customInput" name="nombre" id="txtcodigo" placeholder="Descripción" >  -->
      <textarea type="text" id="txtValorizacion" class="form-control pText customInput" name="nombre" placeholder="Descripción"  rows="3" cols="30" style="resize: none;" ></textarea>     
    </div>
  </div>
  <div class="row rowFinal2 text-right">
    <button id="btnAgregarEscala" type="button" class="customButtonLarge btn btn-success btn-lg pText customButtonRubr" name="agregar_escala" value="agregar"> Agregar Valorización </button>
  </div>
  <div class="col-md-8 col-sm-6">
   <h1 class="secondaryTitle mainTitle" >Lista de Valorizaciones</h1>
 </div>

 <div id="myDIVValorizaciones" class="myDIVValorizacionesclass">
 <div class="x_content bs-example-popovers courseContainer">
  <div class="courseButton alert alert-success alert-dismissible fade in" role="alert">
    <button id="btnClose" type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
    </button>
    <p class="pText">{{$escalas[0]->NOMBRE}} {{$descripciones[0]}}</p>
  </div>
</div>
<div class="x_content bs-example-popovers courseContainer">
  <div class="courseButton alert alert-success alert-dismissible fade in" role="alert">
    <button id="btnClose" type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
    </button>
    <p class="pText">{{$escalas[1]->NOMBRE}} {{$descripciones[1]}}</p>
  </div>
</div>
<div class="x_content bs-example-popovers courseContainer">
  <div class="courseButton alert alert-success alert-dismissible fade in" role="alert">
    <button id="btnClose" type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
    </button>
    <p class="pText">{{$escalas[2]->NOMBRE}} {{$descripciones[2]}}</p>
  </div>
</div>
<div class="x_content bs-example-popovers courseContainer">
  <div class="courseButton alert alert-success alert-dismissible fade in" role="alert">
    <button id="btnClose" type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
    </button>
    <p class="pText">{{$escalas[3]->NOMBRE}} {{$descripciones[3]}}</p>
  </div>
</div>
</div>

</div>
</div>
=======
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <div class="row">
      <div class="col-md-8 col-sm-6">
        <h1 class="mainTitle"> GESTIÓN DE RÚBRICAS </h1>
      </div>
      <div class="col-md-4 col-sm-6" style="text-align: right">
        <button type="submit" class="btn btn-success btn-lg pText customButtonRubr" name="guardar_button" value="guardar"> Guardar Rúbrica </button>
        <button type="button" class="btn btn-success btn-lg pText customButtonRubr" name="descargar_button" value="descargar"> Descargar Rúbrica </button>
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
              <input type="text" id="txtCodigoResultado" class="form-control pText" name="codigo" id="txtcodigo" required="required" placeholder="{{$ultimoCriterio->NOMBRE}}">     
            </div>
          </div>
          <div class="row">
            <div class="col-md-3">
              <h2>Resultado </h2>     
            </div>
            <div class="col-md-6">
              <input type="text" id="txtResultado" class="form-control pText" name="nombre" id="txtcodigo" required="required" placeholder="{{$ultimoCriterio->DESCRIPCION}}">     
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
                   <input type="text" id="txtCategoria" class="form-control pText" name="categoria" id="txtcodigo" required="required" placeholder="{{$ultimaCategoria->NOMBRE}}">    
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
                        <input type="text" id="txtIndicador" class="form-control pText" name="indicador" id="txtcodigo" required="required" placeholder="{{$ultimoSubcriterio->NOMBRE}}">
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
                            <input type="text" id="txtIndCalif1" class="form-control pText" name="indCalif1" id="txtcodigo" required="required" placeholder="1">
                          </div>
                          <div class="col-xs-6 form-group" style="padding-left: 0px;">
                            <textarea id="txtIndCalifDescrip1" class="textarea form-control" name="texto1" rows="4" cols="20" placeholder="{{$ultimoSubcriterio->DESCRIPCION_1}}"></textarea>
                          </div>
                        </div>
                        <div class="row" style="padding-bottom: 10px; padding-top: 10px;">
                          <div class="col-xs-3">
                            <input type="text" id="txtIndCalif2" class="form-control pText" name="indCalif2" id="txtcodigo" required="required" placeholder="2">
                          </div>
                          <div class="col-xs-6 form-group" style="padding-left: 0px;">
                            <textarea id="txtIndCalifDescrip2" class="textarea form-control" name="texto2" rows="4" cols="20" placeholder="{{$ultimoSubcriterio->DESCRIPCION_2}}"></textarea>
                          </div>
                        </div>
                        <div class="row" style="padding-bottom: 10px; padding-top: 10px;">
                          <div class="col-xs-3">
                            <input type="text" id="txtIndCalif3" class="form-control pText" name="indCalif3" id="txtcodigo" required="required" placeholder="3">
                          </div>
                          <div class="col-xs-6 form-group" style="padding-left: 0px;">
                            <textarea id="txtIndCalifDescrip3" class="textarea form-control" name="texto3" rows="4" cols="20" placeholder="{{$ultimoSubcriterio->DESCRIPCION_3}}"></textarea>
                          </div>
                        </div>
                        <div class="row" style="padding-bottom: 10px; padding-top: 10px;">
                          <div class="col-xs-3">
                            <input type="text" id="txtIndCalif4" class="form-control pText" name="indCalif4" id="txtcodigo" required="required" placeholder="4">
                          </div>
                          <div class="col-xs-6 form-group" style="padding-left: 0px;">
                            <textarea id="txtIndCalifDescrip4" class="textarea form-control" name="texto4" rows="4" cols="20" placeholder="{{$ultimoSubcriterio->DESCRIPCION_4}}"></textarea>
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
>>>>>>> AranaBranch
</form>
@stop

@section('js-scripts')


@stop
