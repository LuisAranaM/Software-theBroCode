	$(document).ready(function () {
		$('.dfecha').each(function() {
			$(this).datepicker({
				maxViewMode: 1,
				daysOfWeekDisabled: "0,6",
				language: "es",
				autoclose: true,
				startDate: "+1d",
				endDate: "+365d",
				format: "yyyy-mm-dd",
			})
			.on('changeDate', function(e) {
            // Revalidate the date field
            //revalidateFechas();            	
        });
		});

		$('.formatInputNumber').keyup(function () {
			this.value = (this.value + '').replace(/[^0-9]/g, '');
		});

var ultimoSelec = $("#semestreAct option:selected");

$("#semestreAct").click(function(){
    ultimoSelec = $("#semestreAct option:selected");
});

$('#semestreAct').on('change', function(e) {
		var idSemestre=$(this).val();
        var semestre=$('#semestreAct option[value='+idSemestre+']').attr('ciclo');
        var resp=confirm("¿Estás seguro que deseas cambiar al semestre "+semestre+"?");
        //var botonCurso=$(this).closest('div').closest('div');
        if (resp == true) {
        	console.log('Se cambia');
        	$('#semestreSistema').text('');
        	$('#semestreSistema').append('<i class="fa fa-calendar"></i>Semestre: '+semestre);
        	//console.log(semestre);
        	//console.log(idSemestre);
            actualizarSemestreSistema(idSemestre);            
        } 
        else{
        	ultimoSelec.prop("selected", true);
    	}
        e.preventDefault();        
    });
		
	});


	function actualizarSemestreSistema(idSemestre){

    	$.ajax({
    	//url: "{{route('administrador.semestre.sistema')}}",    
        url: APP_URL + 'admin/gestionar-semestre/sistema',
        type: 'POST',        
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data:{
            idSemestre:idSemestre,
        },
        success: function (result) {
            console.log("LOL");
        },
        error: function (xhr, status, text) {
            e.preventDefault();
            alert('Hubo un error al registrar la información');
            item.removeClass('hidden').prev().addClass('hidden');
        }
    });

}