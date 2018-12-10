@extends('Layouts.layout')
@section('pageTitle', 'Calificar Alumnos')
@section('content')
@section('js-libs')
<script type="text/javascript"  src="{{ URL::asset('js/alumnos/alumnos.js') }}"></script>
<script type="text/javascript"  src="{{ URL::asset('js/steps/jquery.steps.js') }}"></script>
<script type="text/javascript"  src="{{ URL::asset('js/steps/jquery.steps.min.js') }}"></script>

<style>
.ocultarTachito {
  display:none;

}

#ocultarTachito:hover .ocultarTachito {
  display:block;
}

.modalCargando {
  display:    none;
  position:   fixed;
  z-index:    1000;
  top:        0;
  left:       0;
  height:     100%;
  width:      100%;
  opacity: 0.7;
  background: #FFFFFF/*rgba( 255, 255, 255, .6 ) */
  /*url('https://1.bp.blogspot.com/-tF9yshvZFJA/V7hCVvgU_VI/AAAAAAAAAmw/UP4HfIHN9dos1J8BHsxLLsQyayx8P_7qACLcB/s1600/jean-claude-van%2Bdamme-gif-transparente-vagonettas.gif') */
  url('http://i.stack.imgur.com/FhHRx.gif') 
  50% 50% 
  no-repeat;
}

/* When the body has the loading class, we turn
the scrollbar off with overflow:hidden */
body.loading .modalCargando {
  overflow: hidden;   
}

/* Anytime the body has the loading class, our
modal element will be visible */
body.loading .modalCargando {
  display: block;
}

</style>

@stop
<?php 
$modoSoloLectura=in_array(Auth::user()->ID_ROL,App\Entity\Usuario::getModoLectura());
?>
@php ($idInd = array())
@php ($i = 0)
@foreach($indicadores as $indicador)
@php ($idInd[$i] = $indicador->ID_INDICADOR)
@php ($i = $i + 1)
@endforeach
<!--La variable $indicadores contiene 'ID_RESULTADO', 'NOMBRE','ID_INDICADOR' -->
<div class="customBody">


	<div class="row">
		<div class="col-md-12 col-sm-12">
      @if($vistaProc=='calificar')
      <h1 class="mainTitle" ><a href="{{route('profesor.calificar')}}"> Calificar Alumnos </a> > <a href=""> {{$curso[0]->NOMBRE}} - {{$horario[0]->NOMBRE}}</a></h1>
      @elseif($vistaProc=='horarios')
      <h1 class="mainTitle" ><a href="{{route('cursos.gestion')}}"> Gestionar Cursos </a> > <a href="{{ route('cursos.horarios') }}?id={{$curso[0]->ID_CURSO}}&nombre={{$curso[0]->NOMBRE}}&codigo={{$curso[0]->CODIGO_CURSO}}">{{$curso[0]->CODIGO_CURSO}} -{{$curso[0]->NOMBRE}}</a> > <a href=""> {{$horario[0]->NOMBRE}}</a></h1>
      @endif
    </div>
  </div>
  @include('flash::message')
  @if(count($alumnos)>0)
  <div class="row">

    <!--BLOQUE IZQUIERDA-->
    <div class="x_panel tile coursesBox ">
     <div class="row rowFinal">
      <div class="row" style="padding-bottom: 10px">
       <div class="col-xs-9 col-md-8" >
        <h1 class="secondaryTitle mainTitle">Seleccione un alumno a calificar</h1>
      </div>
      <div class="col-md-4 col-sm-6 form-group top_search" >
        <div class="input-group">
          <input id="buscarAlumno" type="text" class="form-control searchText" placeholder="Alumno...">
          <span class="input-group-btn">
            <button class="btn btn-default searchButton" type="button">Buscar</button>
          </span>
        </div>
      </div>
    </div>

    <div class="row">
     <form action="{{ route('proyecto.store.masivo') }}" method="post" enctype="multipart/form-data">
      {{ csrf_field() }}
      <div class="table-responsive">
        <table class="table table-striped jambo_table bulk_action">
         <thead >
          <tr class="headings" style="background-color: #005b7f; color: white; font-family: Segoe UI">
           <th class="pText column-title" style=""> Código</th>
           <th class="pText column-title" style="">Nombre</th>
           @if(!$modoSoloLectura)
           <th class="pText column-title" style="">Proyecto</th>
           @endif
           @if(count($projects)>0)
           <td></td>  
           @endif
           <!--<th class="pText column-title" style=""> </th>-->
           <!--para cada resultado-->
           @foreach($resultados as $resultado)
           <th class="pText column-title" style="text-align:center;">{{$resultado->NOMBRE}}</th>
           @endforeach 
           @if(!$modoSoloLectura)
           <th class="pText column-title" style=""> </th>
           @endif

         </tr>
       </thead>
       <!--CargarCurso-->

       <tbody class="text-left" id="listaAlumnos">
        @foreach($alumnos as $alumno)

        <tr class="even pointer" id="ocultarTachito">
          <td class="pText" style="background-color: white; padding-top: 12px; color: #72777a;vertical-align: center;">{{$alumno->CODIGO}} </td>
          <td class="pText" id="" style="background-color: white; padding-top: 12px; color: #72777a;vertical-align: center;">{{$alumno->NOMBRES}} {{$alumno->APELLIDO_PATERNO}} {{$alumno->APELLIDO_MATERNO}}

          </td>
          <input type="text" name="codAlumnos[]" value="{{$alumno->CODIGO}}" hidden>
          <input type="text" name="horario" value="{{$horario[0]->ID_HORARIO}}" hidden>
          @if(!$modoSoloLectura)
          <td class="pText" style="background-color: white; padding-top: 12px; color: #72777a;text-align: center;vertical-align: center;"><input type="file" name="archivos[{{$alumno->ID_ALUMNO}}]" id = "file" class="fileToUpload"></td>    
          @endif

      <!--<td class="pText" style="background-color: white; padding-top: 12px; color: #72777a">
        <button type = "submit" class = "btn btn-success btn-lg pText customButton">Cargar <i class="fa fa-upload" style="padding-left: 5px"></i> </button>
      </td>-->
      @if(count($projects)>0)
      <td class="pText" style="background-color: white; padding-top: 12px; color: #72777a;text-align: center;vertical-align: center;">
        @foreach($projects as $project)                        

        @if($project->ID_PROYECTO == $alumno->ID_PROYECTO2)

        <a href="{{URL::asset('upload/'.$project->NOMBRE)}}" download="{{$project->NOMBRE}}" style="text-decoration: underline;">
          @if($project->ID_PROYECTO!=1){{$project->NOMBRE}}<i class="fa fa-download" style="padding-left: 5px"></i> @endif</a>
          @break

          @endif

          @endforeach
        </td>
        @endif


        @foreach($resultados as $resultado)
        <td id="{{$resultado->ID_RESULTADO}}" idCurso="{{$curso[0]->ID_CURSO}}" idHorario="{{$horario[0]->ID_HORARIO}}" idResultado="{{$resultado->ID_RESULTADO}}" idAlumno="{{$alumno->ID_ALUMNO}}" codAlumno ="{{$alumno->CODIGO}}" nombreAlumno="{{$alumno->NOMBRES}} {{$alumno->APELLIDO_PATERNO}} {{$alumno->APELLIDO_MATERNO}}" class="pText AbrirCalificacion view" style="background-color: white; padding-top: 12px; color: #72777a;text-align: center;vertical-align: center;cursor: pointer;">
          <i class="fa fa-edit"></i></td>
          @endforeach
          @if(!$modoSoloLectura)
          <td>  <center><div class="" style=""><i idAlumno="{{$alumno->ID_ALUMNO}}" idHorario="{{$horario[0]->ID_HORARIO}}" nombreAlumno="{{$alumno->NOMBRES}} {{$alumno->APELLIDO_PATERNO}} {{$alumno->APELLIDO_MATERNO}}" class="elimAlumno fas fa-trash" id="1" style="color: #005b7f; cursor: pointer;text-align:center;vertical-align: middle;"></i></div></center></td>
          @endif
        </tr>


        @endforeach
      </tbody>
    </table>

  </div>
  @if(!$modoSoloLectura)
  <button type = "submit" class = "btn btn-success btn-lg pText customButton" style="width:130px !important">Subir Archivos<i class="fa fa-upload" style="padding-left: 5px"></i> </button>
  @endif
