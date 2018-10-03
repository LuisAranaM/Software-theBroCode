var HorariosContainer = document.getElementById("listHorarios");
$( document ).ready(function() {
	$("#btnAgregarHorario").on("click", function(){
		$('#frmCursosModal')[0].reset();
		$("#modalHorarios").modal("show");
	});

	$('#btnCancelarHorarios').click(function() {
		$('#modalHorarios').modal('hide');
	});

	function actualizarHorarios(horarios){
		$.ajax({
			type:'POST',
			headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			url: '/actualizar-horarios',
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