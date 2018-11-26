@extends('Layouts.layout')

@section('js-libs')

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
  <div class="row">
    
		<div class="row">
			<div class=" x_panel tile ">
				<h4>Filtros:</h4>

			</div>
		</div>
  

  <div class="row">
   <div class=" x_panel">
    <form id="frmActivarUsuarios" method="POST" action="{{route('administrador.usuario.activar')}}" style="margin-top: 10px;margin-bottom: 10px;" autocomplete="off">
      <div class="form-group">
        <input style="margin-bottom: 0px;" type="hidden" name="_token" value="{{ csrf_token() }}">
      </div>
      <div class="col-md-3 col-sm-6">
        <div class="form-group">
          <button class="btn btn-primary" type="submit" style="font-size: 14px">Activar</button>
        </div>
      </div>
      <table class="table table-striped jambo_table">
       <thead>
        <tr class="headings">
         <td style="vertical-align:middle;text-align:center">Usuario</td>
         <td style="vertical-align:middle;text-align:center">E-mail</td>
         <td style="vertical-align:middle;text-align:center">Nombres y Apellidos</td>

         <td style="vertical-align:middle;text-align:center">Rol</td>
         <td style="vertical-align:middle;text-align:center">Especialidad</td>
         <td style="vertical-align:middle;text-align:center"></td>
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
</form>
</div>
</div>
</div>
</div>
</div>

</div>

</div>




@stop

@section('js-scripts')

@stop


