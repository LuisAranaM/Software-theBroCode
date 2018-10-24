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
			url: 'horarios/desactivar',
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
	function actualizarHorarios(horarios){
		$.ajax({
			type:'POST',
			headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			url: 'horarios/actualizar',
			data: {
				_idHorarios: horarios
			},
			dataType: "text",
			success: function(resultData) {
			}
		});

	}
	$('#btnActualizarHorarios').click(function() {
		
		var horariosSeleccionados=[];
		$('.get_value').each(function(){
			if($(this).is(":checked")){
				horariosSeleccionados.push($(this).val());
			}
		});
		
		actualizarHorarios(horariosSeleccionados);	
		//Aquí falta el refrescar Horarios
		$('#modalHorarios').modal('hide');
	});

	$("#btnAgregarCriterios").on("click", function(){
		console.log("btn accionado");
		$("#modalCriterios").modal("show");
	});

	

});