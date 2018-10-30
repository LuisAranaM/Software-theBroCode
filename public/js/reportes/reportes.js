$( document ).ready(function() {
    $('#btnGraficoCxR').click(function() {
		console.log("btnGraficoCxR accionado");
        init_echarts();
        $("#modalCxR").modal("show")
    });
    
    $('#cerrarModalCxR').click(function() {
		$('#modalCxR').modal('hide');
    });
});
