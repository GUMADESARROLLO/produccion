<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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
Route::get('/', 'Auth\LoginController@showLoginForm');
Route::group(['prefix' => 'admin', 'namespace' => 'Admin', 'middleware' => 'auth'], function () {

});

//RUTAS MENUS
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/usuario', 'Admin\usuarioController@index')->name('usuario');
Route::get('/orden-produccion', 'User\orden_produccionController@index')->name('orden-produccion');
Route::get('/configuracion', 'User\configuracionController@index')->name('configuracion');
Route::get('/turnos', 'User\configuracionController@turnos')->name('turnos');
Route::get('/fibras', 'User\fibrasController@index')->name('fibras');
Route::get('/fibras/nueva-fibra', 'User\fibrasController@index')->name('fibras/nueva');
Route::get('/productos', 'User\produccionController@productos')->name('inventario');
Route::get('/maquinas', 'User\maquinasController@index')->name('maquinas');
Route::get('/maquina/nueva-maquina', 'User\maquinasController@nueva')->name('maquina/nueva');
Route::get('/reporte', 'User\reporteController@index')->name('maquina/nueva');
/***** Add by Rodolfo *****/
Route::get('/costos', 'User\CostoController@index')->name('costos');


/******Add by Xochilt */

//QUIMICOS
Route::get('/quimicos', 'User\QuimicoController@index')->name('quimicos');
Route::get('/quimico/nuevo-quimico', 'User\QuimicoController@nuevoQuimico')->name('quimico/nuevo-quimico');
Route::get('/quimico/nuevo', 'User\QuimicoController@nuevoQuimico')->name('quimico/nuevo');
Route::post('/quimico/guardar-quimico', 'User\QuimicoController@guardarQuimico')->name('quimico/guardar-quimico');
Route::get('/quimico/editar-quimico/{id}', 'User\QuimicoController@editarQuimico')->name('quimico/editar-quimico/{$id}');
Route::post('/quimico/actualizar-quimico/', 'User\QuimicoController@actualizarQuimico')->name('quimico/actualizar-quimico');
Route::get('/quimico/eliminar-quimico/{id}', 'User\QuimicoController@eliminarQuimico')->name('quimico/eliminar-quimico/{id}');

//
//RUTAS USUARIO
Route::get('user/nuevo', 'Admin\usuarioController@crear')->name('user/nuevo');
Route::post('usuario/guardar', 'Admin\usuarioController@guardar')->name('usuario/guardar');
Route::get('failed-user', 'Admin\usuarioController@guardarUserFailed')->name('failed-user');
Route::get('success-user', 'Admin\usuarioController@guardarUserSuccess')->name('success-user');
Route::get('user/edit/{id}', 'Admin\usuarioController@editarUser')->name('user/edit/{id}');
Route::post('usuario/actualizar', 'Admin\usuarioController@actualizarUser')->name('usuario/actualizar');
Route::get('user/detalle/{id}', 'Admin\usuarioController@detalleUser')->name('user/detalle/{id}');
Route::get('user/eliminar/{id}', 'Admin\usuarioController@eliminarUser')->name('user/eliminar/{id}');
Route::get('user/activar/{id}', 'Admin\usuarioController@activarUser')->name('user/activar/{id}');







//RUTAS ROLES
Route::get('/rol', 'Admin\RolController@index')->name('rol');
Route::get('rol/crear', 'Admin\RolController@crear')->name('crear_rol');
Route::post('guardar_rol', 'Admin\RolController@guardar')->name('guardar_rol');
Route::get('menu', 'Admin\MenuRolController@index')->name('menu');
Route::get('menu/crear', 'Admin\Menu_controller@index')->name('menu/crear');
Route::get('menu-rol', 'Admin\MenuRolController@index')->name('menu-rol');
Route::post('menu-rol', 'Admin\MenuRolController@guardar')->name('guardar_menu_rol');
Route::post('menu/guardar', 'Admin\menu_controller@guardar')->name('menu/guardar');
Route::post('menu/guardar-orden', 'Admin\menu_controller@guardarOrden')->name('guardar-orden');
Route::get('rol/edit/{id}','Admin\RolController@editar')->name('rol/edit/{id}');
Route::post('rol/actualizar', 'Admin\RolController@actualizar')->name('rol/actualizar');

