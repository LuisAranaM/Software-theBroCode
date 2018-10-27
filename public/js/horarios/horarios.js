$( document ).ready(function() {
	$("#btnAgregarHorario").on("click", function(){
		$("#modalHorarios").modal("show");
	});

	$("#btnAgregarResultado").on("click", function(){
		$("#modalResultados").modal("show");
	});


	


	$('#btnCancelarHorarios').click(function() {
		$('#modalHorarios').modal('hide');
	});
	$('#btnCargarAlumnos').click(function() {
		console.log("btnCargarAlumnos accionado");
		$("#modalCargar").modal("show")
		$("#CargarCursos").hide();
		$("#CargarHorarios").hide();
		$("#CargarAlumnos").show();

		$("#btnCargarAlumnosModal").show();
		$("#btnCargarCursosModal").hide();
		$("#btnCargarHorariosModal").hide();

		$("#btnCancelarModal").show();
	});

	function updateHorarios(horarios,estado){
		$.ajax({
			type:'POST',
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			url: APP_URL+'/horarios/actualizar-horarios',
			data: {
				estadoEvaluacion: estado,
				idHorarios: horarios

			},
			success: function(resultData) {
			}
		});
	}

	$('.closeHorario').on('click', function(e) {
        var idHorario=$(this).attr('idHorario');
        var nombreHorario=$(this).attr('nombreHorario');
        var resp=confirm("¿Estás seguro que deseas dejar de evaluar "+nombreHorario+"?");
        var botonHorario=$(this).closest('div').closest('div');
        if (resp == true) {
            eliminarHorarioEvaluar(idHorario,botonHorario);            
		}
		window.location.reload();   
	});

	function eliminarHorarioEvaluar(idHorario,botonHorario){
		console.log(idHorario);
		console.log(APP_URL);
		$.ajax({
			type: 'POST',  
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			url: APP_URL + '/horarios/eliminar-evaluacion-horario',
			data:{
				idHorario:idHorario,
			},
			success: function (result) {
				botonHorario.hide();
			},
			error: function (xhr, status, text) {
				e.preventDefault();
				alert('Hubo un error al registrar la información');
				item.removeClass('hidden').prev().addClass('hidden');
			}
		});
		
	}


	$(".btnAgregarSubcriterios").on("click", function(){
		console.log("he");
		$("#modalAgregarSubcriterio").modal("show");
	});

	$('#btnActualizarHorarios').click(function() {
		var horariosSeleccionados=[];
		var estadoAcreditacion=[];
		$('.get_value').each(function(){
			if($(this).is(":checked"))
				estadoAcreditacion.push(1);
			else{
				estadoAcreditacion.push(0);
			}
			horariosSeleccionados.push($(this).val());
		});

		//Aquí falta el refrescar Horarios
		$('#modalHorarios').modal('hide');
		updateHorarios(horariosSeleccionados,estadoAcreditacion);
		window.location.reload();
	});

	$("#btnAgregarCriterios").on("click", function(){
		console.log("btn accionado");
		$("#modalCriterios").modal("show");
	});
});