$( document ).ready(function() {
	console.log("inicio");

	$("#CargarCurso").on("click", function(){
		console.log("btn accionado");
		$("#modalCursos").modal("show");

	});

	$("#btnCargarAlumnos").on("click", function(){
		console.log("btn accionado");
		$("#modalCargar").modal("show");
		$("#CargarAlumnos").show();
		$("#CargarHorarios").hide();
		$("#btnBuscarArchivoAlumnos").show();
		$("#btnBuscarArchivoHorarios").hide();
	});
	
	$("#btnCargarHorario").on("click", function(){
	console.log("btn accionado");
	$("#modalCargar").modal("show");
	$("#CargarHorarios").show();
	$("#CargarAlumnos").hide();
	$("#btnBuscarArchivoHorarios").show();
	$("#btnBuscarArchivoAlumnos").hide();
	});

});