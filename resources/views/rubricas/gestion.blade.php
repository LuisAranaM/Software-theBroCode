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
      <div class="  x_panel tile coursesBox ">
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
      <?php if (!is_null($firstR= array_shift($resultados))): ?>
        <div class="x_content bs-example-popovers courseContainer">
        <a class="" href="{{route('rubricas.gestion')}}?resultado={{$firstR->ID_CATEGORIA}}">
        <div id="{{$firstR->ID_CATEGORIA}}" class="courseButton activeButton alert alert-success alert-dismissible fade in" role="alert">
          <button id="btnClose" type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
          </button>
          <p class="pText">{{$firstR->NOMBRE}} {{$firstR->DESCRIPCION}}</p>
        </div>
        </a>
        </div>
      <?php endif ?>
      <?php foreach ($resultados as $resultado): ?>
        <div class="x_content bs-example-popovers courseContainer">
        <div id="{{$resultado->ID_CATEGORIA}}" class="courseButton alert alert-success alert-dismissible fade in" role="alert">
          <button id="btnClose" type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
          </button>
          <p class="pText">{{$resultado->NOMBRE}} {{$resultado->DESCRIPCION}}</p>
        </div>
        </div>
      <?php endforeach ?>
    </div>
  </div>
</div>

<!-- CATEGORÍAS -->
<div class="col-xs-12 divcategorias">
  <div class="  x_panel tile coursesBox ">
    <div class="col-md-12 ">
     <h1 class="secondaryTitle mainTitle" >Nueva Categoría</h1>
   </div>
   <div class="row rowFinal2">
    <div class="col-md-12 inputRight no-padding">
      <!--<input type="text" id="txtCategoria" class="form-control pText customInput" name="nombre" id="txtcodigo"  placeholder="Descripción" > -->
      <textarea type="text" id="txtCategoria" class="form-control pText customInput" name="nombre" id="txtcodigo"  placeholder="Descripción" rows="3" cols="30" style="resize: none;" ></textarea>       
    </div>
  </div>
  <div class="row rowFinal2 text-right">
    <button type="button" class="btn btn-success btn-lg pText customButtonLarge customButtonRubr" name="guardar_button" value="guardar"> Agregar Categoría </button>
  </div>
  <div class="col-md-8 col-sm-6">
   <h1 class="secondaryTitle mainTitle" >Lista de Categorías</h1>
 </div>
 <div id="myDIVCategorias" class="myDIVCategoriasclass">
    <?php if (!is_null($firstC= array_shift($categorias))): ?>
        <div class="x_content bs-example-popovers courseContainer">
        <div id="hola" class="courseButton activeButton alert alert-success alert-dismissible fade in" role="alert">
          <button id="btnClose" type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
          </button>
          <p class="pText">{{$firstC->NOMBRE}}</p>
        </div>
        </div>
    <?php endif ?>
   <?php foreach ($categorias as $categoria): ?>
    <div class="x_content bs-example-popovers courseContainer">
    <div class="courseButton alert alert-success alert-dismissible fade in" role="alert">
      <button id="btnClose" type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
      </button>
      <p class="pText">{{$categoria->NOMBRE}}</p>
    </div>
    </div>
   <?php endforeach ?>
</div>
</div>
</div>


