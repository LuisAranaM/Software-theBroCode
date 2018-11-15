var graficoResultadoxCiclo;
var graficoResultadosxCurso;
var contResultadosxCiclo = 0;
var contResultadosxCurso = 0;
var contIndicadoresxResultado = 0;

$( document ).ready(function() {
    //init_charts();
    //Obtener los cursos
    //Inicializamos valores de los combobox de semestre
    $.ajax({
        url: APP_URL + '/getSemestres',
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

    $.ajax({
        url: APP_URL + '/getResultadosCbo',
		type: 'GET',
		data: {
            idSemestre: 2
        },
        async: false,
        success: function( result ) {
            $.each(result, function(i, value) {
                $('.resultados').append("<option value="+value.ID_RESULTADO+">"+value.NOMBRE+"</option>'");
            });
        }
      });
    // ***************** Combo boxes *****************
    //Cuando cambie el semestre del modal 1
    document.getElementById('ciclos1').onchange = function () {
        idSemestre = this.options[this.selectedIndex].value;
        //$(".ruta1").prop("href", "{{route('exportar.reporte1)}}?idSemestre="+idSemestre);
        updategraficoResultadoxCiclo(idSemestre);
    }
    
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

    /*$('#btnAtrasIxR').click(function() {
        $('#modalRxC').modal('show');
        $('#modalIxR').modal('hide');
    });*/

    $('#btnDescargarReportes1').click(function() {
        idSemestre = document.getElementById('ciclos1').options[document.getElementById('ciclos1').selectedIndex].value;
        //$('#modalRxC').modal('hide');
    });

     $('#btnDescargarReportes2').click(function() {
        $('#modalResultadosCurso').modal('hide');
    });

     $('#btnDescargarReportes4').click(function() {
        $('#modalConsolidado').modal('hide');
    });

    

    $('#cerrarModalRxC').click(function() {
        init_chartsgraficoCursosXResultado();
        $('#modalRxC').modal('hide');
    });

    //Cuando cambie el resultado del modal 1.2
    document.getElementById('cboResultados').onchange = function () {
        idResultado = this.options[this.selectedIndex].value;
        idSemestre = document.getElementById('ciclos1').options[document.getElementById('ciclos1').selectedIndex].value;
        //idResultado = document.getElementById('cboResultados').options[document.getElementById('cboResultados').selectedIndex].value;
        updategraficoIndicadoresxResultado(idSemestre, idResultado);
    }

    // ***************** Botones que despliegan el modal *****************
    //Boton para ingresar al Modal 1
    $('#btnGraficoRxC').click(function() {
        $('#ciclos1 option').last().prop('selected',true);
        idSemestre = document.getElementById('ciclos1').options[document.getElementById('ciclos1').selectedIndex].value;
        //$("#ruta1").prop("href", "{{route('exportar.reporte1')}}");
        updategraficoResultadoxCiclo(idSemestre);
        $("#modalRxC").modal("show");
    });

    //Boton para ingresar al Modal 2
    $('#btnGraficoResultadosCurso').click(function() {
        $('#ciclos2 option').last().attr('selected',true);
        idSemestre = document.getElementById('ciclos2').options[document.getElementById('ciclos2').selectedIndex].value;
        updateCmbCursos(idSemestre);
        idCurso = document.getElementById('cursos2').options[0].value;
        updateGraficoResultadosxCurso(idSemestre,idCurso);
        $("#modalResultadosCurso").modal("show");
    });

    //Boton para ingresar al Modal 3
    $('#btnGraficoIndicadoresResultado').click(function() {
        
    });

    //Boton para ingresar al Modal 4
    $('#btnGraficoConsolidado').click(function() {
        $('#ciclos4 option').last().prop('selected',true);
        $("#modalConsolidado").modal("show")
    });

    $('#btnDescargarGraficos1').click(function(event) {
        var canvas = document.querySelector('#graficoResultadoxCiclo');
        var dataURL = canvas.toDataURL();
        var pdf = new jsPDF();
        pdf.addImage(dataURL, 'PNG', 35, 50);
        semestre = document.getElementById('ciclos1').options[document.getElementById('ciclos1').selectedIndex].text;
        pdf.text('Resultados del Ciclo '+semestre, 70, 40)
        pdf.save('Gráfico Resultados '+semestre+".pdf");
      });

      $('#btnDescargarGraficos12').click(function(event) {       
        var canvas = document.querySelector('#graficoIndicadoresxResultado');
        var dataURL = canvas.toDataURL();
        var pdf = new jsPDF();
        pdf.addImage(dataURL, 'PNG', 35, 50);
        semestre = document.getElementById('ciclos2').options[document.getElementById('ciclos2').selectedIndex].text;
        resultado = document.getElementById('cboResultados').options[document.getElementById('cboResultados').selectedIndex].text;
        pdf.text('Resultado '+resultado+' Ciclo '+semestre, 70, 40);
        pdf.save('Grafico Resultado '+resultado+' Ciclo '+semestre+".pdf");
      });

      $('#btnDescargarGraficos2').click(function(event) {       
        var canvas = document.querySelector('#graficoResultadosxCurso');
        var dataURL = canvas.toDataURL();
        var pdf = new jsPDF();
        pdf.addImage(dataURL, 'PNG', 35, 50);
        semestre = document.getElementById('ciclos2').options[document.getElementById('ciclos2').selectedIndex].text;
        curso = document.getElementById('cursos2').options[document.getElementById('cursos2').selectedIndex].text;
        pdf.text('Resultados\nCurso '+curso+'\nCiclo '+semestre, 70, 30);
        pdf.save('Grafico Resultados Curso '+curso+' Ciclo '+semestre+".pdf");
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
        url: APP_URL + '/getCursosbyIdSemestre',
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

function updateCmbResultados(idSemestre) {
    //Grafico de barras
    $.ajax({
        url: APP_URL + '/getResultadosbyIdSemestre',
		type: 'GET',
		data: {
            idSemestre: idSemestre
        },
        async: false,
        success: function( result ) {
            $(".resultados").empty();
            $.each(result, function(i, value) {
                $('.resultados').append("<option value="+value.ID_RESULTADO+">"+value.NOMBRE+"</option>'");
            });
        }
      });
    
}

var ctx;
var ctx1_2;
var ctx2;

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
            event.preventDefault();
            alert('Hubo un error al buscar la información');
            item.removeClass('hidden').prev().addClass('hidden');
        }
    });
}

var globResultadosId = [];

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
            globResultadosId = resultadosId;
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
            event.preventDefault();
            alert('Hubo un error al buscar la información');
            item.removeClass('hidden').prev().addClass('hidden');
        }
    });
}

