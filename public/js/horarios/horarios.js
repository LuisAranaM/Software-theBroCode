$( document ).ready(function() {
	$("#btnAgregarHorario").on("click", function(){
		$('#frmCursosModal')[0].reset();
		$("#modalHorarios").modal("show");
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

	function desactivarHorario(horario){
		$.ajax({
			type:'POST',
			headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			url: '/desactivar',
			data: {
				_idHorario: horario
			},
			dataType: "json",
			success: function(resultData) {
			}
		});

	}

	$('#btnClose').click(function() {
		desactivarHorario($(this).val());
	});
	function updateHorarios(idCurso,nombreCurso,codCurso,horarios,estado){
		$.ajax({
			type:'POST',
			headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			url: APP_URL+'/horarios/actualizar-horarios',
			data: {
				id: idCurso,
				nombre: nombreCurso,
				codigo: codCurso,
				estadoAcreditacion: estado,
				idHorarios: horarios
				
			},
			dataType: "json",
			success: function(resultData) {
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
		var idCurso = $('#idCurso').data("field-id");
		var nombreCurso = $('#nombreCurso').data("field-id");
		var codCurso = $('#codCurso').data("field-id");
		
		//Aquí falta el refrescar Horarios
		$('#modalHorarios').modal('hide');
		updateHorarios(idCurso,nombreCurso,codCurso,horariosSeleccionados,estadoAcreditacion);
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