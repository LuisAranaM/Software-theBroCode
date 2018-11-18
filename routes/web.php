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
/* EJEMPLO DE RUTAS:
Route::get('/cursos/gestion', ['as'=>'cursos.gestion','uses'=>'PruebaController@cursosGestion']);
Route::post('/cursos/calificar', ['as'=>'cursos.calificar','uses'=>'PruebaController@calificar']);
Composición=>(ruta,[alias,controladorUsar@metodo])
GRUPOS
Route::group(['prefix' => 'cursos', 'middleware' => ['authBase', 'authRol:1']], function() {
	***AQUÍ SE COLOCAN TODAS LAS RUTAS QUE CONFORMEN EL GRUPO****
	*prefix es la ruta previa a la ruta absoluta definida por cada una en el grupo
	*middleware permitirá el acceso de acuerdo al rol del usuario
	*Administrador=1, Coordinador=2, Asistente=3, Profesor=4
});
 */
/****RUTAS GENERALES****/
/* Rutas públicas */

/*ACCESO CON GOOGLE*/
Route::get('login/google', ['as'=>'login.google','uses'=>'LoginController@redirectToProvider']);
Route::get('login/google/callback', ['as'=>'login.google.callback','uses'=>'LoginController@handleProviderCallback']);
Route::get('login/google/formulario', ['as'=>'login.google.formulario','uses'=>'LoginController@formularioCuentaRubrikGoogle']);
Route::post('login/google/crear', ['as'=>'login.google.crear','uses'=>'LoginController@crearCuentaRubrikGoogle']);
/**/

Route::get('/', ['as' => 'login.index', 'uses' => 'LoginController@index']);
Route::get('/pagenotfound',['as'=>'notfound','uses'=>'HomeController@pagenotfound']);
Route::get('/home', ['as' => 'home.index', 'uses' => 'HomeController@index']);
Route::get('/logout', ['as' => 'logout', 'uses' => 'LoginController@logout']);
Route::post('/login', ['as' => 'login.attempt', 'uses' => 'LoginController@attempt']);
/* RUTAS RECUPERACION */
Route::get('/pass-gen', ['as' => 'pass.gen', 'uses' => 'PassController@gen']);
Route::get('/pass-update', ['as' => 'pass.update', 'uses' => 'PassController@formularioNuevaContrasena']);
Route::post('/pass-update-post',['as'=>'pass.update.post','uses'=>'PassController@actualizarContrasena']);
Route::post('/pass-save', ['as' => 'pass.save', 'uses' => 'PassController@save']);
Route::get('/extra-login', ['as' => 'pass.login', 'uses' => 'PassController@login']);
Route::post('/extra-attempt', ['as' => 'pass.attempt', 'uses' => 'PassController@attempt']);
Route::get('/prueba', ['as'=>'prueba','uses'=>'PruebaController@index']);
Route::get('/reportes', ['as'=>'reportes','uses'=>'PruebaController@reportesGestion']);

