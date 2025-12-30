<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use app\Http\Controllers\LoginController;
use App\Http\Controllers\MovilController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\HappyBirthdayController;
use App\Http\Controllers\EmpleadoController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
/*
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    
    return $request->user();
});*/

//Route::get('/prueba',[LoginController::class,'create']);
Route::GET('/prueba2','App\Http\Controllers\LoginController@create');
//Route::POST('/login','app\Http\LoginController@login');
Route::post('/loginapp',[MovilController::class,'login']);
Route::get('/lis_empleados',[MovilController::class,'ListarEmpleados']);
Route::get('/lis_empleados_count',[MovilController::class,'ListarEmpleadosCount']);

Route::GET('/usuario',[UsuarioController::class, 'get_usuarios']);
Route::GET('/enviar-correo-happy-birthday',[HappyBirthdayController::class, 'enviar_correo_happy_birthday']);

Route::GET('/get-verficar-empleado-id/{id}',[EmpleadoController::class, 'get_verificar_empleado_id']);
Route::GET('/get-verficar-empleado-id-p/{id}',[EmpleadoController::class, 'get_verificar_empleado_id_p']);
