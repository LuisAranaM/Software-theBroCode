@extends('Layouts.layout')
@section('pageTitle', 'Principal')
@section('content')
@section('js-libs')
<script type="text/javascript"  src="{{ URL::asset('js/rubricas/rubricasjs.js') }}"></script>
<script type="text/javascript"  src="{{ URL::asset('js/rubricas/configuracion.js') }}"></script>
@stop
<form>
  <div id="apRes" class="customBody">
    <input type="hidden" name="_token" value="{{ csrf_token() }}" >
    
    <!-- TITULO -->
    <div class="row" style="padding-right: 10px; padding-bottom: 10px">
      <div class="col-md-8 col-xs-6">
        <h1 class="mainTitle" style="padding-left: 10px"><a>Lista de Resultados</a></h1>
      </div>
      <!--
      <div class="col-md-4 col-xs-6" style="text-align: right">
        <button type="submit" class="btn btn-success btn-lg pText customButtonLarge customButtonRubr" name="guardar_button" value="guardar" style="background-color: #1ABB9C; border-color: transparent"> Guardar Rúbrica </button>
        <button type="button" class="btn btn-success btn-lg pText customButtonLarge customButtonRubr" name="descargar_button" value="descargar" style="background-color: #1ABB9C; border-color:   transparent"> Descargar Rúbrica </button>
      </div>
      -->
    </div>
    
    @include('flash::message')
    <!-- RESULTADOS -->

    <div class="col-md-3 col-xs-4">
      <div class="resultContainer no-padding x_panel tile coursesBox" style="background-color: #DFE3E6">
        <div class="outer">
          <div class="middle">


            <div id ="AgregarResultado" class="text-center inner resultButton alert alert-success alert-dismissible fade in" role="alert" style="padding-right: 15px; background-color: #DFE3E6; border-color: transparent; cursor:pointer">
              <p class="pText">Crear nuevo resultado...</p>
              
            </div>
          </div>
        </div>
      </div>
    </div>

    <div id="resultados">
      @foreach ($resultados as $resultado) 
      <div class="col-md-3 col-xs-4">
        <div class="resultContainer x_panel tile coursesBox resultadoBox">
          <div class="bs-example-popovers">
            
              <div class="row" value="{{$resultado->ID_RESULTADO}}">
                <div id="{{$resultado->ID_RESULTADO}}" class="col-md-3 resultButton alert-success alert-dismissible fade in" role="alert" style="display: inline-block; padding-left: 10px">
                  <p class="pText" style="font-weight: bold; font-size: 30px; color: black">{{$resultado->NOMBRE}}</p>
                </div>
                <div  class="col-md-9" value="{{$resultado->ID_RESULTADO}}" style="text-align: right; display: inline-block; padding-right: 25px; padding-top: 15px">
                  <i class="resultadoEdit fas fa-pen fa-md" style="color: #72777a; cursor: pointer; display: none; opacity: 0.7" id ="EditarIndicador"></i>
                  <i class="resultTrash fas fa-trash fa-md" id="{{$resultado->ID_RESULTADO}}"  style="color: #72777a; padding-left: 2px; cursor: pointer; display: none; opacity: 0.7"></i>
                </div>
                <a href="{{ route('rubricas.categorias')}}?idRes={{$resultado->ID_RESULTADO}}&resultado={{$resultado->NOMBRE}}">

                <div id="{{$resultado->ID_RESULTADO}}" class="col-xs-12 resultButton alert-success alert-dismissible fade in" role="alert" style="padding-right: 25px">
                  <p class="pText">{{$resultado->DESCRIPCION}}</p>
                </div>
              </a>
            </div>
            
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
          <label  class="reportsTitle mainTitle modal-title" style="padding-top: 10px" id="ModalTitle" name="codigoHorario" type="text" value=""></label>
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
                  <input type="text" id="txtCodigoResultado" class="nombreResultado form-control pText customInput" name="codigo" placeholder="Código" >     
                </div>
                <div class="col-xs-12">
                  <textarea type="text" id="txtResultado" class="descripcionResultado form-control pText customInput" name="nombre" placeholder="Descripción" rows="3" cols="30" style="resize: none;" ></textarea>   
                </div>
                <div class="col-xs-12" style="padding-top: 20px !important; padding-left: 10px;">
                  <p style="font-size: 16px; font-family: segoe UI semibold; text-align: left; color: black">Lista de Categorías</p>
                </div>
                <div id="filasCats">
                  <div class="col-xs-11" style="padding-bottom: 6px">

                    <textarea type="text" id="txtCategoria" class="cat form-control pText customInput" name="nombre" placeholder="Nombre de la categoría" rows="1" cols="30" style="resize: none;" ></textarea>       
                  </div>
                  <div id="agregarFilaIcono"class="col-xs-1" style="padding-left: 2px; padding-top: 2px">
                    <i id="btnAgregarFila" class="fa fa-plus-circle fa-2x" style="color: #005b7f"></i>
                  </div>
                </div>

              </div>
            </div>

            <div id="btnsResultado" class="modal-footer">
              <div class="row" style="padding-top: 5px; text-align: center; display: flex;justify-content: center;">
                <div class="col-md-4">
                  <button id="btnAgregarResultado" class = "btn btn-success pText customButton" type="button" value = "Cargar" name="cargar">Cargar</button>
                </div>
                <div class="col-md-4">
                  <button type="reset" class="btn btn-success pText customButton" data-dismiss="modal"
                  aria-label="Close">Cancelar</button>
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

