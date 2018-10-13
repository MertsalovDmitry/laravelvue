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


// Route::get('/', function () {
//     return view('employees.index');
// });

// Route::group(['prefix' => '/v1', 'namespace' => 'Api\V1', 'as' => 'api.'], function () {
//     Route::resource('employees', 'EmployeeController');
//     Route::get('tree', 'EmployeeController@tree');
// });

Auth::routes();
Route::get('/', 'EmployeeController@home');
Route::get('/list', 'EmployeeController@list')->middleware('auth');
Route::resource('/employees', 'EmployeeController');
Route::get('/tree', 'EmployeeController@tree');
Route::get('/treenode', 'EmployeeController@treenode');
Route::get('/searchchiefs', 'EmployeeController@searchChiefs');
Route::get('/positions', 'PositionController@index');

//Route::get('/home', 'HomeController@index')->name('home');
