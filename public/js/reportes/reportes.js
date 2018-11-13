var graficoResultadoxCiclo;
var graficoResultadosxCurso;
var contResultadosxCiclo = 0;
var contResultadosxCurso = 0;

$( document ).ready(function() {
    //init_charts();
    //Obtener los cursos
    //Inicializamos valores de los combobox de semestre
    $.ajax({
        url: APP_URL + 'getSemestres',
		type: 'GET',
		data: {
        },
        async: false,
        success: function( result ) {
            $.each(result, function(i, value) {
                $('.ciclos').append("<option value="+value.ID_SEMESTRE+">"+value.SEMESTRE+"</option>'");
            });
        }
      });
    //Cuando cambie el semestre del modal 1
    document.getElementById('ciclos1').onchange = function () {
        idSemestre = this.options[this.selectedIndex].value
        updategraficoResultadoxCiclo(idSemestre);
    }
    
    //Boton para ingresar al Modal 1
    $('#btnGraficoRxC').click(function() {
        $('#ciclos1 option').last().prop('selected',true);
        idSemestre = document.getElementById('ciclos1').options[document.getElementById('ciclos1').selectedIndex].value;
        updategraficoResultadoxCiclo(idSemestre);
        $("#modalRxC").modal("show");
    });

    $('#btnDescargarReportes').click(function() {
        $('#modalRxC').modal('hide');
    });

    $('#cerrarModalRxC').click(function() {
        init_chartsgraficoCursosXResultado();
        $('#modalRxC').modal('hide');
    });

    //Boton para ingresar al Modal 2
    $('#btnGraficoResultadosCurso').click(function() {
        $('#ciclos2 option').last().prop('selected',true);
        idSemestre = document.getElementById('ciclos2').options[document.getElementById('ciclos2').selectedIndex].value;
        updateCmbCursos(idSemestre);
        idCurso = document.getElementById('cursos2').options[0].value;
        updateGraficoResultadosxCurso(idSemestre,idCurso);
        $("#modalResultadosCurso").modal("show");
    });
    //Cuando cambie el semestre del modal 2
    document.getElementById('ciclos2').onchange = function () {
        idSemestre = this.options[this.selectedIndex].value
        updateCmbCursos(idSemestre);
    }

    //Cuando cambie el curso del modal 2
    document.getElementById('cursos2').onchange = function () {
        idSemestre = document.getElementById('ciclos2').options[document.getElementById('ciclos2').selectedIndex].value;
        
        idCurso = document.getElementById('cursos2').options[document.getElementById('cursos2').selectedIndex].value;
        updateGraficoResultadosxCurso(idSemestre,idCurso);
}
     $('#btnDescargarReportes2').click(function() {
        $('#modalResultadosCurso').modal('hide');
    });

    //Boton para ingresar al Modal 4
     $('#btnGraficoConsolidado').click(function() {
        $('#ciclos4 option').last().prop('selected',true);
        $("#modalConsolidado").modal("show")
    });

     $('#btnDescargarReportes4').click(function() {
        $('#modalConsolidado').modal('hide');
    });
});

function callback(data) {   
    for (var i = 0; i < data.dps.length; i++) {
        dataPoints.push({
            x: new Date(data.dps[i].date),
            y: data.dps[i].units
        });
    }
    chart.render(); 
}

function gestionarCboxRxC() {
    var indexCiclo = document.getElementById("ciclosRxC").value;
    //indexCiclo se supone que servira para jalar el ciclo de la bd
    init_charts(String(indexCiclo), myChart);
}


function updateCmbCursos(idSemestre) {
    //Grafico de barras
    $.ajax({
        url: APP_URL + 'getCursosbyIdSemestre',
		type: 'GET',
		data: {
            idSemestre: idSemestre
        },
        async: false,
        success: function( result ) {
            $(".cursos").empty();
            $.each(result, function(i, value) {
                $('.cursos').append("<option value="+value.ID_CURSO+">"+value.NOMBRE+"</option>'");
            });
        }
      });
    
}
var ctx2;
var ctx;

