$( document ).ready(function() {

  console.log("inicio");

  $("#btnNuevoUsuario").on("click", function(e){
    console.log("Nuevo Usuario");
    $('#frmNuevoUsuario').trigger("reset");           



    $('#frmNuevoUsuario input[type="text"]').val('');     
    $('#frmNuevoUsuario').formValidation('destroy', true);
    initializeFormUsuario();
    $("#modalNuevoUsuario").modal("show");

  });

  $(".eliminarUsuario").on("click", function(e){
    var filaUsuario=$(this).parent().parent();
    var idUsuario=filaUsuario.attr('idUsuario');
    var nombreUsuario=filaUsuario.attr('nombreUsuario');

    var resp=confirm("¿Estás seguro que deseas eliminar a "+nombreUsuario+"?");
    if (resp == true) {
      console.log("Vamos a eliminar a "+nombreUsuario+ ' con el id '+idUsuario);
      //filaUsuario.remove();
      eliminarUsuario(idUsuario,nombreUsuario,filaUsuario);            
    } 
    e.preventDefault();
    });

   $(".editarUsuario").on("click", function(e){
    var filaUsuario=$(this).parent().parent();
    var idUsuario=filaUsuario.attr('idUsuario');
    var nombreUsuario=filaUsuario.attr('nombreUsuario');
      console.log("Vamos a editar a "+nombreUsuario+ ' con el id '+idUsuario);
    });


  /*$('.formatInputNumber').keyup(function () {
    this.value = (this.value + '').replace(/[^0-9]/g, '');
  });

    $('.formatInputLetter').keyup(function () {
    this.value = (this.value + '').replace(/^[a-zA-ZñÑáéíóúü ]/g, '');
  });*/


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


});

function eliminarUsuario(idUsuario,nombreUsuario,filaUsuario){
    //console.log("Necesitamos agregar cursos");
    //filaUsuario.remove();
      //eliminarUsuario(idUsuario);      
    $.ajax({
        url: APP_URL + 'admin/gestionar-usuario/eliminar',
        //url: "{{route('eliminar.acreditacion')}}",     
        type: 'POST',        
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data:{
            idUsuario:idUsuario,
        },
        success: function (result) {
            filaUsuario.remove();
            alert('Se eliminó al usuario '+nombreUsuario+' correctamente');
        },
        error: function (xhr, status, text) {
            e.preventDefault();
            alert('Hubo un error al eliminar el usuario');
        }
    });

}

function initializeFormUsuario() {
    //console.log('Ingresamos al form validation');
    
    return $('#frmNuevoUsuario').formValidation({
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
            regexp: /^[0-9]+$/,
            message: 'El código debe ser numérico'
          },
          stringLength: {
            message: 'El usuario debe tener como máximo 8 caracteres',
            max: 8
          } 
        }
      },
      nombres: {
        validators: {
          notEmpty: {
           message: '*Campo obligatorio'
         },
         regexp: {
           regexp: /^[a-zA-ZñÑáéíóúü ]+$/,
           message: 'Los nombres solo puede tener caracteres alfabéticos'
         }
       }
     },
     apellidoMat: {
      validators: {
        notEmpty: {
         message: '*Campo obligatorio'
       },
       regexp: {
         regexp: /^[a-zA-ZñÑáéíóúü ]+$/,
         message: 'El apellido materno solo puede tener caracteres alfabéticos'
       }
     }
   },
   apellidoPat: {
    validators: {
      notEmpty: {
       message: '*Campo obligatorio'
     },
     regexp: {
       regexp: /^[a-zA-ZñÑáéíóúü ]+$/,
       message: 'El apellido paterno solo puede tener caracteres alfabéticos'
     }
   }
 },
 email: {
  validators: {
    notEmpty: {
     message: '*Campo obligatorio'
   },
   emailAddress: {
    message: 'La dirección debe ser un email válido'
  }
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


},
})
    .off('success.form.fv');  

  }