@extends('Layouts.layout')
@section('pageTitle', 'Principal')
@section('content')
@section('js-libs')
<script type="text/javascript"  src="{{ URL::asset('js/rubricas/rubricasjs.js') }}"></script>
@stop

<div class="customBody">

  <div class="row">
    <div class="col-md-8 col-sm-6">
      <h1 class="mainTitle">Categorías del Resultado A</h1>
    </div>

    <div class="col-md-4 col-sm-6 form-group top_search" >
      <div class="input-group">
        <input type="text" class="form-control searchText" placeholder="Curso...">
        <span class="input-group-btn">
          <button class="btn btn-default searchButton" type="button">Buscar</button>
        </span>
      </div>
    </div>
  </div>

  <div class="row">
    <div class=" x_panel tile coursesBox">


      <!-- CURSOS CARGADOS DE LA BD -->
      <div class="row rowFinal">

        <div class="row">
          <div class="col-xs-11" >
            <h1 class="secondaryTitle mainTitle">Matemáticas</h1>
          </div>

          <div class="col-xs-1 text-right" style="text-align: right; font-size: 20px"> 
            <i class="fa fa-caret-up"></i>
          </div>
        </div>


        <div class="row">

          <div class="col-sm-1 col-xs-2" >
            <p class="pText" style="margin-bottom: 0px">a</p>
          </div>
          <div class="col-sm-9 col-xs-7" style="padding-bottom: 0">
            <div class="widget_summary" >
              <div class="w_center w_55" style="width: 100%">

              </div>
            </div>

          </div>
          <div class="col-sm-2 col-xs-3 text-right">
              
          </div>
        </div>
    
      </div>

      <!-- END CURSOS CARGADOS DE LA BD-->     

</div>
	
	<a href="{{route('rubricas.gestion')}}" class="pText"><i class="fa fa-arrow-circle-left" aria-hidden="true"></i> Retornar a la gestión de rúbricas</a>

</div>

<!-- Modal de Cargar Alumnos  -->

<div class="modal fade bs-example-modal-lg text-center" role="dialog" tabindex="-1"
id="modalCargarAlumnos" data-keyboard="false" data-backdrop="static"
aria-labelledby="gdridfrmnuavaUO" data-focus-on="input:first" >
<div class="customModal modal-dialog modal-lg ">
  <div class="modal-content" style="top: 30%">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal"
      aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
    <h4 id="CargarAlumnos" class="reportsTitle mainTitle modal-title" style="padding-top: 10px" id="gridSystemModalLabel">Cargar Alumnos</h4>
  </div>
  <hr style="padding: 0px; margin-top: 0px; margin-bottom: 0px; width: 80%">
  <div class="modal-body">
    <div class="container-fluid text-center">
      <div class="dropzone" style="min-height: 100px; height: 190px; width: 350px; border: 2px dashed #ccc; display: inline-block; background-color: white; margin-top: 10px; margin-bottom: 10px">
        <i class="fa fa-5x fa-cloud-upload" style="color: #ccc; height: 100px; padding: 10px"></i>
        <p class="pText">Arrastra y suelta un archivo <br> o <br> 

          <form id="upload_form" action = "" method = "post" enctype = "multipart/form-data">
            {{csrf_field()}}
            <div class = "form-group">
              <input type = "file" name = "upload-file" class="form-control image" style="border-color: white">
            </div>
            <div class="row" style="padding-top: 20px; text-align: center; display: flex;justify-content: center;">
              <div class="col-md-4">
                <input id="btnCargarAlumnosModal" class = "btn btn-success pText customButtonThin upload-file" style="padding-right: 5px; padding-left: 5px;" type="submit" value = "Cargar" name="submit">
              </div>
              <div class="col-md-4">
                <button type="reset" id="btnCancelarModalAlumnos" class="btn btn-success pText customButtonThin" style="padding-right: 5px; padding-left: 5px;">Cancelar</button>
              </div>

            </div>
            
          </form>
        </div>
      </div>
    </div>
  </div>
  <!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->
</div>
<!-- /.modal -->



@stop

@section('js-scripts')


@stop