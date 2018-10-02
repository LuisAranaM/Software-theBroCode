$( document ).ready(function() {
	console.log("inicio");

	$("#CargarCurso").on("click", function(){
		console.log("btn accionado");
		$("#modalCursos").modal("show");

	});

	$("#btnCargarAlumnos").on("click", function(){
		console.log("btn accionado");
		$("#modalCargar").modal("show");
		$("#CargarCursos").hide();
		$("#CargarHorarios").hide();
		$("#CargarAlumnos").show();

		
		$("#btnCargarAlumnosModal").show();
		$("#btnCargarCursosModal").hide();
		$("#btnCargarHorariosModal").hide();
		$("#btnCancelarModal").show();
	});
	
	$("#btnCargarHorario").on("click", function(){
		console.log("btn accionado");
		$("#modalCargar").modal("show");
		$("#CargarCursos").hide();
		$("#CargarHorarios").show();
		$("#CargarAlumnos").hide();

		$("#btnCargarHorariosModal").show();
		$("#btnCargarCursosModal").hide();
		$("#btnCargarAlumnosModal").hide();
		$("#btnCancelarModal").show();
	});

	$("#btnCargarCursos").on("click", function(){
		console.log("btn accionado");
		$("#modalCargar").modal("show");
		$("#CargarCursos").show();
		$("#CargarHorarios").hide();
		$("#CargarAlumnos").hide();

		$("#btnCargarCursosModal").show();
		$("#btnCargarHorariosModal").hide();
		$("#btnCargarAlumnosModal").hide();
		$("#btnCancelarModal").show();
	});

});