$( document ).ready(function() {
	console.log("inicioR");

	$("#CargarCurso").on("click", function(){
		console.log("Cargando cursos a Acreditar");
        if($('.checkCurso:checked').length==0){
            $('#btnAgregar').attr('disabled',true);                
        }
        else{
            $('#btnAgregar').removeAttr('disabled');        
        }
		$("#modalCursos").modal("show");

	});
 
	$("#CargarResultado").on("click", function(){
		console.log("Cargando Resultados");
		$("#modalResultados").modal("show");
	});



	$("#hola").click(function () {
        //$("#hola").hide();
    });
    //no pongo seleccion en validaciones pues esa casilla depende de indicadores 
    //y no hay más listas que desprendan de validaciones

    $('#apRes').on("click",".courseButton",function(){
    	refrescarCategorias($(this).attr('id'));
    	$('#myDIVResultados .courseButton').removeClass('activeButton');
    	$(this).addClass('activeButton'); //interiormente tambien refresca Categorias e Indicadores

    	$('#myDIVCategorias .courseButton').removeClass('activeButton');
    	$('.myDIVCategoriasclass div.courseButton:first').addClass('activeButton');

    	$('#myDIVIndicadores .courseButton').removeClass('activeButton');
    	$('.myDIVIndicadoresclass div.courseButton:first').addClass('activeButton');
    });


    $('#apCat').on("click",".courseButton",function(){
    	refrescarIndicadores($(this).attr('id'));
    	$('#myDIVCategorias .courseButton').removeClass('activeButton');
    	$(this).addClass('activeButton');
    	$('#myDIVIndicadores .courseButton').removeClass('activeButton');
    	$('.myDIVIndicadoresclass div.courseButton:first').addClass('activeButton');
    });

    $('#apInd').on("click",".courseButton",function(){
    	refrescarEscalas($(this).attr('id'));
    	$('#myDIVIndicadores .courseButton').removeClass('activeButton');
    	$(this).addClass('activeButton');
    });
	//NOTA:(hacer lo sig al usar iteradores)
	//solo cuidar que cuando se use iteradores, al hacer clic en resultados,
	// la seleccion en categorias e indicadores sea en su primer boton
	//(en caso esté en uun boton distinto al primero)
	//ej:
	//resultados : boton1 (boton2:SELECCIONADO) boton3
	//categorias : boton1 boton2 (boton3:SELECCIONADO)
	//indicadoress : boton1 (boton2:SELECCIONADO) boton3
	//
	//si cambio la seleccion en resultados del boton 2 al 3:
	//resultados ahora: boton1 boton2 (boton3:SELECCIONADO)
	//categorias ahora: (boton1:SELECCIONADO) boton2 boton3
	//indicadoress ahora: (boton1:SELECCIONADO) boton2 boton3

	$("#apRes").on("click",".courseButton",function() {
		$('html,body').animate({
			scrollTop: $(".divcategorias").offset().top},
			500);
	});
	$("#apCat").on("click",".courseButton",function() {
		$('html,body').animate({
			scrollTop: $(".divindicadores").offset().top},
			500);
	});
	$("#apInd").on("click",".courseButton",function() {
		$('html,body').animate({
			scrollTop: $(document).height() - $(window).height()},
			500);
	});

	$('#btnAgregarResultado').on('click',function(e) {
		var codRes = $('#txtCodigoResultado').val();
		var descRes = $('#txtResultado').val();
		var cat = []
		cat[0] =$('#txtCategoria').val();
		console.log("si llega aca");
		actualizarResultados(codRes,descRes);
		e.preventDefault();
		
	});


	$('#btnAgregarCategoria').click(function() {
		var descCat = $('#txtCategoria').val();
		var idRes = $('#myDIVResultados div.activeButton:first').attr('id');
		actualizarCategorias(descCat, idRes);
	});

	$('#btnAgregarIndicador').click(function() {
		var descInd = $('#txtIndicador').val();
		var idCat = $('#myDIVCategorias div.activeButton:first').attr('id');
		actualizarIndicadores(descInd, idCat);
	});

	$('#btnAgregarEscala').click(function() {
		var escala = $('#txtEscala').val();
		var descripcion = $('#txtValorizacion').val();
		var idInd = $('#myDIVIndicadores div.activeButton:first').attr('id');
		actualizarEscalas(escala, descripcion, idInd);
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

function actualizarResultados(codRes,descRes,cat){
	$.ajax({
		type:'POST',
		headers: {
		'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		},
		url: APP_URL + '/rubricas/actualizar-resultados',
		data: {
			_codRes: codRes,
			_descRes: descRes,
		},
		dataType: "text",
		success: function(result) {
			result = JSON.parse(result);
			//refrescarResultados(result);
			var idRes= result;	
			console.log(idRes);
			/*for(i=0; i<cat.length;i++){
				actualizarCategorias(cat[i], idRes);
			}	*/			
		},
		error: function (xhr, status, text) {
        	e.preventDefault();
        	alert('Hubo un error al registrar la información');
    	}
	});
}
function actualizarCategorias(descCat, idRes){
	$.ajax({
		type:'POST',
		headers: {
		'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		},
		url: APP_URL + '/rubricas/actualizar-categorias',
		data: {
			_descCat: descCat,
			resultado: idRes,
		},
		dataType: "text",
		success: function(result) {
			//refrescarCategorias(idRes,1,result);   	
		}
	});
}
function actualizarIndicadores(descInd, idCat){
	$.ajax({
		type:'POST',
		headers: {
		'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		},
		url: APP_URL + '/rubricas/actualizar-indicadores',
		data: {
			_descInd: descInd,
			_idCat: idCat,

		},
		dataType: "text",
		success: function(result) {
			refrescarIndicadores(idCat,1,result);
		}
	});
}
function actualizarEscalas(escala, descripcion, idInd){
	$.ajax({
		type:'POST',
		headers: {
		'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		},
		url: APP_URL + '/rubricas/actualizar-escalas',
		data: {
			_escala: escala,
			_descripcion: descripcion,
			_idInd: idInd,

		},
		dataType: "text",
		success: function(result) {
			refrescarEscalas(idInd);
		}
	});
}
