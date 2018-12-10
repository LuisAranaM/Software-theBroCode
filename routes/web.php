<?php
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/welcome', function () {
    return view('welcome');
});

/****RUTAS GENERALES****/
/* Rutas públicas */

/***LOGIN***/
Route::get('/', ['as' => 'login.index', 'uses' => 'LoginController@index']);
Route::get('/logout', ['as' => 'logout', 'uses' => 'LoginController@logout']);
Route::post('/login', ['as' => 'login.attempt', 'uses' => 'LoginController@attempt']);
Route::get('login/google', ['as'=>'login.google','uses'=>'LoginController@redirectToProvider']);
Route::get('login/google/callback', ['as'=>'login.google.callback','uses'=>'LoginController@handleProviderCallback']);
Route::get('login/google/formulario', ['as'=>'login.google.formulario','uses'=>'LoginController@formularioCuentaRubrikGoogle']);
Route::post('login/google/crear', ['as'=>'login.google.crear','uses'=>'LoginController@crearCuentaRubrikGoogle']);


/***HOME***/
Route::get('/pagenotfound',['as'=>'notfound','uses'=>'HomeController@pagenotfound']);
Route::get('/home', ['as' => 'home.index', 'uses' => 'HomeController@index']);


/***PASSWORD***/
Route::get('/pass-gen', ['as' => 'pass.gen', 'uses' => 'PassController@gen']);
Route::get('/pass-update', ['as' => 'pass.update', 'uses' => 'PassController@formularioNuevaContrasena']);
Route::post('/pass-update-post',['as'=>'pass.update.post','uses'=>'PassController@actualizarContrasena']);
Route::get('/pass-reset',['as'=>'pass.reset','uses'=>'PassController@recuperarContrasena']);
Route::post('/pass-reset/post',['as'=>'pass.reset.post','uses'=>'PassController@recuperarContrasenaCorreo']);
Route::post('/pass-save', ['as' => 'pass.save', 'uses' => 'PassController@save']);
Route::get('/extra-login', ['as' => 'pass.login', 'uses' => 'PassController@login']);
Route::post('/extra-attempt', ['as' => 'pass.attempt', 'uses' => 'PassController@attempt']);
Route::get('/reportes', ['as'=>'reportes','uses'=>'ReportesController@reportesGestion']);


/***HORARIOS***/
Route::group(['prefix' => 'horarios', 'middleware' => ['authBase', 'authRol:2']], function() {
	Route::post('/actualizar-horarios', ['as'=>'actualizar.horarios','uses'=>'HorarioController@actualizarHorarios']);
	Route::post('/eliminar-evaluacion-horario', ['as'=>'eliminar.horarios','uses'=>'HorarioController@eliminarEvaluacionHorarios']);
});

Route::post('/actualizar-indicadores-curso', ['as'=>'actualizar.indicadorescurso','uses'=>'HorarioController@actualizarIndicadoresCurso','middleware' => ['authBase', 'authRol:2']]);

/***PROYECTO***/
Route::get('/subir-proyecto', ['as'=>'subir.proyecto','uses'=>'ProyectoController@index','middleware' => ['authBase', 'authRol:2|3|4']]);
Route::post('/subir-proyecto/guardar', ['as'=>'proyecto.store','uses'=>'ProyectoController@store','middleware' => ['authBase', 'authRol:2|3|4']]);
Route::post('/subir-proyecto-masivo/guardar', ['as'=>'proyecto.store.masivo','uses'=>'ProyectoController@storeMasivo','middleware' => ['authBase', 'authRol:2|3|4']]);