<!-- INDICADORES -->
<div class="col-xs-12 divindicadores">
  <div class="  x_panel tile coursesBox ">
    <div class="col-md-12 ">
     <h1 class="secondaryTitle mainTitle" >Nuevo Indicador</h1>
   </div>
   <div class="row rowFinal2">
    <div class="col-md-12 inputRight no-padding">
      <!--<input type="text" id="txtResultado" class="form-control pText customInput" name="nombre" id="txtcodigo"  placeholder="Descripción" >    -->
      <textarea id="txtResultado" class="form-control pText customInput" name="nombre" id="txtcodigo"  placeholder="Descripción" rows="3" cols="30" style="resize: none;" ></textarea> 
    </div>
  </div>
  <div class="row rowFinal2 text-right">
    <button type="button" class="btn btn-success btn-lg pText customButtonLarge customButtonRubr" name="guardar_button" value="guardar"> Agregar Indicador </button>
  </div>
  <div class="col-md-8 col-sm-6">
   <h1 class="secondaryTitle mainTitle" >Lista de Indicadores</h1>
 </div>
 <div id="myDIVIndicadores" class="myDIVIndicadoresclass">
  <?php if (!is_null($firstI= array_shift($indicadores))): ?>
        <div class="x_content bs-example-popovers courseContainer">
        <div id="hola" class="courseButton activeButton alert alert-success alert-dismissible fade in" role="alert">
          <button id="btnClose" type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
          </button>
          <p class="pText">{{$firstI->NOMBRE}}</p>
        </div>
        </div>
    <?php endif ?>
  <?php foreach ($indicadores as $indicador): ?>
    <div class="x_content bs-example-popovers courseContainer">
    <div class="courseButton alert alert-success alert-dismissible fade in" role="alert">
      <button id="btnClose" type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
      </button>
      <p class="pText">{{$indicador->NOMBRE}}</p>
    </div>
    </div>
  <?php endforeach ?>  
</div>
</div>

<!-- VALORIZACIÓN -->
<div class="col-xs-12 divvalorizaciones">
  <div class="  x_panel tile coursesBox ">
    <div class="col-md-12 ">
     <h1 class="secondaryTitle mainTitle" >Nueva Valorización</h1>
   </div>
   <div class="row rowFinal2">
    <div class="col-md-3 inputLeft no-padding">
      <input type="text" id="txtCodigoResultado" class="form-control pText customInput" name="codigo" id="txtcodigo" placeholder="Nivel" >     
    </div>
    <div class="col-md-9 inputRight no-padding">
      <!--<input type="text" id="txtResultado" class="form-control pText customInput" name="nombre" id="txtcodigo" placeholder="Descripción" >  -->
      <textarea type="text" id="txtValorizacion" class="form-control pText customInput" name="nombre" id="txtcodigo" placeholder="Descripción"  rows="3" cols="30" style="resize: none;" ></textarea>     
    </div>
  </div>
  <div class="row rowFinal2 text-right">
    <button type="button" class="customButtonLarge btn btn-success btn-lg pText customButtonRubr" name="guardar_button" value="guardar"> Agregar Valorización </button>
  </div>
  <div class="col-md-8 col-sm-6">
   <h1 class="secondaryTitle mainTitle" >Lista de Valorizaciones</h1>
 </div>

  <div class="x_content bs-example-popovers courseContainer">
  <div class="courseButton alert alert-success alert-dismissible fade in" role="alert">
    <button id="btnClose" type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
    </button>
    <p class="pText">{{$escalas[0]->NOMBRE}} {{$firstI->DESCRIPCION_1}}</p>
  </div>
  </div>
  <div class="x_content bs-example-popovers courseContainer">
  <div class="courseButton alert alert-success alert-dismissible fade in" role="alert">
    <button id="btnClose" type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
    </button>
    <p class="pText">{{$escalas[1]->NOMBRE}} {{$firstI->DESCRIPCION_2}}</p>
  </div>
  </div>
  <div class="x_content bs-example-popovers courseContainer">
  <div class="courseButton alert alert-success alert-dismissible fade in" role="alert">
    <button id="btnClose" type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
    </button>
    <p class="pText">{{$escalas[2]->NOMBRE}} {{$firstI->DESCRIPCION_3}}</p>
  </div>
  </div>
  <div class="x_content bs-example-popovers courseContainer">
  <div class="courseButton alert alert-success alert-dismissible fade in" role="alert">
    <button id="btnClose" type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
    </button>
    <p class="pText">{{$escalas[3]->NOMBRE}} {{$firstI->DESCRIPCION_4}}</p>
  </div>
  </div>
  
</div>
</div>
</form>
@stop

@section('js-scripts')


@stop
