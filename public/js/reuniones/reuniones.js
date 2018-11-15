$( document ).ready(function() {
	console.log("inicioAvisos");


	$("#ModalCargar").on("click", function(){
		$("#modalCargarDocsReuniones").modal("show");
	});


	$('#anhoInicio').on('paste', function (event) {
		if (event.originalEvent.clipboardData.getData('Text').match(/[^\d]/)) {
			event.preventDefault();
		}
	});

	$("#anhoInicio").on("keypress",function(event){
		if(event.which < 48 || event.which >57){
			return false;
		}
	});

	$("#btnDescargarDoc").on("click", function(){
		console.log("Descargando documentos");
		array = []
		$("input:checkbox[name=checkDocs]:checked").each(function(){
			array.push($(this).val());
		});
		console.log(array);

		
	});
	var anhoInicio;
	var anhoFin;
	$('#btnBuscarDocs').click(function(e) {
		array = []
		$("input:checkbox[name=checkDocs]:checked").each(function(){
			array.push($(this).val());
		});

		anhoInicio = $('#anhoInicio').val();
		//console.log("leyo anho inicio");
		//console.log(anhoInicio);
		semIni = document.getElementById('semIni').options[document.getElementById('semIni').selectedIndex].value;
		//console.log("leyo sem inicio");
		//console.log(semIni);
		anhoFin = $('#anhoFin').val();
		//console.log("leyo anho fin");
		//console.log(anhoFin);
		semFin = document.getElementById('semFin').options[document.getElementById('semFin').selectedIndex].value;
		//console.log("leyo sem fin");
		//console.log(semFin);
		filtrarDocumentosReuniones(anhoInicio,semIni,anhoFin,semFin);
		e.preventDefault();
	});



	function filtrarDocumentosReuniones(anhoInicio,semIni,anhoFin,semFin) {
		console.log(anhoInicio,semIni,anhoFin,semFin);
		$.ajax({
			url: APP_URL + '/resultadosFiltroDocs',
			type: 'GET',
			data: {
				//_token: $('#signup-token').val(),
				anhoInicio:anhoInicio,
				semIni:semIni,
				anhoFin:anhoFin,
				semFin:semFin
			},
			success: function (result) {

				console.log(result.length);
				$('#listaDocumentos').find('tr').remove();
				var html = '';
				for(var i=0;i<result.length;i++){
					html+='<tr class="even pointer" id="">';	
					html+='<td class="pText" style="background-color: white; padding-top: 12px; color: #72777a;text-align: center;vertical-align: center;">'+result[i].DOCUMENTO_ANHO+'-'+result[i].DOCUMENTO_SEMESTRE+'</td>';

					if(result[i].TIPO_DOCUMENTO == "acta"){
						html+='<td class="pText" style="background-color: white; padding-top: 12px; color: #72777a;text-align:';
						html+='center;vertical-align: center;"> Acta de Reunión </td>';
					}else{
						html+='<td class="pText" style="background-color: white; padding-top: 12px; color: #72777a;text-align:';
						html+='center;vertical-align: center;"> Plan de Mejora </td>';
					}


					html+='<td class="pText" style="background-color: white; padding-top: 12px; color: #72777a;text-align:';
					html+='center;vertical-align: center;"><a href="'+APP_URL+'/upload/'+result[i].NOMBRE+'"';
					html+=' download="'+result[i].NOMBRE+'" style="text-decoration: underline;">'+result[i].NOMBRE;
					html+='<i class="fa fa-download" style="padding-left: 5px"></i> </a></td> ';
					html+='<td><label><input type="checkbox" class="form-check-input checkDoc" name="checkDocs[]" value="'+result[i].NOMBRE;
					html+='style="text-align: center;" ><span class="pText label-text "></span></label></td>';

					html+='</tr>';
				}			
				$('#listaDocumentos').append(html); 


			},
			error: function (xhr, status, text) {
           // e.preventDefault();
           alert('Hubo un error al buscar la información');
            //item.removeClass('hidden').prev().addClass('hidden');
        }
    });
	}

});