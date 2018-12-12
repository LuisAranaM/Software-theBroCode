$( document ).ready(function() {
	//muestra y oculta los iconos de "eliminar y editar" de los Indicadores
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

	//muestra y oculta los iconos de "eliminar y editar" de los Resultados
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

	//Elimina un indicador
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

	//Elimina un resultado 
	$(document).on("click",".resultTrash", function(e){
		//var codigoCurso=$(this).attr('codigoCurso');
        //var nombreCurso=$(this).attr('nombreCurso');
        var resp=confirm("¿Estás seguro de que deseas eliminar este resultado?");
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

	//Muestra el Modal de Agregar Resultado
	$("#AgregarResultado").on("click", function(e){
		
		$("#ModalTitle").text("Agregar Nuevo Resultado" );
		$(".nombreResultado").val("");
		$(".descripcionResultado").val("");
		$('#contenedorAE').remove();
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

	//Muestra el Modal de Agregar Indicador
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
		html+='<div class="col-md-6 col-xs-12 no-padding" id="1Contenedor">'
		html+='<div id="1" class="col-xs-6 text-left" style="padding-botom: 6px; padding-right: 5px; padding-top: 8px">'
		html+='<p class="pText descOrd" numdesc="1" style="font-size: 16px; font-family: segoe UI semibold; color: black">Nivel 1</p>'
		html+='</div>'
		html+='<div id="1" class="col-xs-12" style="padding-bottom: 6px; padding-left: 10px">'
		html+='<textarea type="text" id="txt" class="descNom form-control pText customInput" name="nombre" placeholder="Código" rows="1" cols="30" style="resize: none;" ></textarea>'
		html+='</div>'
		html+='<div id="1" class="col-xs-12">'
		html+='<textarea type="text" id="txtDescripcion" class="desc form-control pText customInput" name="nombre" placeholder="Descripción" rows="3" cols="30" style="resize: none;" ></textarea>'
		html+='</div>'
		html+='</div>'

		html+='<div class="col-md-6 col-xs-12 no-padding" id="2Contenedor">'
		html+='<div id="2" class="col-xs-6 text-left" style="padding-botom: 6px; padding-right: 5px; padding-top: 8px">'
		html+='<p class="pText descOrd" numdesc="2" style="font-size: 16px; font-family: segoe UI semibold; color: black">Nivel 2</p>'
		html+='</div>'
		html+='<div id="2" class="col-xs-12" style="padding-bottom: 6px; padding-left: 10px">'
		html+='<textarea type="text" id="txt" class="descNom form-control pText customInput" name="nombre" placeholder="Código" rows="1" cols="30" style="resize: none;" ></textarea>'
		html+='</div>'
		html+='<div id="2" class="col-xs-12">'
		html+='<textarea type="text" id="txtDescripcion" class="desc form-control pText customInput" name="nombre" placeholder="Descripción" rows="3" cols="30" style="resize: none;" ></textarea>'
		html+='</div>'
		html+='<div id="contenedorAE">'
		html+='<div id="contenedorAgregar" class="col-xs-7 text-left" style="padding-botom: 4px; padding-right: 12px; padding-top: 12px; cursor: pointer">'
		html+='<p class="pText">Agregar Valorizacion <i class="fas fa-plus fa-sm" style="padding-left: 2px"> </i></p>'
		html+='</div>'
		html+='<div id="contenedorEliminar" class="col-xs-5 text-right" style="padding-botom: 4px; padding-right: 12px; padding-top: 12px; cursor: pointer">'
		html+='<p class="pText">Eliminar <i class="fas fa-trash fa-sm" style="padding-left: 2px"> </i></p>'
		html+='</div>'
		html+='</div>'
		//html+='<div class="text-right">'
		//html+='<p class="pText">Eliminar...</p>'
		//html+='</div>'
		html+='</div>'
		
		$('#filasDesc').append(html);
		$("#modalIndicador").modal("show");
		$("#modalIndicador").val($(this).attr('id'));
	});

	//Muestra el Modal de Editar Resultado
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

	//Muestra el Modal de Editar Indicador
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

	//Confirmar Agregar Resultado o Editar Resultado
	$('#btnAgregarResultado').on('click',function(e) {
		var codRes = $('#txtCodigoResultado').val();
		var descRes = $('#txtResultado').val();
		var cat = [];
		var catIds= [];
		var valRes= [];
		$('.valRes').each(function() {
			valRes.push( $(this).attr("nombre"));
		});
		for(i=0;i<valRes.length;i++){
			if(valRes[i] == codRes){
				alert("Este código ya existe! Ingrese otro Código de Resultado");
				return;
			};
		}
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

			if(codRes!="" && descRes!="" && cat[0]!=""){
				insertarResultado(codRes,descRes,cat);
				e.preventDefault();			
			} else {
				alert("Ingrese todos los campos del Resultado");
			}
		}	
	});

	//Confrimar Agregar Indicador o Editar Indicador
	$('#btnAgregarIndicador').on('click', function(e) {

		var res= $('#Resultado').attr("value");
		var ind = $('#txtIndicador').val();
		var idCat= $('#modalIndicador').val();
		var ordenInd= $('#txtOrdenInd').val();
		
		
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

		if(ind!="" && ordenInd!="" && descsNom[0]!="" && descs[0]!=""){
			ordenInd = ordenInd.replace(/[^\d]+/g,'');
			if(ordenInd==""){
				alert("Oops! El código del indicador debe ser numerico. Vuelva a ingresarlo por favor");
				$('#txtOrdenInd').focus();
				return;
			}
			for (i = 0; i <descsOrd.length; i++) {
				if((descsNom[i]=="" || descs[i]=="")){
					alert("Oops! Ingrese todos los campos de las descripciones");
					return;
					//$('#filasDesc .descNom:first').focus();						
				}
			}
		}else if(ordenInd==""){
			$('#txtOrdenInd').focus();
			alert("Ingrese todos los campos del Indicador");
			return;
			} else if(ind==""){
				$('#txtIndicador').focus();
				alert("Ingrese todos los campos del Indicador");
				return;
				} else{
					$('#filasDesc .descNom:first').focus();
					alert("Ingrese todos los campos de las descripciones");
					return;
				}

		//console.log(cat[1]);
		if ($("#ModalTitle").text()!="Agregar Nuevo Indicador"){
			var idInd= $("#modalIndicador").attr("idInd");
			console.log(idInd);
			console.log(ind);
			console.log(ordenInd);
			console.log(res);
			actualizarIndicador(idInd,ind,ordenInd,descs,descsNom,descsOrd,descsId,res,idCat);
			e.preventDefault();
		}else{
			insertarIndicador(idCat,ind,ordenInd,descs,descsNom,descsOrd,res);
			e.preventDefault();	
		}
	});

	//Agregar una fila de Categoria en el Modal de Resultado
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

	//Agregar una fila de Descripcion en el Modal de Indicador
	$(document).on('click','#contenedorAgregar' ,function(e) {
		var nivel = $('#numDescripciones').attr("value");
		$('#contenedorAE').remove();
		$('#agregarFilaIcono').remove();
		$('#contenedorEliminar').remove();

		html=''
		html+='<div class="col-md-6 col-xs-12 no-padding" id="'+nivel+'Contenedor">'
		html+='<div id="" class="col-xs-12 text-left" style="padding-botom: 6px; padding-right: 5px; padding-top: 8px">'
		html+='<p class="pText descOrd" numdesc="'+nivel+'" style="font-size: 16px; font-family: segoe UI semibold; color: black">Nivel ' + nivel + ' </p>'
		html+='</div>'
		html+='<div id="" class="col-xs-12" style="padding-bottom: 6px; padding-left: 10px">'
		html+='<textarea type="text" id="txt" class="descNom form-control pText customInput" name="nombre" placeholder="Código" rows="1" cols="30" style="resize: none;" ></textarea>'
		html+='</div>'
		html+='<div id="" class="col-xs-12">'
		html+='<textarea type="text" id="txtDescripcion" class="desc form-control pText customInput" name="nombre" placeholder="Descripción" rows="3" cols="30" style="resize: none;" ></textarea>'
		html+='</div>'	  
		html+='<div id="contenedorAE">'
		html+='<div id="contenedorAgregar" class="col-xs-7 text-left" style="padding-botom: 4px; padding-right: 12px; padding-top: 12px; cursor: pointer">'
		html+='<p class="pText">Agregar Valorizacion <i class="fas fa-plus fa-sm" style="padding-left: 2px"> </i></p>'
		html+='</div>'
		html+='<div id="contenedorEliminar" class="col-xs-5 text-right" style="padding-botom: 4px; padding-right: 12px; padding-top: 12px; cursor: pointer">'
		html+='<p class="pText">Eliminar <i class="fas fa-trash fa-sm" style="padding-left: 2px"> </i></p>'
		html+='</div>'
		html+='</div>'
		html+='</div>'

		$('#filasDescs').append(html);
		nivel++;
		$('#numDescripciones').attr("value", nivel);
	});

	//Eliminar una fila de Categoria en el Modal de Agregar Resultado
	$(document).on('click','#filasCat .fa-trash-add' ,function(e) {
		$(this).parent().prev('div').remove();
		$(this).parent().remove();
		e.preventDefault();
	});

	//Eliminar una fila de Categoria en el Modal de Editar Resultado
	$(document).on('click','#filasCat .fa-trash-edit' ,function(e) {
		$(this).parent().prev('div').remove();
		$(this).parent().remove();
		e.preventDefault();
	});

	//Eliminar Descripcion en el Modal de Indicador
	$(document).on('click','#contenedorEliminar' ,function(e) {
		var nivel = $('#numDescripciones').attr("value") -1;
		if (nivel == 2) {
			alert("Deben haber al menos dos niveles de valorización.");
			return;
		}
		var nivel2 = $('#numDescripciones').attr("value") -2;
		$('#' + nivel + 'Contenedor').remove();
		html=''
		html+='<div id="contenedorAE">'
		html+='<div id="contenedorAgregar" class="col-xs-7 text-left" style="padding-botom: 4px; padding-right: 12px; padding-top: 12px; cursor: pointer">'
		html+='<p class="pText">Agregar Valorizacion <i class="fas fa-plus fa-sm" style="padding-left: 2px"> </i></p>'
		html+='</div>'
		html+='<div id="contenedorEliminar" class="col-xs-5 text-right" style="padding-botom: 4px; padding-right: 12px; padding-top: 12px; cursor: pointer">'
		html+='<p class="pText">Eliminar <i class="fas fa-trash fa-sm" style="padding-left: 2px"> </i></p>'
		html+='</div>'
		html+='</div>'
		$('#'+nivel2+'Contenedor').append(html);
		 $('#numDescripciones').attr("value", nivel);
	});

	

});


//Inserta un Resultado y refresca la pagina de Resultados
function insertarResultado(codRes,descRes,cat){
	$.ajax({
		type:'POST',
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		},
		url: APP_URL + '/rubricas/insertar-resultado',
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
				insertarCategoria(cat[i], idRes);
			}
			window.location = APP_URL + "/rubricas/gestion";			
		},
		error: function (xhr, status, text,e) {
			e.preventDefault();
			alert('Hubo un error al registrar la información');
		}
	});
}

