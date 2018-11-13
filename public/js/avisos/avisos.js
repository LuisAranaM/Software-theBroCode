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
		var cadena =  $('#daterange').val();
		var fechas = convertirDateRange(cadena);
		console.log(fechas[0]);
		console.log(fechas[1]);
		insertarAvisos($("#textoAviso").val(), fechas[0], fechas[1]);
		$("#modalAvisos").modal("hide");		
	});

	function convertirDateRange(range) {
		var fechas = range.split(" - ");
		fecha1 = fechas[0].split("/");
		fecha2 = fechas[1].split("/");
		fechas[0] = fecha1[2] + "-" + fecha1[0] + "-" + fecha1[1];
		fechas[1] = fecha2[2] + "-" + fecha2[0] + "-" + fecha2[1];
		return fechas;
    }


	function insertarAvisos(desc, fechaIni, fechaFin) {
		//console.log("HOLA");
		$.ajax({
			url: APP_URL + 'avisos/generar-aviso',
			type:'POST',
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			data: {
				_desc: desc,
				_fechaIni: fechaIni,
				_fechaFin: fechaFin,
			},
			dataType: "text",
			success: function(result) {
				html=''
				html+='<div class="x_content bs-example-popovers courseContainer" style="cursor:pointer">'
				html+='<div class="courseButton alert alert-success alert-dismissible fade in" role="alert">'
				html+='<button type="button" class="closeaviso close" data-dismiss="alert" aria-label="Close" codigoaviso="6" fechasaviso="01/25/2018" textoaviso="Se acrca la fecha de cierre de notas, por favor concluir con las calificaciones."><span aria-hidden="true">×</span></button>'
				html += '<p class="pText">' + fechaIni + ' a ' + fechaFin + ' : ' + desc + '</p'
				html += '</div>'
				html += '</div>'
				$('#listaAvisos').prepend(html);
				
			},
			error: function (xhr, status, text,e) {
			alert('Hubo un error al registrar la información');
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

	$('.closeaviso').on('click', function(e) {
        var idAviso=$(this).attr('idAviso');
        var resp=confirm("¿Seguro que deseas eliminar este aviso?");
        var botonAviso=$(this).parent().parent();
        console.log(botonAviso);
        if (resp == true) {
            eliminarAviso(idAviso, botonAviso);            
        }
        botonAviso.hide();
        e.preventDefault();        
    });

    function eliminarAviso(idAviso, botonAviso){
    //console.log("Necesitamos agregar cursos");
    $.ajax({
        url: APP_URL + 'avisos/eliminar-aviso',
        type: 'POST',        
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data:{
            _idAviso: idAviso,
        },
        success: function (result) {
            botonAviso.hide();
        },
        error: function (xhr, status, text) {
            alert('Hubo un error al eliminar este aviso.');
        }
    });

   

}

});