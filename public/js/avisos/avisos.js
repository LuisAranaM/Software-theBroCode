$( document ).ready(function() {
	console.log("inicioAvisos");


	$("#CargarAviso").on("click", function(){
		$("#modalAvisos").modal("show");
	});

	$("#btnAgregar").on("click", function(){
		if($("#textoAviso").val().length==0){
			$('#btnAgregar').attr('disabled',true);                
		}
		else{
			$('#btnAgregar').removeAttr('disabled');        
		}
	});


	function insertarAvisos(idInd) {
		$.ajax({
			url: APP_URL + '/avisos/generar-aviso',
			type:'POST',
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			data: {
				_id: idRes,
				_desc: desc,
				_fechaIni: fechaIni,
				_fechaFin: fechaFin,
			},
			dataType: "text",
			success: function(result) {
				html=''
				html+='<div class="courseButton alert alert-success alert-dismissible fade in" role="alert">'
				html+='<button type="button" class="closeaviso close" data-dismiss="alert" aria-label="Close" codigoaviso="6" fechasaviso="01/25/2018" textoaviso="Se acrca la fecha de cierre de notas, por favor concluir con las calificaciones."><span aria-hidden="true">×</span></button>'
				html+='<div id="'+result[i].ID_CATEGORIA+'" class="courseButton alert alert-success alert-dismissible fade in" role="alert">'
				<p class="pText">{{$a->FECHA_INICIO}} a {{$a->FECHA_FIN}} : {{$a->DESCRIPCION}}</p>
				
			}
		});
	}

	$(function() {
		$('input[name="daterange"]').daterangepicker({
			opens: 'left'
		}, function(start, end, label) {
			console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
		});
	});
});