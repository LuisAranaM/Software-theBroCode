$( document ).ready(function() {
	console.log("inicio");

	$("#CargarCurso").on("click", function(){
		console.log("btn accionado");
		$("#modalCursos").modal("show");

	});

	$("#btnCargarAlumnos").on("click", function(){
		console.log("btn accionado");
		$("#modalCargarAlumnos").modal("show");
	});
	
	$("#btnCargarHorario").on("click", function(){
		console.log("btn accionado");
		$("#modalCargarHorarios").modal("show");
	});

	$("#btnCargarCursos").on("click", function(){
		console.log("btn accionado");
		$("#modalCargarCursos").modal("show");
	});


	$('#btnBuscarCurso').click(function (e) {
		//console.log("HOLI");
		buscarCursos($(this));
	});

	$('#txtCursoBuscar').keypress(function (e) {
    	//Búsqueda con Enter
    	if (e.which == 13) {
    		buscarCursos($(this));
    	}
    });

	$('#frmAgregarCursos').on('keyup keypress', function(e) {
		var keyCode = e.keyCode || e.which;
		if (keyCode === 13) { 
			e.preventDefault();
			return false;
		}
	});

});

function buscarCursos(button) {
	console.log('Buscando...');
	var cursoBuscar = $('#txtCursoBuscar').val();
	form = $('#frmAgregarCursos');
	item = button.find('.fa-search');
	item.addClass('hidden').prev().removeClass('hidden');

	$.ajax({
		url: APP_URL + '/cursos/buscar',
		type: 'GET',
		data: {
			cursoBuscar: cursoBuscar
		},
		success: function (result) {
                    //$('#frmNuevaAccionComercial .modal-footer').removeClass('hidden');

                    $('#listaCursos').removeClass('hidden');                        
                    $('#listaCursos .cargando-resultados').addClass('hidden');

                    if (result.length!=0) {

                    	$('#btnsAgregarCurso').removeClass('hidden');
                    	console.log('Se encontró');                   

                    	var i;
                    	var html = '';
                    	html+='<div class="table-responsive">  <table class="table table-striped jambo_table bulk_action">';
                    	html+='<thead><tr class="headings" style="background-color: #005b7f; color: white; font-family: Segoe UI">';
                    	html+='<th class="pText column-title" style="border: none"></th>';
                    	html+='<th class="pText column-title" style="border: none"> Código</th>';
                    	html+='<th class="pText column-title" style="border: none">Curso</th>';
                    	html+='<th class="pText bulk-actions" colspan="7">';
                    	html+='<a class="antoo" style="color:#fff; font-weight:500;">Bulk Actions ( <span class="action-cnt"> ';
                    	html+='</span> ) <i class="fa fa-chevron-down"></i></a>';
                    	html+='</th></tr></thead><tbody class="text-left">';
                    	console.log(result.length);
                    	for (i = 0; i < result.length; ++i) {
                    		html+='<tr class="even pointer">';
                    		html+='<td class="a-center"  style="background-color: white; padding-right: 0px">';
                    		html+='<div class="form-check" style="padding-left: 10px; width: 20px"><label>';
                    		html+='<input type="checkbox" checked="" > <span class="pText label-text "></span>';
                    		html+='</label></div></td>';
                    		html+='<td class="pText" style="background-color: white; padding-top: 12px; color: #72777a;">'+result[i].CODIGO_CURSO+'</td>';
                    		html+='<td class="pText" style="background-color: white; padding-top: 12px; color: #72777a">'+result[i].NOMBRE+'</td>';        
                    		html+='</tr>';
                    	}
                    	html+='</tbody></table></div>'

                    	$('#listaCursos').append(html); 

                    } else {
                    	$('#listaCursos .sin-resultados').removeClass('hidden');                        
                    	console.log('No se encontró');
                    	return;
                    }
                    item.removeClass('hidden').prev().addClass('hidden');

                },
                error: function (xhr, status, text) {
                	e.preventDefault();
                	alert('Hubo un error al buscar la información');
                	item.removeClass('hidden').prev().addClass('hidden');
                }
            });

}



