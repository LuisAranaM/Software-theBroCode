$( document ).ready(function() {
	console.log("inicioAvisos");


	$("#ModalCargar").on("click", function(){
		$("#modalCargarDocsReuniones").modal("show");
	});


	$("#btnDescargarDoc").on("click", function(){
		console.log("Descargando documentos");
		array = []
		$("input:checkbox[name=checkDocs]:checked").each(function(){
			array.push($(this).val());
		});
		console.log(array);

		
	});

});