//Inserta una Categoria
function insertarCategoria(descCat, idRes){
  
	$.ajax({
		type:'POST',
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		},
		url: APP_URL + '/rubricas/insertar-categoria',
		data: {
			_descCat: descCat,
			resultado: idRes,
		},
		dataType: "text",
		async: false
	});
}

//Inserta un Indicador y refresca los Indicadores con Ajax
function insertarIndicador(idCat,ind,ordenInd,descs,descsNom,descsOrd,resultado){
	$.ajax({
		type:'POST',
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		},
		url: APP_URL + '/rubricas/insertar-indicador',
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
					if(descsNom[i]=="") continue;
					var resp=insertarDescripcion(descs[i],descsNom[i],descsOrd[i], idInd);
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

//Inserta una Descripcion
function insertarDescripcion(desc,descNom, descOrd, idInd){
	$.ajax({
		type:'POST',
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		},
		url: APP_URL + '/rubricas/insertar-descripcion',
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

//Obtiene las Categorias de un Id de Resultado y Muestra el Modal de Editar Resultado
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

//Obtiene las Descripciones de un Id de Indicador y Muestra el Modal de Editar Indicador
function obtenerDescripciones(idInd){
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
			$('#filasDescs').remove();
			var html='<div id="filasDescs" class="row rowFinal2">'
			for(i=0;i<descripciones.length;i++){
				html+='<div class="col-md-6 col-xs-12 no-padding"  id="'+(i+1)+'Contenedor">'
				html+='<div id="'+descripciones[i].ID_DESCRIPCION+'" class="col-xs-12 text-left" style="padding-botom: 6px; padding-right: 5px; padding-top: 8px">'
				html+='<p class="pText descOrd" numdesc="'+descripciones[i].VALORIZACION+'" style="font-size: 16px; font-family: segoe UI semibold; color: black">Nivel ' + descripciones[i].VALORIZACION + '</p>'
				html+='</div>'
				html+='<div id="'+descripciones[i].ID_DESCRIPCION+'" class="col-xs-12" style="padding-bottom: 6px; padding-left: 10px">'
				html+='<textarea type="text" id="txt" class="descNom form-control pText customInput" name="nombre" placeholder="Código" rows="1" cols="30" style="resize: none;" >'+descripciones[i].NOMBRE_VALORIZACION+'</textarea>'
				html+='</div>'
				html+='<div id="'+descripciones[i].ID_DESCRIPCION+'" class="col-xs-12">'
				html+='<textarea type="text" id="txtDescripcion" class="desc form-control pText customInput" name="nombre" placeholder="Descripción" rows="3" cols="30" style="resize: none;" >'+descripciones[i].NOMBRE+'</textarea>'
				html+='</div>'
				if (i<descripciones.length -1) {	  
					html+='</div>'	
				}
			}
			$('#numDescripciones').attr("value", descripciones.length + 1);
			console.log($('#numDescripciones').attr("value") );
			html+='<div id="contenedorAE">'
			html+='<div id="contenedorAgregar" class="col-xs-7 text-left" style="padding-botom: 4px; padding-right: 12px; padding-top: 12px; cursor: pointer">'
			html+='<p class="pText">Agregar Valorizacion <i class="fas fa-plus fa-sm" style="padding-left: 2px"> </i></p>'
			html+='</div>'
			html+='<div id="contenedorEliminar" class="col-xs-5 text-right" style="padding-botom: 4px; padding-right: 12px; padding-top: 12px; cursor: pointer">'
			html+='<p class="pText">Eliminar <i class="fas fa-trash fa-sm" style="padding-left: 2px"> </i></p>'
			html+='</div>'
			html+='</div>'
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

//Refresca los Indicadores de la Pagina una vez confirmado el Modal de Editar o Agregar Indicador
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

//Actualiza un Resultado una vez confirmado el Modal de Editar Resultado
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
					if(catIds[i]=="") insertarCategoria(cat[i],idRes); //inserta una categoria
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

//Actualiza una Categoria
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

////Actualiza un Indicador una vez confirmado el Modal de Editar Indicador y refresca la pagina con ajax
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
			if(result[0]== -2){
				alert("Oops! Ya existe un indicador con este orden. Ingrese otro orden por favor");
				return;
			}
			else{
				var descripciones = result[1];
				var descEliminados=[];
				var countEliminados=0;
				for(j=0; j<descripciones.length;j++){
					var idDescExistente= descripciones[j].ID_DESCRIPCION;
					var eliminado =1 ;
					for(i=0; i<descsId.length;i++){
						var idDescNoEliminado= descsId[i]
						if(idDescExistente==idDescNoEliminado){
							eliminado=0;
							break;
						}
					}
					if(eliminado==1){
						descEliminados[countEliminados]=idDescExistente;
						countEliminados++;
					}
				}

				if(countEliminados==descripciones.length){
					alert('No puedes eliminar todas las descripciones!');
					return;
				}
				for(k=0;k<countEliminados;k++){
					borrarDescripcion(descEliminados[k]);
				}

				for(i=0; i<descs.length;i++){
					console.log(descs[i]);
					if(descs[i]=="" || descsNom[i]==""){
						if(descsId[i]="") continue;
						else{
							alert('No puedes dejar en blanco un descripcion');
							return;
						}
					}
					
					//si tiene todos los campos llenos y un id se actualiza, si no tiene id se inserta
					if(descsId[i]!=""){
						var resp =actualizarDescripcion(descsId[i],descs[i],descsNom[i],descsOrd[i],idInd);
						if(resp==-2) break;							
					} else {
						var resp =insertarDescripcion(descs[i],descsNom[i], descsOrd[i], idInd);
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
			alert('Hubo un error al actualizar el indicador');
		}
	})
}

//Actualiza una Descripcion
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

//Borra un Resultado
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

//Borra una Categoria
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

//Borra un Indicador
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

//Borra una Descripcion
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
