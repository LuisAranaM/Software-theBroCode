@extends('Layouts.layout')

@section('js-libs')
<script type="text/javascript"  src="{{ URL::asset('js/usuarios/usuarios.js') }}"></script>
@stop

@section('content')
@section('pageTitle', 'Administrador - Usuarios')


<div class="customBody">

	<div class="row">
		<div class="col-md-9 col-sm-6">
			<h1 class="mainTitle"> Gestionar Usuarios</h1>
		</div>
		<div class="col-md-3 col-sm-6">
			<h1 class="mainTitle">Nuevo Usuario <i id="btnNuevoUsuario" class="fa fa-plus-circle" style="font-size: 30px;cursor:pointer;"></i></h1>
		</div>
		 
	</div>
	@include('flash::message')
	<div class="row">
		<div class="row">
			<div class=" x_panel tile ">
				<h4>Filtros:</h4>

			</div>
		</div>


		<div class="row">
			<div class=" x_panel">
				<table class="table table-striped jambo_table">
					<thead>
						<tr class="headings">
							<td style="vertical-align:middle;text-align:center">Usuario</td>
							<td style="vertical-align:middle;text-align:center">E-mail</td>
							<td style="vertical-align:middle;text-align:center">Nombres y Apellidos</td>

							<td style="vertical-align:middle;text-align:center">Rol</td>
							<td style="vertical-align:middle;text-align:center">Especialidad</td>
							<td style="vertical-align:middle;text-align:center"></td>
							<td style="vertical-align:middle;text-align:center"></td>
						</tr>
					</thead>
					<tbody>
						@if(count($usuarios)>0)
						@foreach($usuarios as $usuario)
						<tr>
							<td style="vertical-align:middle;text-align:center">{{$usuario->USUARIO}}</td>
							<td style="vertical-align:middle;text-align:center">{{$usuario->CORREO}}</td>
							<td style="vertical-align:middle;text-align:center">{{$usuario->NOMBRES_COMPLETOS}} 
								@if($usuario->PERFIL==NULL)
								<div class="user-profile">
									<img src="{{ URL::asset('img/profile.jpg') }}" alt="perfil">
								</div> 
								@else
								<div class="user-profile">
									<img src="{{$usuario->PERFIL}}" alt="perfil"> </div>
									@endif
								</td>

								<td style="vertical-align:middle;text-align:center">{{$usuario->ROL_USUARIO}}</td>
								<td style="vertical-align:middle;text-align:center">{{$usuario->ESPECIALIDAD_USUARIO}}</td>
								<td style="vertical-align:middle;text-align:center"><a href="#"><i class="fa fa-edit" style="font-size: 20px"></i></a></td>
								<td style="vertical-align:middle;text-align:center"><a href="#"><i class="fa fa-trash" style="font-size: 20px"></i></a></td>
							</tr>
							@endforeach
							@else
							<tr>
								<td colspan="10">No se encontraron resultados</td>
							</tr>
							@endif
						</tbody>
					</table>

					{{$usuarios->appends(array_merge($filtros,$orden))->links()}}
				</div>
			</div>
		</div>
	</div>
</div>

</div>

</div>


<!--Modal de carga de curso-->
<div class="modal fade bs-example-modal-lg text-center" role="dialog" tabindex="-1"
id="modalNuevoUsuario" data-keyboard="false" data-backdrop="static"
aria-labelledby="gdridfrmnuavaUO" data-focus-on="input:first" >
<div class="customModal modal-dialog modal-lg ">
  <div class="modal-content" style="top: 20%;width: 700px;left: -150px">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal"
      aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
    <h4 class="reportsTitle mainTitle modal-title" style="padding-top: 10px" id="gridSystemModalLabel">Agregar Nuevo Usuario</h4>
  </div>
  <hr style="padding: 0px; margin-top: 0px; margin-bottom: 0px; width: 80%">
  <div class="modal-body">
    <div class="container-fluid text-center">
      <form id="frmNuevoUsuario" method="POST" action="{{ route('administrador.usuario.crear') }}" style="margin-top: 10px;margin-bottom: 10px;" autocomplete="off">
    <div class="form-group">
        <input style="margin-bottom: 0px;" type="hidden" name="_token" value="{{ csrf_token() }}">
        <input style="margin-bottom: 0px;"  class="form-control" type="hidden" name="perfil" value="">
        <div class="col-md-6 col-sm-6 col-xs-12"> 
            <div class="form-group">
                <label>Usuario</label>
                <input style="margin-bottom: 0px;"  class="form-control formatInputNumber" placeholder="Código PUCP" type="text" name="usuario" >
            </div>
            <div class="form-group">
                <label>Nombres</label>
                <input style="margin-bottom: 0px;"  class="form-control formatInputLetter" placeholder="Nombres" type="text" name="nombres" value="">
            </div>
            <div class="form-group">
                <label>Apellido Paterno</label>
                <input style="margin-bottom: 0px;"  class="form-control" placeholder="Apellido Paterno" type="text" name="apellidoPat" value="">
            </div>
            <div class="form-group">
                <label>Apellido Materno</label>
                <input style="margin-bottom: 0px;"  class="form-control" placeholder="Apellido Materno" type="text" name="apellidoMat" value="">
            </div>
            <div class="form-group">
                <label>Correo Electrónico </label>
                <input style="margin-bottom: 0px;"  class="form-control" placeholder="Correo Electrónico" type="text" name="email" value="">
            </div>
        </div>
        <div class="col-md-6 col-sm-6 col-xs-12">
            <div class="form-group">
                <label>Contraseña</label>
                <input style="margin-bottom: 0px;" class="form-control" placeholder="Contraseña" type="password" name="pass">
            </div>
            <div class="form-group">
                <label>Confirmar Contraseña</label>
                <input style="
                margin-bottom: 0px;" class="form-control" placeholder="Contraseña" type="password" name="passConfirm">
            </div>
            <div class="form-group" style="height: 55px">

                <label>Rol</label>
                <select class="form-control" name="rol" id="cboRol">
                  <option value="">Selecciona una opción</option>
                  @foreach($roles as $rol)
                  <option value="{{$rol->ID_ROL}}">{{$rol->NOMBRE}}</option>
                  @endforeach
              </select>
          </div>

          <div class="form-group" style="height: 55px">
              <label>Especialidad</label>
              <select class="form-control" name="especialidad" id="cboEspecialidad" disabled="">
                  <option value="">Selecciona una opción</option>
                  @foreach($especialidades as $especialidad)
                  <option value="{{$especialidad->ID_ESPECIALIDAD}}">{{$especialidad->NOMBRE}}</option>
                  @endforeach
              </select>
          </div>
      </div>
  </div>
  <div class="form-group">
    <button class="btn btn-primary" type="submit" style="font-size: 14px;margin-top: 20px">Registrar Usuario</button>
</div>

</form> 
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


