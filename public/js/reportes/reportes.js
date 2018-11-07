$( document ).ready(function() {
    //Se creara un chart global
    var ctx = document.getElementById("myChart").getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ["A", "B", "C", "D", "E", "F"],
            datasets: [{
                label: '# de votos',
                data: [12, 19, 3, 5, 2, 3],
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

    $('#btnGraficoRxC').click(function() {
        console.log("btnGraficoRxC accionado");
        var cadCiclo = "2018-2"; //Ciclo predeterminado
        init_charts(cadCiclo, myChart);
        $("#modalRxC").modal("show")
    });

    $('#btnDescargarReportes').click(function() {
        $('#modalRxC').modal('hide');
    });

    $('#cerrarModalRxC').click(function() {
        $('#modalRxC').modal('hide');
    });

    $('#btnGraficoResultadosCurso').click(function() {
        //init_echarts();
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

/*var chart = null;
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


$.getJSON("https://canvasjs.com/data/gallery/javascript/daily-sales.json?callback=?", callback);    */

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
//}

/*function callback(data) {   
    for (var i = 0; i < data.dps.length; i++) {
        dataPoints.push({
            x: new Date(data.dps[i].date),
            y: data.dps[i].units
        });
    }
    chart.render(); 
}*/

function gestionarCboxRxC() {
    var indexCiclo = document.getElementById("ciclosRxC").value;
    //indexCiclo se supone que servira para jalar el ciclo de la bd
    init_charts(String(indexCiclo), myChart);
}

//Se llenan los datos
function init_charts(indexCiclo, myChart) {
    //Grafico de barras
    console.log("Haaa");
    $.ajax({
		url: APP_URL + '/resultadosCiclo',
		type: 'GET',
		data: {
		},
		success: function (result) {
            //Se llena
            resultadosId=[];
            resultadosNombre=[];
            resultadosPorcentaje=[];
            for(var i=0;i<result.length;i++){
                resultadosId.push(result[i].ID_RESULTADO);
                resultadosNombre.push(result[i].NOMBRE);
                resultadosPorcentaje.push(result[i].PORCENTAJE*100);
            }
            myChart.data.labels = resultadosNombre;
            //myChart.data.datasets.label = '# de votos';
            myChart.data.datasets.data = resultadosPorcentaje;
            myChart.data.datasets.backgroundColor = [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)'
            ];
            myChart.data.datasets.borderColor = [
                'rgba(255,99,132,1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)'
            ];
            myChart.data.datasets.borderColor = 1;
            myChart.update();
            /*var myChart = new Chart(ctx, {
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
            });*/
        },
        error: function (xhr, status, text) {
            e.preventDefault();
            alert('Hubo un error al buscar la información');
            item.removeClass('hidden').prev().addClass('hidden');
        }
    });
        

}