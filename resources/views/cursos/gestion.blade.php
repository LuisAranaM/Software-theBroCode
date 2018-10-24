@extends('Layouts.layout')
@section('pageTitle', 'Principal')
@section('content')
@section('js-libs')
<script type="text/javascript"  src="{{ URL::asset('js/cursos/cursosjs.js') }}"></script>
@stop

<div class="customBody">

  <div class="row">
    <div class="col-md-8 col-sm-6">
      <h1 class="mainTitle"> Gestionar Cursos </h1>
    </div>

    <div class="col-md-4 col-sm-6 form-group top_search" >
      <div class="input-group">
        <input id="busquedaGeneral" type="text" class="form-control searchText" placeholder="Curso...">
        <span class="input-group-btn">
          <button class="btn btn-default searchButton" type="button" id="btnBuscarCurso">
            <i class="fa fa-spinner fa-spin fa-fw fa-1x margin-bottom hidden"></i>
            <i class="fa fa-search"></i>
          </button>
        </span>
      </div>
    </div>
  </div>

  <div class="row">
    <div class=" x_panel tile coursesBox">

      <div class="row">
        <div class="col-xs-6" >
          <h1 class="secondaryTitle mainTitle">Cursos a Calificar </h1>
        </div>

        <!--<div class="col-xs-6 text-right">
          <button id="btnCargarCursos" type="button" class="btn btn-success btn-lg pText customButton">Cargar Cursos</button>
          <button id="btnCargarHorario" type="button" class="btn btn-success btn-lg pText customButton">Cargar Horario</button>
          <button id="btnCargarAlumnos" type="button" class="btn btn-success btn-lg pText customButton">Cargar Alumnos</button>
        </div>  -->
      </div>

      <div class="x_content bs-example-popovers courseContainer">
        <div id ="CargarCurso" class="addCourseButton alert alert-success alert-dismissible fade in" role="alert">
          <button type="button" class="close" aria-label="Close"><span aria-hidden="true">+</span>
          </button>
          <p class="pText"> Agregar Nuevo Curso </p>
        </div>
      </div>

      <div id="listaCursos">        
      @foreach($cursos as $curso)
      <div class="x_content bs-example-popovers courseContainer" >
        <a class="" href="{{ route('cursos.horarios') }}?id={{$curso->ID_CURSO}}&nombre={{$curso->NOMBRE}}&codigo={{$curso->CODIGO_CURSO}}">
          <div class="courseButton alert alert-success alert-dismissible fade in courseButton" role="alert">

            <button type="button" class="close closeCurso" aria-label="Close" codigoCurso="{{$curso->CODIGO_CURSO}}" nombreCurso="{{$curso->NOMBRE}}"><span aria-hidden="true">×</span>

            </button>
            <label class="pText" style="font-weight: bold;">{{$curso->CODIGO_CURSO}} - </label>           
            <label class="pText">{{$curso->NOMBRE}}</label>
          </div> 
        </a>

      </div>
      @endforeach
      </div>
    </div>
  </div>

</div>


<!-- Modal de Nuevo Curso -->

<div class="modal fade bs-example-modal-lg text-center" role="dialog" tabindex="-1"
id="modalCursos" data-keyboard="false" data-backdrop="static"
aria-labelledby="gdridfrmnuavaUO" data-focus-on="input:first">
<div class="customModal modal-dialog modal-lg" style="width: 600px; height: 300px" >
  <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal"
      aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
    <h4 id="gridSystemModalLabel" class="reportsTitle mainTitle modal-title" style="padding-top: 10px" id="gridSystemModalLabel">Seleccionar Cursos a Evaluar</h4>
  </div>
  <hr style="padding: 0px; margin-top: 0px; margin-bottom: 0px; width: 80%">
  <div class="modal-body">
    <div class="container-fluid" style="">
      <form id="frmAgregarCursos" action="{{route('agregar.acreditacion')}}" method="POST">
        {{ csrf_field() }}
        <div class="tile coursesModalBox" style="padding-bottom: 20px;">
          <div class="col-xs-12 form-group top_search">

            <div class="input-group">
              <!--<input id="txtCursoBuscar" type="text" class="form-control searchText" placeholder="Curso...">-->
              <input id="txtCursoBuscar" type="text" class="form-control searchText" placeholder="Curso...">
              <span class="input-group-btn">
                <button class="btn btn-default searchButton" type="button" id="btnBuscarCurso">
                  <i class="fa fa-spinner fa-spin fa-fw fa-1x margin-bottom hidden"></i>
                  <i class="fa fa-search"></i>
                </button>
              </span>
            </div>
          </div>

        </div>

        <!--Esto se debe de volver a generar por AJAX-->

        <div class="table-responsive" id="tablaCursos" style="height:300px;overflow:auto; position: relative;">
          <table class="table table-striped jambo_table bulk_action">
            <thead>
              <tr class="headings" style="background-color: #005b7f; color: white; font-family: Segoe UI">
                <th class="pText column-title" style="border: none;text-align: center;"></th>
                <th class="pText column-title" style="border: none;text-align: center;"> Código</th>
                <th class="pText column-title" style="border: none;text-align: center;">Curso</th>
                <!--<th class="pText bulk-actions" colspan="7">
                  <a class="antoo" style="color:#fff; font-weight:500;">Bulk Actions ( <span class="action-cnt"> </span> ) <i class="fa fa-chevron-down"></i></a>
                </th>-->
              </tr>
            </thead>

            <tbody class="text-left" id="tablaBuscar">
          @if(count($cursosBuscar)>0)
            @foreach($cursosBuscar as $cursoB)
            <tr class="even pointer">
          <td class="a-center"  style="background-color: white; padding-right: 0px">
          <div class="form-check" style="padding-left: 10px; width: 20px">
          <label>
          <input type="checkbox" class="form-check-input checkCurso" 
          name="checkCursos[]" value="{{$cursoB->CODIGO_CURSO}}" <?php echo ($cursoB->ESTADO_ACREDITACION==1 ? 'checked' : '');?>>
          <span class="pText label-text "></span>
          </label>
          </div></td>
          <td class="pText" style="background-color: white;text-align:center;vertical-align: middle;">
          {{$cursoB->CODIGO_CURSO}}</td>
          <td class="pText" style="background-color: white;text-align:center;vertical-align: middle;">
          {{$cursoB->NOMBRE}}</td>        
          </tr> 
            @endforeach
          @else
          <tr>
              <td colspan="10">No se encontraron resultados</td>
          </tr>
          @endif
          </table>

        </div>
        
        <div id="btnsAgregarCurso" class="modal-footer">
          <div class="text-center" style="padding-top: 0px; padding-bottom: 10px">

            <button id="btnAgregar" class="btn btn-success pText customButtonThin" disabled>Agregar</button>
            <!--<button id="btnCancelar" class="btn btn-success pText customButtonThin">Cancelar</button>-->
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


@stop

@section('js-scripts')


@stop