/***RESULTADO***/
/*RÚBRICAS*/
Route::group(['prefix' => 'rubricas', 'middleware' => ['authBase', 'authRol:1|2|3']], function() {
	Route::get('/gestion', ['as'=>'rubricas.gestion','uses'=>'ResultadoController@rubricasGestion']);	
	Route::post('/insertar-resultado', ['as' => 'insertar.resultado', 'uses' => 'ResultadoController@insertarResultado']);
	Route::post('/insertar-categoria', ['as' => 'insertar.categoria', 'uses' => 'ResultadoController@insertarCategoria']);
	Route::post('/insertar-indicador', ['as' => 'insertar.indicador', 'uses' => 'ResultadoController@insertarIndicador']);
	Route::post('/insertar-descripcion', ['as' => 'insertar.descripcion', 'uses' => 'ResultadoController@insertarDescripcion']);
	Route::post('/actualizar-resultado', ['as' => 'actualizar.resultado', 'uses' => 'ResultadoController@actualizarResultado']);
	Route::post('/actualizar-categoria', ['as' => 'actualizar.categoria', 'uses' => 'ResultadoController@actualizarCategoria']);
	Route::post('/actualizar-indicador', ['as' => 'actualizar.indicador', 'uses' => 'ResultadoController@actualizarIndicador']);
	Route::post('/actualizar-descripcion', ['as' => 'actualizar.descripcion', 'uses' => 'ResultadoController@actualizarDescripcion']);
	Route::post('/borrar-resultado', ['as' => 'borrar.resultado', 'uses' => 'ResultadoController@borrarResultado']);
	Route::post('/borrar-categoria', ['as' => 'borrar.categoria', 'uses' => 'ResultadoController@borrarCategoria']);
	Route::post('/borrar-indicador', ['as' => 'borrar.indicador', 'uses' => 'ResultadoController@borrarIndicador']);
	Route::post('/borrar-descripcion', ['as' => 'borrar.descripcion', 'uses' => 'ResultadoController@borrarDescripcion']);
	Route::get('/refrescar-indicadores', ['as' => 'refrescar.indicadores', 'uses' => 'ResultadoController@refrescarIndicadores']);
	Route::get('/obtener-categorias', ['as' => 'obtener.categorias', 'uses' => 'ResultadoController@obtenerCategorias']);
	Route::get('/obtener-descripciones', ['as' => 'obtener.descripciones', 'uses' => 'ResultadoController@obtenerDescripciones']);
});

Route::get('/mapeo-indicadores', ['as'=>'mapeo.indicadores','uses'=>'ResultadoController@mapeoDeIndicadores','middleware' => ['authBase', 'authRol:1|2|3']]);
Route::get('/rubricas/categorias', ['as'=>'rubricas.categorias','uses'=>'ResultadoController@categorias','middleware' => ['authBase', 'authRol:1|2|3']]);
Route::get('/configuracionSemestre',['as'=>'configuracion','uses'=>'ResultadoController@informacionRubrica','middleware' => ['authBase', 'authRol:2']]);
Route::post('/configuracionSemestre/copiar',['as'=>'configuracion.copiar','uses'=>'ResultadoController@copiarRubrica','middleware' => ['authBase', 'authRol:2']]);


/****CURSOS****/
Route::group(['prefix' => 'cursos', 'middleware' => ['authBase', 'authRol:1|2|3']], function() {
	Route::get('/gestion', ['as'=>'cursos.gestion','uses'=>'CursoController@index']);
	Route::get('/horarios', ['as'=>'cursos.horarios','uses'=>'HorarioController@index']);
	Route::post('/agregar-acreditacion', ['as'=>'agregar.acreditacion','uses'=>'CursoController@agregarCursosAcreditacion']);
	Route::post('/eliminar-acreditacion', ['as'=>'eliminar.acreditacion','uses'=>'CursoController@eliminarCursoAcreditacion']);
});
//Excel
Route::post('/subir-excels/upload',['as'=>'subir.excel.cursos','uses'=>'CursoController@store','middleware' => ['authBase', 'authRol:2|3']]);

/***ALUMNOS***/
Route::post('/subir-excels/uploadAlumnos', ['as'=>'subir.excel.alumnos','uses'=>'AlumnoController@store','middleware' => ['authBase', 'authRol:2|3|4']]);
Route::post('/subir-excels/uploadAlumnosDeCurso',['as'=>'subir.excel.alumnos.curso','uses'=> 'AlumnoController@uploadAlumnosDeCurso','middleware' => ['authBase', 'authRol:2|3|4']]);


/***REUNIONES***/
Route::get('/reuniones', ['as'=>'reuniones','uses'=>'ReunionesController@reunionesGestion','middleware' => ['authBase', 'authRol:1|2|3']]);
Route::post('/reuniones/guardar', ['as'=>'reuniones.store','uses'=>'ReunionesController@store','middleware' => ['authBase', 'authRol:2']]);
Route::post('/reuniones-descargarDocumentos', ['as'=>'descDocs','uses'=>'ReunionesController@descargarDocumentosReuniones','middleware' => ['authBase', 'authRol:1|2|3']]);
Route::get('/resultadosFiltroDocs', ['as'=>'reultadosFiltro.docs','uses'=>'ReunionesController@resultadosFiltroDocs','middleware' => ['authBase', 'authRol:1|2|3']]);


