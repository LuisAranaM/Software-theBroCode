$( document ).ready(function() {
	
	console.log("inicioR");

	$(".btnCargarAlumnos2").on("click", function(){
		var cod = $(this).data('id');
		$(".modal-body #bookId").val( cod );
		$("#modalCargarAlumnos").modal("show");
	})

	$(".indicadorTrash").on("click", function(e){

		//var codigoCurso=$(this).attr('codigoCurso');
        //var nombreCurso=$(this).attr('nombreCurso');
        var resp=confirm("¿Estás seguro de que deseas eliminar este indicador?");
        //var botonCurso=$(this).closest('div').closest('div');
        if (resp == true) {
            //eliminarCursoAcreditar(codigoCurso,botonCurso); 
            var id= $(this).attr('id');
            borrarIndicador(id); 
            $(this).parent().parent().remove();          
        } 
        e.preventDefault();
    });

	$(".resultTrash").on("click", function(e){
		//var codigoCurso=$(this).attr('codigoCurso');
        //var nombreCurso=$(this).attr('nombreCurso');
        var resp=confirm("¿Estás seguro de que deseas eliminar este indicador?");
        //var botonCurso=$(this).closest('div').closest('div');
        if (resp == true) {
            //eliminarCursoAcreditar(codigoCurso,botonCurso);  
            var id= $(this).attr('id');
            console.log(id);
            borrarResultado(id);          
            $(this).parent().parent().parent().parent().parent().remove();
        } 
        e.preventDefault();
    });

	$(document).on("click",".agregarIndicador", function(){
		
		$("#ModalTitle").text( "Agregar Nuevo Indicador" );
		$(".nombreIndicador").val("");
		$(".descripcionIndicador").val("");
		$("#modalIndicador").modal("show");
		$("#modalIndicador").val($(this).attr('id'));
	});

	$("#AgregarResultado").on("click", function(){
		
		$("#ModalTitle").text("Agregar Nuevo Resultado" );
		$(".nombreResultado").val("");
		$(".descripcionResultado").val("");
		$("#modalAgregarResultado").modal("show");
	});

	$(".resultadoEdit").on("click", function(){
		var codigo= $(this).parent().prev('div').find('p').text();
		var descripcion=$(this).parent().next('a').find('p').text();

		$("#ModalTitle").text("Editar Resultado" );
		console.log($("#ModalTitle").text());
		$(".nombreResultado").val(codigo);
		console.log(codigo);
		$(".descripcionResultado").val(descripcion);
		console.log(descripcion);
		obtenerCategorias($(this).parent().attr("value"));
	});

	$(".indicadorEdit").on("click", function(){
		var codigo= $(this).parent().prev('div').find('p').text();
		var descripcion=$(this).parent().next('div').find('p').text();

		$("#ModalTitle").text("Editar Indicador");
		$(".nombreIndicador").val(codigo);
		console.log(codigo);
		$(".descripcionIndicador").val(descripcion);
		console.log(descripcion);
		$("#modalIndicador").modal("show");
	});


	$("#CargarResultado").on("click", function(){
		//console.log("Cargando Resultados");
		$("#modalResultados").modal("show");
	});



	$("#hola").click(function () {
        //$("#hola").hide();
    });
    //no pongo seleccion en validaciones pues esa casilla depende de indicadores 
    //y no hay más listas que desprendan de validaciones

    $('#btnAgregarResultado').on('click',function(e) {
    	var codRes = $('#txtCodigoResultado').val();
    	var descRes = $('#txtResultado').val();
    	var cat = [];
    	var catIds= [];
    	$('#filasCats .cat').each(function() {
    		cat.push( $(this).val());
    		catIds.push($(this).parent().attr("id"));
    	});
    	if ($("#ModalTitle").text()=="Editar Resultado"){
    		var idRes= $("#modalAgregarResultado").val();
    		actualizarResultado(idRes,codRes,descRes,cat,catIds);
    		e.preventDefault();	
    	}else{    		
			//console.log(cat[1]);
			console.log("si llega aca");
			if(codRes!="" && descRes!="" && cat[0]!=""){
				//insertarResultados(codRes,descRes,cat);
				e.preventDefault();			
			} else {
				alert("Ingrese todos los campos del Resultado");
			}
    	}	
	});


    $('#btnAgregarIndicador').on('click', function(e) {

    	var ind = $('#txtIndicador').val();
    	var idCat= $('#modalIndicador').val();
    	var ordenInd= $('#txtOrdenInd').val();
    	var descs = []
    	var descsNom= []
    	var descsOrd= []
    	$('#filasDesc .desc').each(function() {
    		descs.push( $(this).val());
    		console.log($(this).val());
    	});

    	$('#filasDesc .descNom').each(function() {
    		descsNom.push( $(this).val());
    	});

    	$('#filasDesc .descOrd').each(function() {
    		descsOrd.push( $(this).val());
    	});
		//console.log(cat[1]);
		console.log("si llega aca");
		if(ind!="" && ordenInd!="" && descs[0]!="" && descsNom[0]!="" && descsOrd[0]!=""){

			var res= $('#Resultado').attr("value");
			console.log(res)
			insertarIndicadores(idCat,ind,ordenInd,descs,descsNom,descsOrd,res);
			e.preventDefault();			
		} else {
			alert("Ingrese todos los campos del Indicador");
		}
	});

    $('#filasCats').on('click','.fa-plus-circle' ,function(e) {
    	$('#agregarFilaIcono').remove();
    	html=''
    	html+='<div id="" class="col-xs-11" style="padding-bottom: 6px">'
    	html+='<textarea type="text" id="txtCategoria" class="cat form-control pText customInput" name="nombre" placeholder="Nombre de la categoría" rows="1" cols="30" style="resize: none;" ></textarea>'
    	html+='</div>'
    	html+='<div id="agregarFilaIcono" class="col-xs-1" style="padding-left: 2px; padding-top: 2px">'
    	html+='<i id="btnAgregarFila" class="fa fa-plus-circle fa-2x" style="color: #005b7f"></i>'
    	html+='</div>'
    	$('#filasCats').append(html);

    	e.preventDefault();
    });

    $('#filasDesc').on('click','.fa-plus-circle' ,function(e) {
    	$('#agregarFilaIcono').remove();
    	$('#removeAgregar').remove();
    	html='<div class="col-xs-6" style="padding-bottom: 6px; padding-right: 5px; padding-top: 15px">'
		html+='<textarea type="text" id="txt" class="descOrd form-control pText customInput" name="nombre" placeholder="Orden" rows="1" cols="30" style="resize: none" ></textarea>'
		html+='</div>'
		html+='<div class="col-xs-6" style="padding-bottom: 6px; padding-left: 5px; padding-top: 15px">'
		html+='<textarea type="text" id="txt" class="descNom form-control pText customInput" name="nombre" placeholder="Nombre" rows="1" cols="30" style="resize: none;" ></textarea>'
		html+='</div>'
		html+='<div class="col-xs-12">'
		html+='<textarea type="text" id="txtDescripcion" class="desc form-control pText customInput" name="nombre" placeholder="Descripción" rows="3" cols="30" style="resize: none;" ></textarea>'
		html+='</div>'
		html+='<div id="removeAgregar" class="col-lg-6 col-xs-5 text-left" style="padding-top: 15px">'
		html+='<p class="pText">Agregar nueva valorización</p>'
		html+='</div>'
		html+='<div id="agregarFilaIcono" class="col-md-2 col-sm-2 text-left" style="padding-top: 10px; margin-left: -40px">'
		html+='<i class="fa fa-plus-circle fa-2x" style="color: #005b7f; padding-top: 2px"></i>'
		html+='</div>'
    	$('#filasDesc').append(html);

    	e.preventDefault();
    });


});
function obtenerCategorias(idRes){
	$.ajax({
		url: APP_URL + '/rubricas/obtener-categorias',
		type:'GET',
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		},
		data: {
			_idRes: idRes,
		},
		dataType: "text",
		success: function(result) {
			result = JSON.parse(result);
			var categorias = result;
			$('#agregarFilaIcono').remove();
	    	$('#filasCats').remove();
			var html = '<div id="filasCats">';

			for (i = 0; i <categorias.length-1; i++) {
		    	html+='<div id="'+categorias[i].ID_CATEGORIA+'" class="col-xs-11" style="padding-bottom: 6px">'
		    	html+='<textarea type="text" id="txtCategoria" class="cat form-control pText customInput" name="nombre" rows="1" cols="30" style="resize: none;" >'+categorias[i].NOMBRE+'</textarea>'
		    	html+='</div>'
			}
			html+='<div id="'+categorias[categorias.length-1].ID_CATEGORIA+'" class="col-xs-11" style="padding-bottom: 6px">'
	    	html+='<textarea type="text" id="txtCategoria" class="cat form-control pText customInput" name="nombre" rows="1" cols="30" style="resize: none;" >'+categorias[categorias.length-1].NOMBRE+'</textarea>'
	    	html+='</div>'
	    	html+='<div id="agregarFilaIcono" class="col-xs-1" style="padding-left: 2px; padding-top: 2px">'
	    	html+='<i id="btnAgregarFila" class="fa fa-plus-circle fa-2x" style="color: #005b7f"></i>'
	    	html+='</div>'
	    	html+='</div>'
	    	$('#filasCat').append(html);
			$("#modalAgregarResultado").modal("show");
			$("#modalAgregarResultado").val(idRes);
		}
	});
}
function refrescarIndicadores(idCat,resultado){
	$.ajax({
		url: APP_URL + '/rubricas/refrescar-indicadores',
		type:'GET',
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		},
		data: {
			_idCat: idCat,
		},
		dataType: "text",
		success: function(result) {
			result = JSON.parse(result);
			var indicadores = result;
			console.log("llega justo antes");
			$('#'+idCat+'rem').remove();
			console.log("llega justo despues");
			var html = '<div id="'+idCat+'rem">';
			for(i=0;i<indicadores.length; i++){
				html+='<div class="row">'
				html+='<hr>'
				html+='<div class="col-xs-9">'
				html+='<p class="pText" style="font-weight: bold; color: black">'+resultado+'.'+indicadores[i].VALORIZACION+'</p>'
				html+='</div>'
				html+='<div class="col-xs-3" style="text-align: right">'
				html+='<i id="'+indicadores[i].ID_INDICADOR+'" class="indicadorEdit fa fa-pencil fa-lg" style="color: #005b7f; cursor: pointer " id ="EditarIndicador"></i>'
				html+='<i id="'+indicadores[i].ID_INDICADOR+'" class="indicadorTrash fa fa-trash fa-lg" style="color: #005b7f; padding-left: 2px; cursor: pointer"></i>'
				html+='</div>'
				html+='<div class="col-xs-12">'
				html+='<p class="pText">'+indicadores[i].NOMBRE+'</p>'
				html+='</div>'
				html+='</div>'
			} 	
			html+='<hr>'
			html+='<div class="row text-center">'
			html+='<p id="'+idCat+'" class="pText agregarIndicador" style="color: #005b7f; cursor: pointer">Agregar nuevo indicador</p>'
			html+='</div>'
			html+='</div>'
			$('#'+idCat+'Ord').append(html);
			$("#modalIndicador").modal("hide");			
		}
	});
}
function refrescarEscalas(idInd){
	$.ajax({
		url: APP_URL + '/rubricas/refrescar-escalas',
		type:'GET',
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		},
		data: {
			_idInd: idInd,
		},
		dataType: "text",
		success: function(result) {
			result = JSON.parse(result);
			console.log(result);
			$('#myDIVValorizaciones').remove();
			var html = '';
			if(result.length >0){
				html+='<div id="myDIVValorizaciones" class="myDIVValorizacionesclass">'
				html+='<div class="x_content bs-example-popovers courseContainer">'
				html+='<div class="courseButton alert alert-success alert-dismissible fade in" role="alert">'
				html+='<button id="btnClose" type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>'
				html+='</button>'
				html+='<p class="pText">'+ result[0] +'</p>'
				html+='</div>'
				html+='</div>'
			}

			for(i = 1; i <result.length; i++){
				html+='<div class="x_content bs-example-popovers courseContainer">'
				html+='<div class="courseButton alert alert-success alert-dismissible fade in" role="alert">'
				html+='<button id="btnClose" type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>'
				html+='</button>'
				html+='<p class="pText">'+ result[i]+'</p>'
				html+='</div>'
				html+='</div>'
			}
			html+='</div>'
			$('#apEsc').append(html);
		}
	});
}
function actualizarResultado(idRes,codRes,descRes,cat,catIds){
	$.ajax({
		type:'POST',
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		},
		url: APP_URL + '/rubricas/actualizar-resultado',
		data: {
			_idRes: idRes,
			_codRes: codRes,
			_descRes: descRes,			
		},
		dataType: "text",
		success: function(result){
			for(i=0; i<cat.length;i++){
				console.log(cat[i]);
				if(catIds[i]=="") continue;
				if(cat[i]=="") borrarCategoria(catIds[i]);
				else{
					actualizarCategoria(catIds[i],cat[i]);
				}
			}
			$("#modalAgregarResultado").modal("hide");
			window.location = APP_URL + "/rubricas/gestion";	
		},
		error: function (xhr, status, text) {
			alert('Hubo un error al actualizar el resultado');
		}
	})
}
function actualizarCategoria(idCat,cat){
	$.ajax({
		type:'POST',
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		},
		url: APP_URL + '/rubricas/actualizar-categoria',
		data: {
			_idCat: idCat,
			_cat: cat,		
		},
		dataType: "text",
		success: function(result){
			
		},
		error: function (xhr, status, text) {
			alert('Hubo un error al actualizar las categorias');
		} 
	})
}

