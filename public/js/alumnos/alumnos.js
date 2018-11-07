$( document ).ready(function() {
	console.log("inicio");

	$('.AbrirCalificacion').click(function() {
		console.log($(this).attr('nombreAlumno'));
		var nombAlumno = $(this).attr('nombreAlumno');
		var codAlumno = $(this).attr('codAlumno');
		console.log(codAlumno);
		$('#alumnoACalificar').text(nombAlumno);
		$('#modalCalificacion').modal('show')
	});

	$("#buscarAlumno").on("keyup", function() {
		console.log("HOLI");
        var value = $(this).val().toLowerCase();
        $("#listaAlumnos tr").filter(function() {
          $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
      });
    });

});