function updateGraficoResultadosxCurso(idSemestre,idCurso) {

    //Grafico de barras
    ctx2 = document.getElementById("graficoResultadosxCurso").getContext('2d');
    $.ajax({
		url: APP_URL + '/resultadosCurso',
		type: 'GET',
		data: {
            idSemestre: idSemestre,
            idCurso: idCurso
		},
		success: function (result) {
            //Se llena
            resultadosId=[];
            resultadosNombre=[];
            resultadosPorcentaje=[];
            for(var i=0;i<result.length;i++){
                resultadosId.push(result[i].ID_RESULTADO);
                resultadosNombre.push(result[i].NOMBRE);
                resultadosPorcentaje.push(Math.round(result[i].PORCENTAJE*100));
            }
            if (contResultadosxCurso == 0) {
                graficoResultadosxCurso = new Chart(ctx2, {
                    type: 'bar',
                    data: {
                        labels: resultadosNombre,
                        datasets: [{
                            label: 'Porcentaje',
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
                            borderWidth: 2
                        }]
                    },
                    options: {
                        scales: {
                            yAxes: [{
                                ticks: {
                                    beginAtZero:true
                                }
                            }]
                        },
                        onClick: graficoResultadoxCursoClickEvent,
                        onHover: cambiarCursor
                    }
                });
                contResultadosxCurso++;
            }
            else {
                if (resultadosNombre.length == 0) {
                    graficoResultadosxCurso.data.labels = ['No se encontraron resultados en el curso'];
                    graficoResultadosxCurso.data.datasets.data = [0];
                }
                else {
                    graficoResultadosxCurso.data.labels = resultadosNombre;
                    graficoResultadosxCurso.data.datasets.data = resultadosPorcentaje;
                }
                graficoResultadosxCurso.update();
            }
        },
        error: function (xhr, status, text) {
            xhr.preventDefault();
            alert('Hubo un error al buscar la información');
            item.removeClass('hidden').prev().addClass('hidden');
        }
    });
}

function updategraficoResultadoxCiclo(idSemestre) {
    //Grafico de barras
    ctx1 = document.getElementById("graficoResultadoxCiclo").getContext('2d');
    $.ajax({
		url: APP_URL + '/resultadosCiclo',
		type: 'GET',
		data: {
            idSemestre: idSemestre
		},
		success: function (result) {
            resultadosId=[];
            resultadosNombre=[];
            resultadosPorcentaje=[];
            for(var i=0;i<result.length;i++){
                resultadosId.push(result[i].ID_RESULTADO);
                resultadosNombre.push(result[i].NOMBRE);
                resultadosPorcentaje.push(Math.round(result[i].PORCENTAJE*100));
            }
            if (contResultadosxCiclo == 0) {
                graficoResultadoxCiclo = new Chart(ctx1, {
                    type: 'bar',
                    data: {
                        labels: resultadosNombre,
                        datasets: [{
                            label: 'Porcentaje',
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
                            borderWidth: 2
                        }]
                    },
                    options: {
                        scales: {
                            yAxes: [{
                                ticks: {
                                    beginAtZero:true
                                }
                            }]
                        },
                        onClick: graficoResultadoxCicloClickEvent,
                        onHover: cambiarCursor
                    }
                });
                contResultadosxCiclo++;
            }
            else {
                if (resultadosNombre.length == 0) {
                    graficoResultadoxCiclo.data.labels = ['No se encontraron resultados en el ciclo'];
                    graficoResultadoxCiclo.data.datasets.data = [0];
                }
                else {
                    graficoResultadoxCiclo.data.labels = resultadosNombre;
                    graficoResultadoxCiclo.data.datasets.data = resultadosPorcentaje;
                }
                graficoResultadoxCiclo.update();
            }
        },
        error: function (xhr, status, text) {
            xhr.preventDefault();
            alert('Hubo un error al buscar la información');
            item.removeClass('hidden').prev().addClass('hidden');
        }
    });
}

function graficoResultadoxCicloClickEvent(evt, chartElement){
    var activePoint = graficoResultadoxCiclo.getElementAtEvent(evt)[0];
    if (activePoint !== undefined) {
        var data = activePoint._chart.data;
        var datasetIndex = activePoint._datasetIndex;
        var labels = data.labels[activePoint._index];
        var label = data.datasets[datasetIndex].label;
        var value = data.datasets[datasetIndex].data[activePoint._index];
        console.log(labels, label, value);
    }
 };

 function graficoResultadoxCursoClickEvent(evt, chartElement){
    var activePoint = graficoResultadosxCurso.getElementAtEvent(evt)[0];
    if (activePoint !== undefined) {
        var data = activePoint._chart.data;
        var datasetIndex = activePoint._datasetIndex;
        var labels = data.labels[activePoint._index];
        var label = data.datasets[datasetIndex].label;
        var value = data.datasets[datasetIndex].data[activePoint._index];
        console.log(labels, label, value);
    }
 };

 function cambiarCursor(evt, chartElement) {
    event.target.style.cursor = chartElement[0] ? 'pointer' : 'default';
 }