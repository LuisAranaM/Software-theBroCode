$( document ).ready(function() {

	$("#btnCopiarConfiguracionObj").on("click", function(e){
		console.log("Copiamos la configuración");
    //$('#frmNuevoUsuario').trigger("reset");           
    $('#modalConfiguracionObj input[type="text"]').val('');     
    //$('#frmNuevoUsuario').formValidation('destroy', true);
    //initializeFormUsuario();
    $("#modalConfiguracionObj").modal("show");

});

	$("#btnMostrarConfiguracionObj").on("click", function(e){

		var idSemestre=$('#cboSemestreConfiguracion').val();
		var semestre=document.getElementById('cboSemestreConfiguracion').
		options[document.getElementById('cboSemestreConfiguracion').selectedIndex].text;
		var nombreEspecialidad=$('#nombreEspecialidad').val();

		$('#modalConfiguracionMObjostrar #tituloModalConfirmacion').text('Semestre '+semestre+' - '+nombreEspecialidad);     

		console.log("Mostramos la configuración en otro modal");
		$("#modalConfiguracionObj").modal("hide");
		informacionObj(idSemestre);
		$("#modalConfiguracionMObjostrar").modal("show");

	});


	function informacionObj(idSemestre){
		console.log("HOLI boli");
		console.log(idSemestre);
		$.ajax({
			url: APP_URL + '/configuracionSemestreObj',
			type: 'GET',        
			data:{
				idSemestre:idSemestre
			},
			success: function (result) {
				//console.log(result);
				 var html='';
				console.log(result.length);
				if(result.length==0){
					html+='<label>No se encontraron resultados</label>';
					$('#btnAceptarCopiaObj').attr('disabled',true);
				}
				else{
					console.log("elseeeee");
					for (var i = 0; i < result.length; i++) {     
						html+='<div class="row">';
						
						html+='<label style="font-weight:bold;color:black;text-align:justify">';
						
						if(result[i].TIPO==1)
							html+='SO: ';
						else
							html+='EO: ';
						html+=result[i].NOMBRE+'</label>';

						html+='</div>';
					} 

				}
				$('#interiorConfirmacion').append(html);
				$('#idSemestreConfirmado').val(idSemestre);
			},
			error: function (xhr, status, text) {
				e.preventDefault();
				alert('Hubo un error al consultar la información');
			}
		});
	}

})