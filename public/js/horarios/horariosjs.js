$( document ).ready(function() {
	console.log("inicio");
	$("#btnAgregarHorario").on("click", function(){
		console.log("btn accionado");
		//$('#frmCursos')[0].reset();
		$("#modalHorarios").modal("show");



	});

	$('#btnCancelarHorarios').click(function() {
		$('#modalHorarios').modal('hide');
	});
	function actualizarChecks(){

		console.log("Holis");
		//Ajax
		$.ajax({
			url: APP_URL+ ':8000/actualizar-horarios',
			type:'POST',			 
			success: function(result){

			}
		});

	}

	$('#btnActualizarHorarios').click(function() {
		
		actualizarChecks();	
		/*$('.get_value').each(function(){
			if($(this).is(":checked")){
				console.log($(this).val());
				actualizar(checkBox);
			}
		});
		
		$('#modalHorarios').modal('hide');
		*/
	});

	$("#btnAgregarCriterios").on("click", function(){
		console.log("btn accionado");
		$("#modalCriterios").modal("show");
	});

	

});