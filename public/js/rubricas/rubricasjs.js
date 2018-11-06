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



	$(".agregarIndicador").on("click", function(){
        if($('.checkCurso:checked').length==0){
            $('#btnAgregar').attr('disabled',true);                
        }
        else{
            $('#btnAgregar').removeAttr('disabled');        
        }
        $("#ModalTitle").text( "Agregar Nuevo Indicador" );
        $(".nombreIndicador").val("");
        $(".descripcionIndicador").val("");
		$("#modalIndicador").modal("show");
		$("#modalIndicador").val($(this).attr('id'));
	});

	$("#AgregarResultado").on("click", function(){
        if($('.checkCurso:checked').length==0){
            $('#btnAgregar').attr('disabled',true);                
        }
        else{
            $('#btnAgregar').removeAttr('disabled');        
        }
        $("#ModalTitle").text("Agregar Nuevo Resultado" );
		$("#modalAgregarResultado").modal("show");
	});

	$(".resultadoEdit").on("click", function(){
        if($('.checkCurso:checked').length==0){
            $('#btnAgregar').attr('disabled',true);                
        }
        else{
            $('#btnAgregar').removeAttr('disabled');        
        }
        $("#ModalTitle").text("Editar Resultado" );
		$("#modalAgregarResultado").modal("show");
	});

	$(".indicadorEdit").on("click", function(){
		var codigo= $(this).parent().prev('div').find('p').text();
		var descripcion=$(this).parent().next('div').find('p').text();

        $("#ModalTitle").text("Editar Indicador" );
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
		var cat = []

		$('#filasCat .cat').each(function() {
        	cat.push( $(this).val());
    	});
		//console.log(cat[1]);
		console.log("si llega aca");
		insertarResultados(codRes,descRes,cat);
		e.preventDefault();
		
	});


	$('#btnAgregarIndicador').click(function(e) {

		var ind = $('#txtIndicador').val();
		var idCat= $('#modalIndicador').val();
		var descs = []

		$('#filasDesc .desc').each(function() {
        	descs.push( $(this).val());
    	});
		//console.log(cat[1]);
		console.log("si llega aca");
		insertarIndicadores(idCat,ind,descs);
		e.preventDefault();
	});

	$('#filasCat').on('click','.fa-plus-circle' ,function(e) {
		$('#agregarFilaIcono').remove();
		html=''
		html+='<div class="col-xs-11" style="padding-bottom: 6px">'
		html+='<textarea type="text" id="txtCategoria" class="cat form-control pText customInput" name="nombre" placeholder="Nombre de la categoría" rows="1" cols="30" style="resize: none;" ></textarea>'
        html+='</div>'
        html+='<div id="agregarFilaIcono" class="col-xs-1" style="padding-left: 2px; padding-top: 2px">'
        html+='<i id="btnAgregarFila" class="fa fa-plus-circle fa-2x" style="color: #005b7f"></i>'
        html+='</div>'
		$('#filasCat').append(html);

		e.preventDefault();
	});

	

});
function refrescarCategorias(idRes,sel,idSel){
	$.ajax({
		url: APP_URL + '/rubricas/refrescar-categorias',
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
			$('#myDIVCategorias').remove();
            var html = '';
            if(result.length >0){
            	html+= '<div id="myDIVCategorias" class="myDIVCategoriasclass">'
			
				html+= '<div class="x_content bs-example-popovers courseContainer">'
				html+= '<div id="'+result[0].ID_RESULTADO+'" class="courseButton activeButton alert alert-success alert-dismissible fade in" role="alert">'
				html+= '<button id="btnClose" type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>'
				html+= '</button>'
				html+= '<p class="pText">'+result[0].NOMBRE+'</p>'
				html+= '</div>'
				html+= '</div>'
            }

			for (i = 1; i <result.length; i++) {
				html+= '<div class="x_content bs-example-popovers courseContainer">'
				html+= '<div id="'+result[i].ID_RESULTADO+'" class="courseButton alert alert-success alert-dismissible fade in" role="alert">'
				html+= '<button id="btnClose" type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>'
				html+= '</button>'
				html+= '<p class="pText">'+result[i].NOMBRE+'</p>'
				html+= '</div>'
				html+= '</div>'
			}
			if(result.length>0){
				html+='</div>'
				$('#apCat').append(html);
			}
			if(sel==1){
		    	$('#myDIVCategorias .courseButton').removeClass('activeButton');
		    	$('#myDIVCategorias div.courseButton:last').addClass('activeButton');

		    	$('#myDIVIndicadores .courseButton').removeClass('activeButton');
		    	$('.myDIVIndicadoresclass div.courseButton:first').addClass('activeButton');
				refrescarIndicadores(idSel);
		    	$('html,body').animate({ 
		    		scrollTop: $(".divindicadores").offset().top},
		    		500);		 					
			}else{
				if(result.length>0){
					refrescarIndicadores(result[0].ID_RESULTADO);
				}else{
					refrescarIndicadores();
				}
			}
		}
	});
}
function refrescarIndicadores(idCat,sel,idSel){
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
			$('#myDIVIndicadores').remove();
            var html = '';
            if(result.length >0){
            	html+='<div id="myDIVIndicadores" class="myDIVIndicadoresclass">'

            	html+='<div class="x_content bs-example-popovers courseContainer">'
	      		html+='<div id="'+result[0].ID_SUBCRITERIO+'" class="courseButton activeButton alert alert-success alert-dismissible fade in" role="alert">'
	        	html+='<button id="btnClose" type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>'
	       	 	html+='</button>'
	        	html+='<p class="pText">'+result[0].NOMBRE+'</p>'
	    	  	html+='</div>'
	  			html+='</div>'
            }

			for (i = 1; i <result.length; i++) {
				html+='<div class="x_content bs-example-popovers courseContainer">'
	      		html+='<div id="'+result[i].ID_SUBCRITERIO+'" class="courseButton alert alert-success alert-dismissible fade in" role="alert">'
	        	html+='<button id="btnClose" type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>'
	       	 	html+='</button>'
	        	html+='<p class="pText">'+result[i].NOMBRE+'</p>'
	    	  	html+='</div>'
	  			html+='</div>'
			}
			if(result.length>0){
				html+='</div>'
				$('#apInd').append(html);
			}
			if(sel==1){
		    	$('#myDIVIndicadores .courseButton').removeClass('activeButton');
		    	$('#myDIVIndicadores div.courseButton:last').addClass('activeButton');

				refrescarEscalas(idSel);
		    	$('html,body').animate({
				scrollTop: $(document).height() - $(window).height()},
				500);					
			}else{
				if(result.length>0){
					refrescarEscalas(result[0].ID_SUBCRITERIO);
				}else{
					$('#myDIVValorizaciones').remove();
				}
			}
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
function refrescarResultados(idRes){
	$.ajax({
		type:'GET',
		headers: {
		'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		},
		url: APP_URL + '/rubricas/refrescar-resultados',
		data: {
		},
		dataType: "text",
		success: function(result){
			result = JSON.parse(result);
			$('#myDIVResultados').remove();
            var html = '';
            	html+='<div id="myDIVResultados" class="myDIVResultadosclass">'
			if(result.length >0){
            	html+='<div class="x_content bs-example-popovers courseContainer">'
	      		html+='<div id="'+result[0].ID_CATEGORIA+'" class="courseButton activeButton alert alert-success alert-dismissible fade in" role="alert">'
	        	html+='<button id="btnClose" type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>'
	       	 	html+='</button>'
	        	html+='<p class="pText">'+result[0].NOMBRE+' '+result[0].DESCRIPCION+'</p>'
	    	  	html+='</div>'
	  			html+='</div>'
            }

			for (i = 1; i <result.length; i++) {
				html+='<div class="x_content bs-example-popovers courseContainer">'
	      		html+='<div id="'+result[i].ID_CATEGORIA+'" class="courseButton alert alert-success alert-dismissible fade in" role="alert">'
	        	html+='<button id="btnClose" type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>'
	       	 	html+='</button>'
	        	html+='<p class="pText">'+result[i].NOMBRE+' '+result[i].DESCRIPCION+'</p>'
	    	  	html+='</div>'
	  			html+='</div>'
			}
			html+='</div>'
			$('#apRes').append(html);

			refrescarCategorias(idRes);
	    	$('#myDIVResultados .courseButton').removeClass('activeButton');
	    	$('#myDIVResultados div.courseButton:last').addClass('activeButton');

	    	$('html,body').animate({ 
	    		scrollTop: $(".divcategorias").offset().top},
	    		500);
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
			window.location = APP_URL + "/rubricas/gestion";

		},
		error: function (xhr, status, text,e) {
        	e.preventDefault();
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
function insertarIndicadores(idCat, ind, descs){
	$.ajax({
		type:'POST',
		headers: {
		'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		},
		url: APP_URL + '/rubricas/insertar-indicadores',
		data: {
			_idCat: idCat,
			_ind: ind,
		},
		dataType: "text",
		success: function(result) {
			//result = JSON.parse(result);
			var idInd= result;	
			for(i=0; i<descs.length;i++){
				console.log(descs[i]);
				insertarDescripciones(descs[i], idInd);
			}
		$('#filasInd').remove();
		html=''
		html+='<div class="col-xs-11" style="padding-bottom: 6px">'
		html+='<textarea type="text" id="txtCategoria" class="cat form-control pText customInput" name="nombre" placeholder="Nombre de la categoría" rows="1" cols="30" style="resize: none;" ></textarea>'
        html+='</div>'
        html+='<div id="agregarFilaIcono" class="col-xs-1" style="padding-left: 2px; padding-top: 2px">'
        html+='<i id="btnAgregarFila" class="fa fa-plus-circle fa-2x" style="color: #005b7f"></i>'
        html+='</div>'
		$('#filasCat').append(html);

		e.preventDefault();
	
			//window.location = APP_URL + "/rubricas/categorias?idRes=" + idRes +"&resultado="+res;			
		},
		error: function (xhr, status, text) {
        	
        	alert('Hubo un error al registrar la información');
    	}
	});
function insertarDescripciones(desc, idInd){
$.ajax({
	type:'POST',
	headers: {
	'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	},
	url: APP_URL + '/rubricas/insertar-descripciones',
	data: {
		_desc: desc,
		_idInd: idInd,
	},
	dataType: "text",
	success: function(result) {

	}
});
}
}