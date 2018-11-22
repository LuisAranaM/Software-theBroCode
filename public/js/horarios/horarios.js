$( document ).ready(function() {
	$('#home-tabM1').tab('show');
	$('.primero1').tab('show');

	$("#btnAgregarHorario").on("click", function(){
		$("#modalHorarios").modal("show");
	});

	$("#btnAgregarResultado").on("click", function(){
		$("#modalResultados").modal("show");
		
	});

    $(".btnCargarAlumnos2").on("click", function(){
        var codCurso = $(this).data('codCurso');
        $(".modal-body #codCurso").val( codCurso );
        $("#modalCargarAlumnos").modal("show");
    });

	//Selecciona todos los checkbox de los indicadores de un resultado
	$('.selectAll').click(function() {
		
		var idResultado=$(this).attr('idResultado');
		console.log("seleccionar todo "+idResultado);
        if ($(this).prop('checked')) {
            $('.checkbox_class'+idResultado).prop('checked', true);
        } else {
            $('.checkbox_class'+idResultado).prop('checked', false);
        }
    });

	$('#btnCancelarHorarios').click(function() {
		$('#modalHorarios').modal('hide');
	});
	$('#btnCargarAlumnos').click(function() {
		console.log("btnCargarAlumnos accionado");
		$("#modalCargar").modal("show")
		$("#CargarCursos").hide();
		$("#CargarHorarios").hide();
		$("#CargarAlumnos").show();

		$("#btnCargarAlumnosModal").show();
		$("#btnCargarCursosModal").hide();
		$("#btnCargarHorariosModal").hide();

		$("#btnCancelarModal").show();
	});

	function updateHorarios(horarios,estado){
		$.ajax({
			type:'POST',
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			url: APP_URL+'/horarios/actualizar-horarios',
			data: {
				estadoEvaluacion: estado,
				idHorarios: horarios

			},
			success: function(resultData) {
				window.location.reload();
			}
		});
	}

	$('.closeHorario').on('click', function(e) {
        var idHorario=$(this).attr('idHorario');
		var nombreHorario=$(this).attr('nombreHorario');
        var resp=confirm("¿Estás seguro que deseas dejar de evaluar "+nombreHorario+"?");
        var botonHorario=$(this).closest('div').closest('div');
        if (resp == true) {
            eliminarHorarioEvaluar(idHorario,botonHorario);            
		}
		  
	});

	function eliminarHorarioEvaluar(idHorario,botonHorario){
		$.ajax({
			type: 'POST',  
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			url: APP_URL + '/horarios/eliminar-evaluacion-horario',
			data:{
				idHorario:idHorario,
			},
			success: function (result) {
				botonHorario.hide();
				window.location.reload(); 
			},
			error: function (xhr, status, text) {
				e.preventDefault();
				alert('Hubo un error al registrar la información');
				item.removeClass('hidden').prev().addClass('hidden');
			}
		});
	}

	$('#btnActualizarHorarios').click(function() {
		var horariosSeleccionados=[];
		var estadoAcreditacion=[];
		$('.get_value').each(function(){
			if($(this).is(":checked"))
				estadoAcreditacion.push(1);
			else{
				estadoAcreditacion.push(0);
			}
			horariosSeleccionados.push($(this).val());
		});

		//Aquí falta el refrescar Horarios
		$('#modalHorarios').modal('hide');
		updateHorarios(horariosSeleccionados,estadoAcreditacion);
		
	});

	function updateIndicadores(indicadores,estado,idCurso){
		$.ajax({
			type:'POST',
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			url: APP_URL + '/actualizar-indicadores-curso',
			data: {
				estadoIndicadores: estado,
				idIndicadores: indicadores,
				idCurso: idCurso
			},
			success: function (result) {
				window.location.reload();
			}
			
		});
	}
	$('#btnCancelarIndicadores').click(function() {
		$('#modalResultados').modal('hide');
		window.location.reload();
	});

	$('#btnActualizarIndicadores').click(function() {
		var idIndicadores=[];
		var estadoIndicadores=[];
		$('.get_valor').each(function(){
			if($(this).is(":checked"))
				estadoIndicadores.push(1);
			else{
				estadoIndicadores.push(0);
			}
			idIndicadores.push($(this).val());
		});
		$('#modalResultados').modal('hide');
		updateIndicadores(idIndicadores,estadoIndicadores,$(this).attr('idCurso'));
		
	});

});

