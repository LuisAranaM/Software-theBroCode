$( document ).ready(function() {
	console.log("inicio");
    
	$("#CargarCurso").on("click", function(){
		console.log("btn accionado");
		$("#modalCursos").modal("show");

	});

    $(".btnCargarAlumnos2").on("click", function(){
        $("#modalCargarAlumnos").modal("show");
    })

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


    //Funciones y activadores de búsqueda
	$('#btnBuscarCurso').click(function (e) {
        //console.log("HOLI CLICK");
        
        var cursoBuscar=$('#txtCursoBuscar').val();
        buscarCursos(cursoBuscar);
    });

    $('#txtCursoBuscar').keypress(function (e) {
        //Búsqueda con Enter
        //console.log("HOLI ENTER");
        var cursoBuscar=$('#txtCursoBuscar').val();
    	if (e.which == 13) {
    		buscarCursos(cursoBuscar);
    	}
    });

	$('#frmAgregarCursos').on('keyup keypress', function(e) {
		var keyCode = e.keyCode || e.which;
		if (keyCode === 13) { 
			e.preventDefault();
			return false;
		}
	});


    /*('#frmAgregarCursos').on('submit', function(e) {
        e.preventDefault();        
        agregarCursosAcreditar();     
    });*/

    $('.closeCurso').on('click', function(e) {
        var codigoCurso=$(this).attr('codigoCurso');
        var nombreCurso=$(this).attr('nombreCurso');
        var resp=confirm("¿Estás seguro que deseas dejar de acreditar "+nombreCurso+"?");
        var botonCurso=$(this).closest('div').closest('div');
        if (resp == true) {
            eliminarCursoAcreditar(codigoCurso,botonCurso);            
        } 
        e.preventDefault();        
    });

    autocompleteCursos();  

    $('.twitter-typeahead').removeAttr('style');

    /*BUSCAR COMO MEJORAR EL Z-INDEX*/
    $('.tt-menu').css('z-index',3000000);
    $('.tt-menu').css('position','relative');
    $('.tt-menu').css('margin-top','35px');
});


function eliminarCursoAcreditar(codigoCurso,botonCurso){
    //console.log("Necesitamos agregar cursos");
    $.ajax({
        url: APP_URL + 'cursos/eliminar-acreditacion',
        type: 'POST',        
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data:{
            codigoCurso:codigoCurso,
        },
        success: function (result) {
                botonCurso.hide();
        },
            error: function (xhr, status, text) {
                e.preventDefault();
                alert('Hubo un error al registrar la información');
                item.removeClass('hidden').prev().addClass('hidden');
            }
        });

}


function agregarCursosAcreditar(){
    console.log("Necesitamos agregar cursos");
    $.ajax({
        url: APP_URL + 'cursos/agregar-acreditacion',
        type: 'GET',        
        success: function (result) {
                //$('#frmNuevaAccionComercial .modal-footer').removeClass('hidden');

                /*$('#listaCursos').removeClass('hidden');                        
                $('#listaCursos .cargando-resultados').addClass('hidden');

                if (result.length!=0) {
                   

                } else {
                   
                }  */                  

            },
            error: function (xhr, status, text) {
                e.preventDefault();
                alert('Hubo un error al registrar la información');
                item.removeClass('hidden').prev().addClass('hidden');
            }
        });

}
function buscarCursos(cursoBuscar) {
	//console.log('Buscando...');
    //console.log(cursoBuscar);
	//var cursoBuscar = $('#txtCursoBuscar').val();
	form = $('#frmAgregarCursos');
	item = $('#btnBuscarCurso').find('.fa-search');
	item.addClass('hidden').prev().removeClass('hidden');

	$.ajax({
		url: APP_URL + 'cursos/buscar',
		type: 'GET',
		data: {
			cursoBuscar: cursoBuscar
		},
		success: function (result) {
                    //$('#frmNuevaAccionComercial .modal-footer').removeClass('hidden');

                    $('#listaCursos').removeClass('hidden');                        
                    $('#listaCursos .cargando-resultados').addClass('hidden');

                    if (result.length!=0) {

                        $('#tablaCursos').find('.table').css('margin-bottom', '0px');
                        $('#btnsAgregarCurso').removeClass('hidden');
                    	$('#tablaCursos').removeClass('hidden');
                    	console.log('Se encontró');                   

                    	var i;
                    	var html = '';

                    	console.log(result.length);
                    	for (i = 0; i < result.length; ++i) {
                    		html+='<tr class="even pointer">';
                    		html+='<td class="a-center"  style="background-color: white; padding-right: 0px">';
                    		html+='<div class="form-check" style="padding-left: 10px; width: 20px"><label>';
                    		html+='<input type="checkbox" class="form-check-input" checked="" name="checkCursos[]" value="'+result[i].CODIGO_CURSO+'" > <span class="pText label-text "></span>';
                    		html+='</label></div></td>';
                    		html+='<td class="pText" style="background-color: white;text-align:center;vertical-align: middle;">'+result[i].CODIGO_CURSO+'</td>';
                    		html+='<td class="pText" style="background-color: white;text-align:center;vertical-align: middle;">'+result[i].NOMBRE+'</td>';        
                    		html+='</tr>';
                    	}
                    	/*html+='</tbody></table></div>'*/

                    	$('#tableBody').append(html); 

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

function autocompleteCursos() {
        var engine = new Bloodhound({
            remote: {
                url: APP_URL + 'cursos/buscar?termino=%Q%',
                wildcard: '%Q%'
            },
            datumTokenizer: Bloodhound.tokenizers.whitespace,
            queryTokenizer: Bloodhound.tokenizers.whitespace
        });
        $('#txtCursoBuscar').typeahead({
            minLength: 3
        }, {
            limit:15,
            display: 'NOMBRE',
            source: engine.ttAdapter(),
            templates: {
                empty: [
                    '<div class="list-group search-results-dropdown searchText top_search" ><div class="list-group-item">No hay resultados</div></div>'
                ],
                suggestion: function (data) {
                    return '<div class="list-group-item searchText" ><a href="#" onclick="buscarCursos('+"'"+data.NOMBRE+"'"+')">' + data.NOMBRE + '</a></div>'
                }
            }
        })
    }