function borrarResultado(id){
	$.ajax({
		type:'POST',
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		},
		url: APP_URL + '/rubricas/borrar-resultado',
		data: {
			_id: id
		},
		dataType: "text",
		success: function(result) {
			//window.location = APP_URL + "/rubricas/gestion";

		},
		error: function (xhr, status, text) {
			alert('Hubo un error al eliminar el Resultado');
		}
	});
}
function borrarCategoria(id){
	$.ajax({
		type:'POST',
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		},
		url: APP_URL + '/rubricas/borrar-categoria',
		data: {
			_id: id
		},
		dataType: "text",
		success: function(result) {
			//window.location = APP_URL + "/rubricas/gestion";

		},
		error: function (xhr, status, text) {
			alert('Hubo un error al eliminar una categoria');
		}
	});
}
function borrarIndicador(id){
	$.ajax({
		type:'POST',
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		},
		url: APP_URL + '/rubricas/borrar-indicador',
		data: {
			_id: id
		},
		dataType: "text",
		success: function(result) {
			//window.location = APP_URL + "/rubricas/gestion";

		},
		error: function (xhr, status, text) {
			console.log(id);
			alert('Hubo un error al eliminar la información');
		}
	});
}
function insertarResultados(codRes,descRes,cat){
	$.ajax({
		type:'POST',
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		},
		url: APP_URL + '/rubricas/insertar-resultados',
		data: {
			_codRes: codRes,
			_descRes: descRes,
		},
		dataType: "text",
		success: function(result) {
			result = JSON.parse(result);
			var idRes= result;	
			for(i=0; i<cat.length;i++){
				console.log(cat[i]);
				insertarCategorias(cat[i], idRes);
			}
			window.location = APP_URL + "/rubricas/gestion";			
		},
		error: function (xhr, status, text,e) {
			e.preventDefault();
			alert('Hubo un error al registrar la información');
		}
	});
}
function insertarCategorias(descCat, idRes){
	$.ajax({
		type:'POST',
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		},
		url: APP_URL + '/rubricas/insertar-categorias',
		data: {
			_descCat: descCat,
			resultado: idRes,
		},
		dataType: "text",
		success: function(result) {
		}
	});
}
function insertarIndicadores(idCat,ind,ordenInd,descs,descsNom,descsOrd,resultado){
	$.ajax({
		type:'POST',
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		},
		url: APP_URL + '/rubricas/insertar-indicadores',
		data: {
			_idCat: idCat,
			_ind: ind,
			_orden: ordenInd,
		},
		dataType: "text",
		success: function(result) {
			result = JSON.parse(result);
			var idInd= result;
			if(idInd== -2){
				alert("Oops! Ya existe un indicador con este orden. Ingrese otro orden por favor");
			}
			else{
				console.log(idInd);
				console.log(descs.length);
				for(i=0; i<descs.length;i++){
					console.log(descs[i]);
					insertarDescripciones(descs[i],descsNom[i],descsOrd[i], idInd);
				}
				refrescarIndicadores(idCat,resultado);
			}

			//window.location = APP_URL + "/rubricas/categorias?idRes=" + idRes +"&resultado="+res;			
		},
		error: function (xhr, status, text) {

			alert('Hubo un error al registrar la información');
		}
	});
	function insertarDescripciones(desc,descNom, descOrd, idInd){
		$.ajax({
			type:'POST',
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			url: APP_URL + '/rubricas/insertar-descripciones',
			data: {
				_desc: desc,
				_descNom: descNom,
				_descOrd: descOrd,
				_idInd: idInd,
			},
			dataType: "text",
			success: function(result) {

			}
		});
	}
}