function updategraficoIndicadoresxResultado(idSemestre, idResultado) {
    console.log('Se obtuvo el idSemestre: ', idSemestre, 'y el idResultado: ', idResultado);
    //Grafico de barras
    ctx1_2 = document.getElementById("graficoIndicadoresxResultado").getContext('2d');
    $.ajax({
		url: APP_URL + '/indicadoresResultado',
		type: 'GET',
		data: {
            idSemestre: idSemestre,
            idResultado: idResultado
		},
		success: function (result) {
            console.log(result);
            updateCmbResultados(idSemestre);
            document.getElementById('cboResultados').value = idResultado;
            indicadoresId=[];
            indicadoresNombre=[];
            indicadoresPorcentaje=[];
            for(var i=0;i<result.length;i++){
                indicadoresId.push(result[i].ID_INDICADOR);
                indicadoresNombre.push("" + result[i].COD_RESULTADO + result[i].VALORIZACION);
                indicadoresPorcentaje.push(Math.round(result[i].PORCENTAJE_PONDERADO*100));
            }
            if (contIndicadoresxResultado == 0) {
                graficoIndicadoresxResultado = new Chart(ctx1_2, {
                    type: 'bar',
                    data: {
                        labels: indicadoresNombre,
                        datasets: [{
                            label: 'Porcentaje',
                            data: indicadoresPorcentaje,
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
                        }//,
                        //onClick: graficoResultadoxCicloClickEvent,
                        //onHover: cambiarCursor
                    }
                });
                contIndicadoresxResultado++;
            }
            else {
                if (resultadosNombre.length == 0) {
                    graficoIndicadoresxResultado.data.labels = ['No se encontraron resultados en el ciclo'];
                    graficoIndicadoresxResultado.data.datasets.data = [0];
                }
                else {
                    graficoIndicadoresxResultado.data.labels = indicadoresNombre;
                    graficoIndicadoresxResultado.data.datasets.data = indicadoresPorcentaje;
                }
                graficoIndicadoresxResultado.update();
            }
        },
        error: function (xhr, status, text) {
            event.preventDefault();
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
        // Los dos ultimos parametros globResultadosId y activePoint._index
        // son el array de IDs de resultados y el indice del resultado que se selecciono
        console.log(labels, label, value, globResultadosId, activePoint._index);
        
        // Se muestra el modal de Indicadores x Resultado
        $('#ciclos1 option').last().prop('selected',true);
        var idSemestre = document.getElementById('ciclos1').options[document.getElementById('ciclos1').selectedIndex].value;
        updategraficoIndicadoresxResultado(idSemestre, globResultadosId[activePoint._index]);
        $("#modalIxR").modal("show");

        // Se oculta el modal de Resultados x Curso
        $('#modalRxC').modal('hide');
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

 $('#downloadPdf').click(function(event) {
  // get size of report page
  var reportPageHeight = $('#reportPage').innerHeight();
  var reportPageWidth = $('#reportPage').innerWidth();
  
  // create a new canvas object that we will populate with all other canvas objects
  var pdfCanvas = $('<canvas />').attr({
    id: "canvaspdf",
    width: reportPageWidth,
    height: reportPageHeight
  });
  
  // keep track canvas position
  var pdfctx = $(pdfCanvas)[0].getContext('2d');
  var pdfctxX = 0;
  var pdfctxY = 0;
  var buffer = 100;
  
  // for each chart.js chart
  $("canvas").each(function(index) {
    // get the chart height/width
    var canvasHeight = $(this).innerHeight();
    var canvasWidth = $(this).innerWidth();
    
    // draw the chart into the new canvas
    pdfctx.drawImage($(this)[0], pdfctxX, pdfctxY, canvasWidth, canvasHeight);
    pdfctxX += canvasWidth + buffer;
    
    // our report page is in a grid pattern so replicate that in the new canvas
    if (index % 2 === 1) {
      pdfctxX = 0;
      pdfctxY += canvasHeight + buffer;
    }
  });
  
  // create new pdf and add our new canvas as an image
  var pdf = new jsPDF('l', 'pt', [reportPageWidth, reportPageHeight]);
  pdf.addImage($(pdfCanvas)[0], 'PNG', 0, 0);
  
  // download the pdf
  pdf.save('filename.pdf');
});