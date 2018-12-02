$( document ).ready(function() {

    $("#btnMostrarCargaCursos").on("click", function(e){
        console.log('mostramos la info que vamos a cargar')
        $('#modalCargarCursos').modal('hide');
        $('#modalConfirmacionCarga').modal('show');
        var archivo=$('#archivoMostrar');
        var data = new FormData();
        jQuery.each(jQuery('#archivoMostrar')[0].files, function(i, file) {
            data.append('files[]', file);
        });
        informacionExcel(data);
    });
    $(document).on({
        mouseenter: function () {
            console.log("HOLI");
            $( this ).find("i.fa-trash").show();
        },
        mouseleave: function () {
            $( this ).find("i.fa-trash").hide();
        }
    }, '.courseButton');

    console.log("inicio");
    
    $("#CargarCurso").on("click", function(){
      console.log("Cargando cursos a Acreditar");
      if($('.checkCurso:checked').length==0){
        $('#btnAgregar').attr('disabled',true);                
    }
    else{
        $('#btnAgregar').removeAttr('disabled');        
    }
    $("#modalCursos").modal("show");

});

    $("#modalCargarAlumnos").on('show',function(e){
        var link = e.relatedTarget();
        var modal = $(this);
        var codigoHorario = link.data("codigoHorario");
        modal.find("#codigoHorario").val(codigoHorario);
    });

    $(".btnCargarAlumnos2").on("click", function(){
        var cod = $(this).data('id');
        var horario = $(this).data('horario');
        $(".modal-body #bookId").val( cod );
        $(".modal-body #horario").val(horario);
        $("#modalCargarAlumnos").modal("show");
    });

    $("#btnCargarAlumnos").on("click", function(){
      console.log("btn accionado");
      $("#modalCargarAlumnos").modal("show");
  });

    $(".closeModal").on("click", function(){
      $("#modalCargarAlumnos").modal("hide");
  });

    $("#btnCargarHorario").on("click", function(){
      console.log("btn accionado");
      $("#modalCargarHorarios").modal("show");
  });

    $("#btnCargarCursos").on("click", function(){
      console.log("btn accionado");
      $("#modalCargarCursos").modal("show");
  });


    //Funciones y activadores de búsqueda
	/*$('#btnBuscarCurso').click(function (e) {
        //console.log("HOLI CLICK");        
        var cursoBuscar=$('#txtCursoBuscar').val();
        buscarCursos(cursoBuscar);
    });*/

    /*$('#txtCursoBuscar').keypress(function (e) {
        //Búsqueda con Enter
        //console.log("HOLI ENTER");
        var cursoBuscar=$('#txtCursoBuscar').val();
    	if (e.which == 13) {
    		buscarCursos(cursoBuscar);
    	}
    });*/

    $('#frmAgregarCursos').on('keyup keypress', function(e) {
      var keyCode = e.keyCode || e.which;
      if (keyCode === 13) { 
         e.preventDefault();
         return false;
     }
 });



    /*('#frmAgregarCursos').on('submit', function(e) {
        e.preventDefault();        
        agregarCursosAcreditar();     
    });*/

    $('.closeCurso').on('click', function(e) {
        var codigoCurso=$(this).attr('codigoCurso');
        var nombreCurso=$(this).attr('nombreCurso');
        var resp=confirm("¿Estás seguro que deseas dejar de acreditar "+nombreCurso+"?");
        var botonCurso=$(this).closest('div').closest('div');
        if (resp == true) {
            //console.log("LOl");
            eliminarCursoAcreditar(codigoCurso,botonCurso);            
        } 
        e.preventDefault();        
    });

    /*autocompleteCursos();  

    $('.twitter-typeahead').removeAttr('style');

    //BUSCAR COMO MEJORAR EL Z-INDEX
    $('.tt-menu').css('z-index',3000000);
    $('.tt-menu').css('position','relative');
    $('.tt-menu').css('margin-top','35px');*/


    $("#txtCursoBuscar").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $("#tablaBuscar tr").filter(function() {
          $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
      });
    });

    $('.checkCurso').change(function(){      
        if($(this).attr('checked')!=undefined){
            $(this).removeAttr('checked');               
            $('#btnAgregar').removeAttr('disabled');
            //$('#btnAgregar').removeClass('disabled');              

        }else{          
            $('#btnAgregar').removeAttr('disabled');
            //$('#btnAgregar').removeClass('disabled');
        } 

        if($('.checkCurso:checked').length==0){
            $('#btnAgregar').attr('disabled',true);                
        }
    });

    $("#busquedaGeneral").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $("#listaCursos div").filter(function() {
          $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
      });
    });

});

function eliminarCursoAcreditar(codigoCurso,botonCurso){
    //console.log("Necesitamos agregar cursos");
    $.ajax({
        url: APP_URL + 'cursos/eliminar-acreditacion',
        //url: "{{route('eliminar.acreditacion')}}",     
        type: 'POST',        
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data:{
            codigoCurso:codigoCurso,
        },
        success: function (result) {
            botonCurso.hide();
        },
        error: function (xhr, status, text) {
            e.preventDefault();
            alert('Hubo un error al registrar la información');
            item.removeClass('hidden').prev().addClass('hidden');
        }
    });

}


function agregarCursosAcreditar(){
    console.log("Necesitamos agregar cursos");
    $.ajax({
        url: APP_URL + 'cursos/agregar-acreditacion',
        type: 'GET',        
        success: function (result) {
                //$('#frmNuevaAccionComercial .modal-footer').removeClass('hidden');

                /*$('#listaCursos').removeClass('hidden');                        
                $('#listaCursos .cargando-resultados').addClass('hidden');

                if (result.length!=0) {
                   

                } else {
                   
                }  */                  

            },
            error: function (xhr, status, text) {
                e.preventDefault();
                alert('Hubo un error al registrar la información');
                item.removeClass('hidden').prev().addClass('hidden');
            }
        });

}



function informacionExcel(data){
  console.log("HOLI boli");
  //console.log(archivo);
  $.ajax({
    url: APP_URL + '/mostrar-cursos-cargar',
    type: 'GET',        
    data:data,
    processData: false,
    success: function (result) {

    },
    error: function (xhr, status, text) {
        e.preventDefault();
        alert('Hubo un error al consultar la información');
    }
});
}