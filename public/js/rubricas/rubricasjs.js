$( document ).ready(function() {
	console.log("inicioR");

	$("#hola").click(function () {
        //$("#hola").hide();
    });
    //no pongo seleccion en validaciones pues esa casilla depende de indicadores 
    //y no hay más listas que desprendan de validaciones
    $('#myDIVResultados .courseButton').click(function(){
    	$('#myDIVResultados .courseButton').removeClass('active');
    	$(this).addClass('active');

    	$('#myDIVCategorias .courseButton').removeClass('active');
    	$('.myDIVCategoriasclass div.courseButton:first').addClass('active');

    	$('#myDIVIndicadores .courseButton').removeClass('active');
    	$('.myDIVIndicadoresclass div.courseButton:first').addClass('active');
    });

    $('#myDIVCategorias .courseButton').click(function(){
    	$('#myDIVCategorias .courseButton').removeClass('active');
    	$(this).addClass('active');

    	$('#myDIVIndicadores .courseButton').removeClass('active');
    	$('.myDIVIndicadoresclass div.courseButton:first').addClass('active');
    });

    $('#myDIVIndicadores .courseButton').click(function(){
    	$('#myDIVIndicadores .courseButton').removeClass('active');
    	$(this).addClass('active');
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
});

