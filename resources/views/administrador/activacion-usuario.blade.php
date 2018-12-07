@extends('Layouts.layout')

@section('js-libs')
<script type="text/javascript"  src="{{ URL::asset('js/usuarios/usuarios.js') }}"></script>
@stop

@section('content')
@section('pageTitle', 'Gestionar Usuarios')


<div class="customBody">

	<div class="row">
		<div class="col-md-9 col-sm-6">
			<h1 class="mainTitle"> Activar Usuarios</h1>
		</div>

  </div>
  @include('flash::message')
  <form action="{{ route('administrador.usuario.activacion') }}" class="form-horizontal">
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
          <select id="cboEspecialidadBuscar" class="form-control" name="especialidadBuscar">
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


    <form id="frmActivarUsuarios" method="POST" action="{{route('administrador.usuario.activar')}}" style="margin-top: 10px;margin-bottom: 10px;" autocomplete="off">
      <div class="row">
       <div class=" x_panel">
        <div class="table-responsive">
          <div class="form-group">
            <input style="margin-bottom: 0px;" type="hidden" name="_token" value="{{ csrf_token() }}">
          </div>

          <table class="table table-striped jambo_table">
           <thead>
            <tr class="headings">
             <td style="vertical-align:middle;text-align:center">Usuario</td>
             <td style="vertical-align:middle;text-align:center">E-mail</td>
             <td style="vertical-align:middle;text-align:center">Nombres y Apellidos</td>

             <td style="vertical-align:middle;text-align:center">Rol</td>
             <td style="vertical-align:middle;text-align:center">Especialidad</td>
             <td style="vertical-align:middle;text-align:center"><label>
              <input class="selectAll" type="checkbox"> <span class="pText label-text "></span>
            </label>
          </td>
        </tr>
      </thead>
      <tbody>
        @if(count($usuarios)>0)
        @foreach($usuarios as $usuario)
        <tr idUsuario="{{$usuario->ID_USUARIO}}" nombreUsuario="{{$usuario->NOMBRES_COMPLETOS}}">
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
         <td style="vertical-align:middle;text-align:center">
          <label>
            <input type="checkbox" class="form-check-input checkActivar" 
            name="checkActivar[]" value="{{$usuario->ID_USUARIO}}" style="text-align: center;" >
            <span class="pText label-text "></span>
          </label>        
        </td>
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
<div class="col-md-3 col-sm-6">
  <div class="form-group">
    <button class="btn btn-primary" type="submit" style="font-size: 14px">Activar</button>
  </div>
</div>
</div>
</div>
</form>
</div>
</div>
</div>

</div>

</div>




@stop

@section('js-scripts')

@stop


