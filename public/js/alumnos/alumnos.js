$( document ).ready(function() {
	console.log("inicio");


	

	$("#buscarAlumno").on("keyup", function() {
		console.log("HOLI");
		var value = $(this).val().toLowerCase();
		$("#listaAlumnos tr").filter(function() {
			$(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
		});
	});	


	function fetchResultados(idResultado,idCurso,idAlumno,idHorario)
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
				idHorario:idHorario,
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
		var idHorario = $(this).attr("idHorario");
		var idHorario = $(this).attr("idHorario");
		var idAlumno = $(this).attr("idAlumno");
		var nombAlumno = $(this).attr('nombreAlumno');
		$('#alumnoACalificar').text(nombAlumno);
		//console.log(idResultado);
		fetchResultados(idResultado,idCurso,idAlumno,idHorario);
	});

	$(document).on('click', '.previous', function(){
		var idResultado = $(this).attr("id");
		var idCurso = $(this).attr("idCurso");
		var idAlumno = $(this).attr("idAlumno");
		var idHorario = $(this).attr("idHorario");
		var nombAlumno = $(this).attr('nombreAlumno');
		$('#alumnoACalificar').text(nombAlumno);
		fetchResultados(idResultado,idCurso,idAlumno,idHorario);
	});

	$(document).on('click', '.next', function(){
		var idResultado = $(this).attr("id");
		var idCurso = $(this).attr("idCurso");
		var idAlumno = $(this).attr("idAlumno");
		var idHorario = $(this).attr("idHorario");
		var nombAlumno = $(this).attr('nombreAlumno');
		$('#alumnoACalificar').text(nombAlumno);
		fetchResultados(idResultado,idCurso,idAlumno,idHorario);
	});

	$(document).on('click', '.btnCriteria', function(){
		//console.log('HOLA');
		$(this).find('input').attr('checked','true');
		var idAlumno = $(this).attr('idAlumno');
		var idHorario = $(this).attr('idHorario');
		var idIndicador = $(this).attr('idIndicador');
		var idCategoria = $(this).attr('idCategoria');
		var idResultado = $(this).attr('idResultado');
		var idDescripcion = $(this).attr('idDescripcion');
		var escalaCalif = $(this).attr('escalaCalif');
		calificarAlumno(idAlumno,idHorario,idIndicador,idCategoria,idResultado,idDescripcion,escalaCalif);
		/*console.log(idAlumno);
		console.log(idHorario);
		console.log(idIndicador);
		console.log(idCategoria);
		console.log(idResultado);
		console.log(idDescripcion);
		console.log(escalaCalif);*/
	});


	function calificarAlumno(idAlumno,idHorario,idIndicador,idCategoria,idResultado,idDescripcion,escalaCalif)	{
		$.ajax({
			type:'POST',
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			url:APP_URL+'/agregar-calificacion-alumno',
			data:{
				idAlumno:idAlumno,
				idHorario:idHorario,
				idIndicador:idIndicador,
				idCategoria:idCategoria,
				idResultado:idResultado,
				idDescripcion:idDescripcion,
				escalaCalif:escalaCalif,
			},
			success:function(result)
			{
				console.log("Se agregó correctamente");
			},error: function (xhr, status, text) {
            e.preventDefault();
            alert('Hubo un error al registrar la información');           
        }
		});
	}
});