/***OBJETIVOS***/
Route::get('/objetivos-educacionales', ['as'=>'objetivos','uses'=>'ObjetivosEducacionalesController@objetivosGestion','middleware' => ['authBase', 'authRol:1|2|3']]);
Route::get('/objetivos-educacionales-gestion', ['as'=>'objetivosGestion','uses'=>'ObjetivosEducacionalesController@objetivosGestionTablas','middleware' => ['authBase', 'authRol:1|2|3']]);
Route::post('/eliminar-sos',['as'=>'eliminar.sos','uses'=>'ObjetivosEducacionalesController@eliminarSos','middleware' => ['authBase', 'authRol:2']]);
Route::post('/eliminar-eos',['as'=>'eliminar.eos','uses'=>'ObjetivosEducacionalesController@eliminarEos','middleware' => ['authBase', 'authRol:2']]);
Route::post('/editar-sos',['as'=>'editar.sos','uses'=>'ObjetivosEducacionalesController@editarSos','middleware' => ['authBase', 'authRol:2']]);
Route::post('/editar-eos',['as'=>'editar.eos','uses'=>'ObjetivosEducacionalesController@editarEos','middleware' => ['authBase', 'authRol:2']]);
Route::post('/agregar-sos',['as'=>'agregar.sos','uses'=>'ObjetivosEducacionalesController@agregarSos','middleware' => ['authBase', 'authRol:2']]);
Route::post('/agregar-eos',['as'=>'agregar.eos','uses'=>'ObjetivosEducacionalesController@agregarEos','middleware' => ['authBase', 'authRol:2']]);
Route::post('/objetivos-educacionales/guardar', ['as'=>'objetivos.guardar','uses'=>'ObjetivosEducacionalesController@objetivosGuardar','middleware' => ['authBase', 'authRol:2']]);


/****ADMINISTRADOR****/
Route::group(['prefix' => 'admin', 'middleware' => ['authBase', 'authRol:1']], function() {
	Route::get('/gestionar-usuario',['as'=>'administrador.usuario','uses'=>'AdministradorController@gestionUsuarios']);
	Route::get('/gestionar-usuario/activacion',['as'=>'administrador.usuario.activacion','uses'=>'AdministradorController@activacionUsuarios']);
	Route::post('/gestionar-usuario/activar',['as'=>'administrador.usuario.activar','uses'=>'AdministradorController@activarUsuarios']);
	Route::post('/gestionar-usuario/crear',['as'=>'administrador.usuario.crear','uses'=>'AdministradorController@crearCuentaRubrik']);
	Route::post('/gestionar-usuario/editar',['as'=>'administrador.usuario.editar','uses'=>'AdministradorController@editarCuentaRubrik']);
	Route::post('/gestionar-usuario/eliminar',['as'=>'administrador.usuario.eliminar','uses'=>'AdministradorController@eliminarCuentaRubrik']);
	Route::get('/gestionar-semestre',['as'=>'administrador.semestre','uses'=>'AdministradorController@gestionSemestres']);
	Route::post('/gestionar-semestre/crear',['as'=>'administrador.semestre.crear','uses'=>'AdministradorController@crearSemestre']);
	Route::post('/gestionar-semestre/sistema',['as'=>'administrador.semestre.sistema','uses'=>'AdministradorController@seleccionarSemestreSistema']);
	Route::post('/gestionar-semestre/editar',['as'=>'administrador.semestre.editar','uses'=>'AdministradorController@editarSemestre']);
	Route::post('/gestionar-semestre/eliminar',['as'=>'administrador.semestre.eliminar','uses'=>'AdministradorController@eliminarSemestre']);
	Route::get('/gestionar-especialidad',['as'=>'administrador.especialidad','uses'=>'AdministradorController@gestionEspecialidades']);
	Route::post('/gestionar-especialidad/crear',['as'=>'administrador.especialidad.crear','uses'=>'AdministradorController@crearEspecialidad']);
	Route::post('/gestionar-especialidad/editar',['as'=>'administrador.especialidad.editar','uses'=>'AdministradorController@editarEspecialidad']);
	Route::post('/gestionar-especialidad/eliminar',['as'=>'administrador.especialidad.eliminar','uses'=>'AdministradorController@eliminarEspecialidad']);
	Route::post('/ver-como',['as'=>'administrador.ver.como','uses'=>'AdministradorController@verComoEspecialidad']);
});


