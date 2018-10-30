@extends('Layouts.layout')
@section('pageTitle', 'Principal')
@section('content')
@section('js-libs')
<script type="text/javascript"  src="{{ URL::asset('js/rubricas/rubricasjs.js') }}"></script>
@stop
<form>
  <div id="apRes" class="customBody">
    <input type="hidden" name="_token" value="{{ csrf_token() }}" >
    
    <!-- TITULO -->
    <div class="row" style="padding-right: 10px; padding-bottom: 10px">
      <div class="col-md-8 col-xs-6">
        <h1 class="mainTitle" style="padding-left: 10px"><a>Lista de Resultados</a></h1>
      </div>
      <div class="col-md-4 col-xs-6" style="text-align: right">
        <button type="submit" class="btn btn-success btn-lg pText customButtonLarge customButtonRubr" name="guardar_button" value="guardar"> Guardar Rúbrica </button>
        <button type="button" class="btn btn-success btn-lg pText customButtonLarge customButtonRubr" name="descargar_button" value="descargar"> Descargar Rúbrica </button>
      </div>
    </div>
    

    <!-- RESULTADOS -->

    <div class="col-md-3 col-xs-6 ">
      <div class="resultContainer no-padding x_panel tile coursesBox">
        <div class="outer">
          <div class="middle">


            <div id ="AgregarResultado" class="inner text-center resultButton alert alert-success alert-dismissible fade in" role="alert">
              <img src="{{ URL::asset('img/add.png') }}" style="height: 45px">
              <p class="pText" >Agregar Nuevo Resultado</p>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div id="resultados">
    @foreach ($resultados as $resultado) 
    <div class="col-md-3 col-xs-6">
      <div class="resultContainer no-padding x_panel tile coursesBox">
        <div class="bs-example-popovers">
          <a href="{{ route('rubricas.categorias')}}?idRes={{$resultado->ID_RESULTADO}}&resultado={{$resultado->NOMBRE}}">
          <div class="outer">
            <div class="middle">
              <div id="{{$resultado->ID_RESULTADO}}" class="inner text-center resultButton alert-success alert-dismissible fade in" role="alert">
                <p class="pText"> <span style="font-weight: bold; font-size: 30px; text-align: center; color: black">  {{$resultado->NOMBRE}} <br> </span>{{$resultado->DESCRIPCION}}</p>
              </div>
            </div>
          </div>
        </a>
        </div>        
      </div>
    </div>
    @endforeach
  </div>



    <!--MODAL-->
    <div class="modal fade bs-example-modal-lg text-center" role="dialog" tabindex="-1" id="modalAgregarResultado" data-keyboard="false" data-backdrop="static" aria-labelledby="gdridfrmnuavaUO" data-focus-on="input:first">
    <div class="customModal modal-dialog modal-lg" style="width: 500px; height: 300px" >
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal"
          aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 id="gridSystemModalLabel" class="reportsTitle mainTitle modal-title" style="padding-top: 10px" id="gridSystemModalLabel">Agregar Nuevo Resultado</h4>
      </div>
      <hr style="padding: 0px; margin-top: 0px; margin-bottom: 0px; width: 80%">
      <div class="modal-body"> 
        <div class="container-fluid" style="">
          <form id="frmAgregarCursos" action="{{route('agregar.acreditacion')}}" method="POST">
            {{ csrf_field() }}
            <div class="tile coursesModalBox" style="padding-bottom: 20px;">

             <div id="filasCat"class="row rowFinal2">
              <div class="col-xs-12">
                <p style="font-size: 16px; font-family: segoe UI semibold; text-align: left; color: black">Detalles del Resultado</p>
              </div>
              <div class="col-xs-12" style="padding-bottom: 6px">
                <input type="text" id="txtCodigoResultado" class="form-control pText customInput" name="codigo" placeholder="Código" >     
              </div>
              <div class="col-xs-12">
                <textarea type="text" id="txtResultado" class="form-control pText customInput" name="nombre" placeholder="Descripción" rows="3" cols="30" style="resize: none;" ></textarea>   
              </div>
              <div class="col-xs-12" style="padding-top: 20px !important; padding-left: 10px;">
                <p style="font-size: 16px; font-family: segoe UI semibold; text-align: left; color: black">Lista de Categorías</p>
              </div>
              <div class="col-xs-11" style="padding-bottom: 6px">

                <textarea type="text" id="txtCategoria" class="cat form-control pText customInput" name="nombre" placeholder="Nombre de la categoría" rows="1" cols="30" style="resize: none;" ></textarea>       
              </div>
              <div id="agregarFilaIcono"class="col-xs-1" style="padding-left: 2px; padding-top: 2px">
                <i id="btnAgregarFila" class="fa fa-plus-circle fa-2x" style="color: #005b7f"></i>
              </div>
              

            </div>
          </div>

          <div id="btnsResultado" class="modal-footer">
            <div class="row" style="padding-top: 5px; text-align: center; display: flex;justify-content: center;">
              <div class="col-md-4">
                <button id="btnAgregarResultado" class = "btn btn-success pText customButton" style="padding-right: 5px; padding-left: 5px;" type="button" value = "Cargar" name="cargar">Cargar</button>
              </div>
              <div class="col-md-4">
                <button type="reset" id="btnCancelarModalAlumnos" class="btn btn-success pText customButton" style="padding-right: 5px; padding-left: 5px;">Cancelar</button>
              </div>

            </div>

          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->
</div>
<!-- /.modal -->




</div>
</form>



@stop

@section('js-scripts')


@stop
