	$(document).ready(function () {
		
		$('.formatInputNumber').keyup(function () {
			this.value = (this.value + '').replace(/[^0-9]/g, '');
		});



        $(".eliminarEspecialidad").on("click", function(e){
            var filaEspecialidad=$(this).parent().parent();
            var idEspecialidad=filaEspecialidad.attr('idEspecialidad');
            var nombEspecialidad=filaEspecialidad.attr('nombEspecialidad');

            var resp=confirm("¿Estás seguro que deseas eliminar la especialidad "+nombEspecialidad+"?");
            if (resp == true) {

                  eliminarEspecialidad(idEspecialidad,nombEspecialidad,filaEspecialidad);            
              } 
              e.preventDefault();
              console.log('HOLI');
          });

        $(".editarEspecialidad").on("click", function(e){
            var filaEspecialidad=$(this).parent().parent();
            var idEspecialidad=filaEspecialidad.attr('idEspecialidad');
            console.log(idEspecialidad);
            var nombEspecialidad=filaEspecialidad.attr('nombEspecialidad');


            $('#modalEditarEspecialidad').modal('show');
            $('#frmEditarEspecialidad input[name="idEspecialidad"]').val(idEspecialidad);
            $('#frmEditarEspecialidad input[name="nombEspecialidadEditar"]').val(nombEspecialidad);
            e.preventDefault();
            console.log('HOLI');
        });

    });



function eliminarEspecialidad(idEspecialidad,nombEspecialidad,filaEspecialidad){
    //console.log("Necesitamos agregar cursos");
    //filaUsuario.remove();
      //eliminarUsuario(idUsuario);      
      $.ajax({
        url: APP_URL + 'admin/gestionar-especialidad/eliminar',
        //url: "{{route('eliminar.acreditacion')}}",     
        type: 'POST',        
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data:{
          idEspecialidad:idEspecialidad,
        },
        success: function (result) {
          filaEspecialidad.remove();
          alert('Se eliminó a la especialidad '+nombEspecialidad+' correctamente');
        },
        error: function (xhr, status, text) {
          e.preventDefault();
          alert('Hubo un error al eliminar el usuario');
        }
      });

    }