$( document ).ready(function() {
	console.log("inicio");
	$("#btnAgregarHorario").on("click", function(){
		console.log("btn accionado");
		$("#modalHorarios").modal("show");

	});

	$("#btnAgregarCriterios").on("click", function(){
		console.log("btn accionado");
		$("#modalCriterios").modal("show");
	});

});