//RUTAS PRODUCCION
Route::get('orden-produccion/nueva', 'User\orden_produccionController@crear')->name('produccion/nueva');
Route::post('orden-produccion/guardar', 'User\orden_produccionController@guardar')->name('orden-produccion/guardar');
Route::post('orden-produccion/actualizar', 'User\orden_produccionController@actualizar')->name('orden-produccion/actualizar');
Route::post('guardarmp-directa', 'User\orden_produccionController@guardarMP')->name('guardarmp-directa');
Route::get('orden-produccion/editar/{id}', 'User\orden_produccionController@editar')->name('orden-produccion/editar/{id}');
Route::get('orden-produccion/detalle/{id}', 'User\orden_produccionController@detalle')->name('orden-produccion/detalle/{id}');
Route::get('data-mp', 'User\orden_produccionController@getDataMateriaPrima')->name('data-mp');
Route::post('eliminar-mp', 'User\orden_produccionController@eliminarMateriaPrima')->name('eliminar-mp');
Route::get('orden-produccion/reporte/{id}', 'User\reporteController@reporte')->name('orden-produccion/editar/{id}');
Route::post('guardar-costos-indirectos-fab', 'User\orden_produccionController@guardarCostosIndirectosFabricacion')->name('guardar-costos-indirectos-fab');
Route::post('cargarmp-directa', 'User\orden_produccionController@cargarMateriaPrimadirecta')->name('cargarmp-directa');
//Add by Rodolfo
Route::post('guardarqm-directa', 'User\orden_produccionController@guardarQM')->name('guardarqm-directa');
Route::get('data-qm', 'User\orden_produccionController@getDataQuimico')->name('data-qm');
Route::post('cargarqm-directa', 'User\orden_produccionController@cargarQuimico')->name('cargarqm-directa');
Route::post('eliminar-qm', 'User\orden_produccionController@eliminarQuimico')->name('eliminar-qm');
//Add by xochilt
Route::get('getData/{idOrd}', 'User\orden_produccionController@getData')->name('getData/{idOrd}');


//RUTAS CONFIGURACIONES
Route::get('turnos/crear', 'User\configuracionController@crearTurno')->name('turnos/crear');
Route::post('turnos/guardar', 'User\configuracionController@guardarTurno')->name('turnos/guardar');
Route::get('turnos/editar/{id}', 'User\configuracionController@editarTurno')->name('turnos/editar/{id}');
Route::get('turnos/eliminar/{id}', 'User\configuracionController@eliminarTurno')->name('turnos/eliminar/{id}');
Route::post('turnos/actualizar', 'User\configuracionController@actualizarTurno')->name('turnos/actualizar');

//RUTAS MI INVENTARIO
Route::get('insumos/nuevo', 'User\inventarioController@nuevo')->name('insumos/nuevo');
Route::post('insumos/guardar', 'User\inventarioController@guardar')->name('insumos/guardar');

//RUTAS FIBRAS

/***Edit by xochilt*/

Route::get('fibras/nueva','User\fibrasController@nuevaFibra')->name('fibras/nueva');
Route::get('fibras/nueva-fibra', 'User\fibrasController@nuevaFibra')->name('fibras/nueva');
Route::get('fibras/editar/{id}', 'User\fibrasController@editarFibras')->name('producto/editar/{id}');
Route::post('fibras/guardar', 'User\fibrasController@guardarFibra')->name('fibras/guardar');
Route::post('fibras/actualizar', 'User\fibrasController@actualizarFibras')->name('producto/actualizar');
Route::get('fibras/eliminar/{id}', 'User\fibrasController@eliminarFibras')->name('producto/eliminar/{id}');
Route::get('fibra-data', 'User\fibrasController@getFibras')->name('fibra-data');

//RUTAS MAQUINAS
Route::post('maquina/guardar', 'User\maquinasController@guardar')->name('maquina/guardar');
Route::get('maquina/editar/{id}', 'User\maquinasController@editar')->name('maquina/editar/{id}');
Route::post('maquina/actualizar', 'User\maquinasController@actualizar')->name('maquina/actualizar');
Route::get('maquina/eliminar/{id}', 'User\maquinasController@eliminar')->name('maquina/eliminar/{id}');

//RUTAS PRODUCTOS
Route::get('productos/nuevo', 'User\produccionController@nuevo')->name('productos/nuevo');
Route::post('producto/guardar', 'User\produccionController@guardarProducto')->name('producto/guardar');
Route::get('producto/editar/{id}', 'User\produccionController@editarProducto')->name('producto/editar/{id}');
Route::post('producto/actualizar', 'User\produccionController@actualizarProducto')->name('producto/actualizar');
Route::get('producto/eliminar/{id}', 'User\produccionController@eliminarProducto')->name('producto/eliminar/{id}');

