@extends('Layouts.layoutNuevo')
@section('pageTitle', 'Nuevo Usuario Google')
@section('content')

<div class="col-md-12 col-sm-12 col-xs-12">
    <img src="{{ URL::asset('img/logo2.png') }}" alt="logoRubriK" style="width: 40%">
</div>
<form id="frmNuevoUsuarioGoogle" method="POST" action="{{ route('login.google.crear') }}" style="margin-top: 10px;margin-bottom: 10px;" autocomplete="off">
    <label style="font-size: 20px">Nuevo Usuario Rubrik</label>
    <div class="form-group">
        <input style="margin-bottom: 0px;" type="hidden" name="_token" value="{{ csrf_token() }}">
        <input style="margin-bottom: 0px;"  class="form-control" type="hidden" name="perfil" value="{{$usuarioGoogle['IMAGEN_PERFIL']}}">
        <div class="col-md-6 col-sm-6 col-xs-12"> 
            <div class="form-group">
                <label>Usuario</label>
                <input style="margin-bottom: 0px;"  class="form-control formatInputNumber" placeholder="Código PUCP" type="text" name="usuario" >
            </div>
            <div class="form-group">
                <label>Nombres</label>
                <input style="margin-bottom: 0px;"  class="form-control" placeholder="Nombres" type="text" name="nombres" value="{{$usuarioGoogle['NOMBRES']}}">
            </div>
            <div class="form-group">
                <label>Apellido Paterno</label>
                <input style="margin-bottom: 0px;"  class="form-control" placeholder="Apellido Paterno" type="text" name="apellidoPat" value="{{$usuarioGoogle['APELLIDO_PATERNO']}}">
            </div>
            <div class="form-group">
                <label>Apellido Materno</label>
                <input style="margin-bottom: 0px;"  class="form-control" placeholder="Apellido Materno" type="text" name="apellidoMat" value="{{$usuarioGoogle['APELLIDO_MATERNO']}}">
            </div>
            <div class="form-group">
                <label>Correo Electrónico </label>
                <input style="margin-bottom: 0px;"  class="form-control" placeholder="Correo Electrónico" type="text" readonly="" name="email" value="{{$usuarioGoogle['EMAIL_GOOGLE']}}">
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
    <button class="btn btn-primary" type="submit" style="font-size: 14px;margin-top: 20px">Registrarme</button>
</div>

</form> 

@stop

@section('js-scripts')



<script> 

    $('.formatInputNumber').keyup(function () {
        this.value = (this.value + '').replace(/[^0-9]/g, '');
    });

    $( "#cboRol" ).change(function() {
      //alert( "Handler for .change() called." );
      var idRol=$(this).val();

      if(idRol==1){
        $('#cboEspecialidad').val('');
        $('#cboEspecialidad').attr('disabled',true);
    }
    else{
        $('#cboEspecialidad').removeAttr('disabled');
    }
});

    $('#frmNuevoUsuarioGoogle').formValidation({
        framework: 'bootstrap',
        icon: {
          valid: 'glyphicon glyphicon-ok',
          invalid: 'glyphicon glyphicon-remove',
          validating: 'glyphicon glyphicon-refresh'
      },
      fields: {
        usuario: {
            validators: {
                notEmpty: {
                   message: '*Campo obligatorio'
               },
               regexp: {
                regexp: /^[0-9]+$/i,
                message: 'El usuario cuenta únicamente con caracteres alfanuméricos'
            }
        }
    },
    nombres: {
        validators: {
            notEmpty: {
               message: '*Campo obligatorio'
           },
       }
   },
   apellidoMat: {
    validators: {
        notEmpty: {
           message: '*Campo obligatorio'
       },
   }
},
apellidoPat: {
    validators: {
        notEmpty: {
           message: '*Campo obligatorio'
       },
   }
},
rol: {
    validators: {
        notEmpty: {
           message: '*Campo obligatorio'
       },
   }
},
especialidad: {
    validators: {
        notEmpty: {
           message: '*Campo obligatorio'
       },
   }
},
usuario: {
    validators: {
        notEmpty: {
           message: '*Campo obligatorio'
       },
   }
},
pass: {
    validators: {
        notEmpty: {
           message: '*Campo obligatorio'
       },
       identical: {
        field: 'passConfirm',
        message: 'La nueva contraseña y la confirmación no son iguales'
    },
    stringLength: {
        message: 'La contraseña debe tener entre 6 y 20 caracteres',
        min: 6,
        max: 20
    } 
}
},
passConfirm: {
    validators: {
        notEmpty: {
           message: '*Campo obligatorio'
       },
       identical: {
        field: 'pass',
        message: 'La nueva contraseña y la confirmación no son iguales'
    },
    stringLength: {
        message: 'La contraseña debe tener entre 6 y 20 caracteres',
        min: 6,
        max: 20
    }             
}
}
}
});
</script>
@stop