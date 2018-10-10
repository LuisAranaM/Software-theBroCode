$( document ).ready(function() {
	console.log("inicioR");

	$("#hola").click(function () {
        //$("#hola").hide();
    });
    //no pongo seleccion en validaciones pues esa casilla depende de indicadores 
    //y no hay más listas que desprendan de validaciones
    function refrescarCategorias(idRes){
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
					html+= '<div id="'+result[0].ID_CRITERIO+'" class="courseButton activeButton alert alert-success alert-dismissible fade in" role="alert">'
					html+= '<button id="btnClose" type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>'
					html+= '</button>'
					html+= '<p class="pText">'+result[0].NOMBRE+'</p>'
					html+= '</div>'
					html+= '</div>'
                }

				for (i = 1; i <result.length; i++) {
					html+= '<div class="x_content bs-example-popovers courseContainer">'
					html+= '<div id="'+result[i].ID_CRITERIO+'" class="courseButton alert alert-success alert-dismissible fade in" role="alert">'
					html+= '<button id="btnClose" type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>'
					html+= '</button>'
					html+= '<p class="pText">'+result[i].NOMBRE+'</p>'
					html+= '</div>'
					html+= '</div>'
				}
				if(result.length>0){
					html+='</div>'
					$('#apCat').append(html);
					refrescarIndicadores(result[0].ID_CRITERIO);
				}else{
					refrescarIndicadores();
				}
			}
		});
	}
	function refrescarIndicadores(idCat){
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
                else{
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
					refrescarEscalas(result[0].ID_SUBCRITERIO);
				}else{
					$('#myDIVValorizaciones').remove();
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

    $('#myDIVResultados .courseButton').click(function(){
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

	$("#myDIVResultados .courseButton").click(function() {
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

	function actualizarResultados(codRes,descRes){
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
			success: function(resultData) {
			}
		});
	}

	$('#btnAgregarResultado').click(function() {
		var codRes = $('#txtCodigoResultado').val();
		var descRes = $('#txtResultado').val();
		
		actualizarResultados(codRes,descRes);
	});
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
			success: function(resultData) {
			}
		});
	}

	$('#btnAgregarCategoria').click(function() {
		var descCat = $('#txtCategoria').val();
		var idRes = $('#resClick').val();
		actualizarCategorias(descCat, idRes);
	});
	function actualizarIndicadores(descInd, idCat, idRes){
		$.ajax({
			type:'POST',
			headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			url: APP_URL + '/rubricas/actualizar-indicadores',
			data: {
				_descCat: descInd,
				resultado: idRes,
				categoria: idCat,

			},
			dataType: "text",
			success: function(resultData) {
			}
		});
	}

	$('#btnAgregarIndicador').click(function() {
		var descInd = $('#txtIndicador').val();
		var idRes = $('#resClick').val();
		var idCat = $('#catClick').val();
		actualizarIndicadores(descInd, idCat, idRes);
	});

	/*$(document).ajaxStop(function(){
    	window.location.reload();
	});*/

});

