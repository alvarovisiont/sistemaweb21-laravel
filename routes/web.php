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

Route::get('/', 'AuthController@index')->name('/');
route::post('/login','AuthController@auth')->name('login');
route::get('/logout','AuthController@logout')->name('logout');
route::get('/home','HomeController@index')->name('home');

Route::resource('menu','MenuController');
Route::resource('perfil','PerfilController');
route::resource('users','UsuarioController');
route::resource('crear_vista','MakeviewController');

// usuarios 

route::get('users/users-active/{id}/{user_active}','UsuarioController@user_active')->name('users.users_active');

// permisos

Route::get('permiso/buscar_perfiles_ajax','PermisoController@buscar_perfiles_ajax')->name('permiso.buscar_perfiles_ajax');
Route::get('permiso/buscar_modulos_ajax','PermisoController@buscar_modulos_ajax')->name('permiso.buscar_modulos_ajax');
Route::get('permiso/buscar_modulos_ajax_user','PermisoController@buscar_modulos_ajax_user')->name('permiso.buscar_modulos_ajax_user');
Route::get('permiso/index','PermisoController@index')->name('permiso.index');
Route::post('permiso/store','PermisoController@store')->name('permiso.store');

// permisos acciones

Route::get('permiso_accion/index', 'PermisoAccionController@index')->name('permiso_accion.index');
Route::get('permiso_accion/buscar_accesos','PermisoAccionController@buscar_accesos')->name('permiso_accion.buscar_accesos');
Route::patch('permiso_accion/modificar_acceso','PermisoAccionController@modificar_acceso')->name('permiso_accion.modificar_acceso');

//configuración

route::get('config','ConfigController@index')->name('config.index');
route::patch('config/{id}','ConfigController@update')->name('config.update');
route::delete('config/delete','ConfigController@remove_img')->name('config.delete');

// crear vista
route::post('crear_vista/store_vista_dt','MakeviewController@store_vista_dt')->name('crear_vista.store_vista_dt');
route::patch('crear_vista/update_dt/{id}', 'MakeviewController@update_dt')->name('crear_vista.update_dt');
route::delete('crear_vista/delete_td/{id}','MakeviewController@delete_td')->name('crear_vista.delete_td');

route::post('crear_vista/store_vista_form','MakeviewController@store_vista_form')->name('crear_vista.store_vista_form');
route::patch('crear_vista/update_form/{id}', 'MakeviewController@update_form')->name('crear_vista.update_form');
route::delete('crear_vista/delete_form/{id}','MakeviewController@delete_form')->name('crear_vista.delete_form');

route::post('crear_vista/make_view','MakeviewController@make_view')->name('crear_vista.make_view');


