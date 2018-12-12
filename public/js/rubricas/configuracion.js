$( document ).ready(function() {


  $("#btnCopiarConfiguracion").on("click", function(e){
    console.log("Copiamos la configuración");
    $('#modalConfiguracion input[type="text"]').val('');     
    $("#modalConfiguracion").modal("show");

  });


  $("#btnMostrarConfiguracion").on("click", function(e){

    var idSemestre=$('#cboSemestreConfiguracion').val();
    var semestre=document.getElementById('cboSemestreConfiguracion').
    options[document.getElementById('cboSemestreConfiguracion').selectedIndex].text;
    var nombreEspecialidad=$('#nombreEspecialidad').val();

    $('#modalConfiguracionMostrar #tituloModalConfirmacion').text('Rúbrica del Semestre '+semestre+' - '+nombreEspecialidad);     

    console.log("Mostramos la configuración en otro modal");
    $("#modalConfiguracion").modal("hide");
    informacionRubrica(idSemestre);
    $("#modalConfiguracionMostrar").modal("show");
  });

});

 function preguntaConfirmacion(){ 
    if (confirm('¿Seguro que deseas copiar la configuración?')){ 
       $('#frmCopiarConfiguracion').submit() 
    } 
} 

function informacionRubrica(idSemestre){
  console.log(idSemestre);
  $.ajax({
    url: APP_URL + '/configuracionSemestre',
    type: 'GET',        
    data:{
      idSemestre:idSemestre
    },
    success: function (result) {
      console.log(result);
      $('#interiorConfirmacion').find('div').remove();
      var html='';
      console.log(result.length);
      if(result.length==0){
        html+='<label>No se encontraron resultados</label>';
        $('#btnAceptarCopia').attr('disabled',true);
      }
      else{
        $('#btnAceptarCopia').removeAttr('disabled');
        for (var i = 0; i < result.length; i++) {     
          if(i==0 || i%3==0) html+='<div class="row">';
          html+='    <div class="col-md-4"><div class="x_panel tile coursesBox" style="background-color: #DFE3E6">'   
          html+='<label style="font-weight:bold;color:black;text-align:justify">'+result[i].RESULTADO+' - '+result[i].DESCRIPCION+'</label>';
          var categorias=result[i].CATEGORIAS;
          for(var j=0;j<categorias.length;j++){
            html+='<p style="color:black;text-align:justify;font-weight:bold">'+categorias[j].NOMBRE_CATEGORIA+'</p>';
            var indicadores=categorias[j].INDICADORES;
            for(var k=0;k<indicadores.length;k++){
              html+='<p style="text-align:justify;">'+result[i].RESULTADO+indicadores[k].VALORIZACION+' - '+indicadores[k].NOMBRE_INDICADOR+'</p>';

          }
        }
        html+='</div></div>';
        if((i+1)%3==0) html+='</div>';
      }   
    }
    $('#interiorConfirmacion').append(html);
    $('#idSemestreConfirmado').val(idSemestre);
  },
  error: function (xhr, status, text) {
    e.preventDefault();
    alert('Hubo un error al consultar la información');
  }
});
}