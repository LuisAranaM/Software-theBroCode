$(document).ready(function () {
  var ultimoSelec = $("#verComoEsp option:selected");

  $("#verComoEsp").click(function(){
    ultimoSelec = $("#verComoEsp option:selected");
  });

  $('#verComoEsp').on('change', function(e) {
    var idEsp=$(this).val();
    var especialidad=$('#verComoEsp option[value='+idEsp+']').attr('especialidad');
    var resp=confirm("¿Estás seguro que deseas cambiar a la especialidad "+especialidad+"?");
        //var botonCurso=$(this).closest('div').closest('div');
        if (resp == true) {
          console.log('Se cambia');
          console.log(idEsp);
          actualizarEspecialidadCoordinador(idEsp);         
        } 
        else{
          ultimoSelec.prop("selected", true);          
        }
        //e.preventDefault();        
      });

});


function actualizarEspecialidadCoordinador(idEsp){
  $.ajax({
      //url: "{{route('administrador.semestre.sistema')}}",    
      url: APP_URL + 'admin/ver-como',
      type: 'POST',        
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      data:{
        idEsp:idEsp,
      },
      success: function (result) {
          location.reload();
        console.log("LOL");
      },
      error: function (xhr, status, text) {
        e.preventDefault();
        alert('Hubo un error al registrar la información');
      }
    });
}