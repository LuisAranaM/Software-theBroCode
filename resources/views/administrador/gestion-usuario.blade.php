@extends('Layouts.layout')

@section('js-libs')
<script type="text/javascript"  src="{{ URL::asset('js/usuarios/usuarios.js') }}"></script>
@stop

@section('content')
@section('pageTitle', 'Gestionar Usuarios')


<div class="customBody">

	<div class="row">
		<div class="col-md-9 col-sm-6">
			<h1 class="mainTitle"> Gestionar Usuarios</h1>
		</div>

		<div class="col-md-3 col-sm-6">
			<button id="btnNuevoUsuario" type="button" class="btn btn-success btn-lg pText customButtonLarge2 customButton btnCargarAlumnos2"
          > Nuevo Usuario <i class="fa fa-plus-circle" style="padding-left: 6px"> </i></button>
		</div>

	</div>
	@include('flash::message')
  <form action="{{ route('administrador.usuario') }}" class="form-horizontal">
   <div class=" x_panel tile ">
    <div class="row">
      <div class="form-group col-md-2">
        <label for="" class="control-label">Usuario:</label>
        <input class="form-control" type="text" value="{{ $filtros['usuario'] }}" name="usuarioBuscar">
      </div>

      <div class="form-group col-md-2">
        <label for="" class="control-label">E-mail:</label>
        <input class="form-control" type="text" value="{{ $filtros['email'] }}" name="emailBuscar">
      </div>

      <div class="form-group col-md-3">
        <label for="" class="control-label">Nombres:</label>
        <input class="form-control" type="text" value="{{ $filtros['nombres'] }}" name="nombreBuscar">
      </div>

      <div class="form-group col-md-2">
        <label for="" class="control-label">Roles:</label>
        <select id="cboRolBuscar" class="form-control" name="rolBuscar">
          <option value="">Todos</option>
          @foreach ($roles as  $rol)
          <option value="{{$rol->ID_ROL}}" {{($rol->ID_ROL == $filtros['rol'])? 'selected="selected"':''}}
            >{{$rol->NOMBRE}}</option>
            @endforeach
          </select>
        </div>

        <div class="form-group col-md-2">
          <label for="" class="control-label">Especialidad:</label>
          <select id="cboEspecialidadBuscar" class="form-control cboEspecialidad" name="especialidadBuscar">
            <option value="">Todos</option>
            @foreach ($especialidades as  $especialidad)
            <option value="{{$especialidad->ID_ESPECIALIDAD}}" {{($especialidad->ID_ESPECIALIDAD == $filtros['especialidad'])? 'selected="selected"':''}}
              >{{$especialidad->NOMBRE}}</option>
              @endforeach
            </select>
          </div>

          <button type="submit" class="btn btn-link" >
            <span class="fa fa-search fa-lg" style="font-size:25px;margin-top: 25px;"></span>
          </button>
        </div>
      </div>
    </form>


    <div class="row">
     <div class=" x_panel">
      <div class="table-responsive">
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
        <tr idUsuario="{{$usuario->ID_USUARIO}}" 
          nombreUsuario="{{$usuario->NOMBRES_COMPLETOS}}"
          nombres="{{$usuario->NOMBRES}}"
          apellidoPat="{{$usuario->APELLIDO_PATERNO}}"
          apellidoMat="{{$usuario->APELLIDO_MATERNO}}"
          usuario="{{$usuario->USUARIO}}"
          correo="{{$usuario->CORREO}}"
          rol="{{$usuario->ID_ROL}}"
          especialidad="{{$usuario->ID_ESPECIALIDAD}}">
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
         <td style="vertical-align:middle;text-align:center"><i class="fas fa-pen editarUsuario" style="font-size: 18px;cursor: pointer;"></i></td>
         <td style="vertical-align:middle;text-align:center"><i class="fas fa-trash eliminarUsuario" style="font-size: 18px;cursor: pointer;"></i></td>
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

</div>


