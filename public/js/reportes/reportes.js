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

    $('#btnGraficoResultadosCurso').click(function() {
        init_echarts();
        $("#modalResultadosCurso").modal("show")
    });

     $('#btnDescargarReportes2').click(function() {
        $('#modalResultadosCurso').modal('hide');
    });

     $('#btnGraficoConsolidado').click(function() {
        init_echarts();
        $("#modalConsolidado").modal("show")
    });

     $('#btnDescargarReportes4').click(function() {
        $('#modalConsolidado').modal('hide');
    });

});