/**HORARIOS**/
Route::group(['prefix' => 'horarios', 'middleware' => ['authBase', 'authRol:2|3|4']], function() {
	Route::post('/actualizar-horarios', ['as'=>'actualizar.horarios','uses'=>'HorarioController@actualizarHorarios']);
	Route::post('/eliminar-evaluacion-horario', ['as'=>'eliminar.horarios','uses'=>'HorarioController@eliminarEvaluacionHorarios']);
});
/*SUBIR ARCHIVOS PROYECTO*/
//Pruebas de André
Route::get('/subir-proyecto', ['as'=>'subir.proyecto','uses'=>'ProyectoController@index','middleware' => ['authBase', 'authRol:1|2|3|4']]);
Route::post('/subir-proyecto/guardar', ['as'=>'proyecto.store','uses'=>'ProyectoController@store','middleware' => ['authBase', 'authRol:1|2|3|4']]);
Route::get('/verProyectos', ['as'=>'ver.proyectos','uses'=>'ProyectoController@downfunc','middleware' => ['authBase', 'authRol:1|2|3|4']]);
Route::get('/descargar-Proyecto', ['as'=>'descargar.proyecto','uses'=>'ProyectoController@descargarProyecto','middleware' => ['authBase', 'authRol:1|2|3|4']]);
/*RÚBRICAS*/
Route::group(['prefix' => 'rubricas', 'middleware' => ['authBase', 'authRol:2|3|4']], function() {
	Route::get('/gestion', ['as'=>'rubricas.gestion','uses'=>'ResultadoController@rubricasGestion']);
	Route::post('/insertar-resultados', ['as' => 'insertar.resultados', 'uses' => 'ResultadoController@insertarResultado']);
	Route::post('/insertar-categorias', ['as' => 'insertar.categorias', 'uses' => 'ResultadoController@insertarCategoria']);
	Route::post('/insertar-indicadores', ['as' => 'insertar.indicadores', 'uses' => 'ResultadoController@insertarIndicador']);
	Route::post('/insertar-descripciones', ['as' => 'insertar.descripciones', 'uses' => 'ResultadoController@insertarDescripcion']);
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
/****RUTAS PARA CURSOS****/
Route::group(['prefix' => 'cursos', 'middleware' => ['authBase', 'authRol:2|3|4']], function() {
	Route::get('/gestion', ['as'=>'cursos.gestion','uses'=>'CursoController@index']);
	Route::get('/horarios', ['as'=>'cursos.horarios','uses'=>'HorarioController@index']);
	Route::get('/progreso', ['as'=>'cursos.progreso','uses'=>'CursoController@progresoGestion']);
	Route::get('/buscar', ['as'=>'buscar.cursos','uses'=>'CursoController@buscarCursos']);
	Route::get('/buscar', ['as'=>'buscar.cursos','uses'=>'CursoController@buscarCursos']);
	Route::post('/agregar-acreditacion', ['as'=>'agregar.acreditacion','uses'=>'CursoController@agregarCursosAcreditacion']);
	Route::post('/eliminar-acreditacion', ['as'=>'eliminar.acreditacion','uses'=>'CursoController@eliminarCursoAcreditacion']);
});
/***EXCELS***/
Route::get('/subir-excels', ['as'=>'subir.excels','uses'=>'CursoController@subirExcels','middleware' => ['authBase', 'authRol:1|2|3|4']]);
Route::get('ExportClients',['uses'=>'CursoController@ExportClients','middleware' => ['authBase', 'authRol:1|2|3|4']]);
Route::post('ImportClients',['as'=>'import.excel','uses'=>'CursoController@ImportClients','middleware' => ['authBase', 'authRol:1|2|3|4']]);
Route::get('upload',['uses'=>'CursoController@upload','middleware' => ['authBase', 'authRol:1|2|3|4']]);
//pruebas excel
#Route::get('upload', 'CursoController@showForm');
Route::post('/subir-excels/upload', 'CursoController@store');
Route::post('/subir-excels/uploadAlumnos', 'AlumnoController@store');
Route::post('/subir-excels/uploadHorarios', 'HorarioController@guardarHorarios');



/***GENERAR AVISOS***/
//Route::get('/avisos', ['as'=>'avisos','uses'=>'PruebaController@avisosGestion']);

/***GESTIONAR MANEJO DE ACTAS Y PLANES***/
Route::get('/reuniones', ['as'=>'reuniones','uses'=>'ReunionesController@reunionesGestion']);
Route::post('/reuniones/guardar', ['as'=>'reuniones.store','uses'=>'ReunionesController@store','middleware' => ['authBase', 'authRol:1|2|3|4']]);
Route::post('/reuniones-descargarDocumentos', ['as'=>'descDocs','uses'=>'ReunionesController@descargarDocumentosReuniones','middleware' => ['authBase', 'authRol:1|2|3|4']]);

Route::get('/resultadosFiltroDocs', ['as'=>'reultadosFiltro.docs','uses'=>'ReunionesController@resultadosFiltroDocs']);

//Rutas para objetivos educacionales
Route::get('/objetivos-educacionales', ['as'=>'objetivos','uses'=>'ObjetivosEducacionalesController@objetivosGestion','middleware' => ['authBase', 'authRol:1|2|3|4']]);
Route::get('/objetivos-educacionales-gestion', ['as'=>'objetivosGestion','uses'=>'ObjetivosEducacionalesController@objetivosGestionTablas','middleware' => ['authBase', 'authRol:1|2|3|4']]);
Route::post('/eliminar-sos',['as'=>'eliminar.sos','uses'=>'ObjetivosEducacionalesController@eliminarSos','middleware' => ['authBase', 'authRol:1|2|3|4']]);
Route::post('/editar-sos',['as'=>'editar.sos','uses'=>'ObjetivosEducacionalesController@editarSos','middleware' => ['authBase', 'authRol:1|2|3|4']]);

Route::post('/objetivos-educacionales/guardar', ['as'=>'objetivos.guardar','uses'=>'ObjetivosEducacionalesController@objetivosGuardar','middleware' => ['authBase', 'authRol:1|2|3|4']]);

/****RUTAS PARA ADMINISTRADOR****/
Route::group(['prefix' => 'admin', 'middleware' => ['authBase', 'authRol:1']], function() {
	Route::get('/principal',['as'=>'administrador.principal','uses'=>'PruebaController@administrador']);
	Route::get('/gestionar-usuario',['as'=>'administrador.usuario','uses'=>'AdministradorController@gestionUsuarios']);
	Route::post('/gestionar-usuario/crear',['as'=>'administrador.usuario.crear','uses'=>'AdministradorController@crearCuentaRubrik']);
	Route::get('/gestionar-semestre',['as'=>'administrador.semestre','uses'=>'AdministradorController@gestionSemestres']);
	Route::post('/gestionar-semestre/crear',['as'=>'administrador.semestre.crear','uses'=>'AdministradorController@crearSemestre']);
	Route::post('/gestionar-semestre/editar',['as'=>'administrador.semestre.editar','uses'=>'AdministradorController@editarSemestre']);
	Route::get('/gestionar-especialidad',['as'=>'administrador.especialidad','uses'=>'AdministradorController@gestionEspecialidades']);
	Route::post('/gestionar-especialidad/crear',['as'=>'administrador.especialidad.crear','uses'=>'AdministradorController@crearEspecialidad']);
	Route::post('/gestionar-especialidad/editar',['as'=>'administrador.especialidad.editar','uses'=>'AdministradorController@editarEspecialidad']);
});
/****RUTAS PARA COORDINADOR****/
Route::group(['prefix' => 'coord', 'middleware' => ['authBase', 'authRol:2|3|4']], function() {
	Route::get('/principal',['as'=>'coordinador.principal','uses'=>'PruebaController@coordinador']);
	Route::post('/actualizar-horarios', ['as'=>'actualizar.horarios','uses'=>'HorarioController@actualizarHorarios']);
	Route::post('/eliminar-evaluacion-horario', ['as'=>'eliminar.horarios','uses'=>'HorarioController@eliminarEvaluacionHorarios']);
	Route::get('/profesor/alumnos', ['as'=>'profesor.alumnos','uses'=>'ProfesorController@index']);
	Route::get('/descargar-Proyecto', ['as'=>'descargar.proyecto','uses'=>'ProyectoController@descargarProyecto']);
});
/****RUTAS PARA ASISTENTE****/
Route::group(['prefix' => 'asis', 'middleware' => ['authBase', 'authRol:3']], function() {
	Route::get('/principal',['as'=>'asistente.principal','uses'=>'PruebaController@asistente']);
});
/****RUTAS PARA PROFESORES****/
Route::group(['prefix' => 'prof', 'middleware' => ['authBase', 'authRol:4']], function() {
	Route::get('/principal',['as'=>'profesor.principal','uses'=>'PruebaController@profesor']);
});
/* RUTAS DE PROFESOR */
Route::get('/profesor/calificar', ['as'=>'profesor.calificar','uses'=>'ProfesorController@profesorCalificar','middleware' => ['authBase', 'authRol:1|2|3|4']]);
Route::get('/rubricas/categorias', ['as'=>'rubricas.categorias','uses'=>'ResultadoController@categorias','middleware' => ['authBase', 'authRol:1|2|3|4']]);

Route::post('/actualizar-indicadores-curso', ['as'=>'actualizar.indicadorescurso','uses'=>'HorarioController@actualizarIndicadoresCurso','middleware' => ['authBase', 'authRol:1|2|3|4']]);

//Reporte de cursos
Route::get('/exportarExcelReporte1', ['as'=>'exportar.reporte1','uses'=>'ReportesController@exportarReporteResultadosCiclo','middleware' => ['authBase', 'authRol:1|2|3|4']]);
//Reporte de cursos
Route::get('/exportarExcelReporte2', ['as'=>'exportar.reporte2','uses'=>'ReportesController@exportarReporteCursosResultado','middleware' => ['authBase', 'authRol:1|2|3|4']]);
//Reporte consolidado
Route::get('/exportarExcelReporte4', ['as'=>'exportar.reporte4','uses'=>'ReportesController@exportarReporteConsolidado','middleware' => ['authBase', 'authRol:1|2|3|4']]);


/**AVISOS**/
Route::group(['prefix' => 'avisos', 'middleware' => ['authBase', 'authRol:1|2|3|4']], function() {
	Route::post('/eliminar-aviso', ['as'=>'eliminar.aviso','uses'=>'AvisosController@eliminarAviso']);
	Route::post('/generar-aviso', ['as'=>'generar.aviso','uses'=>'AvisosController@generarAviso']);
	Route::get('/avisos', ['as'=>'avisos','uses'=>'AvisosController@gestionAvisos']);
});






Route::get('/resultadosCiclo', ['as'=>'grafico.resultados','uses'=>'ReportesController@graficoReporteResultadosCiclo','middleware' => ['authBase', 'authRol:1|2|3|4']]);
Route::get('/getSemestres', ['as'=>'get.ciclos','uses'=>'SemestreController@getSemestres','middleware' => ['authBase', 'authRol:1|2|3|4']]);
Route::get('/getCursosbyIdSemestre', ['as'=>'get.cursos','uses'=>'CursoController@getCursosbyIdSemestre','middleware' => ['authBase', 'authRol:1|2|3|4']]);
Route::get('/resultadosCurso', ['as'=>'resultados.curso','uses'=>'ReportesController@graficoResultadosxCurso','middleware' => ['authBase', 'authRol:1|2|3|4']]);

Route::get('/indicadoresResultado', ['as'=>'grafico.indicadoresResultado','uses'=>'ReportesController@graficoIndicadoresResultado']);

Route::get('/getResultadosCbo', ['as'=>'resultados.cbo','uses'=>'ResultadoController@getResultadosCbo']);






Route::post('/modal-calificar-fetch-resultados',['as'=>'fetch.resultados','uses'=>'ProfesorController@fetchResultados','middleware' => ['authBase', 'authRol:1|2|3|4']]);

Route::post('/modal-calificar-fetch-alumnos',['as'=>'fetch.alumnos','uses'=>'ProfesorController@fetchAlumnos','middleware' => ['authBase', 'authRol:1|2|3|4']]);
Route::post('/agregar-calificacion-alumno',['as'=>'agregar.calificacion.alumnos','uses'=>'ProfesorController@calificarAlumnos','middleware' => ['authBase', 'authRol:1|2|3|4']]);

Route::post('/eliminar-alumno-horario',['as'=>'eliminar.alumno.horario','uses'=>'ProfesorController@eliminarAlumnoHorario','middleware' => ['authBase', 'authRol:1|2|3|4']]);
