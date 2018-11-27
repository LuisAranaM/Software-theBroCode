$( document ).ready(function() {
	console.log("inicioR");
	$( "#rubricas" ).css("border-right", "5px solid #1ABB9C");

	$(document).on({
		mouseenter: function () {
			$( this ).find("i.fa-trash").show();
			$( this ).find("i.fa-pen").show();
		},
		mouseleave: function () {
			$( this ).find("i.fa-trash").hide();
			$( this ).find("i.fa-pen").hide();
		}
	}, '.indicadorBox');

		$(document).on({
		mouseenter: function () {
			$( this ).find("i.fa-trash").show();
			$( this ).find("i.fa-pen").show();
		},
		mouseleave: function () {
			$( this ).find("i.fa-trash").hide();
			$( this ).find("i.fa-pen").hide();
		}
	}, '.resultadoBox');


	$("#abrir").on("click", function(){
		$("#modalIndicador").modal("show");
	})

	$(".btnCargarAlumnos2").on("click", function(){
		var cod = $(this).data('id');
		$(".modal-body #bookId").val( cod );
		$("#modalCargarAlumnos").modal("show");
	})

	$(document).on("click",".indicadorTrash", function(e){

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

	$(document).on("click",".resultTrash", function(e){
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
		$(".ordenIndicador").val("");
		$(".descripcionIndicador").val("");
		$(".descNom").val("");
		$(".desc").val("");
		$('#agregarFilaIcono').remove();
		$('#removeAgregar').remove();
		$('#filasDescs').remove();
		$('#numDescripciones').attr("value", 3);
		var html='<div id="filasDescs" class="row rowFinal2">'
		html+='<div class="col-md-6 col-xs-12 no-padding">'
		html+='<div id="" class="col-xs-12 text-left" style="padding-botom: 6px; padding-right: 5px; padding-top: 8px">'
		html+='<p class="pText descOrd" numdesc="1" style="font-size: 16px; font-family: segoe UI semibold; color: black">Nivel 1</p>'
		html+='</div>'
		html+='<div id="" class="col-xs-12" style="padding-bottom: 6px; padding-left: 10px">'
		html+='<textarea type="text" id="txt" class="descNom form-control pText customInput" name="nombre" placeholder="Código" rows="1" cols="30" style="resize: none;" ></textarea>'
		html+='</div>'
		html+='<div id="" class="col-xs-12">'
		html+='<textarea type="text" id="txtDescripcion" class="desc form-control pText customInput" name="nombre" placeholder="Descripción" rows="3" cols="30" style="resize: none;" ></textarea>'
		html+='</div>'
		html+='</div>'

		html+='<div class="col-md-6 col-xs-12 no-padding">'
		html+='<div id="" class="col-xs-12 text-left" style="padding-botom: 6px; padding-right: 5px; padding-top: 8px">'
		html+='<p class="pText descOrd" numdesc="2" style="font-size: 16px; font-family: segoe UI semibold; color: black">Nivel 2</p>'
		html+='</div>'
		html+='<div id="" class="col-xs-12" style="padding-bottom: 6px; padding-left: 10px">'
		html+='<textarea type="text" id="txt" class="descNom form-control pText customInput" name="nombre" placeholder="Código" rows="1" cols="30" style="resize: none;" ></textarea>'
		html+='</div>'
		html+='<div id="" class="col-xs-12">'
		html+='<textarea type="text" id="txtDescripcion" class="desc form-control pText customInput" name="nombre" placeholder="Descripción" rows="3" cols="30" style="resize: none;" ></textarea>'
		html+='</div>'
		html+='</div>'

		html+='<div id="contenedorAgregar" class="col-xs-12 no-padding">'
		html+='<div id="removeAgregar" class="col-lg-5 col-xs-4 text-left" style="padding-top: 15px">'
		html+='<p class="pText">Agregar nueva valorización</p>'
		html+='</div>'
		html+='<div id="agregarFilaIcono" class="col-md-2 col-sm-2 text-left" style="padding-top: 10px; margin-left: -40px">'
		html+='<i class="fa fa-plus-circle fa-2x" style="color: #005b7f; padding-top: 2px"></i>'
		html+='</div>'
		html+='</div>'
		
		$('#filasDesc').append(html);
		$("#modalIndicador").modal("show");
		$("#modalIndicador").val($(this).attr('id'));

	});

	$("#AgregarResultado").on("click", function(e){
		
		$("#ModalTitle").text("Agregar Nuevo Resultado" );
		$(".nombreResultado").val("");
		$(".descripcionResultado").val("");
		$('#agregarFilaIcono').remove();
		$('#filasCats').remove();
		var html = '<div id="filasCats">';
		html+='<div id="" class="col-xs-11" style="padding-bottom: 6px">'
		html+='<textarea type="text" id="txtCategoria" class="cat form-control pText customInput" name="nombre" placeholder="Nombre de la categoría" rows="1" cols="30" style="resize: none;" ></textarea>'
		html+='</div>'

		html+='<div id="agregarFilaIcono" class="col-xs-1" style="padding-left: 2px; padding-top: 2px">'
		html+='<i id="btnAgregarFila" class="fa fa-plus-circle fa-2x" style="color: #005b7f"></i>'
		html+='</div>'
		html+='</div>'
		$('#filasCat').append(html);
		$("#modalAgregarResultado").modal("show");
		e.preventDefault();
	});

	$(document).on("click",".resultadoEdit", function(){
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

	$(document).on("click",".indicadorEdit", function(){
		var codigo= $(this).parent().prev('div').find('p').attr("value");
		var descripcion=$(this).parent().next('div').find('p').text();
		var resultado = $('#ResultadoNombre').attr("value");

		$("#ModalTitle").text("Indicador " + resultado + "." + codigo);
		$(".ordenIndicador").val(codigo);
		console.log(codigo);
		$(".descripcionIndicador").val(descripcion);
		console.log(descripcion);
		$("#modalIndicador").val($(this).parent().parent().parent().parent().attr('cat'));
		console.log($('#modalIndicador').val());
		obtenerDescripciones($(this).attr("id"));
	});


	$("#CargarResultado").on("click", function(){
		//console.log("Cargando Resultados");
		$("#modalResultados").modal("show");
	});


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
				insertarResultados(codRes,descRes,cat);
				e.preventDefault();			
			} else {
				alert("Ingrese todos los campos del Resultado");
			}
		}	
	});


	$('#btnAgregarIndicador').on('click', function(e) {

		var res= $('#Resultado').attr("value");
		var ind = $('#txtIndicador').val();
		var idCat= $('#modalIndicador').val();
		var ordenInd= $('#txtOrdenInd').val();
		ordenInd = ordenInd.replace(/[^\d]+/g,'');
		if(ordenInd==""){
			alert("Oops! El código del indicador debe ser numerico. Vuelva a ingresarlo por favor");
			return;
		} 
		var descs = []
		var descsNom= []
		var descsOrd= []
		var descsId=[]
		$('#filasDesc .desc').each(function() {
			descs.push( $(this).val());
			descsId.push($(this).parent().attr("id"));
		});

		$('#filasDesc .descNom').each(function() {
			descsNom.push( $(this).val());
		});

		$('#filasDesc .descOrd').each(function() {
			descsOrd.push( $(this).attr("numdesc"));
		});
		//console.log(cat[1]);
		if ($("#ModalTitle").text()!="Agregar Nuevo Indicador"){
			var idInd= $("#modalIndicador").attr("idInd");
			actualizarIndicador(idInd,ind,ordenInd,descs,descsNom,descsOrd,descsId,res,idCat);
			e.preventDefault();
		}else{
			console.log("si llega aca");
			if(ind!="" && ordenInd!="" && descs[0]!="" && descsNom[0]!="" && descsOrd[0]!=""){
				insertarIndicadores(idCat,ind,ordenInd,descs,descsNom,descsOrd,res);
				e.preventDefault();			
			} else {
				alert("Ingrese todos los campos del Indicador");
			}
		}
		
	});
	$(document).on('click','#filasCat .fa-plus-circle ' ,function(e) {
		$('#agregarFilaIcono').remove();
		html=''
		html+='<div id="eliminarFilaIcono" class="col-xs-1" style="padding-left: 2px; padding-top: 2px">'
		html+='<i class=" fas fa-trash fa-trash-add fa-md" style="color: #005b7f; cursor: pointer;"></i>'
		html+='</div>'
		html+='<div id="" class="col-xs-11" style="padding-bottom: 6px">'
		html+='<textarea type="text" id="txtCategoria" class="cat form-control pText customInput" name="nombre" placeholder="Nombre de la categoría" rows="1" cols="30" style="resize: none;" ></textarea>'
		html+='</div>'
		html+='<div id="agregarFilaIcono" class="col-xs-1" style="padding-left: 2px; padding-top: 2px">'
		html+='<i id="btnAgregarFila" class="fa fa-plus-circle fa-2x" style="color: #005b7f"></i>'
		html+='</div>'
		$('#filasCats').append(html);

		e.preventDefault();
	});

	$(document).on('click','#filasCat .fa-trash-add' ,function(e) {
		$(this).parent().prev('div').remove();
		$(this).parent().remove();
		e.preventDefault();
	});
	$(document).on('click','#filasCat .fa-trash-edit' ,function(e) {
		$(this).parent().prev('div').remove();
		$(this).parent().remove();
		e.preventDefault();
	});



	//Agregar nueva valorizacion
	$(document).on('click','#filasDesc .fa-plus-circle ' ,function(e) {
		var nivel = $('#numDescripciones').attr("value");
		$('#contenedorAgregar').remove();
		$('#removeAgregar').remove();
		$('#agregarFilaIcono').remove();
		html=''
		html+='<div class="col-md-6 col-xs-12 no-padding">'
		html+='<div id="" class="col-xs-12 text-left" style="padding-botom: 6px; padding-right: 5px; padding-top: 8px">'
		html+='<p class="pText descOrd" numdesc="'+nivel+'" style="font-size: 16px; font-family: segoe UI semibold; color: black">Nivel ' + nivel + ' </p>'
		html+='</div>'
		html+='<div id="" class="col-xs-12" style="padding-bottom: 6px; padding-left: 10px">'
		html+='<textarea type="text" id="txt" class="descNom form-control pText customInput" name="nombre" placeholder="Código" rows="1" cols="30" style="resize: none;" ></textarea>'
		html+='</div>'
		html+='<div id="" class="col-xs-12">'
		html+='<textarea type="text" id="txtDescripcion" class="desc form-control pText customInput" name="nombre" placeholder="Descripción" rows="3" cols="30" style="resize: none;" ></textarea>'
		html+='</div>'	  
		html+='</div>'
		html+='<div id="contenedorAgregar" class="col-xs-12 no-padding">'
		html+='<div id="removeAgregar" class="col-lg-5 col-xs-4 text-left" style="padding-top: 15px">'
		html+='<p class="pText">Agregar nueva valorización</p>'
		html+='</div>'
		html+='<div id="agregarFilaIcono" class="col-md-2 col-sm-2 text-left" style="padding-top: 10px; margin-left: -40px">'
		html+='<i class="fa fa-plus-circle fa-2x" style="color: #005b7f; padding-top: 2px"></i>'
		html+='</div>'
		html+='</div>'
		$('#filasDescs').append(html);
		nivel++;
		$('#numDescripciones').attr("value", nivel);
	});

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
			result = JSON.parse(result);
			if(result== -2){
				alert("Oops! Ya existe una descripcion con el orden ingresado. Vuelva a editarlo por favor");
				return -2;
			}
			return 1;
		},
		error: function (xhr, status, text) {
			alert('Hubo un error al insertar una de las descripciones');
		}

	});
}
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
				html+='<div id="eliminarFilaIcono" class="col-xs-1" style="padding-left: 2px; padding-top: 2px">'
				html+='<i class=" fas fa-trash fa-trash-edit fa-md" style="color: #005b7f; cursor: pointer;"></i>'
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
		},
		error: function (xhr, status, text) {
			alert('Hubo un error al obtener las categorias');
		}
	});
}