@if(count($resultados)==0)
  <a id="btnCopiarConfiguracion" style="cursor: pointer;">Copiar configuración de semestre pasado (solo mostrar cuando está vacío rubricas)</a>
@endif

<div class="modal fade bs-example-modal-lg text-center" role="dialog" tabindex="-1" id="modalConfiguracion" data-keyboard="false" data-backdrop="static" aria-labelledby="gdridfrmnuavaUO" data-focus-on="input:first">
  <div class="customModal modal-dialog modal-lg" style="width: 500px; height: 300px" >
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"
        aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
      <h4 class="mainTitle modal-title" style="padding-top: 10px" id="gridSystemModalLabel">Copiar Configuración de Rúbrica</h4>
    </div>
    <hr style="padding: 0px; margin-top: 0px; margin-bottom: 0px; width: 80%">
    <div class="modal-body"> 
      <div class="container-fluid" style="">
        <form id="frmAgregarCursos" action="" method="POST">
          {{ csrf_field() }}
          <div class="tile coursesModalBox" style="padding-bottom: 20px;">

            <div id="filasCat"class="row">
              <div class="col-xs-12">
                <p style="font-size: 16px; font-family: segoe UI semibold; text-align: left; color: black">Selecciona el semestre para copiar la configuración:</p>
              </div>
              <div class="col-xs-12">
                <select class="form-control" id="cboSemestreConfiguracion">
                  <option>Seleccionar una opción</option>
                  @foreach($semestres as $semestre)
                  <option value="{{$semestre->ID_SEMESTRE}}" semestre="{{$semestre->SEMESTRE}}">{{$semestre->SEMESTRE}}</option>
                  @endforeach
                </select>
              </div>

            </div>
          </div>

          <div class="modal-footer">
            <div class="row" style="padding-top: 5px; text-align: center; display: flex;justify-content: center;">
              <div class="col-md-4">
                <button id="btnMostrarConfiguracion" class = "btn btn-success pText customButton" type="button" value = "Cargar" name="cargar">Mostrar Configuración</button>
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


<div class="modal fade bs-example-modal-lg text-center" role="dialog" tabindex="-1" id="modalConfiguracionMostrar" data-keyboard="false" data-backdrop="static" aria-labelledby="gdridfrmnuavaUO" data-focus-on="input:first" style="overflow-y: scroll;">
  <div class="customModal modal-dialog modal-lg" style="width: 1200px; height: 300px;" >
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"
        aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
      
        <h4 class="mainTitle modal-title" style="padding-top: 10px" id="tituloModalConfirmacion"></h4>

    </div>
    <hr style="padding: 0px; margin-top: 0px; margin-bottom: 0px; width: 80%">
    <div class="modal-body"> 
      <div class="container-fluid" style="">
        <form id="frmCopiarConfiguracion" action="{{route('configuracion.copiar')}}" method="POST">
          {{ csrf_field() }}
          <div class="tile coursesModalBox" style="padding-bottom: 20px;" id="interiorConfirmacion">


          </div>
          <input type="hidden" name="idSemestreConfirmado" id="idSemestreConfirmado">

          <div class="modal-footer">
            <div class="row" style="padding-top: 5px; text-align: center; display: flex;justify-content: center;">
              <div class="col-md-4">
                <button id="btnAceptarCopia" class = "btn btn-success pText customButton" type="submit" style="width: 100px" >Copiar Configuración</button>
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
<?php $nombreEspecialidad=App\Entity\Especialidad::getNombreEspecialidadUsuario(); ?>
<input type="hidden" value="{{$nombreEspecialidad}}" id="nombreEspecialidad">
@stop

@section('js-scripts')


@stop
