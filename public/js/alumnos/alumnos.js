$( document ).ready(function() {
	console.log("inicio");

	/*$('.AbrirCalificacion').click(function() {
		console.log($(this).attr('nombreAlumno'));
		var nombAlumno = $(this).attr('nombreAlumno');
		var codAlumno = $(this).attr('codAlumno');
		console.log(codAlumno);
		$('#alumnoACalificar').text(nombAlumno);
		$('#modalCalificacion').modal('show')
	});*/

	$("#buscarAlumno").on("keyup", function() {
		console.log("HOLI");
		var value = $(this).val().toLowerCase();
		$("#listaAlumnos tr").filter(function() {
			$(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
		});
	});	


	function fetchResultados(idResultado,idCurso,idAlumno)
	{
		$.ajax({
			type:'POST',
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			url:APP_URL+'/modal-calificar-fetch-resultados',
			data:{
				idResultado:idResultado,
				idCurso:idCurso,
				idAlumno:idAlumno,
			},
			success:function(data)
			{
				console.log("Holas");
				$('#modalCalificacion').modal('show');
				$('#detalleModal').html(data);
			}
		});
	}

	$(document).on('click', '.view', function(){
		var idResultado = $(this).attr("id");
		var idCurso = $(this).attr("idCurso");
		var idAlumno = $(this).attr("idAlumno");
		var nombAlumno = $(this).attr('nombreAlumno');
		$('#alumnoACalificar').text(nombAlumno);
		//console.log(idResultado);
		fetchResultados(idResultado,idCurso,idAlumno);
	});

	$(document).on('click', '.previous', function(){
		var idResultado = $(this).attr("id");
		var idCurso = $(this).attr("idCurso");
		var idAlumno = $(this).attr("idAlumno");
		var nombAlumno = $(this).attr('nombreAlumno');
		$('#alumnoACalificar').text(nombAlumno);
		fetchResultados(idResultado,idCurso,idAlumno);
	});

	$(document).on('click', '.next', function(){
		var idResultado = $(this).attr("id");
		var idCurso = $(this).attr("idCurso");
		var idAlumno = $(this).attr("idAlumno");
		var nombAlumno = $(this).attr('nombreAlumno');
		$('#alumnoACalificar').text(nombAlumno);
		fetchResultados(idResultado,idCurso,idAlumno);
	});



	/*$("#example-basic").steps({
    headerTag: "h3",
    bodyTag: "section",
    transitionEffect: "slideLeft",
    autoFocus: true
});*/
});




