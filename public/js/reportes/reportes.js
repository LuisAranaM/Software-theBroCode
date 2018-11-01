
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

var chart = null;
var dataPoints = [];

window.onload = function() {

chart = new CanvasJS.Chart("chartContainer1", {
    animationEnabled: true,
    theme: "light2",
    title: {
        text: "Resultados por Ciclo"
    },
    axisY: {
        title: "Aprobados",
        titleFontSize: 24
    },
    data: [{
        type: "column",
        yValueFormatString: "#,### Units",
        dataPoints: dataPoints
    }]
});


$.getJSON("https://canvasjs.com/data/gallery/javascript/daily-sales.json?callback=?", callback);    



chart = new CanvasJS.Chart("chartContainer2", {
    animationEnabled: true,
    theme: "light2",
    title: {
        text: "Resultados por Ciclo"
    },
    axisY: {
        title: "Aprobados",
        titleFontSize: 24
    },
    data: [{
        type: "column",
        yValueFormatString: "#,### Units",
        dataPoints: dataPoints
    }]
});


$.getJSON("https://canvasjs.com/data/gallery/javascript/daily-sales.json?callback=?", callback);    



chart = new CanvasJS.Chart("chartContainer3", {
    animationEnabled: true,
    theme: "light2",
    title: {
        text: "Resultados por Ciclo"
    },
    axisY: {
        title: "Aprobados",
        titleFontSize: 24
    },
    data: [{
        type: "column",
        yValueFormatString: "#,### Units",
        dataPoints: dataPoints
    }]
});


$.getJSON("https://canvasjs.com/data/gallery/javascript/daily-sales.json?callback=?", callback);    


chart = new CanvasJS.Chart("chartContainer4", {
    animationEnabled: true,
    theme: "light2",
    title: {
        text: "Resultados por Ciclo"
    },
    axisY: {
        title: "Aprobados",
        titleFontSize: 24
    },
    data: [{
        type: "column",
        yValueFormatString: "#,### Units",
        dataPoints: dataPoints
    }]
});


$.getJSON("https://canvasjs.com/data/gallery/javascript/daily-sales.json?callback=?", callback);    

}

function callback(data) {   
    for (var i = 0; i < data.dps.length; i++) {
        dataPoints.push({
            x: new Date(data.dps[i].date),
            y: data.dps[i].units
        });
    }
    chart.render(); 
}