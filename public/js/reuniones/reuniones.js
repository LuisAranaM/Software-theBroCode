$( document ).ready(function() {
	console.log("inicioAvisos");


	$("#ModalCargar").on("click", function(){
		$("#modalCargarDocsReuniones").modal("show");
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
	$('#btnBuscarDocs').click(function() {
		array = []
		$("input:checkbox[name=checkDocs]:checked").each(function(){
			array.push($(this).val());
		});

		anhoInicio = $('#anhoInicio').val();
		console.log("leyo anho inicio");
		console.log(anhoInicio);
		semIni = document.getElementById('semIni').options[document.getElementById('semIni').selectedIndex].value;
		console.log("leyo sem inicio");
		console.log(semIni);
		anhoFin = $('#anhoFin').val();
		console.log("leyo anho fin");
		console.log(anhoFin);
		semFin = document.getElementById('semFin').options[document.getElementById('semFin').selectedIndex].value;
		console.log("leyo sem fin");
		console.log(semFin);
		filtrarDocumentosReuniones(array,anhoInicio,semIni,anhoFin,semFin);
	});



	function filtrarDocumentosReuniones(anhoInicio,semIni,anhoFin,semFin) {

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
				var html = '';
				for(var i=0;i<result.length;i++){
					html+='<tr class="even pointer" id="">';	
					html+='<td class="pText" style="background-color: white; padding-top: 12px; color: #72777a;text-align: center;vertical-align: center;">'+result[i].DOCUMENTO_ANHO+'-'+result[i].DOCUMENTO_SEMESTRE+'</td>';

					if(result[i].TIPO_DOCUMENTO == "acta"){
						html+='<td class="pText" style="background-color: white; padding-top: 12px; color: #72777a;text-align: center;vertical-align: center;"> Acta de Reunión </td>';
					}else{
						html+='<td class="pText" style="background-color: white; padding-top: 12px; color: #72777a;text-align: center;vertical-align: center;"> Plan de Mejora </td>';
					}


					html+='<td class="pText" style="background-color: white; padding-top: 12px; color: #72777a;text-align: center;vertical-align: center;"><a href="{{URL::asset("upload/".$documento->NOMBRE)}}" download="{{$documento->NOMBRE}}" style="text-decoration: underline;">{{$documento->NOMBRE}}<i class="fa fa-download" style="padding-left: 5px"></i> </a></td> ';
					html+='<td><label><input type="checkbox" class="form-check-input checkDoc" name="checkDocs[]" value="'+result[i].NOMBRE+'style="text-align: center;" ><span class="pText label-text "></span></label></td>';

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