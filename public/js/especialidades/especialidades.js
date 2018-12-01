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
              filaEspecialidad.remove();
                  //eliminarUsuario(idUsuario,nombreUsuario,filaEspecialidad);            
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