const http = {
	get: function({
		path,
		data,
		success,
		error,

	}) {
		return $.ajax({
			url: APP_URL + path,
			type: 'GET',
			headers: {},
			data: data,
			success: success,
			error: error,
			dataType: 'text'
		})
	}
}


function obtenerDescripciones(idInd){
	/*http.get({
		path: '/rubricas/obtener-descripciones',
		data: {
			_idInd: idInd
		},
		success: result => {

		},
		error: (xhr, status, text) => {

		}
	})*/
	$.ajax({
		url: APP_URL + '/rubricas/obtener-descripciones',
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
			var descripciones = result;
			$('#agregarFilaIcono').remove();
			$('#removeAgregar').remove();
			$('#filasDescs').remove();
			var html='<div id="filasDescs" class="row rowFinal2">'
			for(i=0;i<descripciones.length;i++){
				html+='<div class="col-md-6 col-xs-12 no-padding">'
				html+='<div id="'+descripciones[i].ID_DESCRIPCION+'" class="col-xs-12 text-left" style="padding-botom: 6px; padding-right: 5px; padding-top: 8px">'
				html+='<p class="pText descOrd" numdesc="'+descripciones[i].VALORIZACION+'" style="font-size: 16px; font-family: segoe UI semibold; color: black">Nivel ' + descripciones[i].VALORIZACION + '</p>'
				html+='</div>'
				html+='<div id="'+descripciones[i].ID_DESCRIPCION+'" class="col-xs-12" style="padding-bottom: 6px; padding-left: 10px">'
				html+='<textarea type="text" id="txt" class="descNom form-control pText customInput" name="nombre" placeholder="Código" rows="1" cols="30" style="resize: none;" >'+descripciones[i].NOMBRE_VALORIZACION+'</textarea>'
				html+='</div>'
				html+='<div id="'+descripciones[i].ID_DESCRIPCION+'" class="col-xs-12">'
				html+='<textarea type="text" id="txtDescripcion" class="desc form-control pText customInput" name="nombre" placeholder="Descripción" rows="3" cols="30" style="resize: none;" >'+descripciones[i].NOMBRE+'</textarea>'
				html+='</div>'	  
				html+='</div>'	
			}
			$('#numDescripciones').attr("value", descripciones.length + 1);
			console.log($('#numDescripciones').attr("value") );
			html+='</div>'
			html+='<div id="contenedorAgregar" class="col-xs-12 no-padding">'
			html+='<div id="removeAgregar" class="col-lg-5 col-xs-4 text-left" style="padding-top: 15px">'
			html+='<p class="pText">Agregar nueva valorización</p>'
			html+='</div>'
			html+='<div id="agregarFilaIcono" class="col-md-2 col-sm-2 text-left" style="padding-top: 10px; margin-left: -40px">'
			html+='<i class="fa fa-plus-circle fa-2x" style="color: #005b7f; padding-top: 2px"></i>'
			html+='</div>'
			$('#filasDesc').append(html);
			$("#modalIndicador").modal("show");
			$("#modalIndicador").attr("idInd",idInd);
		},
		error: function (xhr, status, text) {
			alert('Hubo un error al obtener las descripciones');
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
			var s = indicadores[0];
			console.log(indicadores.length);
			var html = '<div id="'+idCat+'rem">';
			for(i=0;i<indicadores.length; i++){
				
				html+='<div class="indicadorBox row" style="background-color: white; padding: 10px; border-radius: 5px; margin-bottom: 10px; box-shadow: 1px 2px #a9aaaa">'
				html+='<div class="col-xs-9">'
				html+='<p class="pText" value="'+indicadores[i].VALORIZACION+'" style="font-weight: bold; color: #72777a">'+resultado+'.'+indicadores[i].VALORIZACION+'</p>'
				html+='</div>'
				html+='<div class="col-xs-3" style="text-align: right">'
				html+='<i id="'+indicadores[i].ID_INDICADOR+'"class="indicadorEdit fas fa-pen fa-md" style="color: #72777a; cursor: pointer; opacity: 0.7; display: none" id ="EditarIndicador"></i>'
				html+='<i id="'+indicadores[i].ID_INDICADOR+'" class="indicadorTrash fas fa-trash fa-md" style="color: #72777a; padding-left: 6px; cursor: pointer; opacity: 0.7; display: none"></i>'
				html+='</div>'
				html+='<div class="col-xs-12">'
				html+='<p class="pText">'+indicadores[i].NOMBRE+'</p>'
				html+='</div>'
				html+='</div>'
			} 	
			html+='<div class="row text-left" style="padding-top: 5px">'
			html+='<p id="'+idCat+'"  class="pText agregarIndicador" style="color: #72777a; opacity: 0.8; cursor: pointer; font-size: 16px"><i class="fas fa-plus"></i> Agregar nuevo indicador</p>'
			html+='</div>'
			html+='</div>'
			$('#'+idCat+'Ord').append(html);
			$("#modalIndicador").modal("hide");			
		},
		error: function (xhr, status, text) {
			alert('Hubo un error al refrescar los indicadores');
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
			result = JSON.parse(result);
			var categorias = result;
			var catEliminados=[];
			var countEliminados=0;
			for(j=0; j<categorias.length;j++){
				var idCatExistente= categorias[j].ID_CATEGORIA;
				var eliminado =1 ;
				for(i=0; i<catIds.length;i++){
					var idCatNoElimnado= catIds[i]
					if(idCatExistente==idCatNoElimnado){
						eliminado=0;
						break;
					}
				}
				if(eliminado==1){
					catEliminados[countEliminados]=idCatExistente;
					countEliminados++;
				} 
			}
			if(countEliminados==categorias.length){
				alert('No puedes eliminar todas las categorias!');
				return;
			}
			for(k=0;k<countEliminados;k++){
				borrarCategoria(catEliminados[k]);
			}
			for(i=0; i<cat.length;i++){
				console.log(cat[i]);
				if(cat[i]=="") 
					if(catIds[i]=="") continue;
					else alert('No puedes dejar en blanco el nombre de una categoria');
				else{
					if(catIds[i]=="") insertarCategorias(cat[i],idRes); //inserta una categoria
					else actualizarCategoria(catIds[i],cat[i]);
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
function actualizarIndicador(idInd,ind,ordenInd,descs,descsNom,descsOrd,descsId,res,idCat){
	$.ajax({
		type:'POST',
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		},
		url: APP_URL + '/rubricas/actualizar-indicador',
		data: {
			_idInd: idInd,
			_codInd: ordenInd,
			_descInd: ind,
			_idRes: res,	
		},
		dataType: "text",
		success: function(result){
			result = JSON.parse(result);
			if(result== -2){
				alert("Oops! Ya existe un indicador con este orden. Ingrese otro orden por favor");
				return;
			}
			else{
				for(i=0; i<descs.length;i++){
					console.log(descs[i]);
					//si se deja n campo totalmente vacio se elimina o se obvia
					if(descs[i]=="" && descsNom[i]==""){
						if(descsId[i]!=""){
							borrarDescripcion(descsId[i]);
							continue;
						}
						else continue;
					}
					//si al menos un campo se deja vacio
					if(descs[i]=="" || descsNom[i]==""){
						alert("Para eliminar la descripcion, deje todos los campos en blanco! Si no, complete los datos faltantes");
						return;
					}
					//si tiene todos los campos llenos y un id se actualiza, si no tiene id se inserta
					if(descsId[i]!=""){
						console.log("BONI");
						var resp =actualizarDescripcion(descsId[i],descs[i],descsNom[i],descsOrd[i],idInd);
						if(resp==-2) break;							
					} else {
						var resp =insertarDescripciones(descs[i],descsNom[i], descsOrd[i], idInd);
						if(resp==-2) break;
					}
					
				}
				$("#modalIndicador").modal("hide");
				//falta refrescar la pagina
				var resultado = $('#ResultadoNombre').attr("value");
				refrescarIndicadores(idCat,resultado);
			}
			//refrescarIndicadores(idCat,res);
		},
		error: function (xhr, status, text) {
			alert('Hubo un error al actualizar el resultado');
		}
	})
}
function actualizarDescripcion(idDesc,desc,descNom,descOrd,idInd){
	$.ajax({
		type:'POST',
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		},
		url: APP_URL + '/rubricas/actualizar-descripcion',
		data: {
			_id: idDesc,
			_desc: desc,
			_descNom: descNom,
			_descOrd: descOrd,
			_idInd: idInd,	
		},
		dataType: "text",
		success: function(result){
			result = JSON.parse(result);
			if(result== -2){
				alert("Oops! Ya existe una descripcion con el orden ingresado. Vuelva a editarlo por favor");
				return -2;
			}
			return 1;
			
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
function borrarDescripcion(id){
	$.ajax({
		type:'POST',
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		},
		url: APP_URL + '/rubricas/borrar-descripcion',
		data: {
			_id: id
		},
		dataType: "text",
		success: function(result) {
			//window.location = APP_URL + "/rubricas/gestion";

		},
		error: function (xhr, status, text) {
			console.log(id);
			alert('Hubo un error al eliminar una de las descripciones');
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
				if(cat[i]=="") continue;
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
		async: false
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
			_idRes: resultado,
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
					var resp=insertarDescripciones(descs[i],descsNom[i],descsOrd[i], idInd);
					if (resp==-2){
						break;						
					} 
				}
				var res = $('#ResultadoNombre').attr("value");
				refrescarIndicadores(idCat,res);
			}

			//window.location = APP_URL + "/rubricas/categorias?idRes=" + idRes +"&resultado="+res;			
		},
		error: function (xhr, status, text) {

			alert('Hubo un error al registrar la información');
		}
	});
	
}