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
Route::get('/', ['as' => 'login.index', 'uses' => 'LoginController@index']);
Route::get('/logout', ['as' => 'logout', 'uses' => 'LoginController@logout']);
Route::post('/login', ['as' => 'login.attempt', 'uses' => 'LoginController@attempt']);
/* RUTAS RECUPERACION */
Route::get('/pass-gen', ['as' => 'pass.gen', 'uses' => 'PassController@gen']);
Route::post('/pass-save', ['as' => 'pass.save', 'uses' => 'PassController@save']);
Route::get('/extra-login', ['as' => 'pass.login', 'uses' => 'PassController@login']);
Route::post('/extra-attempt', ['as' => 'pass.attempt', 'uses' => 'PassController@attempt']);
Route::get('/prueba', ['as'=>'prueba','uses'=>'PruebaController@index']);
Route::get('/reportes', ['as'=>'reportes','uses'=>'PruebaController@reportesGestion']);
//Route::post('/actualizar', ['as'=>'actualizar.horario','uses'=>'HorarioController@actualizarHorarios']);
/**HORARIOS**/
Route::group(['prefix' => 'horarios', 'middleware' => ['authBase', 'authRol:2|3']], function() {
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
Route::group(['prefix' => 'rubricas', 'middleware' => ['authBase', 'authRol:2|3']], function() {
	Route::get('/gestion', ['as'=>'rubricas.gestion','uses'=>'ResultadoController@rubricasGestion']);
	//Route::post('/actualizar-criterios', ['as' => 'actualizar.criterios', 'uses' => 'ResultadoController@actualizarCriterios']);
	Route::post('/actualizar-resultados', ['as' => 'actualizar.resultados', 'uses' => 'ResultadoController@actualizarResultados']);
	Route::post('/actualizar-categorias', ['as' => 'actualizar.categorias', 'uses' => 'ResultadoController@actualizarCategorias']);
	Route::get('/refrescar-categorias', ['as' => 'refrescar.categorias', 'uses' => 'ResultadoController@refrescarCategorias']);
	Route::post('/actualizar-indicadores', ['as' => 'actualizar.indicadores', 'uses' => 'ResultadoController@actualizarIndicadores']);
	Route::get('/refrescar-indicadores', ['as' => 'refrescar.indicadores', 'uses' => 'ResultadoController@refrescarIndicadores']);
	Route::post('/actualizar-escalas', ['as' => 'actualizar.escalas', 'uses' => 'ResultadoController@actualizarEscalas']);
	Route::get('/refrescar-escalas', ['as' => 'refrescar.escalas', 'uses' => 'ResultadoController@refrescarEscalas']);
});
/****RUTAS PARA CURSOS****/
Route::group(['prefix' => 'cursos', 'middleware' => ['authBase', 'authRol:2|3']], function() {
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


/***GENERAR AVISOS***/
Route::get('/avisos', ['as'=>'avisos','uses'=>'PruebaController@avisosGestion']);

/****RUTAS PARA ADMINISTRADOR****/
Route::group(['prefix' => 'admin', 'middleware' => ['authBase', 'authRol:1']], function() {
	Route::get('/principal',['as'=>'administrador.principal','uses'=>'PruebaController@administrador']);
});
/****RUTAS PARA COORDINADOR****/
Route::group(['prefix' => 'coord', 'middleware' => ['authBase', 'authRol:2']], function() {
	Route::get('/principal',['as'=>'coordinador.principal','uses'=>'PruebaController@coordinador']);
	Route::post('/actualizar-horarios', ['as'=>'actualizar.horario','uses'=>'HorarioController@actualizarHorarios']);
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
Route::get('/profesor/calificar', ['as'=>'profesor.calificar','uses'=>'ProfesorController@profesorCalificar']);
Route::get('/rubricas/categorias', ['as'=>'rubricas.categorias','uses'=>'ResultadoController@categorias']);

