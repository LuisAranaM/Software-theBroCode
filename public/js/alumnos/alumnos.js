

$( document ).ready(function() {
	console.log("inicio");


	$(".DescargarProyecto").on("click", function(){
		console.log("jojo");
		var codigoAlumno=$(this).attr('codigoAlumno');
        var nombreHorario=$(this).attr('nombreHorario');
        if (resp == true) {
            DescargarProyectoAlumno(codigoAlumno,nombreHorario);            
        } 
        e.preventDefault(); 

    });
    
    function DescargarProyectoAlumno(codigoHorario,nombreHorario){
        $.ajax({
			url: APP_URL + '/descargar-Proyecto',
			type: 'GET',        
			data:{
                codigoHorario:codigoHorario,
                nombreHorario:nombreHorario,
			},
			success: function (result) {
					botonHorario.hide();
			}
		});
    }

});