@extends('Layouts.layout')

@section('js-libs')

@stop

@section('content')
@section('pageTitle', 'Administrador - Usuarios')


<div class="customBody">

	<div class="row">
		<div class="col-md-8 col-sm-6">
			<h1 class="mainTitle"> Gestionar Usuarios </h1>
		</div>
		<div class="col-md-4 col-sm-6" >
      
        <span class="input-group-btn">
          <button class="btn btn-default" type="button" id="btnNuevoUsuario">
			Nuevo Usuario
          </button>
        </span>
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


@stop

@section('js-scripts')

@stop


