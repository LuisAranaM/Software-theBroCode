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

		
	});

	$(document).on('click', '.elimAlumno', function(){
		//console.log('HOLA');
		var idAlumno=$(this).attr('idAlumno');
		var nombreAlumno=$(this).attr('nombreAlumno');
		var idHorario=$(this).attr('idHorario');
		var filaAlumno=$(this).parent().parent().parent();
		var resp=confirm("¿Estás seguro que deseas eliminar a "+nombreAlumno+"?");
        var botonCurso=$(this).closest('div').closest('div');
        if (resp == true) {
            eliminarAlumno(idAlumno,idHorario,filaAlumno);          
			//.css('display','none');
        } 
        e.preventDefault();    
		
	});

	function eliminarAlumno(idAlumno,idHorario,filaAlumno)	{
		$.ajax({
			type:'POST',
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			url:APP_URL+'/eliminar-alumno-horario',
			data:{
				idAlumno:idAlumno,				
				idHorario:idHorario,				
			},
			success:function(result)
			{
				filaAlumno.css('display','none');
			},error: function (xhr, status, text) {
            e.preventDefault();
            alert('Hubo un error al registrar la información');           
        }
		});
	}


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

	$body = $("body");

$(document).on({
    ajaxStart: function() { 
    	$('#modalCalificacion').css('z-index',1000);
    	$body.addClass("loading");    
    },
     ajaxStop: function() { 
    	$('#modalCalificacion').css('z-index',2000);
     	$body.removeClass("loading");
     	 }    
});
});




