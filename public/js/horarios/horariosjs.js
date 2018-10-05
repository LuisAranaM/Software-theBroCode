$( document ).ready(function() {
	$("#btnAgregarHorario").on("click", function(){
		$('#frmCursosModal')[0].reset();
		$("#modalHorarios").modal("show");
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

	function desactivarHorario(horario){
		$.ajax({
			type:'POST',
			headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			url: '/desactivar',
			data: {
				_idHorario: horario
			},
			dataType: "text",
			success: function(resultData) {
			}
		});

	}

	$('#btnClose').click(function() {
		desactivarHorario($(this).val());
	});
	function updateHorarios(horarios){
		$.ajax({
			type:'POST',
			headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			url: 'horarios/actualizar-horarios',
			data: {
				_idHorarios: horarios
			},
			dataType: 'json',
			success: function(resultData) {
			}
		});
	}
	$('#btnActualizarHorarios').click(function() {
		var horariosSeleccionados=[];
		console.log("holawa");	
		$('.get_value').each(function(){
			if($(this).is(":checked")){
				horariosSeleccionados.push($(this).val());
			}
		});
		updateHorarios(horariosSeleccionados);
		console.log("he");
		//Aquí falta el refrescar Horarios
		$('#modalHorarios').modal('hide');
	});

	$("#btnAgregarCriterios").on("click", function(){
		console.log("btn accionado");
		$("#modalCriterios").modal("show");
	});

	

});