//RUTAS CATALOGO DE COSTOS
Route::get('costos/nuevo', 'User\CostoController@nuevoCosto')->name('costos/nuevo');
Route::post('costos/guardar', 'User\CostoController@guardarCosto')->name('costos/guardar');
Route::get('costos/editar/{id}', 'User\CostoController@editarCosto')->name('costos/editar/{id}');
Route::post('costos/actualizar', 'User\CostoController@actualizarCosto')->name('costos/actualizar');

//RUTAS COSTOS POR ORDEN
Route::get('/costo-orden', 'User\CostoOrdenController@index')->name('costo-orden');
Route::get('costo-orden/nuevo/{numOrden}', 'User\CostoOrdenController@nuevoCostoOrden')->name('costo-orden/nuevo/{numOrden}');
Route::post('costo-orden/guardar', 'User\CostoOrdenController@guardarCostoOrden')->name('costo-orden/guardar');
Route::get('costo-orden/detalle/{numOrden}', 'User\CostoOrdenController@detalleCostoOrden')->name('costo-orden/detalle/{numOrden}');
Route::get('costo-orden/detalle/editar/{id}', 'User\CostoOrdenController@editarCostoOrden')->name('costo-orden/detalle/editar/{id}');
Route::post('costo-orden/actualizar', 'User\CostoOrdenController@actualizarCostoOrden')->name('costo-orden/actualizar');
Route::post('costo-orden/guardarhrs-producidas', 'User\CostoOrdenController@guardarHrasProd')->name('costo-orden/guardarhrs-producidas');
Route::post('costo-orden/add-comment', 'User\CostoOrdenController@guardarComment')->name('costo-orden/add-comment');


//RUTAS REPORTES
Route::post('guardar-tiempo-pulpeo', 'User\reporteController@guardarTiempoPulpeo')->name('guardar-tiempo-pulpeo');
Route::post('guardar-inventario-ajax', 'User\reporteController@guardarInventarioAjax')->name('guardar-inventario-ajax');
Route::post('guardar-tiempo-lavado', 'User\reporteController@guardarTiempoLavado')->name('guardar-tiempo-lavado');
Route::post('eliminar-tiempo-pulpeo', 'User\reporteController@eliminarTiempoPulpeo')->name('eliminar-tiempo-pulpeo');
Route::post('eliminar-vinieta', 'User\reporteController@eliminarVinietaJRoll')->name('eliminar-vinieta');
Route::post('eliminar-tiempo-lavado', 'User\reporteController@eliminarTiempoLavado')->name('eliminar-tiempo-lavado');
Route::post('guardar-tiempos-muertos', 'User\reporteController@guardarTiemposMuertos')->name('guardar-tiempos-muertos');
Route::post('eliminar-tiempos-muertos', 'User\reporteController@eliminarTiemposMuertos')->name('eliminar-tiempos-muertos');
Route::post('guardar-jumboroll', 'User\reporteController@guardarJumboRoll')->name('guardar-jumboroll');
Route::post('guardar-inventario', 'User\reporteController@guardarInventario')->name('guardar-inventario');
Route::get('dataJROLL/{idTurno}/{codigo}', 'User\reporteController@getDataJumboRoll')->name('dataJROLL/{idTurno}/{codigo}');
Route::get('getDtaInventario/{codigo}', 'User\reporteController@getDataInventario')->name('getDtaInventario/{codigo}');
Route::get('getDataJRDetail/{codigo}', 'User\reporteController@getDataJRDetail')->name('getDataJRDetail/{codigo}');
Route::post('guardar-detailJR', 'User\reporteController@guardarDetailJR')->name('guardar-detailJR');
Route::post('guardar-detailJR', 'User\reporteController@guardarDetailJR')->name('guardar-detailJR');


Route::post('guardar-hrasEft', 'User\reporteController@guardarhrasEft')->name('guardar-hrasEft');
Route::post('eliminar-hras-efectivas', 'User\reporteController@eliminarHrasEft')->name('eliminar-hras-efectivas');




//PDF
//Route::get('/pdf','PDFController@PDF')->name('descargarPDF');
Route::get('/detalleOrdenPDF/{numOrden}','PDFController@detalleOrdenPDF')->name('detalleOrdenPDF/{numOrden}');
Route::get('/home/detalle/{numOrden}', 'HomeController@detail')->name('/home/detalle/{numOrden}');



//Tipo de Cambio
Route::get('costo-orden/detalle/get-Tipo-Cambio/{date}', 'User\TipoCambioController@getTipoCambio')->name('costo-orden/detalle/get-Tipo-Cambio/{date}');
Route::post('costo-orden/detalle/actualizarTC', 'User\TipoCambioController@actualizarTC')->name('costo-orden/detalle/actualizarTC');


Auth::routes();
