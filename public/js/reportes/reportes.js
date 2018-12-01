var graficoResultadoxCiclo;
var graficoResultadosxCurso;
var graficoIndicadoresxResultado;
var graficoCursosxResultado;
var contResultadosxCiclo = 0;
var contResultadosxCurso = 0;
var contIndicadoresxCurso = 0;
var contHorariosxResultado = 0;
var contIndicadoresxResultado = 0;
var contCursosxResultado = 0;

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
                console.log("<option value="+value.ID_RESULTADO+">"+value.NOMBRE+"</option>'");
            });
        }
      });
    // ***************** Combo boxes *****************
    //Cuando cambie el semestre del modal 1
    document.getElementById('ciclos1').onchange = function () {
        //contResultadosxCiclo = 0;
        idSemestre = this.options[this.selectedIndex].value;
        //$(".ruta1").prop("href", "{{route('exportar.reporte1)}}?idSemestre="+idSemestre);
        updategraficoResultadoxCiclo(idSemestre);
    }
    
    //Cuando cambie el semestre del modal 2
    document.getElementById('ciclos2').onchange = function () {
        idSemestre = this.options[this.selectedIndex].value
        updateCmbCursos(idSemestre);
        idCurso = document.getElementById('cursos2').options[document.getElementById('cursos2').selectedIndex].value;
        updateGraficoResultadosxCurso(idSemestre,idCurso);
    }
    //Cuando cambie el curso del modal 2
    document.getElementById('cursos2').onchange = function () {
        //contResultadosxCurso = 0;
        idSemestre = document.getElementById('ciclos2').options[document.getElementById('ciclos2').selectedIndex].value;
        
        idCurso = document.getElementById('cursos2').options[document.getElementById('cursos2').selectedIndex].value;
        updateGraficoResultadosxCurso(idSemestre,idCurso);
    }

    //Cuando cambie el semestre del modal 3
    document.getElementById('ciclos3').onchange = function () {
        idSemestre = this.options[this.selectedIndex].value
        updateCmbResultados(idSemestre);
        idResultado = document.getElementById('cboResultados2').options[document.getElementById('cboResultados2').selectedIndex].value;
        updategraficoCursosxResultado(idSemestre,idResultado);
    }

    //Cuando cambie el resultado del modal 3
    document.getElementById('cboResultados2').onchange = function () {
        //contCursosxResultado = 0;
        idSemestre = document.getElementById('ciclos3').options[document.getElementById('ciclos3').selectedIndex].value;
        //idResultado = this.options[this.selectedIndex].value;
        idResultado = document.getElementById('cboResultados2').options[document.getElementById('cboResultados2').selectedIndex].value;
        updategraficoCursosxResultado(idSemestre,idResultado);
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
        //contIndicadoresxResultado = 0;
        idResultado = this.options[this.selectedIndex].value;
        idSemestre = document.getElementById('ciclos1').options[document.getElementById('ciclos1').selectedIndex].value;
        //idResultado = document.getElementById('cboResultados').options[document.getElementById('cboResultados').selectedIndex].value;
        updategraficoIndicadoresxResultado(idSemestre, idResultado);
    }

    // ***************** Botones que despliegan el modal *****************
    //Boton para ingresar al Modal 1
    $('#btnGraficoRxC').click(function() {
        //$('#ciclos1 option').last().prop('selected',true);
        idSemestre = document.getElementById('ciclos1').options[document.getElementById('ciclos1').selectedIndex].value;
        console.log("" + idSemestre);
        //$("#ruta1").prop("href", "{{route('exportar.reporte1')}}");
        updategraficoResultadoxCiclo(idSemestre);
        $("#modalRxC").modal("show");
    });

    //Boton para ingresar al Modal 2
    $('#btnGraficoResultadosCurso').click(function() {
        //$('#ciclos2 option').last().attr('selected',true);
        idSemestre = document.getElementById('ciclos2').options[document.getElementById('ciclos2').selectedIndex].value;
        updateCmbCursos(idSemestre);
        if (typeof document.getElementById('cursos2').options[0] === "undefined")
            idCurso=null;
        else
            idCurso = document.getElementById('cursos2').options[0].value;
        updateGraficoResultadosxCurso(idSemestre,idCurso);
        $("#modalResultadosCurso").modal("show");
    });

    //Boton para ingresar al Modal 3
    $('#btnGraficoIndicadoresResultado').click(function() {
        //$('#ciclos3 option').last().attr('selected',true);
        idSemestre = document.getElementById('ciclos3').options[document.getElementById('ciclos3').selectedIndex].value;
        updateCmbResultados(idSemestre);
        if (typeof document.getElementById('cboResultados2').options[0] === "undefined")
            idResultado=null;
        else
            idResultado = document.getElementById('cboResultados2').options[0].value;
        updategraficoCursosxResultado(idSemestre,idResultado);
        $("#modalCxR").modal("show");
    });

    //Boton para ingresar al Modal 4
    $('#btnGraficoConsolidado').click(function() {
        //$('#ciclos4 option').last().prop('selected',true);
        $("#modalConsolidado").modal("show")
    });

    var semestre = "";
    var curso = "";
    var horario = "";
    $('#btnDescargarGraficos1').click(function(event) {
        var canvas = document.querySelector('#graficoResultadoxCiclo');
        var dataURL = canvas.toDataURL();
        var pdf = new jsPDF('l');
        pdf.addImage(dataURL, 'PNG', 0, 50);
        semestre = document.getElementById('ciclos1').options[document.getElementById('ciclos1').selectedIndex].text;
        pdf.text('Resultados del Ciclo '+semestre, 10, 25)
        pdf.save('Grafico_Resultados_Ciclo_'+semestre+".pdf");
      });

      $('#btnDescargarGraficos12').click(function(event) {       
        var canvas = document.querySelector('#graficoIndicadoresxResultado');
        var dataURL = canvas.toDataURL();
        var pdf = new jsPDF('l');
        pdf.addImage(dataURL, 'PNG', 0, 50);
        semestre = document.getElementById('ciclos2').options[document.getElementById('ciclos2').selectedIndex].text;
        resultado = document.getElementById('cboResultados').options[document.getElementById('cboResultados').selectedIndex].text;
        pdf.text('Resultado '+resultado+' del Ciclo '+semestre, 10, 25);
        pdf.save('Grafico_Indicadores_de_'+resultado+'_Ciclo_'+semestre+".pdf");
      });

      $('#btnDescargarGraficos2').click(function(event) {       
        var canvas = document.querySelector('#graficoResultadosxCurso');
        var dataURL = canvas.toDataURL();
        var pdf = new jsPDF('l');
        pdf.addImage(dataURL, 'PNG', 0, 50);
        semestre = document.getElementById('ciclos2').options[document.getElementById('ciclos2').selectedIndex].text;
        curso = document.getElementById('cursos2').options[document.getElementById('cursos2').selectedIndex].text;
        pdf.text('Resultados\nCurso '+curso+'\nCiclo '+semestre, 10, 25);
        pdf.save('Grafico_Resultados_Curso_' + curso + '_Ciclo_'+semestre+".pdf");
      });

      $('#btnDescargarGraficos22').click(function(event) {       
        var canvas = document.querySelector('#graficoIndicadoresxCurso');
        var dataURL = canvas.toDataURL();
        var pdf = new jsPDF('l');
        pdf.addImage(dataURL, 'PNG', 0, 50);
        //semestre = document.getElementById('ciclos2').options[document.getElementById('ciclos2').selectedIndex].text;
        //curso = document.getElementById('cursos2').options[document.getElementById('cursos2').selectedIndex].text;
        console.log(semestre, curso);
        pdf.text('Indicadores\nCurso '+curso+'\nCiclo '+semestre, 10, 25);
        pdf.save('Grafico_Indicadores_Curso_' + curso + '_Ciclo_'+semestre+".pdf");
      });

      $('#btnDescargarGraficos3').click(function(event) {       
        var canvas = document.querySelector('#graficoCursosxResultado');
        var dataURL = canvas.toDataURL();
        var pdf = new jsPDF('l');
        pdf.addImage(dataURL, 'PNG', 0, 50);
        semestre = document.getElementById('ciclos3').options[document.getElementById('ciclos3').selectedIndex].text;
        resultado = document.getElementById('cboResultados2').options[document.getElementById('cboResultados2').selectedIndex].text;
        pdf.text('Resultado ' + resultado + '\nCiclo ' + semestre, 10, 25);
        pdf.save('Grafico_Cursos_Resultado_'+ resultado + '_Ciclo_' + semestre + ".pdf");
      });

      $('#btnDescargarGraficos32').click(function(event) {       
        var canvas = document.querySelector('#graficoCursosxResultado');
        var dataURL = canvas.toDataURL();
        var pdf = new jsPDF('l');
        pdf.addImage(dataURL, 'PNG', 0, 50);
        //semestre = document.getElementById('ciclos3').options[document.getElementById('ciclos3').selectedIndex].text;
        //resultado = document.getElementById('cboResultados2').options[document.getElementById('cboResultados2').selectedIndex].text;
        pdf.text('Resultados \nCurso ' + curso + '\nHorario ' + horario + '\n Ciclo ' + semestre, 10, 15);
        pdf.save('Grafico_Resultado_Curso_'+ curso + '_Ciclo_' + semestre + ".pdf");
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
        url: APP_URL + '/getResultadosCbo',
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
var ctx2_2;
var ctx3;
var ctx3_2;

var globColors = [
    'rgba(255, 99, 132, 0.6)',
    'rgba(54, 162, 235, 0.6)',
    'rgba(255, 206, 86, 0.6)',
    'rgba(75, 192, 192, 0.6)',
    'rgba(153, 102, 255, 0.6)',
    'rgba(255, 159, 64, 0.6)'
];
var resultadosCursoId = [];
var resultadosCursoNombre = [];
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
            console.log("exito");
            console.log(result);
            resultadosId=[];
            resultadosNombre=[];
            resultadosPorcentaje=[];
            
            for(var i=0;i<result.length;i++){
                resultadosId.push(result[i].ID_RESULTADO);
                resultadosNombre.push(result[i].NOMBRE);
                resultadosPorcentaje.push(Math.round(result[i].PORCENTAJE*100));
            }
            console.log(resultadosId);
            console.log(resultadosNombre);
            console.log(resultadosPorcentaje);
            if (resultadosId.length == 0) {
                resultadosNombre = ['No se encontraron resultados en el curso'];
                resultadosPorcentaje = [0];
            }
            resultadosCursoId = resultadosId;
            resultadosCursoNombre = resultadosNombre;
            if (contResultadosxCurso != 0) {
                graficoResultadosxCurso.destroy();
            }
            graficoResultadosxCurso = new Chart(ctx2, {
                type: 'bar',
                data: {
                    labels: resultadosNombre,
                    datasets: [{
                        label: 'Porcentaje',
                        data: resultadosPorcentaje,
                        backgroundColor: globColors,
                        borderWidth: 0
                    }]
                },
                options: {
                    legendCallback: function(chart) {
                        var text = [];
                        text.push('<ul>');
                        for (var i = 0; i < chart.data.datasets[0].data.length; i++) {
                          text.push('<span class="chartjs-legend-li-span label-default" style="margin-right: 30px; '+ 
                          'padding-left: 20px; padding-right: 20px; ' +
                          'background-color:' + 
                          chart.data.datasets[0].backgroundColor[i] + '">');
                            if (chart.data.labels[i]) {
                            text.push(chart.data.labels[i]);
                          }
                          text.push('</span>');
                        }
                        text.push('</ul>');
                        return text.join("");
                    },
                    legend: {
                        display: false
                    },
                    scales: {
                        yAxes: [{
                            scaleLabel: {
                                display: true,
                                labelString: 'Porcentaje de Resultados en el curso'
                            },
                            ticks: {
                                beginAtZero:true,
                                max: 100
                            }
                        }],
                        xAxes: [{
                            maxBarThickness: 100,
                            scaleLabel: {
                                display: true,
                                labelString: 'Resultados'
                            }
                        }]
                    },
                    onClick: graficoResultadoxCursoClickEvent,
                    onHover: cambiarCursor,
                    annotation: {
                        annotations: [{
                          type: 'line',
                          mode: 'horizontal',
                          scaleID: 'y-axis-0',
                          value: 70,
                          borderColor: '#ADF6B1',
                          borderWidth: 1,
                          label: {
                            enabled: false,
                            content: 'Test label'
                          }
                        }]
                    }
                }
            });
            contResultadosxCurso++;
            $("#chartjs-legend2").html(graficoResultadosxCurso.generateLegend());
        },
        error: function (xhr, status, text) {
            event.preventDefault();
            alert('Hubo un error al buscar la información');
            item.removeClass('hidden').prev().addClass('hidden');
        }
    });
}

