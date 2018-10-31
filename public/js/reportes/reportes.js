$( document ).ready(function() {
    $('#btnGraficoCxR').click(function() {
		console.log("btnGraficoCxR accionado");
        init_echarts();
        $("#modalCxR").modal("show")
    });

    $('#btnDescargarReportes').click(function() {
		$('#modalCxR').modal('hide');
    });

    $('#cerrarModalCxR').click(function() {
		$('#modalCxR').modal('hide');
    });
});
