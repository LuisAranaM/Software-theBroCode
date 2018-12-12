$( document ).ready(function() {
	console.log("holaaa");
	var GBNombreEOS;
	
	$(document).on('click', '.elimSo', function(e){
		console.log('HOLA');
		e.preventDefault();    
		e.stopPropagation();
		var IDSOS=$(this).attr('idSOS');
		var nombreSOS=$(this).attr('nombreSOS');
		var resp=confirm("¿Estás seguro que deseas eliminar a "+nombreSOS+"?");
		if (resp == true) {
			eliminarSOS(IDSOS,nombreSOS);
			$(this).parent().parent().remove(); 
			e.preventDefault();          
		} 

		
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
				//location.reload();
			},error: function (xhr, status, text) {
				e.preventDefault();
				e.stopPropagation();
				alert('Hubo un error al registrar la información');           
			}
		});
	}

	$(document).on('click', '.elimEo', function(e){
		e.preventDefault();    
		e.stopPropagation();
		var IDEOS=$(this).attr('idEOS');
		var nombreEOS=$(this).attr('nombreEOS');
		console.log(GBNombreEOS);
		console.log(nombreEOS);
		if(GBNombreEOS!=null){
			var resp=confirm("¿Estás seguro que deseas eliminar a "+GBNombreEOS+"?");
			if (resp == true) {
				eliminarEOS(IDEOS,GBNombreEOS);   
				$(this).parent().parent().remove();
				e.preventDefault();                
			} 
		}else{
			var resp=confirm("¿Estás seguro que deseas eliminar a "+nombreEOS+"?");
			if (resp == true) {
				eliminarEOS(IDEOS,nombreEOS);   
				$(this).parent().parent().remove();
				e.preventDefault();                
			} 
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
			},error: function (xhr, status, text) {
				e.preventDefault();
				e.stopPropagation()
				alert('Hubo un error al registrar la información');           
			}
		});
	}

	
	$("#btnAgregarSos").on("click", function(){
		console.log("boton");
		$("#modalAgregarObjetivosSOS").modal("show");
    	//e.preventDefault(); 
    });

	
	$("#btnAgregarSosModal").on("click", function(){
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
				location.reload();
			},error: function (xhr, status, text) {
				e.preventDefault();
				alert('Hubo un error al registrar la información');           
			}
		});
	}

	$("#btnAgregarEos").on("click", function(){
		$("#modalAgregarObjetivosEOS").modal("show");
    	//e.preventDefault(); 
    });

	
	$("#btnAgregarEosModal").on("click", function(e){
		var txtEos=$('#txtEos').val();

		var myLengtheos = $("#txtEos").val().length
		if(myLengtheos==null || myLengtheos==''){
			$('#txtEos').focus();
			alert("Ingrese la descripción del EOS");
			//return;
		}else{
			agregarEOS(txtEos);   
		}


		//e.preventDefault();      
		
	});

	function agregarEOS(txtEos)	{
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
				location.reload();
			},error: function (xhr, status, text) {
				e.preventDefault();
				alert('Hubo un error al registrar la información');           
			}
		});
	}


	$(document).on('click', '.editSo', function(){
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
					editarSOS(IDSOS,nombreSOS); 
					e.preventDefault();
					e.stopPropagation();
				}
			}
		}).appendTo( $this.empty() ).focus();
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
				e.preventDefault();
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
					GBNombreEOS = nombreEOS;
					//location.reload();
					editarEOS(IDEOS,nombreEOS); 
					e.preventDefault();
				}
			}
		}).appendTo( $this.empty() ).focus();
	});


	function editarEOS(IDEOS,nombreEOS)	{

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

				//e.preventDefault();
			},error: function (xhr, status, text) {
				e.preventDefault();
				alert('Hubo un error al registrar la información');           
			}
		});
	}

});