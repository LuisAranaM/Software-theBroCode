$( document ).ready(function() {
	console.log("inicio");

	$('.AbrirCalificacion').click(function() {
		$('#modalCalificacion').modal('show')
	});

	$("#buscarAlumno").on("keyup", function() {
		console.log("HOLI");
        var value = $(this).val().toLowerCase();
        $("#listaAlumnos tr").filter(function() {
          $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
      });
    });	

	/*$("#example-basic").steps({
    headerTag: "h3",
    bodyTag: "section",
    transitionEffect: "slideLeft",
    autoFocus: true
});*/
});