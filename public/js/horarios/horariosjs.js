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
	/*
	$("#btnCargarHorario").on("click", function(){
	console.log("btn accionado");
	$("#modalCargar").modal("show");
	$("#CargarHorarios").show();
	$("#CargarAlumnos").hide();
	$("#btnBuscarArchivoHorarios").show();
	$("#btnBuscarArchivoAlumnos").hide();
	});*/

});