@extends('Layouts.layout')
@section('pageTitle', 'Principal')
@section('content')
@section('js-libs')
<script type="text/javascript"  src="{{ URL::asset('js/cursos/cursosjs.js') }}"></script>
@stop
<div class="customBody">

	<div class="row">
		<div class="col-md-8 col-sm-6">
			<h1 class="mainTitle"> Drag and Drop </h1>
		</div>
	</div>

	<p>
  		This is the most minimal example of Dropzone. The upload in this example
  		doesn't work, because there is no actual server to handle the file upload.
	</p>
	<form action="/upload" class="dropzone"></form>
	<button id="btnCargarCursos" type="button" class="btn btn-success btn-lg pText customButton">Cargar Cursos</button>

  <form action="{{route('prueba.cursoInd')}}" type="post">
    {{csrf_field()}}
  <button id="btnPrueba" type="submit" class="btn btn-success btn-lg pText customButton">Prueba Cursos</button>
  </form>
</div>


<!--Modal de carga de curso-->
<div class="modal fade bs-example-modal-lg text-center" role="dialog" tabindex="-1"
id="modalCargarCursos" data-keyboard="false" data-backdrop="static"
aria-labelledby="gdridfrmnuavaUO" data-focus-on="input:first" >
<div class="customModal modal-dialog modal-lg ">
  <div class="modal-content" style="top: 30%">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal"
      aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
    <h4 id="CargarCursos" class="reportsTitle mainTitle modal-title" style="padding-top: 10px" id="gridSystemModalLabel">Cargar Cursos</h4>
  </div>
  <hr style="padding: 0px; margin-top: 0px; margin-bottom: 0px; width: 80%">
  <div class="modal-body">
    <div class="container-fluid text-center">
      <div class="customBody">
      	<div class="row">
			<div class="col-md-8 col-sm-6">
				<h1 class="mainTitle"> Drag and Drop </h1>
			</div>
		</div>

	
		

          <form id="upload_form" action = "{{url('/subir-excels/upload')}}" class="dropzone"  method = "post" >
            {{csrf_field()}}
            <div class = "form-group">
              <input type = "file" name = "upload-file" multiple class="form-control image" style="border-color: white">
            </div>>
            
            <!--input type="file" name="file"-->
            <div class="row" style="padding-top: 20px; text-align: center; display: flex;justify-content: center;">
              <div class="col-md-4">
                <input id="btnCargarCursosModal" class = "btn btn-success pText customButtonThin upload-file" style="padding-right: 5px; padding-left: 5px;" type="submit" value = "Cargar" name="submit">
              </div>
              <div class="col-md-4">
                <button type="reset" id="btnCancelarModalCursos" class="btn btn-success pText customButtonThin" style="padding-right: 5px; padding-left: 5px;">Cancelar</button>
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

@stop

@section('js-scripts')


@stop