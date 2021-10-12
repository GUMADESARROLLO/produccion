<?php

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
Route::get('/','Auth\LoginController@showLoginForm');
Route::group(['prefix' => 'admin', 'namespace' => 'Admin', 'middleware' => 'auth'], function() {

});

//RUTAS MENUS
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/usuario','Admin\usuarioController@index')->name('usuario');
Route::get('/orden-produccion','User\orden_produccionController@index')->name('orden-produccion');
Route::get('/configuracion','User\configuracionController@index')->name('configuracion');
Route::get('/turnos','User\configuracionController@turnos')->name('turnos');
Route::get('/fibras','User\fibrasController@index')->name('fibras');
Route::get('/fibras/nueva-fibra','User\fibrasController@index')->name('fibras/nueva');
Route::get('/productos','User\produccionController@productos')->name('inventario');
Route::get('/maquinas','User\maquinasController@index')->name('maquinas');
Route::get('/maquina/nueva-maquina','User\maquinasController@nueva')->name('maquina/nueva');
Route::get('/reporte','User\reporteController@index')->name('maquina/nueva');

//RUTAS USUARIO
Route::get('user/nuevo', 'Admin\usuarioController@crear')->name('user/nuevo');
Route::post('usuario/guardar', 'Admin\usuarioController@guardar')->name('usuario/guardar');
Route::get('failed-user', 'Admin\usuarioController@guardarUserFailed')->name('failed-user');
Route::get('success-user', 'Admin\usuarioController@guardarUserSuccess')->name('success-user');

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

//RUTAS CONFIGURACIONES
Route::get('turnos/crear', 'User\configuracionController@crearTurno')->name('turnos/crear');
Route::post('turnos/guardar', 'User\configuracionController@guardarTurno')->name('turnos/guardar');
Route::get('turnos/editar/{id}', 'User\configuracionController@editarTurno')->name('turnos/editar/{id}');
Route::get('turnos/eliminar/{id}', 'User\configuracionController@eliminarTurno')->name('turnos/eliminar/{id}');
Route::post('turnos/actualizar', 'User\configuracionController@actualizarTurno')->name('turnos/actualizar');

//RUTAS MI INVENTARIO
Route::get('insumos/nuevo','User\inventarioController@nuevo')->name('insumos/nuevo');
Route::post('insumos/guardar', 'User\inventarioController@guardar')->name('insumos/guardar');

//RUTAS FIBRAS
Route::get('fibras/nueva','User\fibrasController@nuevaFibra')->name('fibras/nueva');
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
Route::get('productos/nuevo','User\produccionController@nuevo')->name('productos/nuevo');
Route::post('producto/guardar', 'User\produccionController@guardarProducto')->name('producto/guardar');
Route::get('producto/editar/{id}', 'User\produccionController@editarProducto')->name('producto/editar/{id}');
Route::post('producto/actualizar', 'User\produccionController@actualizarProducto')->name('producto/actualizar');
Route::get('producto/eliminar/{id}', 'User\produccionController@eliminarProducto')->name('producto/eliminar/{id}');

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


Auth::routes();