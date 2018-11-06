$( document ).ready(function() {
    //init_charts();
    $('#btnGraficoRxC').click(function() {
        init_charts();
        $("#modalRxC").modal("show")
    });

    $('#btnDescargarReportes').click(function() {
        $('#modalRxC').modal('hide');
    });

    $('#cerrarModalRxC').click(function() {
        $('#modalRxC').modal('hide');
    });

    $('#btnGraficoResultadosCurso').click(function() {
        //init_charts();
        $("#modalResultadosCurso").modal("show")
    });

     $('#btnDescargarReportes2').click(function() {
        $('#modalResultadosCurso').modal('hide');
    });

     $('#btnGraficoConsolidado').click(function() {
        //init_echarts();
        $("#modalConsolidado").modal("show")
    });

     $('#btnDescargarReportes4').click(function() {
        $('#modalConsolidado').modal('hide');
    });

});



/*

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
*/


function callback(data) {   
    for (var i = 0; i < data.dps.length; i++) {
        dataPoints.push({
            x: new Date(data.dps[i].date),
            y: data.dps[i].units
        });
    }
    chart.render(); 
}

function init_charts() {
    //Grafico de barras
    console.log("Haaa");
    var ctx = document.getElementById("myChart").getContext('2d');
    $.ajax({
		url: APP_URL + '/resultadosCiclo',
		type: 'GET',
		data: {
		},
		success: function (result) {
            resultadosId=[];
            resultadosNombre=[];
            resultadosPorcentaje=[];
            for(var i=0;i<result.length;i++){
                resultadosId.push(result[i].ID_RESULTADO);
                resultadosNombre.push(result[i].NOMBRE);
                resultadosPorcentaje.push(result[i].PORCENTAJE*100);
            }
            var myChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: resultadosNombre,
                    datasets: [{
                        label: '# of Votes',
                        data: resultadosPorcentaje,
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.2)',
                            'rgba(54, 162, 235, 0.2)',
                            'rgba(255, 206, 86, 0.2)',
                            'rgba(75, 192, 192, 0.2)',
                            'rgba(153, 102, 255, 0.2)',
                            'rgba(255, 159, 64, 0.2)'
                        ],
                        borderColor: [
                            'rgba(255,99,132,1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(153, 102, 255, 1)',
                            'rgba(255, 159, 64, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero:true
                            }
                        }]
                    }
                }
            });

        },
        error: function (xhr, status, text) {
            e.preventDefault();
            alert('Hubo un error al buscar la información');
            item.removeClass('hidden').prev().addClass('hidden');
        }
    });
        

}