//Gráfico 2.2
function updategraficoIndicadoresxCurso(idSemestre,idCurso,idResultado,nombreResultado) {
    //Grafico de barras
    ctx2_2 = document.getElementById("graficoIndicadoresxCurso").getContext('2d');
    $.ajax({
		url: APP_URL + '/graficoIndicadoresCurso',
		type: 'GET',
		data: {
            idSemestre: idSemestre,
            idCurso: idCurso,
            idResultado: idResultado,
		},
		success: function (result) {
            //Se llena
            console.log("holaaa");
            console.log(result);
            console.log("bais");
            indicadoresId=[];
            indicadoresNombre=[];
            indicadoresPorcentaje=[];
            
            for(var i=0;i<result.length;i++){
                indicadoresId.push(result[i].ID_INDICADOR);
                indicadoresNombre.push(nombreResultado+result[i].VALORIZACION);
                indicadoresPorcentaje.push(Math.round(result[i].PORCENTAJE*100));
            }
            console.log(indicadoresId);
            console.log(indicadoresNombre);
            console.log(indicadoresPorcentaje);
            if (indicadoresId.length == 0) {
                indicadoresNombre = ['No se encontraron resultados en el curso'];
                indicadoresPorcentaje = [0];
            }
            if (contIndicadoresxCurso != 0) {
                graficoIndicadoresxCurso.destroy();
            }
            graficoIndicadoresxCurso = new Chart(ctx2_2, {
                type: 'bar',
                data: {
                    labels: indicadoresNombre,
                    datasets: [{
                        label: 'Porcentaje',
                        data: indicadoresPorcentaje,
                        backgroundColor: globColors,
                        borderWidth: 0
                    }]
                },
                options: {
                    legendCallback: function(chart) {
                        var text = [];
                        text.push('<ul>');
                        for (var i = 0; i < chart.data.datasets[0].data.length; i++) {
                          text.push('<span class="chartjs-legend-li-span label-default" style="margin-right: 30px; '+ 
                          'padding-left: 20px; padding-right: 20px; ' +
                          'background-color:' + 
                          chart.data.datasets[0].backgroundColor[i] + '">');
                            if (chart.data.labels[i]) {
                            text.push(chart.data.labels[i]);
                          }
                          text.push('</span>');
                        }
                        text.push('</ul>');
                        return text.join("");
                    },
                    legend: {
                        display: false
                    },
                    scales: {
                        yAxes: [{
                            scaleLabel: {
                                display: true,
                                labelString: 'Porcentaje de Indicadores en el curso'
                            },
                            ticks: {
                                beginAtZero:true,
                                max: 100
                            }
                        }],
                        xAxes: [{
                            maxBarThickness: 100,
                            scaleLabel: {
                                display: true,
                                labelString: 'Indicadores'
                            }
                        }]
                    },
                    //onClick: graficoResultadoxCursoClickEvent,
                    //onHover: cambiarCursor,
                    annotation: {
                        annotations: [{
                          type: 'line',
                          mode: 'horizontal',
                          scaleID: 'y-axis-0',
                          value: 70,
                          borderColor: '#ADF6B1',
                          borderWidth: 1,
                          label: {
                            enabled: false,
                            content: 'Test label'
                          }
                        }]
                    }
                }
            });
            contIndicadoresxCurso++;
            $("#chartjs-legend22").html(graficoIndicadoresxCurso.generateLegend());
        },
        error: function (xhr, status, text) {
            event.preventDefault();
            alert('Hubo un error al buscar la información');
            item.removeClass('hidden').prev().addClass('hidden');
        }
    });
}