</form>

</div>
</div>
</div>
</div>

@endif
 <!-- <div class="row">
   <a href="{{route('profesor.calificar')}}" class="pText"><i class="fa fa-arrow-circle-left" aria-hidden="true"></i> Retornar a la vista de cursos</a>
 </div>
 <-->



 <!-- Modal Alumno a Evaluar-->

 <div class="modal fade bs-example-modal-lg text-center" role="dialog" tabindex="-1"
 id="modalCalificacion" data-keyboard="false" data-backdrop="static"
 aria-labelledby="gdridfrmnuavaUO" data-focus-on="input:first" style="z-index: 2000;position: fixed;">
 <div class="modalAlumnos modal-dialog modal-lg">
  <div class="modal-content">
    <div class="modal-header">
      <button id="closeCalificar" type="button" class="close" data-dismiss="modal"
      aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
    <h4 class="reportsTitle mainTitle modal-title" style="padding-top: 10px; text-align: center;" id="gridSystemModalLabel">  Alumno a Evaluar: </h4>
    <h4 id="alumnoACalificar" class="reportsTitle mainTitle modal-title" style="text-align: center;" id="gridSystemModalLabel"></h4>
  </div>
  <hr style="padding: 0px; margin-top: 0px; margin-bottom: 0px; width: 80%">
  
  <!--<div class="row" style="padding-top: 20px;margin: 10px;">

   <div class="col-xs-6 text-left">
    <i class="fa fa-angle-left" style="padding-right: 5px"> <span class="pText">Resultado A</span></i> 
  </div>

  <div class="col-xs-6 text-right">
    <span class="pText">Resultado B</span><i class="fa fa-angle-right" style="padding-left: 5px"></i>
  </div>
</div>-->

<div class="modal-body" id="detalleModal">

<!--SE REFRESCA CON AJAX
<div class="row" style="padding-top: 20px;margin: 10px;">

 <div class="col-xs-6 text-left">
  <i class="fa fa-angle-left" style="padding-right: 5px"> <span class="pText">Anterior Alumno</span></i> 
</div>

<div class="col-xs-6 text-right">
  <span class="pText">Siguiente Alumno</span><i class="fa fa-angle-right" style="padding-left: 5px"></i>
</div>
</div>
-->
</div>
</div>

<!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->
</div>
<!-- /.modal -->


</div>




<div class="modalCargando"><!-- Place at bottom of page --></div>

@stop

@section('js-scripts')

<script type="text/javascript">
  PNotify.prototype.options.delay ? (function() {
    PNotify.prototype.options.delay -= 500;
    update_timer_display();
  }()) : (alert('Timer is already at zero.'))
</script>

@stop