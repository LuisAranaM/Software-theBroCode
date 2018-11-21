$( document ).ready(function() {


  $("#btnCopiarConfiguracion").on("click", function(e){
    console.log("Copiamos la configuración");
    //$('#frmNuevoUsuario').trigger("reset");           



    $('#modalConfiguracion input[type="text"]').val('');     
    //$('#frmNuevoUsuario').formValidation('destroy', true);
    //initializeFormUsuario();
    $("#modalConfiguracion").modal("show");

  });

  $("#btnMostrarConfiguracion").on("click", function(e){

    var idSemestre=$('#cboSemestreConfiguracion').val();
    var semestre=document.getElementById('cboSemestreConfiguracion').
    options[document.getElementById('cboSemestreConfiguracion').selectedIndex].text;
    var nombreEspecialidad=$('#nombreEspecialidad').val();

    $('#modalConfiguracionMostrar #tituloModalConfirmacion').text('Semestre '+semestre+' - '+nombreEspecialidad);     

    console.log("Mostramos la configuración en otro modal");
    $("#modalConfiguracion").modal("hide");
    informacionRubrica(idSemestre);
    $("#modalConfiguracionMostrar").modal("show");
    //$('#frmNuevoUsuario').trigger("reset");           



    //$('#frmNuevoUsuario input[type="text"]').val('');     
    //$('#frmNuevoUsuario').formValidation('destroy', true);
    //initializeFormUsuario();

  });

/*  $(".eliminarUsuario").on("click", function(e){
    var filaUsuario=$(this).parent().parent();
    var idUsuario=filaUsuario.attr('idUsuario');
    var nombreUsuario=filaUsuario.attr('nombreUsuario');

    var resp=confirm("¿Estás seguro que deseas eliminar a "+nombreUsuario+"?");
    if (resp == true) {
      console.log("Vamos a eliminar a "+nombreUsuario+ ' con el id '+idUsuario);
      //filaUsuario.remove();
      eliminarUsuario(idUsuario,nombreUsuario,filaUsuario);            
    } 
    e.preventDefault();
  });*/


});

function informacionRubrica(idSemestre){
  console.log("HOLI boli");
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
      //console.log(result.lenght);
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
          html+='    <div class="col-md-4"><div class=" x_panel">'   
          html+='<label style="font-weight:bold">'+result[i].RESULTADO+' - '+result[i].DESCRIPCION+'</label>';
          var categorias=result[i].CATEGORIAS;
          for(var j=0;j<categorias.length;j++){
            html+='<p>'+categorias[j].NOMBRE_CATEGORIA+'</p>';
            var indicadores=categorias[j].INDICADORES;
            for(var k=0;k<indicadores.length;k++){
              html+='<p style="color:red">'+result[i].RESULTADO+indicadores[k].VALORIZACION+' - '+indicadores[k].NOMBRE_INDICADOR+'</p>';
            /*var descripciones=indicadores[k].DESCRIPCIONES;
            for(var l=0;l<descripciones.length;l++){
              html+='<p style="color:blue">'+descripciones[l].NOMBRE_VALORIZACION+' - '+descripciones[l].NOMBRE_DESCRIPCION+'</p>';
            }*/

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