//Gráfico 3.2
function updategraficoHorariosxResultado(idSemestre,idCurso,idResultado,nombreResultado) {
    //Grafico de barras
    ctx3_2 = document.getElementById("graficoHorariosxResultado").getContext('2d');
    $.ajax({
		url: APP_URL + '/graficoHorariosResultado',
		type: 'GET',
		data: {
            idSemestre: idSemestre,
            idCurso: idCurso,
            idResultado: idResultado,
		},
		success: function (result) {
            //Se llena
            //console.log("holaaa");
            //console.log(result);
            //console.log("bais");
            horarioId=[];
            horarioNombre=[];
            horarioPorcentaje=[];
            
            for(var i=0;i<result.length;i++){
                horarioId.push(result[i].ID_INDICADOR);
                horarioNombre.push(nombreResultado+result[i].VALORIZACION);
                horarioPorcentaje.push(Math.round(result[i].PORCENTAJE*100));
            }
            //console.log(indicadoresId);
            //console.log(indicadoresNombre);
            //console.log(indicadoresPorcentaje);
            if (horarioId.length == 0) {
                horarioNombre = ['No se encontraron resultados en el curso'];
                horarioPorcentaje = [0];
            }
            if (contHorariosxResultado != 0) {
                graficoHorariosxResultado.destroy();
            }
            graficoHorariosxResultado = new Chart(ctx3_2, {
                type: 'bar',
                data: {
                    labels: horarioNombre,
                    datasets: [{
                        label: 'Porcentaje',
                        data: horarioPorcentaje,
                        backgroundColor: globColors,
                        borderWidth: 0
                    }]
                },
                options: {
                    legendCallback: function(chart) {
                        var text = [];
                        text.push('<ul>');
                        for (var i = 0; i < chart.data.datasets[0].data.length; i++) {
                          text.push('<span class="chartjs-legend-li-span label-default" style="margin-right: 30px; '+ 
                          'padding-left: 20px; padding-right: 20px; ' +
                          'background-color:' + 
                          chart.data.datasets[0].backgroundColor[i] + '">');
                            if (chart.data.labels[i]) {
                            text.push(chart.data.labels[i]);
                          }
                          text.push('</span>');
                        }
                        text.push('</ul>');
                        return text.join("");
                    },
                    legend: {
                        display: false
                    },
                    scales: {
                        yAxes: [{
                            scaleLabel: {
                                display: true,
                                labelString: 'Porcentaje del Resultado en el horario'
                            },
                            ticks: {
                                beginAtZero:true,
                                max: 100
                            }
                        }],
                        xAxes: [{
                            maxBarThickness: 100,
                            scaleLabel: {
                                display: true,
                                labelString: 'Horarios'
                            }
                        }]
                    },
                    //onClick: graficoResultadoxCursoClickEvent,
                    //onHover: cambiarCursor,
                    annotation: {
                        annotations: [{
                          type: 'line',
                          mode: 'horizontal',
                          scaleID: 'y-axis-0',
                          value: 70,
                          borderColor: '#ADF6B1',
                          borderWidth: 1,
                          label: {
                            enabled: false,
                            content: 'Test label'
                          }
                        }]
                    }
                }
            });
            contHorariosxResultado++;
            $("#chartjs-legend22").html(graficoHorariosxResultado.generateLegend());
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
            var resultadosId=[];
            var resultadosNombre=[];
            var resultadosPorcentaje=[];
            //var etiquetas = new Array();
            for(var i=0;i<result.length;i++){
                resultadosId.push(result[i].ID_RESULTADO);
                resultadosNombre.push(result[i].NOMBRE);
                resultadosPorcentaje.push(Math.round(result[i].PORCENTAJE*100));
                //etiquetas.push({label: result[i].NOMBRE, data: result[i].PORCENTAJE*100, backgroundColor: 'rgba(255, 99, 132, 0.2)'});
                //console.log(result[i].ID_RESULTADO);
            }
            //console.log(etiquetas);
            if (resultadosId.length == 0) {
                resultadosNombre = ['No se encontraron resultados en el ciclo'];
                resultadosPorcentaje = [0];
            }
            //console.log(resultadosPorcentaje);
            globResultadosId = resultadosId;
            if (contResultadosxCiclo != 0) {
                graficoResultadoxCiclo.destroy();
            }

            graficoResultadoxCiclo = new Chart(ctx1, {
            type: 'bar',
                data: {
                    labels: resultadosNombre,
                    datasets: [{
                        label: 'Porcentaje',
                        data: resultadosPorcentaje,
                        backgroundColor: globColors,
                        borderWidth: 0
                    }]
                },
                options: {
                    legendCallback: function(chart) {
                        var text = [];
                        text.push('<ul>');
                        for (var i = 0; i < chart.data.datasets[0].data.length; i++) {
                          text.push('<span class="chartjs-legend-li-span label-default" style="margin-right: 30px; '+ 
                          'padding-left: 20px; padding-right: 20px; ' +
                          'background-color:' + 
                          chart.data.datasets[0].backgroundColor[i] + '">');
                            if (chart.data.labels[i]) {
                            text.push(chart.data.labels[i]);
                          }
                          text.push('</span>');
                        }
                        text.push('</ul>');
                        return text.join("");
                    },
                    legend: {
                        display: false
                    },
                    scales: {
                        yAxes: [{
                            scaleLabel: {
                                display: true,
                                labelString: 'Porcentaje de Resultados en el ciclo'
                            },
                            ticks: {
                                beginAtZero: true,
                                max: 100
                            }
                        }],
                        xAxes: [{
                            maxBarThickness: 100,
                            scaleLabel: {
                                display: true,
                                labelString: 'Resultados'
                            }
                        }]
                    },
                    onClick: graficoResultadoxCicloClickEvent,
                    onHover: cambiarCursor,
                    annotation: {
                        annotations: [{
                          type: 'line',
                          mode: 'horizontal',
                          scaleID: 'y-axis-0',
                          value: 70,
                          borderColor: '#ADF6B1',
                          borderWidth: 1,
                          label: {
                            enabled: false,
                            content: 'Test label'
                          }
                        }]
                    }
                }
            });
            contResultadosxCiclo++;
            $("#chartjs-legend").html(graficoResultadoxCiclo.generateLegend());
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
            if (indicadoresId.length == 0) {
                indicadoresNombre = ['No se encontraron indicadores en el resultado'];
                indicadoresPorcentaje = [0];
            }
            if (contIndicadoresxResultado != 0) {
                graficoIndicadoresxResultado.destroy();
            }
            graficoIndicadoresxResultado = new Chart(ctx1_2, {
                type: 'bar',
                data: {
                    labels: indicadoresNombre,
                    datasets: [{
                        label: 'Porcentaje',
                        data: indicadoresPorcentaje,
                        backgroundColor:globColors,
                        borderWidth: 0
                    }]
                },
                options: {
                    legendCallback: function(chart) {
                        var text = [];
                        text.push('<ul>');
                        for (var i = 0; i < chart.data.datasets[0].data.length; i++) {
                          text.push('<span class="chartjs-legend-li-span label-default" style="margin-right: 30px; '+ 
                          'padding-left: 20px; padding-right: 20px; ' +
                          'background-color:' + 
                          chart.data.datasets[0].backgroundColor[i] + '">');
                            if (chart.data.labels[i]) {
                            text.push(chart.data.labels[i]);
                          }
                          text.push('</span>');
                        }
                        text.push('</ul>');
                        return text.join("");
                    },
                    legend: {
                        display: false
                    },
                    scales: {
                        yAxes: [{
                            scaleLabel: {
                                display: true,
                                labelString: 'Porcentaje de Indicadores en el Resultado'
                            },
                            ticks: {
                                beginAtZero:true,
                                max: 100
                            }
                        }],
                        xAxes: [{
                            maxBarThickness: 100,
                            scaleLabel: {
                                display: true,
                                labelString: 'Indicadores'
                            }
                        }]
                    },
                    annotation: {
                        annotations: [{
                          type: 'line',
                          mode: 'horizontal',
                          scaleID: 'y-axis-0',
                          value: 70,
                          borderColor: '#ADF6B1',
                          borderWidth: 1,
                          label: {
                            enabled: false,
                            content: 'Test label'
                          }
                        }]
                    }//,
                    //onClick: graficoResultadoxCicloClickEvent,
                    //onHover: cambiarCursor
                }
            });
            contIndicadoresxResultado++;
            $("#chartjs-legend12").html(graficoIndicadoresxResultado.generateLegend());
        },
        error: function (xhr, status, text) {
            event.preventDefault();
            alert('Hubo un error al buscar la información');
            item.removeClass('hidden').prev().addClass('hidden');
        }
    });
}
var globCursosId = [];
var globCursosNombre = [];
function updategraficoCursosxResultado(idSemestre, idResultado) {
    console.log('Se obtuvo el idSemestre: ', idSemestre, 'y el idResultado: ', idResultado);
    //Grafico de barras
    ctx3 = document.getElementById("graficoCursosxResultado").getContext('2d');
    $.ajax({
		url: APP_URL + '/getCursosByResultado',
		type: 'GET',
		data: {
            idSemestre: idSemestre,
            idResultado: idResultado
		},
		success: function (result) {
            //updateCmbResultados(idSemestre);
            document.getElementById('cboResultados').value = idResultado;
            cursosId=[];
            cursosNombre=[];
            cursosPorcentaje=[];
            cursosCodigo=[];
            //console.log(result.length);
            for(var i=0;i<result.length;i++){
                cursosId.push(result[i].ID_CURSO);
                cursosNombre.push("" + result[i].NOMBRE);
                cursosPorcentaje.push(Math.round(result[i].PROMEDIO_APROBADOS*100));
                cursosCodigo.push(result[i].CODIGO_CURSO);
            }
            //console.log(cursosID);
            console.log(cursosId.length);
            globCursosId = cursosId;
            globCursosNombre = cursosNombre;
            if (cursosId.length == 0) {
                cursosCodigo = ['No se encontraron cursos con el resultado seleccionado'];
                cursosPorcentaje = [0];
            }
            if (contCursosxResultado != 0) {
                graficoCursosxResultado.destroy();
            }
            graficoCursosxResultado = new Chart(ctx3, {
                type: 'bar',
                data: {
                    labels: cursosNombre,
                    datasets: [{
                        label: 'Porcentaje',
                        data: cursosPorcentaje,
                        backgroundColor:globColors,
                        borderWidth: 0
                    }]
                },
                options: {
                    legendCallback: function(chart) {
                        var text = [];
                        text.push('<ul>');
                        for (var i = 0; i < chart.data.datasets[0].data.length; i++) {
                          text.push('<span class="chartjs-legend-li-span label-default" style="margin-right: 30px; '+ 
                          'padding-left: 20px; padding-right: 20px; ' +
                          'background-color:' + 
                          chart.data.datasets[0].backgroundColor[i] + '">');
                            if (chart.data.labels[i]) {
                            text.push(chart.data.labels[i]);
                          }
                          text.push('</span>');
                        }
                        text.push('</ul>');
                        return text.join("");
                    },
                    legend: {
                        display: false
                    },
                    //responsive: true,
                    //maintainAspectRatio: true,
                    scales: {
                        yAxes: [{
                            scaleLabel: {
                                display: true,
                                labelString: 'Porcentaje de Resultados en el Curso'
                            },
                            ticks: {
                                beginAtZero:true,
                                max: 100
                            }
                        }],
                        xAxes: [{
                            maxBarThickness: 100,
                            scaleLabel: {
                                display: true,
                                labelString: 'Cursos'
                            }
                        }]
                    },
                    annotation: {
                        annotations: [{
                          type: 'line',
                          mode: 'horizontal',
                          scaleID: 'y-axis-0',
                          value: 70,
                          borderColor: '#ADF6B1',
                          borderWidth: 1,
                          label: {
                            enabled: false,
                            content: 'Test label'
                          }
                        }]
                    },
                    onClick: graficoCursosxResultadoClickEvent,
                    onHover: cambiarCursor
                }
            });
            contCursosxResultado++;
            $("#chartjs-legend3").html(graficoCursosxResultado.generateLegend());
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
        //$('#ciclos1 option').last().prop('selected',true);
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

        var idSemestre = document.getElementById('ciclos2').options[document.getElementById('ciclos2').selectedIndex].value;
        var idCurso = document.getElementById('cursos2').options[document.getElementById('cursos2').selectedIndex].value;
        updategraficoIndicadoresxCurso(idSemestre, idCurso,resultadosCursoId[activePoint._index],resultadosCursoNombre[activePoint._index]);
        

        var nombreSemestre = document.getElementById('ciclos2').options[document.getElementById('ciclos2').selectedIndex].text;
        semestre = nombreSemestre;
        var nombreCurso = document.getElementById('cursos2').options[document.getElementById('cursos2').selectedIndex].text;
        curso = nombreCurso;
        var nombreResultado = resultadosCursoNombre[activePoint._index];     
        document.getElementById("detalleModal22Semestre").textContent="Semestre: "+nombreSemestre;
        document.getElementById("detalleModal22Curso").textContent="Curso: "+nombreCurso;
        document.getElementById("detalleModal22Resultado").textContent="Resultado: "+nombreResultado;
        
        $("#modalIndicadoresCurso").modal("show");

        // Se oculta el modal de Resultados x Curso
        $('#modalResultadosCurso').modal('hide');
    }
    
 };

 function graficoCursosxResultadoClickEvent(evt, chartElement){
    var activePoint = graficoCursosxResultado.getElementAtEvent(evt)[0];
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
        //$('#ciclos1 option').last().prop('selected',true);
        var idSemestre = document.getElementById('ciclos3').options[document.getElementById('ciclos3').selectedIndex].value;
        var idResultado= document.getElementById('cboResultados2').options[document.getElementById('cboResultados2').selectedIndex].value;
        

        var nombreSemestre = document.getElementById('ciclos3').options[document.getElementById('ciclos3').selectedIndex].text;
        //var nombreCurso = document.getElementById('cursos2').options[document.getElementById('cursos2').selectedIndex].value;
        semestre = nombreSemestre;
        var nombreCurso = data.labels[activePoint._index];
        curso = nombreCurso;
        var nombreResultado = document.getElementById('cboResultados2').options[document.getElementById('cboResultados2').selectedIndex].text;
        document.getElementById("detalleModal32Semestre").textContent="Semestre: " + nombreSemestre;
        document.getElementById("detalleModal32Curso").textContent="Curso: " + nombreCurso;
        document.getElementById("detalleModal32Resultado").textContent="Resultado: " + nombreResultado;
        
        updategraficoHorariosxResultado(idSemestre, idResultado, globCursosId[activePoint._index]);
        $("#modalHorariosResultado").modal("show");

        // Se oculta el modal de 3.1 Cursos x Resultado
        $('#modalCxR').modal('hide');
    }
 };

 function cambiarCursor(evt, chartElement) {
    event.target.style.cursor = chartElement[0] ? 'pointer' : 'default';
 }