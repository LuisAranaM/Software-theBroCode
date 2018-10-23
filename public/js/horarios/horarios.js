$( document ).ready(function() {
	$("#btnAgregarHorario").on("click", function(){
		$("#modalHorarios").modal("show");
	});

	$("#btnAgregarResultado").on("click", function(){
		$("#modalResultados").modal("show");
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

	$(function(){
		$("ul.checktree").checktree();
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
			dataType: "json",
			success: function(resultData) {
			}
		});
	}

	$('.closeHorario').on('click', function(e) {
		var codigoHorario=$(this).attr('codigoHorario');
		var nombreHorario=$(this).attr('nombreHorario');
		var resp=confirm("¿Estás seguro que deseas dejar de evaluar "+nombreHorario+"?");
		var botonHorario=$(this).closest('div').closest('div');
		if (resp == true) {
			eliminarHorarioEvaluar(codigoHorario,botonHorario);            
		} 
		e.preventDefault();        
	});

	function eliminarHorarioEvaluar(codigoHorario,botonHorario){
		$.ajax({
			url: APP_URL + '/horarios/eliminar-evaluacion-horario',
			type: 'POST',        
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			data:{
				codigoHorario:codigoHorario,
			},
			success: function (result) {
				botonHorario.hide();
			},
			error: function (xhr, status, text) {
				e.preventDefault();
				alert('Hubo un error al registrar la información');
				item.removeClass('hidden').prev().addClass('hidden');
			}
		});
		
	}


	$(".btnAgregarSubcriterios").on("click", function(){
		console.log("he");
		$("#modalAgregarSubcriterio").modal("show");
	});

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
		window.location.reload();
	});

	$("#btnAgregarCriterios").on("click", function(){
		console.log("btn accionado");
		$("#modalCriterios").modal("show");
	});

	//var tabID = new Array();
	//tabID[0] = 0; tabID[1] = 0;
	var tabID = 0;
	$('#btn-add-tab').click(function () {
		tabID++;
		$('#tab-list').append($('<li><a href="#tab' + tabID + '" role="tab" data-toggle="tab">Tab ' + tabID + '<button class="close close-tab-style" type="button" title="Remove this page">×</button></a></li>'));
		$('#tab-content').append($('<div class="tab-pane fade content-tab-style" id="tab' + tabID + '" style="margin-right">  Tab '+ tabID +' content</div>'));
	});
	$('#tab-list').on('click','.close',function(){
		var tabID = $(this).parents('a').attr('href');
		$(this).parents('li').remove();
		$(tabID).remove();
        //display first tab
        //var tabFirst = $('#tab-list a:first');
        //tabFirst.tab('show');
    });

	var list = document.getElementById("tab-list");
	new Sortable(list);
});