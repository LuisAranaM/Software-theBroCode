$( document ).ready(function() {
	console.log("holaaa");

	
	$(document).on('click', '.elimSo', function(e){
		console.log('HOLA');
		e.preventDefault();    
		e.stopPropagation();
		var IDSOS=$(this).attr('idSOS');
		var nombreSOS=$(this).attr('nombreSOS');
		//var filaAlumno=$(this).parent().parent().parent();
		var resp=confirm("¿Estás seguro que deseas eliminar a "+nombreSOS+"?");
		//var botonCurso=$(this).closest('div').closest('div');
		if (resp == true) {
			eliminarSOS(IDSOS,nombreSOS);
			$(this).parent().parent().remove(); 
			e.preventDefault();          
			//.css('display','none');
		} 

		
	});

	function eliminarSOS(IDSOS,nombreSOS)	{
		console.log("elim");
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
				//location.reload();
			},error: function (xhr, status, text) {
				e.preventDefault();
				e.stopPropagation();
				alert('Hubo un error al registrar la información');           
			}
		});
	}

	$(document).on('click', '.elimEo', function(e){
		console.log('HOLA');
		e.preventDefault();    
		e.stopPropagation();
		var IDEOS=$(this).attr('idEOS');
		var nombreEOS=$(this).attr('nombreEOS');
		//var filaAlumno=$(this).parent().parent().parent();
		var resp=confirm("¿Estás seguro que deseas eliminar a "+nombreEOS+"?");
		//var botonCurso=$(this).closest('div').closest('div');
		if (resp == true) {
			eliminarEOS(IDEOS,nombreEOS);   
			$(this).parent().parent().remove();
			e.preventDefault();                
			//.css('display','none');
		} 

		
	});

	function eliminarEOS(IDEOS,nombreEOS)	{
		console.log("elim");
		$.ajax({
			type:'POST',
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			url:APP_URL+'/eliminar-eos',
			data:{
				IDEOS:IDEOS,				
				nombreEOS:nombreEOS,				
			},
			success:function(result)
			{
				//location.reload();
			},error: function (xhr, status, text) {
				e.preventDefault();
				e.stopPropagation()
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
    	//e.preventDefault(); 
    });

	
	$("#btnAgregarSosModal").on("click", function(){
		console.log('HOLA2');
		var textSos=$('#txtSos').val();
		var myLength = $("#txtSos").val().length
		if(myLength==null || myLength==''){
			$('#txtSos').focus();
			alert("Ingrese la descripción del SOS");
			//return;
		}else{
			agregarSOS(textSos);             
			
		}
		
	});

	function agregarSOS(textSos)	{
		console.log('agregarSOS');
		$.ajax({
			type:'POST',
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			url:APP_URL+'/agregar-sos',
			data:{
				textSos:textSos,				
			},
			success:function(result)
			{
				console.log('EXITO');
				location.reload();
			},error: function (xhr, status, text) {
				e.preventDefault();
				alert('Hubo un error al registrar la información');           
			}
		});
	}

	$("#btnAgregarEos").on("click", function(){
		console.log("boton");
		$("#modalAgregarObjetivosEOS").modal("show");
    	//e.preventDefault(); 
    });

	
	$("#btnAgregarEosModal").on("click", function(e){
		console.log('HOLA3');
		var txtEos=$('#txtEos').val();

		var myLengtheos = $("#txtEos").val().length
		if(myLengtheos==null || myLengtheos==''){
			$('#txtEos').focus();
			alert("Ingrese la descripción del EOS");
			//return;
		}else{
			console.log(txtEos);
			agregarEOS(txtEos);   
		}


		//e.preventDefault();      
		
	});

	function agregarEOS(txtEos)	{
		console.log('agregarEOS');
		$.ajax({
			type:'POST',
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			url:APP_URL+'/agregar-eos',
			data:{
				txtEos:txtEos,				
			},
			success:function(result)
			{
				console.log('EXITO');
				location.reload();
			},error: function (xhr, status, text) {
				e.preventDefault();
				alert('Hubo un error al registrar la información');           
			}
		});
	}


	$(document).on('click', '.editSo', function(){
			/*console.log('editSo');
			var html = $(this).html();
			var input = $('<input type="text" style="width:700px;"/>');
			input.val(html);
			$(this).html(input);
			*/
			var $this = $(this);
			var nombreAtributo=$this.attr('nombreSOS');
			var $input = $('<input>', {
				value: nombreAtributo,
				width: '350px',
				blur: function() {
					$this.attr('nombreSOS',this.value);
					$this.text(this.value);
				},
				keyup: function(e) {
					if (e.which === 13) {
						$input.blur();
						var IDSOS=$this.attr('idSOS');
						var nombreSOS=$this.attr('nombreSOS');
						console.log(IDSOS);
						console.log(nombreSOS);
						editarSOS(IDSOS,nombreSOS); 
						e.preventDefault();
						e.stopPropagation();
					}
				}
			}).appendTo( $this.empty() ).focus();
		});


	function editarSOS(IDSOS,nombreSOS)	{

		console.log("entra a funcion");
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
				e.preventDefault();
				//location.reload();
				//filaAlumno.css('display','none');
			},error: function (xhr, status, text) {
				e.preventDefault();
				alert('Hubo un error al registrar la información');           
			}
		});
	}


	$(document).on('click', '.editEo', function(){
		var $this = $(this);
		var nombreAtributo=$this.attr('nombreEOS');
		var $input = $('<input>', {
			value: nombreAtributo,
			width: '750px',
			blur: function() {
				$this.attr('nombreEOS',this.value);
				$this.text(this.value);
			},
			keyup: function(e) {
				if (e.which === 13) {
					$input.blur();
					var IDEOS=$this.attr('idEOS');
					var nombreEOS=$this.attr('nombreEOS');
					console.log(IDEOS);
					console.log(nombreEOS);
					editarEOS(IDEOS,nombreEOS); 
					e.preventDefault();
				}
			}
		}).appendTo( $this.empty() ).focus();
	});


	function editarEOS(IDEOS,nombreEOS)	{

		console.log("entra a funcion");
		$.ajax({
			type:'POST',
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			url:APP_URL+'/editar-eos',
			data:{
				IDEOS:IDEOS,				
				nombreEOS:nombreEOS,				
			},
			success:function(result)
			{
				//location.reload();
				e.preventDefault();
				//filaAlumno.css('display','none');
			},error: function (xhr, status, text) {
				e.preventDefault();
				alert('Hubo un error al registrar la información');           
			}
		});
	}

});