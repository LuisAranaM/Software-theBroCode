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


	function fetch_post_data(idResultado,idCurso)
	{
		$.ajax({
			type:'POST',
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			url:APP_URL+'/modal-alumnos-fetch',
			data:{
				idResultado:idResultado,
				idCurso:idCurso,
			},
			success:function(data)
			{
				console.log("Holas");
				$('#post_modal').modal('show');
				$('#post_detail').html(data);
			}
		});
	}

	$(document).on('click', '.view', function(){
		var idResultado = $(this).attr("id");
		var idCurso = $(this).attr("idCurso");
		//console.log(idResultado);
		fetch_post_data(idResultado,idCurso);
	});

	$(document).on('click', '.previous', function(){
		var idResultado = $(this).attr("id");
		var idCurso = $(this).attr("idCurso");
		fetch_post_data(idResultado,idCurso);
	});

	$(document).on('click', '.next', function(){
		var idResultado = $(this).attr("id");
		var idCurso = $(this).attr("idCurso");
		//console.log("HOLI");
		fetch_post_data(idResultado,idCurso);
	});



	/*$("#example-basic").steps({
    headerTag: "h3",
    bodyTag: "section",
    transitionEffect: "slideLeft",
    autoFocus: true
});*/
});




