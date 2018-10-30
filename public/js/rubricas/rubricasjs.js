$( document ).ready(function() {
	console.log("inicioR");


	$(".btnCargarAlumnos2").on("click", function(){
        var cod = $(this).data('id');
        $(".modal-body #bookId").val( cod );
        $("#modalCargarAlumnos").modal("show");
    })

	$(".fa-trash").on("click", function(){

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

	$(".agregarIndicador").on("click", function(){
        if($('.checkCurso:checked').length==0){
            $('#btnAgregar').attr('disabled',true);                
        }
        else{
            $('#btnAgregar').removeAttr('disabled');        
        }
        $("#ModalTitle").text( "Agregar Nuevo Indicador" );
		$("#modalCursos").modal("show");
	});

	$("#AgregarResultado").on("click", function(){
        if($('.checkCurso:checked').length==0){
            $('#btnAgregar').attr('disabled',true);                
        }
        else{
            $('#btnAgregar').removeAttr('disabled');        
        }
		$("#modalAgregarResultado").modal("show");
	});

	$(".edit").on("click", function(){
		var codigo= $(this).parent().prev('div').find('p').text();
		var descripcion=$(this).parent().next('div').find('p').text();
        if($('.checkCurso:checked').length==0){
            $('#btnAgregar').attr('disabled',true);                
        }
        else{
            $('#btnAgregar').removeAttr('disabled');        
        }
        $("#ModalTitle").text("Editar Indicador" );
        $(".nombreIndicador").val(codigo);
       	console.log(codigo);
        $(".descripcionIndicador").val(descripcion);
        console.log(descripcion);
		$("#modalCursos").modal("show");
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

		$('#filasCat .cat').each(function() {
        	cat.push( $(this).val());
    	});
		//console.log(cat[1]);
		console.log("si llega aca");
		actualizarResultados(codRes,descRes,cat);
		//e.preventDefault();
		
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

	$('#filasCat').on('click','.fa-plus-circle' ,function() {
		$('#agregarFilaIcono').remove();
		html=''
		html+='<div class="col-xs-11" style="padding-bottom: 6px">'
		html+='<textarea type="text" id="txtCategoria" class="cat form-control pText customInput" name="nombre" placeholder="Nombre de la categoría" rows="1" cols="30" style="resize: none;" ></textarea>'
        html+='</div>'
        html+='<div id="agregarFilaIcono" class="col-xs-1" style="padding-left: 2px; padding-top: 2px">'
        html+='<i id="btnAgregarFila" class="fa fa-plus-circle fa-2x" style="color: #005b7f"></i>'
        html+='</div>'
		$('#filasCat').append(html);

		//e.preventDefault();
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
			for(i=0; i<cat.length;i++){
				console.log(cat[i]);
				actualizarCategorias(cat[i], idRes);
			}
			window.location = APP_URL + "/rubricas/gestion";			
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