/****COORDINADOR****/
Route::group(['prefix' => 'coord', 'middleware' => ['authBase', 'authRol:1|2|3|4']], function() {
	Route::post('/actualizar-horarios', ['as'=>'actualizar.horarios','uses'=>'HorarioController@actualizarHorarios']);
	Route::post('/eliminar-evaluacion-horario', ['as'=>'eliminar.horarios','uses'=>'HorarioController@eliminarEvaluacionHorarios']);
	Route::get('/profesor/alumnos', ['as'=>'profesor.alumnos','uses'=>'ProfesorController@index']);
});


/***PROFESOR***/
Route::get('/profesor/calificar', ['as'=>'profesor.calificar','uses'=>'ProfesorController@profesorCalificar','middleware' => ['authBase', 'authRol:1|2|3|4']]);
Route::post('/modal-calificar-fetch-resultados',['as'=>'fetch.resultados','uses'=>'ProfesorController@fetchResultados','middleware' => ['authBase', 'authRol:1|2|3|4']]);
Route::post('/modal-calificar-fetch-alumnos',['as'=>'fetch.alumnos','uses'=>'ProfesorController@fetchAlumnos','middleware' => ['authBase', 'authRol:1|2|3|4']]);
Route::post('/agregar-calificacion-alumno',['as'=>'agregar.calificacion.alumnos','uses'=>'ProfesorController@calificarAlumnos','middleware' => ['authBase', 'authRol:2|4']]);
Route::post('/eliminar-alumno-horario',['as'=>'eliminar.alumno.horario','uses'=>'ProfesorController@eliminarAlumnoHorario','middleware' => ['authBase', 'authRol:2|4']]);


/*REPORTES*/
//Reporte de cursos
Route::get('/exportarExcelReporte1', ['as'=>'exportar.reporte1','uses'=>'ReportesController@exportarReporteResultadosCiclo',
	'middleware' => ['authBase', 'authRol:1|2|3|4']]);
//Reporte de cursos
Route::get('/exportarExcelReporte2', ['as'=>'exportar.reporte2','uses'=>'ReportesController@exportarReporteCursosResultado',
	'middleware' => ['authBase', 'authRol:1|2|3|4']]);
//Reporte consolidado
Route::get('/exportarExcelReporte4', ['as'=>'exportar.reporte4','uses'=>'ReportesController@exportarReporteConsolidado',
	'middleware' => ['authBase', 'authRol:1|2|3|4']]);
Route::get('/resultadosCiclo', ['as'=>'grafico.resultados','uses'=>'ReportesController@graficoReporteResultadosCiclo','middleware' => ['authBase', 'authRol:1|2|3|4']]);
Route::get('/getSemestres', ['as'=>'get.ciclos','uses'=>'SemestreController@getSemestres','middleware' => ['authBase', 'authRol:1|2|3|4']]);
Route::get('/getCursosbyIdSemestre', ['as'=>'get.cursos','uses'=>'CursoController@getCursosbyIdSemestre','middleware' => ['authBase', 'authRol:1|2|3|4']]);
Route::get('/resultadosCurso', ['as'=>'resultados.curso','uses'=>'ReportesController@graficoResultadosxCurso','middleware' => ['authBase', 'authRol:1|2|3|4']]);
Route::get('/graficoIndicadoresCurso', ['as'=>'grafico.indicadores.curso','uses'=>'ReportesController@graficoIndicadoresCurso','middleware' => ['authBase', 'authRol:1|2|3|4']]);
Route::get('/indicadoresResultado', ['as'=>'grafico.indicadoresResultado','uses'=>'ReportesController@graficoIndicadoresResultado']);
Route::get('/getResultadosCbo', ['as'=>'resultados.cbo','uses'=>'ResultadoController@getResultadosCbo']);
Route::get('/getCursosByResultado', ['as'=>'get.cursosResultado','uses'=>'CursoController@getCursosByResultado','middleware' => ['authBase', 'authRol:1|2|3|4']]);
Route::get('/graficoHorariosResultado', ['as'=>'grafico.horarios.resultado','uses'=>'CursoController@graficoHorariosxResultado','middleware' => ['authBase', 'authRol:1|2|3|4']]);


/**AVISOS**/
Route::group(['prefix' => 'avisos', 'middleware' => ['authBase', 'authRol:1|2|3']], function() {
	Route::post('/eliminar-aviso', ['as'=>'eliminar.aviso','uses'=>'AvisosController@eliminarAviso']);
	Route::post('/generar-aviso', ['as'=>'generar.aviso','uses'=>'AvisosController@generarAviso']);
	Route::get('/avisos', ['as'=>'avisos','uses'=>'AvisosController@gestionAvisos']);
});