<!--Modal de nuevo usuario-->
<div class="modal fade bs-example-modal-lg text-center" role="dialog" tabindex="-1"
id="modalNuevoUsuario" data-keyboard="false" data-backdrop="static"
aria-labelledby="gdridfrmnuavaUO" data-focus-on="input:first" >
<div class="modalUsuario modal-dialog modal-lg ">
  <div class="modal-content" style="top: 20%;">
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
      <form id="frmNuevoUsuario" class="frmUsuario" method="POST" action="{{ route('administrador.usuario.crear') }}" style="margin-top: 10px;margin-bottom: 10px;" autocomplete="off">
        <div class="form-group">
          <input style="margin-bottom: 0px;" type="hidden" name="_token" value="{{ csrf_token() }}">
          <input style="margin-bottom: 0px;"  class="form-control" type="hidden" name="perfil" value="">
          <div class="col-md-6 col-sm-6 col-xs-12 text-left"> 
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
          </div>
          <div class="col-md-6 col-sm-6 col-xs-12 text-left">
            <div class="form-group">
              <label>Correo Electrónico </label>
              <input style="margin-bottom: 0px;"  class="form-control" placeholder="Correo Electrónico" type="text" name="email" value="">
            </div>
            <!--<div class="form-group">
              <label>Contraseña</label>
              <input style="margin-bottom: 0px;" class="form-control" placeholder="Contraseña" type="password" name="pass">
            </div>
            <div class="form-group">
              <label>Confirmar Contraseña</label>
              <input style="
              margin-bottom: 0px;" class="form-control" placeholder="Contraseña" type="password" name="passConfirm">
            </div>
          -->
            <div class="form-group" style="height: 55px">

              <label>Rol</label>
              <select class="form-control cboRol" name="rol" id="cboRol">
                <option value="">Selecciona una opción</option>
                @foreach($roles as $rol)
                <option value="{{$rol->ID_ROL}}">{{$rol->NOMBRE}}</option>
                @endforeach
              </select>
            </div>

            <div class="form-group" style="height: 55px">
              <label>Especialidad</label>
              <select class="form-control cboEspecialidad" name="especialidad" id="cboEspecialidad" disabled="">
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




<!--Modal de editar usuario-->
<div class="modal fade bs-example-modal-lg text-center" role="dialog" tabindex="-1"
id="modalEditarUsuario" data-keyboard="false" data-backdrop="static"
aria-labelledby="gdridfrmnuavaUO" data-focus-on="input:first" >
<div class="modalUsuario modal-dialog modal-lg ">
  <div class="modal-content" style="top: 20%">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal"
      aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
    <h4 class="reportsTitle mainTitle modal-title" style="padding-top: 10px" id="gridSystemModalLabel">Editar Usuario</h4>
  </div>
  <hr style="padding: 0px; margin-top: 0px; margin-bottom: 0px; width: 80%">
  <div class="modal-body">
    <div class="container-fluid text-center">
      <form id="frmEditarUsuario" class="frmUsuario" method="POST" action="{{ route('administrador.usuario.editar') }}" style="margin-top: 10px;margin-bottom: 10px;" autocomplete="off">
        <div class="form-group">
          <input style="margin-bottom: 0px;" type="hidden" name="_token" value="{{ csrf_token() }}">
          <input style="margin-bottom: 0px;"  class="form-control" type="hidden" name="perfil" value="">
          <div class="col-md-6 col-sm-6 col-xs-12 text-left"> 
            <div class="form-group" >
              <input type="text" name="idUsuario" hidden="" >
            </div>
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
          </div>
          <div class="col-md-6 col-sm-6 col-xs-12 text-left">
            <div class="form-group">
              <label>Correo Electrónico </label>
              <input style="margin-bottom: 0px;"  class="form-control" placeholder="Correo Electrónico" type="text" name="email" value="">
            </div>
            <div class="form-group" style="height: 55px">

              <label>Rol</label>
              <select class="form-control cboRol" name="rol" id="cboRolEditar">
                <option value="">Selecciona una opción</option>
                @foreach($roles as $rol)
                <option value="{{$rol->ID_ROL}}">{{$rol->NOMBRE}}</option>
                @endforeach
              </select>
            </div>

            <div class="form-group cboEspecialidad" style="height: 55px">
              <label>Especialidad</label>
              <select class="form-control cboEspecialidad" name="especialidad" id="cboEspecialidadEditar" disabled="">
                <option value="">Selecciona una opción</option>
                @foreach($especialidades as $especialidad)
                <option value="{{$especialidad->ID_ESPECIALIDAD}}">{{$especialidad->NOMBRE}}</option>
                @endforeach
              </select>
            </div>
          </div>
        </div>
        <div class="form-group">
          <button class="btn btn-primary" type="submit" style="font-size: 14px;margin-top: 20px">Actualizar</button>
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


