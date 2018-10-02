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
		$('#modalHorarios').modal('hide');
	});

	$("#btnAgregarCriterios").on("click", function(){
		console.log("btn accionado");
		$("#modalCriterios").modal("show");
	});

	

});