$( document ).ready(function() {
	console.log("inicio");
	$("#btnAgregarHorario").on("click", function(){
		console.log("btn accionado");
		$("#modalHorarios").modal("show");

	});

	$('#btnCancelarHorarios').click(function() {
		$('#modalHorarios').modal('hide');
	});
	
	$('#btnActualizarHorarios').click(function() {
		
		var checkboxes =[];

		$('.get_value').each(function(){
			if($(this).is(":checked")){
				console.log($(this).val());
			}
		});
		
		$('#modalHorarios').modal('hide');

	});

	$("#btnAgregarCriterios").on("click", function(){
		console.log("btn accionado");
		$("#modalCriterios").modal("show");
	});

	

});