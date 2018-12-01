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
        $('#frmEditarSemestre').formValidation('revalidateField', 'fInicio');
        $('#frmEditarSemestre').formValidation('revalidateField', 'fFin');
        $('#frmEditarSemestre').formValidation('revalidateField', 'fAlerta'); 

        $('#frmNuevoSemestre').formValidation('revalidateField', 'fInicio');
        $('#frmNuevoSemestre').formValidation('revalidateField', 'fFin');
        $('#frmNuevoSemestre').formValidation('revalidateField', 'fAlerta');
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



  $(".eliminarSemestre").on("click", function(e){
    var filaSemestre=$(this).parent().parent();
    var idSemestre=filaSemestre.attr('idSemestre');
    var semestre=filaSemestre.attr('semestre');

    var resp=confirm("¿Estás seguro que deseas eliminar el semestre "+semestre+"?");
    if (resp == true) {
      //filaSemestre.remove();
      eliminarSemestre(idSemestre,semestre,filaSemestre);            
    } 
    e.preventDefault();
    console.log('HOLI');
    });

    $(".editarSemestre").on("click", function(e){
        var filaSemestre=$(this).parent().parent();
        var idSemestre=filaSemestre.attr('idSemestre');
        var semestre=filaSemestre.attr('semestre');
        var anho=filaSemestre.attr('anho');
        var ciclo=filaSemestre.attr('ciclo');
        var fInicio=filaSemestre.attr('fInicio');
        var fFin=filaSemestre.attr('fFin');
        var fAlerta=filaSemestre.attr('fAlerta');

        $('#frmEditarSemestre').formValidation('destroy', true);
        initializeFormSemestre();
        $('#modalEditarSemestre').modal('show');
        $('#modalEditarSemestre input[name="idSemestre"]').val(idSemestre);
        $('#modalEditarSemestre input[name="anho"]').val(anho);
        $('#modalEditarSemestre input[name="ciclo"]').val(ciclo);
        $('#modalEditarSemestre input[name="fInicio"]').val(fInicio);
        $('#modalEditarSemestre input[name="fFin"]').val(fFin);
        $('#modalEditarSemestre input[name="fAlerta"]').val(fAlerta);
        e.preventDefault();
        console.log('HOLI');
    });

    $('#frmNuevoSemestre').formValidation({
      framework: 'bootstrap',
      icon: {
        valid: 'glyphicon glyphicon-ok',
        invalid: 'glyphicon glyphicon-remove',
        validating: 'glyphicon glyphicon-refresh'
      },
      fields: {
  anho: {
  validators: {
    notEmpty: {
     message: '*Campo obligatorio'
   },
 }
},
ciclo: {
  validators: {
    notEmpty: {
     message: '*Campo obligatorio'
   },
 }
},
fInicio: {
  validators: {
    notEmpty: {
     message: '*Campo obligatorio'
   },
   date: {
      format: 'YYYY-MM-DD',
      message: 'Ingrese una fecha válida',
    }
 }
},
fFin: {
  validators: {
    notEmpty: {
     message: '*Campo obligatorio'
   },
   date: {
      format: 'YYYY-MM-DD',
      message: 'Ingrese una fecha válida',
    }
 }
},
fAlerta: {
  validators: {
    notEmpty: {
     message: '*Campo obligatorio'
   },
   date: {
      format: 'YYYY-MM-DD',
      message: 'Ingrese una fecha válida',
    }
 }
}


},
})
    .off('success.form.fv');  
		
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





function initializeFormSemestre() {
    //console.log('Ingresamos al form validation');
    
    return $('#frmEditarSemestre').formValidation({
      framework: 'bootstrap',
      icon: {
        valid: 'glyphicon glyphicon-ok',
        invalid: 'glyphicon glyphicon-remove',
        validating: 'glyphicon glyphicon-refresh'
      },
      fields: {
  anho: {
  validators: {
    notEmpty: {
     message: '*Campo obligatorio'
   },
 }
},
ciclo: {
  validators: {
    notEmpty: {
     message: '*Campo obligatorio'
   },
 }
},
fInicio: {
  validators: {
    notEmpty: {
     message: '*Campo obligatorio'
   },
   date: {
      format: 'YYYY-MM-DD',
      message: 'Ingrese una fecha válida',
    }
 }
},
fFin: {
  validators: {
    notEmpty: {
     message: '*Campo obligatorio'
   },
   date: {
      format: 'YYYY-MM-DD',
      message: 'Ingrese una fecha válida',
    }
 }
},
fAlerta: {
  validators: {
    notEmpty: {
     message: '*Campo obligatorio'
   },
   date: {
      format: 'YYYY-MM-DD',
      message: 'Ingrese una fecha válida',
    }
 }
}


},
})
    .off('success.form.fv');  

  }



function eliminarSemestre(idSemestre,semestre,filaSemestre){
    //console.log("Necesitamos agregar cursos");
    //filaUsuario.remove();
      //eliminarUsuario(idUsuario);      
      $.ajax({
        url: APP_URL + 'admin/gestionar-semestre/eliminar',
        //url: "{{route('eliminar.acreditacion')}}",     
        type: 'POST',        
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data:{
          idSemestre:idSemestre,
        },
        success: function (result) {
          filaSemestre.remove();
          alert('Se eliminó el semestre '+semestre+' correctamente');
        },
        error: function (xhr, status, text) {
          e.preventDefault();
          alert('Hubo un error al eliminar el usuario');
        }
      });

    }