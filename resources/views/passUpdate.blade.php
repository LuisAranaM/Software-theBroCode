@extends('Layouts.layout')
@section('pageTitle', 'Cambiar Contraseña')
@section('content')
@section('js-libs')
<!--
  <link href="{{ URL::asset('css/formValidation.min.css') }}" rel="stylesheet" type="text/css" > 

  <script type="text/javascript" src="{{ URL::asset('js/formvalidation/formValidation.popular.min.js') }}"></script>
  <script type="text/javascript" src="{{ URL::asset('js/formvalidation/language/es_CL.js') }}"></script>
  <script type="text/javascript" src="{{ URL::asset('js/formvalidation/framework/bootstrap.min.js') }}"></script>
-->
@stop
<div class="customBody">

  <div class="row">
    <div class="col-md-8 col-sm-6">
      <h1 class="mainTitle">Cambiar Contraseña</h1>
  </div>  
</div>
@include('flash::message')
<div class="row">
    <div class="x_panel">
        <div class="x_content">
            <form action="{{ route('pass.update.post') }}" method="POST" id="frmPasswordUpdate" class="frmPasswordUpdate">
                {{ csrf_field() }}
                <div class="form-group col-md-12 col-sm-12 col-xs-12">
                    <div class="form-group col-md-4 col-sm-4 col-xs-12">
                        <label>Contraseña antigua</label>
                        <input class="form-control" placeholder="Contraseña antigua" required="" type="password" name="passwA" id="passwA">
                    </div> 
                </div>                 
                <div class="form-group col-md-12 col-sm-12 col-xs-12">
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <label>Nueva contraseña</label>
                        <input class="form-control" placeholder="Nueva contraseña" required="" type="password" name="passwN" id="passwN">
                    </div>
                </div>
                
                <div class="form-group col-md-12 col-sm-12 col-xs-12">
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <label>Confirmar nueva contraseña</label>
                        <input class="form-control" placeholder="Confirmar nueva contraseña" required="" type="password" name="passwR" id="passwR">
                    </div>
                </div>

                <br><br><br><br>
                <div class="form-group col-md-4 col-sm-4 col-xs-12">
                    <button class="btn btn-primary" type="submit">Cambiar contraseña</button>
                </div>
                <div class="clearfix"></div>

            </form> 
        </div>
    </div>
</div>



</div>
@stop

@section('js-scripts')
<script> 
    $('#frmPasswordUpdate').formValidation({
        framework: 'bootstrap',
        icon: {
          valid: 'glyphicon glyphicon-ok',
          invalid: 'glyphicon glyphicon-remove',
          validating: 'glyphicon glyphicon-refresh'
      },
      fields: {
        passwA: {
            validators: {
                notEmpty: {
                   message: '*Campo obligatorio'
               },
        }
    },
    passwN: {
        validators: {
            notEmpty: {
               message: '*Campo obligatorio'
           },
           identical: {
            field: 'passwR',
            message: 'La nueva contraseña y la confirmación no son iguales'
        },
        stringLength: {
            message: 'La contraseña debe tener entre 6 y 20 caracteres',
            min: 6,
            max: 20
        } 
    }
},
passwR: {
    validators: {
        notEmpty: {
           message: '*Campo obligatorio'
       },
       identical: {
        field: 'passwN',
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