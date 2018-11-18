$( document ).ready(function() {
	console.log("holaaa");

	
	$(document).on('click', '.elimSo', function(){
		console.log('HOLA');
		var IDSOS=$(this).attr('idSOS');
		var nombreSOS=$(this).attr('nombreSOS');
		//var filaAlumno=$(this).parent().parent().parent();
		var resp=confirm("¿Estás seguro que deseas eliminar a "+nombreSOS+"?");
		var botonCurso=$(this).closest('div').closest('div');
		if (resp == true) {
			eliminarSOS(IDSOS,nombreSOS);          
			//.css('display','none');
		} 
		e.preventDefault();    
		
	});

	function eliminarSOS(IDSOS,nombreSOS)	{
		$.ajax({
			type:'POST',
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			url:APP_URL+'/eliminar-sos',
			data:{
				IDSOS:IDSOS,				
				nombreSOS:nombreSOS,				
			},
			success:function(result)
			{
				//filaAlumno.css('display','none');
			},error: function (xhr, status, text) {
            e.preventDefault();
            alert('Hubo un error al registrar la información');           
        }
		});
	}

	/*
	$(document).on('click', '.editSo', function(){
		//console.log('HOLA');
		var IDSOS=$(this).attr('idSOS');
		var nombreSOS=$(this).attr('nombreSOS');
		editarSOS(IDSOS,nombreSOS);          
		
		e.preventDefault();    
		
	});

	function editarSOS(IDSOS,nombreSOS)	{
		$.ajax({
			type:'POST',
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			url:APP_URL+'/editar-sos',
			data:{
				IDSOS:IDSOS,				
				nombreSOS:nombreSOS,				
			},
			success:function(result)
			{
				//filaAlumno.css('display','none');
			},error: function (xhr, status, text) {
            e.preventDefault();
            alert('Hubo un error al registrar la información');           
        }
		});
	}*/
	$("#btnAgregarSos").on("click", function(){
    	console.log("boton");
    	$("#modalAgregarObjetivosSOS").modal("show");
	});

});