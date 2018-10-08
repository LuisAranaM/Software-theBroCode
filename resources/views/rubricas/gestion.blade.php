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
          <input type="text" id="txtCodigoResultado" class="form-control pText customInput" name="codigo" id="txtcodigo" placeholder="Código" >     
        </div>
        <div class="col-md-9 inputRight no-padding">
          <!--<input type="text" id="txtResultado" class="form-control pText customInput" name="nombre" id="txtcodigo"  placeholder="Descripción" >   -->
          <textarea type="text" id="txtResultado" class="form-control pText customInput" name="nombre" id="txtcodigo"  placeholder="Descripción" rows="3" cols="30" style="resize: none;" ></textarea>   
        </div>
      </div>
      <div class="row rowFinal2 text-right">
        <button type="submit" class="btn btn-success btn-lg pText customButtonLarge customButtonRubr" name="guardar_button" value="guardar"> Agregar Resultado </button>
      </div>
      <div class="col-md-8 col-sm-6">
       <h1 class="secondaryTitle mainTitle" >Lista de Resultados</h1>
     </div>
     <div id="myDIVResultados">
       <div class="x_content bs-example-popovers courseContainer">
        <div id="hola" class="courseButton activeButton alert alert-success alert-dismissible fade in" role="alert">
          <button id="btnClose" type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
          </button>
          <p class="pText">Diseña y conduce experimentos</p>
        </div>
      </div>
      <div class="x_content bs-example-popovers courseContainer">
        <div class="courseButton alert alert-success alert-dismissible fade in" role="alert">
          <button id="btnClose" type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
          </button>
          <p class="pText">Diseña y conduce experimentos</p>
        </div>
      </div>
      <div class="x_content bs-example-popovers courseContainer">
        <div class="courseButton alert alert-success alert-dismissible fade in" role="alert">
          <button id="btnClose" type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
          </button>
          <p class="pText">Diseña y conduce experimentos</p>
        </div>
      </div>
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
    <button type="submit" class="btn btn-success btn-lg pText customButtonLarge customButtonRubr" name="guardar_button" value="guardar"> Agregar Categoría </button>
  </div>
  <div class="col-md-8 col-sm-6">
   <h1 class="secondaryTitle mainTitle" >Lista de Categorías</h1>
 </div>
 <div id="myDIVCategorias" class="myDIVCategoriasclass">
   <div class="x_content bs-example-popovers courseContainer">
    <div class="courseButton activeButton alert alert-success alert-dismissible fade in" role="alert">
      <button id="btnClose" type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
      </button>
      <p class="pText">Conduce e interpreta resultados</p>
    </div>
  </div>
  <div class="x_content bs-example-popovers courseContainer">
    <div class="courseButton alert alert-success alert-dismissible fade in" role="alert">
      <button id="btnClose" type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
      </button>
      <p class="pText">Conduce e interpreta resultados</p>
    </div>
  </div>
  <div class="x_content bs-example-popovers courseContainer">
    <div class="courseButton alert alert-success alert-dismissible fade in" role="alert">
      <button id="btnClose" type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
      </button>
      <p class="pText">Conduce e interpreta resultados</p>
    </div>
  </div>
</div>
</div>
</div>


<!-- INDICADORES -->
<div class="col-xs-12">
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
    <button type="submit" class="btn btn-success btn-lg pText customButtonLarge customButtonRubr" name="guardar_button" value="guardar"> Agregar Indicador </button>
  </div>
  <div class="col-md-8 col-sm-6">
   <h1 class="secondaryTitle mainTitle" >Lista de Indicadores</h1>
 </div>
 <div id="myDIVIndicadores" class="myDIVIndicadoresclass">
   <div class="x_content bs-example-popovers courseContainer">
    <div class="courseButton activeButton alert alert-success alert-dismissible fade in" role="alert">
      <button id="btnClose" type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
      </button>
      <p class="pText">Matemáticas</p>
    </div>
  </div>
  <div class="x_content bs-example-popovers courseContainer">
    <div class="courseButton alert alert-success alert-dismissible fade in" role="alert">
      <button id="btnClose" type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
      </button>
      <p class="pText">Física</p>
    </div>
  </div>
  <div class="x_content bs-example-popovers courseContainer">
    <div class="courseButton alert alert-success alert-dismissible fade in" role="alert">
      <button id="btnClose" type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
      </button>
      <p class="pText">Química</p>
    </div>
  </div>
</div>
</div>

<!-- VALORIZACIÓN -->
<div class="col-xs-12">
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
    <button type="submit" class="customButtonLarge btn btn-success btn-lg pText customButtonRubr" name="guardar_button" value="guardar"> Agregar Valorización </button>
  </div>
  <div class="col-md-8 col-sm-6">
   <h1 class="secondaryTitle mainTitle" >Lista de Valorizaciones</h1>
 </div>

 <div class="x_content bs-example-popovers courseContainer">
  <div class="courseButton alert alert-success alert-dismissible fade in" role="alert">
    <button id="btnClose" type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
    </button>
    <p class="pText">Matemáticas</p>
  </div>
</div>
<div class="x_content bs-example-popovers courseContainer">
  <div class="courseButton alert alert-success alert-dismissible fade in" role="alert">
    <button id="btnClose" type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
    </button>
    <p class="pText">Física</p>
  </div>
</div>
<div class="x_content bs-example-popovers courseContainer">
  <div class="courseButton alert alert-success alert-dismissible fade in" role="alert">
    <button id="btnClose" type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
    </button>
    <p class="pText">Química</p>
  </div>
</div>
</div>
</div>
</form>
@stop

@section('js-scripts')


@stop
