@extends('Layouts.layout')
@section('pageTitle', 'Principal')
@section('content')
@section('js-libs')
<script type="text/javascript"  src="{{ URL::asset('js/rubricas/rubricasjs.js') }}"></script>
@stop
<form method="POST" action="{{ route('actualizar.criterios') }}" >
  <div class="customBody">
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
      <div id="{{$firstC->ID_RESULTADO}}" class="courseButton activeButton alert alert-success alert-dismissible fade in" role="alert">
        <button id="btnClose" type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
        </button>
        <p class="pText">{{$firstC->NOMBRE}}</p>
      </div>
  </div>
  @endif
  @foreach ($categorias as $categoria)
  <div class="x_content bs-example-popovers courseContainer">
      <div id="{{$categoria->ID_RESULTADO}}" class="courseButton alert alert-success alert-dismissible fade in" role="alert">
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
</form>
@stop

@section('js-scripts')


@stop
