<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArchivosController;
use App\Http\Controllers\MedicoController;
use App\Http\Controllers\LotaipController;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\ApiControllers;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!dfdfdfdf
|
*/


Route::GET('/', 'App\Http\Controllers\IndexController@index');
Route::prefix('aporte_ciudadano')->group(function () {
    Route::GET('/', 'App\Http\Controllers\ReportesController@index_aporte_ciudadano');
    Route::GET('/get/{fecha_desde}/{fecha_hasta}', 'App\Http\Controllers\ReportesController@get_aporte_ciudadano')->middleware(['auth.custom']);
    Route::GET('/excel/{fecha_desde}/{fecha_hasta}', 'App\Http\Controllers\ReportesController@get_excel_aporte_ciudadano')->middleware(['auth.custom']);
    Route::GET('/pdf/{fecha_desde}/{fecha_hasta}', 'App\Http\Controllers\ReportesController@get_pdf_aporte_ciudadano')->middleware(['auth.custom']);
    Route::POST('/store', 'App\Http\Controllers\IndexController@registrar_aporte_ciudadano');
});

Route::GET('/agencia-transito', 'App\Http\Controllers\IndexController@index_p');

//PAGINA INDEX DE TERMINAL
Route::GET('/terminal', 'App\Http\Controllers\IndexTerminalController@index_pagina');

//LOGIN
Route::GET('/home', 'App\Http\Controllers\HomeController@index')->middleware(['auth.custom']);
Route::GET('/login', 'App\Http\Controllers\LoginController@index')->name('login');
Route::GET('/login2', 'App\Http\Controllers\LoginController@index2');
Route::GET('/login3', 'App\Http\Controllers\LoginController@index3');
Route::POST('/iniciar-sesion', 'App\Http\Controllers\LoginController@iniciar_sesion')->middleware('throttle:10,1');
Route::GET('/cerrar-sesion', 'App\Http\Controllers\LoginController@cerrar_sesion');

Route::prefix('session_data')->group(function () {
    Route::POST('/store', 'App\Http\Controllers\LoginController@store_session_data');
    Route::POST('/update', 'App\Http\Controllers\LoginController@update_session_data');
    Route::GET('/unclosed', 'App\Http\Controllers\LoginController@get_session_data_unclosed');
    Route::GET('/daily', 'App\Http\Controllers\LoginController@get_session_data_daily');
    Route::GET('/close_id/{id}', 'App\Http\Controllers\LoginController@close_id');
});

//EMPLEADO
Route::GET('/nomina', 'App\Http\Controllers\EmpleadoController@index');
Route::GET('/registrar-nomina', 'App\Http\Controllers\EmpleadoController@index_registrar_empleado');
Route::GET('/modificar-nomina/{id}', 'App\Http\Controllers\EmpleadoController@index_modificar_empleado');
Route::GET('/acuerdo', 'App\Http\Controllers\EmpleadoController@index_registrar_acuerdo_empleado');
Route::GET('/get-empleado', 'App\Http\Controllers\EmpleadoController@get_empleados');
Route::GET('/get-direccion', 'App\Http\Controllers\EmpleadoController@get_direcciones');
Route::GET('/get-jefatura-subdireccion/{id}', 'App\Http\Controllers\EmpleadoController@get_subdirecciones');
Route::GET('/get-empleado-jefatura-subdireccion/{id}', 'App\Http\Controllers\EmpleadoController@get_empleado_subdirecciones');
Route::POST('/registrar-empleado', 'App\Http\Controllers\EmpleadoController@save_empleado');
Route::POST('/eliminar-empleado-id', 'App\Http\Controllers\EmpleadoController@delete_empleado_id');
Route::GET('/get-empleado-id/{id}', 'App\Http\Controllers\EmpleadoController@get_empleados_id');
Route::POST('/modificar-empleado', 'App\Http\Controllers\EmpleadoController@update_empleado');
Route::GET('/get-empleado-tipo/{tipo}/{valor}', 'App\Http\Controllers\EmpleadoController@get_empleados_tipo');
Route::GET('/get-empleado-modificar-id/{id}', 'App\Http\Controllers\EmpleadoController@get_empleados_modificar_id');
Route::GET('/get-cargo/{id_dire}/{id_jefatura}/{id_cargo_superior}', 'App\Http\Controllers\EmpleadoController@get_cargos_update');
Route::GET('/get-cargo/{id_dire}/{id_jefatura}', 'App\Http\Controllers\EmpleadoController@get_cargos');
Route::GET('/get-cargo-superior/{id_car}', 'App\Http\Controllers\EmpleadoController@get_cargos_superior');
Route::get('/vacaciones', 'App\Http\Controllers\EmpleadoController@vacaciones');
Route::get('/get_vacaciones', 'App\Http\Controllers\EmpleadoController@get_vacaciones');
Route::get('getdias/{id}', 'App\Http\Controllers\EmpleadoController@getdias');
Route::get('get_periodos/{id}', 'App\Http\Controllers\EmpleadoController@getperiodos');
Route::get('get_dias_periodos', 'App\Http\Controllers\EmpleadoController@get_dias_periodos');
Route::post('descontar_dias', 'App\Http\Controllers\EmpleadoController@descontar_dias');
Route::post('aprobar_dias', 'App\Http\Controllers\EmpleadoController@aprobar_dias');
Route::post('denegar_dias', 'App\Http\Controllers\EmpleadoController@denegar_dias');
Route::get('/get_search_empleado/{limit}/{text}', 'App\Http\Controllers\EmpleadoController@get_empleados_search');
Route::get('/get_search_empleado_busq/{limit}/{text}', 'App\Http\Controllers\EmpleadoController@get_empleados_search_busq');
Route::GET('/acciones_personal_listado', 'App\Http\Controllers\EmpleadoController@acciones_personal');
Route::GET('/get_list_acciones_personal/{fecha_desde?}/{fecha_hasta?}/{tipo_accion?}', 'App\Http\Controllers\EmpleadoController@get_acciones_personal');
Route::GET('/view_accion_personal/{id_accion}', 'App\Http\Controllers\EmpleadoController@view_accion_personal');
Route::GET('/reenviar-correo-empleado/{id_empleado}', 'App\Http\Controllers\EmpleadoController@reenviar_correo');


//CREDENCIAL
Route::GET('/credencial', 'App\Http\Controllers\QRController@index');
Route::GET('/get-empleado-qr/{id}', 'App\Http\Controllers\QRController@get_empleado_qr');
Route::GET('/qr-empleado', 'App\Http\Controllers\QRController@get_qr_empleado');
Route::GET('/descargar-qr/{ruta}', 'App\Http\Controllers\QRController@get_descargar_qr_empleado');
Route::POST('/generar-qr', 'App\Http\Controllers\QRController@save_qr_empleado');
Route::GET('/descargar-foto-empleado/{ruta}', 'App\Http\Controllers\QRController@descargar_foto_empleado');
Route::GET('/descargar-qr-empleado/{ruta}', 'App\Http\Controllers\QRController@descargar_QR_empleado');
Route::GET('/qr-masivo', 'App\Http\Controllers\QRController@save_qr_empleado_masivo');


//CORREO
Route::GET('/correo', 'App\Http\Controllers\CorreoController@index');
Route::GET('/enviar-correo-empleado/{id_direccion}/{id_jefatura}/{regimen_contractual}/{mensaje}', 'App\Http\Controllers\CorreoController@enviar_correo');


//BIOMETRICO
Route::GET('/registrar-empleado-biometrico', 'App\Http\Controllers\EmpleadoController@verificar_empleado');

//NOTIFICACION EMPLEADO
Route::POST('/registrar-notificacion-empleado', 'App\Http\Controllers\NotificacionEmpleadoController@save_notificacion_controller');
Route::POST('/eliminar-notificacion', 'App\Http\Controllers\NotificacionEmpleadoController@delete_notificacion');

//HOJA DE RUTA
Route::GET('/hoja-ruta', 'App\Http\Controllers\HojaRutaController@index');
Route::GET('/get-paz-salvo-empleado/{id}', 'App\Http\Controllers\HojaRutaController@get_paz_salvo_empleados_id');
Route::GET('/get-paz-salvo-empleado-jefe-inmediato/{id}', 'App\Http\Controllers\HojaRutaController@get_paz_salvo_empleados_jefe_inmediato_id');
Route::POST('/registrar-jefe-inmediato', 'App\Http\Controllers\HojaRutaController@save_paz_salvo_empleados_jefe_inmediato');

//EVALUACION DE DESEMPENOO EMPLEADO
Route::GET('/evaluacion', 'App\Http\Controllers\EvaluacionController@index');
Route::GET('/admin-reporte-evaluacion', 'App\Http\Controllers\EvaluacionController@index_reporte_evaluacion');
Route::GET('/get-reporte-evaluacion/{id_direccion}/{id_jefatura}/{regi_contra}', 'App\Http\Controllers\EvaluacionController@get_reporte_evaluacion');

Route::GET('/reporte-nomina', 'App\Http\Controllers\ReporteEmpleadoController@index');
Route::GET('/get-reporte-empleado/{id_direccion}/{id_jefatura}/{fecha_inicio}/{fecha_fin}/{regi_contra}', 'App\Http\Controllers\ReporteEmpleadoController@get_reporte_empleados');
Route::GET('/get-reporte-empleado_ni/{nivel}', 'App\Http\Controllers\ReporteEmpleadoController@get_reporte_empleados_niveles');
Route::GET('/imprimir-pdf/{id_direccion}/{id_jefatura}/{fecha_inicio}/{fecha_fin}/{regi_contra}', 'App\Http\Controllers\ReporteEmpleadoController@reportePdfEmpleados');
Route::GET('/imprimir-excel/{id_direccion}/{id_jefatura}/{fecha_inicio}/{fecha_fin}/{regi_contra}', 'App\Http\Controllers\ReporteEmpleadoController@reporteExcelEmpleados');

Route::GET('/imprimir-pdf_nivel/{nivel}', 'App\Http\Controllers\ReporteEmpleadoController@reportePdfEmpleados_nivel');
Route::GET('/imprimir-excel_nivel/{nivel}', 'App\Http\Controllers\ReporteEmpleadoController@reporteExcelEmpleados_nivel');

Route::GET('/vista-prueba', 'App\Http\Controllers\ReporteEmpleadoController@indexp');
Route::GET('/imagen', 'App\Http\Controllers\ReporteEmpleadoController@imagen');
Route::GET('/enviar-correo/{id}', 'App\Http\Controllers\EmpleadoController@enviar_correo');

// ACUERDOS
Route::GET('/imprimir-acuerdo-responsabilidad/{id}', 'App\Http\Controllers\ReporteEmpleadoController@reportePdfAcuerdoResponsabilidad');
Route::GET('/imprimir-acuerdo-confidencialidad/{id}', 'App\Http\Controllers\ReporteEmpleadoController@reportePdfAcuerdoConfidencialidad');
Route::POST('/file-acuerdo-responsabilidad', 'App\Http\Controllers\AcuerdosControllers@ArchivoAcuerdoResponsabilidadConfidencialidad');
Route::GET('/get-empleado-acuerdo-id/{id}', 'App\Http\Controllers\AcuerdosControllers@get_empleados_acuerdos_id');
Route::GET('descargar-archivo-ar/{nombre}', 'App\Http\Controllers\AcuerdosControllers@descargar_archivo_ac');
Route::POST('/eliminar-acuerdo-id', 'App\Http\Controllers\AcuerdosControllers@delete_acuerdoResponsabilidadConfidencialidad');


//USUARIOS
Route::GET('/usuario', 'App\Http\Controllers\UsuarioController@index');
Route::GET('/get-usuario', 'App\Http\Controllers\UsuarioController@get_usuarios');
Route::GET('/get-jefatura-subdireccion', 'App\Http\Controllers\UsuarioController@get_subdirecciones');
Route::POST('/registrar-usuario', 'App\Http\Controllers\UsuarioController@save_usuarios');
Route::POST('/eliminar-usuario-id', 'App\Http\Controllers\UsuarioController@delete_usuarios_id');
Route::GET('/get-usuario-id/{id}', 'App\Http\Controllers\UsuarioController@get_usuarios_id');
Route::POST('/modificar-usuario', 'App\Http\Controllers\UsuarioController@update_usuarios');
Route::POST('/cambiar-clave-usuario', 'App\Http\Controllers\UsuarioController@update_clave_usuario');
Route::GET('/usuario/{cedula}', 'App\Http\Controllers\UsuarioController@asignacion');

//NOSOTROS
Route::GET('/admin-nosotro', 'App\Http\Controllers\NosotroController@index');
Route::GET('/nosotros', 'App\Http\Controllers\NosotroController@index_pagina');
Route::GET('/quiene-somo', 'App\Http\Controllers\NosotroController@index_pagina_quienes_somos');

Route::GET('/get-nosotro', 'App\Http\Controllers\NosotroController@get_nosotros');
Route::POST('/registrar-nosotro', 'App\Http\Controllers\NosotroController@save_nosotros');
Route::POST('/eliminar-nosotro-id', 'App\Http\Controllers\NosotroController@delete_nosotro_id');
Route::GET('/get-nosotro-id/{id}', 'App\Http\Controllers\NosotroController@get_nosotros_id');
Route::POST('/modificar-nosotro', 'App\Http\Controllers\NosotroController@update_nosotros');


//CONSOLIDADO
Route::GET('/consolidado', 'App\Http\Controllers\ConsolidadoController@index');
Route::GET('/get-indicador', 'App\Http\Controllers\ConsolidadoController@get_indicadores');
Route::GET('/get-indicador-id/{id}', 'App\Http\Controllers\ConsolidadoController@get_indicadores_id');
Route::GET('/get-tipo-indicador-id/{id}', 'App\Http\Controllers\ConsolidadoController@get_tipos_indicadores_id');
Route::POST('/registrar-indicador', 'App\Http\Controllers\ConsolidadoController@save_indicador');
Route::GET('/get-indicador-modificar-id/{id}', 'App\Http\Controllers\ConsolidadoController@get_indicadores_modificar_id');
Route::POST('/modificar-indicador', 'App\Http\Controllers\ConsolidadoController@update_indicador_id');
Route::POST('/eliminar-indicador-id', 'App\Http\Controllers\ConsolidadoController@delete_indicador_id');

//REPORTE CONSOLIDADO
Route::GET('/consolidado-reporte', 'App\Http\Controllers\ConsolidadoReporteController@index');
Route::GET('/get-reporte-consolidado/{fecha_inicio}/{fecha_fin}', 'App\Http\Controllers\ConsolidadoReporteController@get_reporte_consolidados');

//RUTAS DE PAGINA WEB
//NOTICIAS
Route::GET('/noticia-dtm', 'App\Http\Controllers\NoticiasController@index_DTM');
Route::GET('/noticia-ttm', 'App\Http\Controllers\NoticiasController@index_TTM');
Route::GET('/noticia/{id}/{tipo}', 'App\Http\Controllers\NoticiasController@index_id');
Route::GET('/admin-noticia', 'App\Http\Controllers\NoticiasController@index_administrador');
Route::GET('/get-noticia', 'App\Http\Controllers\NoticiasController@get_noticias');
Route::GET('/get-noticia-paginacion/{id}/{desde}/{hasta}/{tipo}', 'App\Http\Controllers\NoticiasController@get_noticia_paginacion');
Route::POST('/registrar-noticia', 'App\Http\Controllers\NoticiasController@save_noticias');
Route::POST('/eliminar-noticia-id', 'App\Http\Controllers\NoticiasController@delete_noticias_id');
Route::GET('/get-noticia-id/{id}', 'App\Http\Controllers\NoticiasController@get_noticias_id');
Route::POST('/modificar-noticia', 'App\Http\Controllers\NoticiasController@update_noticias');

//SERVICIOS
Route::GET('/servicio', 'App\Http\Controllers\ServicioController@index_pagina');

//CONTACTANOS
Route::GET('/admin-contactano', 'App\Http\Controllers\ContactanoController@index');
Route::GET('/contacto', 'App\Http\Controllers\ContactanoController@index_pagina');
Route::POST('/registrar-contactano-pagina', 'App\Http\Controllers\ContactanoController@save_contactanos_paginas');
Route::POST('/registrar-contactano', 'App\Http\Controllers\ContactanoController@save_contactanos');
Route::GET('/get-contactano', 'App\Http\Controllers\ContactanoController@get_contactanos');
Route::POST('/eliminar-contactano-id', 'App\Http\Controllers\ContactanoController@delete_contactanos_id');

Route::GET('/get-contactano-id/{id}', 'App\Http\Controllers\ContactanoController@get_contactanos_id');
Route::POST('/modificar-contactano', 'App\Http\Controllers\ContactanoController@update_contactanos');

//LOTAIP
Route::GET('/admin-lotaip', 'App\Http\Controllers\LotaipController@index');
Route::GET('/admin-lotaip/{id}/{year}', 'App\Http\Controllers\LotaipController@index_registrar');
Route::GET('/admin-lotaip/{id}', 'App\Http\Controllers\LotaipController@index_registrarv2');
Route::GET('/admin-solicitud-lotaip', 'App\Http\Controllers\LotaipController@index_solicitud_lotaip');
Route::GET('/get-solicitud-lotaip', 'App\Http\Controllers\LotaipController@get_solicitud_lotaips');
Route::GET('/get-solicitud-lotaip-id/{id}', 'App\Http\Controllers\LotaipController@get_solicitud_lotaips_id');



Route::GET('/lotaip', 'App\Http\Controllers\LotaipController@index_pagina');
Route::GET('/get-lotaip', 'App\Http\Controllers\LotaipController@get_lotaips');
Route::GET('/get-lotaip-modificar-id/{id}', 'App\Http\Controllers\LotaipController@get_lotaips_id');
//Route::GET('/get-literal-lotaip', 'App\Http\Controllers\LotaipController@get_literales_lotaips');
Route::POST('/registrar-lotaip', 'App\Http\Controllers\LotaipController@save_lotaip');
Route::POST('/modificar-lotaip', 'App\Http\Controllers\LotaipController@update_lotaip');
Route::POST('/eliminar-lotaip-id', 'App\Http\Controllers\LotaipController@delete_lotaip');
Route::POST('/registrar-literal-lotaip_document', 'App\Http\Controllers\LotaipController@save_literal_lotaip');
Route::POST('/update-literal-lotaip_document', 'App\Http\Controllers\LotaipController@update_literal_lotaip');
Route::GET('/get-literal-lotaip/{id}', 'App\Http\Controllers\LotaipController@get_literales_id_lotaips');
Route::GET('/get-literal-lotaip-modificar-id/{id}', 'App\Http\Controllers\LotaipController@get_literales_modificar_id_literal_lotaips');
Route::POST('/eliminar-literal-lotaip-id', 'App\Http\Controllers\LotaipController@delete_literal_lotaip_id');
Route::POST('/registrar-solicitud-lotaip', 'App\Http\Controllers\LotaipController@save_solicitud_lotaip');
Route::POST('/enviar-solicitud-lotaip', 'App\Http\Controllers\LotaipController@send_solicitud_lotaip');
Route::POST('/registrar-contestacion-solicitud-lotaip-email', 'App\Http\Controllers\LotaipController@save_contestacion_solicitud_lotaip_email');
Route::POST('/registrar-contestacion-solicitud-lotaip-fisico', 'App\Http\Controllers\LotaipController@save_contestacion_solicitud_lotaip_fisico');
Route::get('/descargar-archivo-solicitud/{ruta}', 'App\Http\Controllers\LotaipController@descargar_archivo_solicitud');
Route::GET('/ver-entrega-informacion-publica/{id}', 'App\Http\Controllers\LotaipController@ver_entrega_informacion_publica');


//LITERAL LOTAIP 
Route::GET('/admin-literal-lotaip', 'App\Http\Controllers\LiteralLotaipController@index');
Route::GET('/get-literal-lotaip', 'App\Http\Controllers\LiteralLotaipController@get_literal_lotaips');
Route::POST('/registrar-literal-lotaip', 'App\Http\Controllers\LiteralLotaipController@save_literal_lotaips');
Route::GET('/get-literal-lotaip-id/{id}', 'App\Http\Controllers\LiteralLotaipController@get_literal_lotaip_id');

//RENDICION DE CUENTA
Route::GET('/admin-rendicion-cuenta', 'App\Http\Controllers\RendicionCuentaController@index');
Route::GET('/admin-literal-rendicion-cuenta/{id}/{year}', 'App\Http\Controllers\RendicionCuentaController@index_registrar');
Route::GET('/rendicion-cuenta', 'App\Http\Controllers\RendicionCuentaController@index_pagina');
Route::GET('/get-rendicion-cuenta', 'App\Http\Controllers\RendicionCuentaController@get_rendicion_cuenta');
Route::POST('/registrar-rendicion-cuenta', 'App\Http\Controllers\RendicionCuentaController@save_rendicion_cuenta');
Route::GET('/get-rendicion-cuenta-modificar-id/{id}', 'App\Http\Controllers\RendicionCuentaController@get_rendicion_cuenta_id');
Route::POST('/eliminar-rendicion-cuenta-id', 'App\Http\Controllers\RendicionCuentaController@delete_rendicion_cuenta_id');
Route::POST('/modificar-rendicion-cuenta', 'App\Http\Controllers\RendicionCuentaController@update_rendicion_cuenta');
Route::GET('/get-literal-rendicion-cuenta', 'App\Http\Controllers\RendicionCuentaController@get_literal_rendicion_cuenta');
Route::GET('/get-literal-rendicion-cuenta-id/{id}', 'App\Http\Controllers\RendicionCuentaController@get_literal_rendicion_cuenta_id');
Route::POST('/registrar-literal-rendicion-cuenta', 'App\Http\Controllers\RendicionCuentaController@save_literal_rendicion_cuenta');
Route::POST('/eliminar-literal-rendicion-cuenta-id', 'App\Http\Controllers\RendicionCuentaController@delete_literal_rendicion_cuenta_id');
Route::GET('/get-literal-rendicion-cuenta-modificar-id/{id}', 'App\Http\Controllers\RendicionCuentaController@get_literales_modificar_id_literal_rendicion_cuenta');

//LITERALES DE RENDICION DE CUENTA


//PLAN ESTARTEGICO 
Route::GET('/plan-estrategico', 'App\Http\Controllers\PlanEstrategicoController@index_pagina');

//SLIDER INDEX
Route::GET('/admin-slider-index', 'App\Http\Controllers\SliderController@index');
Route::GET('/get-slider-index', 'App\Http\Controllers\SliderController@get_slider_index');
Route::POST('/registrar-slider', 'App\Http\Controllers\SliderController@save_slider_index');
Route::POST('/registrar-slider_intranet', 'App\Http\Controllers\SliderController@save_slider_intranet');
Route::GET('/get-slider-id/{id}', 'App\Http\Controllers\SliderController@get_slider_id');
Route::POST('/modificar-slider', 'App\Http\Controllers\SliderController@update_slider_index_id');
Route::POST('/eliminar-slider-id', 'App\Http\Controllers\SliderController@delete_slider_id');


//COOPERATIVA
Route::GET('/cooperativa', 'App\Http\Controllers\CooperativaController@index_pagina');
Route::GET('/cooperativa-id/{id}', 'App\Http\Controllers\CooperativaController@index_pagina_id');
Route::GET('/admin-cooperativa', 'App\Http\Controllers\CooperativaController@index');
Route::GET('/get-cooperativa', 'App\Http\Controllers\CooperativaController@get_cooperativa');
Route::POST('/registrar-cooperativa', 'App\Http\Controllers\CooperativaController@save_cooperativa');
Route::POST('/eliminar-cooperativa-id', 'App\Http\Controllers\CooperativaController@delete_cooperativa_id');
Route::GET('/get-cooperativa-id/{id}', 'App\Http\Controllers\CooperativaController@get_cooperativas_id');
Route::POST('/modificar-cooperativa', 'App\Http\Controllers\CooperativaController@update_cooperativa');

//DESTINO
Route::GET('/admin-destino', 'App\Http\Controllers\DestinoController@index');
Route::GET('/get-destino', 'App\Http\Controllers\DestinoController@get_destino');
Route::POST('/registrar-destino', 'App\Http\Controllers\DestinoController@save_destino');
Route::POST('/eliminar-destino-id', 'App\Http\Controllers\DestinoController@delete_destino_id');
Route::GET('/get-destino-id/{id}', 'App\Http\Controllers\DestinoController@get_destino_id');
Route::POST('/modificar-destino', 'App\Http\Controllers\DestinoController@update_destino');
Route::GET('/buscar-destino', 'App\Http\Controllers\DestinoController@index_search_destino');
Route::GET('/get-destino-cooperativa/{id}', 'App\Http\Controllers\DestinoController@get_destino_cooperativa');
Route::GET('/get-buscar-destino/{id_de}/{id_coop}', 'App\Http\Controllers\DestinoController@get_search_destino');
Route::POST('/registrar-destino-cooperativa', 'App\Http\Controllers\DestinoController@save_destino_cooperativa');
Route::GET('/get-destino-cooperativa-id/{id}', 'App\Http\Controllers\DestinoController@get_destino_cooperativa_id');
Route::POST('/eliminar-destino-cooperativa-id', 'App\Http\Controllers\DestinoController@delete_destino_cooperativa_id');
Route::GET('/admin-get-destino-cooperativa/{id}', 'App\Http\Controllers\DestinoController@admin_get_destino_cooperativa');

//HORARIO
Route::GET('/get-horario-destino-cooperativa/{id}', 'App\Http\Controllers\HorarioController@get_horario_destino_cooperativa');
Route::POST('/registrar-horario-destino-cooperativa', 'App\Http\Controllers\HorarioController@save_horario_destino_cooperativa');
Route::GET('/get-horario-destino-cooperativa-id/{id}', 'App\Http\Controllers\HorarioController@get_horario_destino_cooperativa_id');
Route::POST('/eliminar-horario-destino-cooperativa-id', 'App\Http\Controllers\HorarioController@delete_horario_destino_cooperativa_id');

//CENTRO COMERCIAL
Route::GET('/centro-comercial', 'App\Http\Controllers\CentroComercialController@index_pagina');

//ENCOMIENDA
Route::GET('/encomienda', 'App\Http\Controllers\EncomiendaController@index_pagina');
Route::GET('/encomienda-id/{id}', 'App\Http\Controllers\EncomiendaController@index_pagina_id');

//TURISMO
Route::GET('/turismo', 'App\Http\Controllers\TurismoController@index_pagina');
Route::GET('/turismo-id/{id}', 'App\Http\Controllers\TurismoController@index_pagina_id');
Route::GET('/centro-comercial-id/{id}', 'App\Http\Controllers\TurismoController@index_centro_comercial_pagina_id');
Route::GET('/admin-turismo', 'App\Http\Controllers\TurismoController@index');
Route::GET('/get-turismo', 'App\Http\Controllers\TurismoController@get_turismo');
Route::POST('/registrar-turismo', 'App\Http\Controllers\TurismoController@save_turismo');
Route::POST('/eliminar-turismo-id', 'App\Http\Controllers\TurismoController@delete_turismo_id');
Route::GET('/get-turismo-id/{id}', 'App\Http\Controllers\TurismoController@get_turismo_id');
Route::POST('/modificar-turismo', 'App\Http\Controllers\TurismoController@update_turismo');
Route::POST('/eliminar-turismo-id', 'App\Http\Controllers\TurismoController@delete_turismo_id');
Route::GET('/get-turismo/{cat}', 'App\Http\Controllers\TurismoController@get_turismo_categoria');
Route::GET('/get-turismo-t/{cat}', 'App\Http\Controllers\TurismoController@get_turismo_categoria_t');
Route::GET('/get-turismo-c/{cat}', 'App\Http\Controllers\TurismoController@get_turismo_categoria_c');

//EVENTOS

//  CATEGORIA
Route::GET('/get-categoria', 'App\Http\Controllers\CategoriaController@get_categoria');
Route::GET('/get-categoria-turismo', 'App\Http\Controllers\CategoriaController@get_categoria_turismo');
Route::GET('/get-categoria-centro-comercial', 'App\Http\Controllers\CategoriaController@get_categoria_comercial');


Route::GET('/web', 'App\Http\Controllers\IndexTerminalController@index_web');

//PRUEBA GENESIS
Route::GET('/pruebag', 'App\Http\Controllers\PruebaGController@index');
Route::GET('/mapa', 'App\Http\Controllers\PruebaGController@index_mapa');
Route::GET('/admin-biometrico', 'App\Http\Controllers\PruebaGController@get_biometrico');
Route::GET('/admin-biometricoB', 'App\Http\Controllers\PruebaGController@get_biometricoB');
Route::GET('/admin-server', 'App\Http\Controllers\PruebaGController@get_server');


Route::POST('/enviar-correo', 'App\Http\Controllers\CorreoController@enviar_correo');
Route::GET('/vista', 'App\Http\Controllers\HappyBirthdayController@index_cumple');



//CATALOGO
Route::GET('/admin-catalogo', 'App\Http\Controllers\CatalogoController@index');
Route::GET('/get-catalogo', 'App\Http\Controllers\CatalogoController@get_catalogo');
Route::POST('/registrar-catalogo', 'App\Http\Controllers\CatalogoController@save_catalogo');
Route::POST('/eliminar-catalogo-id', 'App\Http\Controllers\CatalogoController@delete_catalogo_id');
Route::GET('/get-catalogo-id/{id}', 'App\Http\Controllers\CatalogoController@get_catalogo_id');
Route::POST('/modificar-catalogo', 'App\Http\Controllers\CatalogoController@update_catalogo');

//REPORTE CATALOGO
Route::GET('/admin-reporte-equipo', 'App\Http\Controllers\ReporteCatalogoController@index');
Route::GET('/get-reporte-catalogo/{id_categoria}/{id_area}/{id_estado}', 'App\Http\Controllers\ReporteCatalogoController@get_reporte_catalogo');
Route::GET('/imprimir-pdf-catalogo/{id_categoria}/{id_area}/{id_estado}', 'App\Http\Controllers\ReporteCatalogoController@get_reporte_catalogo_pdf');
Route::GET('/imprimir-excel-catalogo/{id_categoria}/{id_area}/{id_estado}', 'App\Http\Controllers\ReporteCatalogoController@get_reporte_catalogo_excell');


//INVENTARIO
Route::GET('/admin-inventario', 'App\Http\Controllers\InventarioController@index');
Route::GET('/get-empleado-id/{id}', 'App\Http\Controllers\InventarioController@get_empleados_id');
Route::POST('/registrar-catalogo-inventario', 'App\Http\Controllers\InventarioController@save_catalogo_inventario');
Route::POST('/eliminar-catalogo-inventario-id', 'App\Http\Controllers\InventarioController@delete_catalogo_inventario_id');


//REPORTES IP
Route::GET('/admin-ip', 'App\Http\Controllers\IPController@index');
Route::GET('/get-ip', 'App\Http\Controllers\IPController@get_ip');


//Route::GET('/','App\Http\Controllers\IndexController@index_ha');

/*MENUS*/
Route::GET('/menu', 'App\Http\Controllers\MenuController@index');
Route::GET('/get-menu', 'App\Http\Controllers\MenuController@get_menu');
Route::GET('/get-menu-id/{id}', 'App\Http\Controllers\MenuController@get_menu_id_');
Route::POST('/registrar-menu', 'App\Http\Controllers\MenuController@save_menu');
Route::POST('/modificar-menu', 'App\Http\Controllers\MenuController@update_menu');
Route::POST('/eliminar-menu-id', 'App\Http\Controllers\MenuController@delete_menu_id');
Route::GET('/get_menus/{id}', 'App\Http\Controllers\MenuController@get_menu_id');

/*PROYECTOS*/
Route::get('/proyectos', 'App\Http\Controllers\ProyectosController@index');
Route::get('/get_project', 'App\Http\Controllers\ProyectosController@get_project');
Route::post('store_project', 'App\Http\Controllers\ProyectosController@store');
Route::post('update_project', 'App\Http\Controllers\ProyectosController@update');
Route::post('delete_project', 'App\Http\Controllers\ProyectosController@destroy');


/*SUBMENU*/
Route::get('/submenu', 'App\Http\Controllers\SubmenuController@index');
Route::get('/get_submenu', 'App\Http\Controllers\SubmenuController@get_submenu');
Route::get('/get_submenu/{id_menu}', 'App\Http\Controllers\SubmenuController@get_submenu_id');
Route::post('store_submenu', 'App\Http\Controllers\SubmenuController@store');
Route::post('update_submenu', 'App\Http\Controllers\SubmenuController@update');
Route::post('delete_submenu', 'App\Http\Controllers\SubmenuController@destroy');


/*SUBMENU*/
Route::post('store_asignacion_menu', 'App\Http\Controllers\UsuarioController@store_asignacion');


//*NOTFICACIONES*/
Route::get('notificaciones', 'App\Http\Controllers\NotificacionController@index');
Route::post('save_noti', 'App\Http\Controllers\NotificacionController@store');
/***************INTRANET********************/
/*EVENTOS*/
Route::prefix('AdminIntra')->group(function () {
    Route::GET('/eventos', 'App\Http\Controllers\EventosController@index');
    Route::GET('/get_eventos', 'App\Http\Controllers\EventosController@get_eventos');
    Route::POST('/store_evento', 'App\Http\Controllers\EventosController@store');
    Route::POST('/update/{id}', 'App\Http\Controllers\EventosController@update');
    Route::POST('/delete/{id}', 'App\Http\Controllers\EventosController@destroy');
});

//SQL MASIVOS
Route::GET('/registrar-usuario-masivo', 'App\Http\Controllers\SQLController@save_usuarios_masivos');


///DOCUMENTOS

Route::get('gestion-documentos', 'App\Http\Controllers\DocumentosController@index');
Route::post('save_folder', 'App\Http\Controllers\DocumentosController@save_folder');
Route::get('delete_folder/{id}', 'App\Http\Controllers\DocumentosController@delete_folder');
Route::post('upload', 'App\Http\Controllers\DocumentosController@subir_archivo');
Route::post('open_carpeta', 'App\Http\Controllers\DocumentosController@open_folder');
Route::post('delete_file', 'App\Http\Controllers\DocumentosController@delete_file');

/*PERMISOS*/
Route::get('permisos', 'App\Http\Controllers\PermisosController@index');
Route::get('/get_permisos/{fecha_desde?}/{fecha_hasta?}', 'App\Http\Controllers\PermisosController@get_permisos');
Route::get('descargar_archivo_per/{ruta}', 'App\Http\Controllers\PermisosController@descargar_archivo');
Route::get('admin-reporte-solicitud', 'App\Http\Controllers\PermisosController@create_reporte_solicitudes');
Route::get('get-reporte-permiso/{fech_ini}/{fech_fin}', 'App\Http\Controllers\PermisosController@get_reporte_permisos');
Route::get('/imprimir-pdf-reporte-permiso/{fech_ini}/{fech_fin}', 'App\Http\Controllers\PermisosController@get_reporte_permisos_pdf');
Route::GET('/imprimir-excel-reporte-permiso/{fech_ini}/{fech_fin}', 'App\Http\Controllers\PermisosController@get_reporte_permisos_excell');
Route::GET('/get_excel_permisos/{fecha_desde?}/{fecha_hasta?}', 'App\Http\Controllers\PermisosController@reporte_excel_permisos_empleados');
Route::GET('/get_pdf_permisos/{fecha_desde?}/{fecha_hasta?}', 'App\Http\Controllers\PermisosController@reporte_pdf_permisos_empleados');


//Tipos de permisos
Route::get('/tipo-permiso', 'App\Http\Controllers\TiposPermisosController@index');
Route::get('/get-tipo-permiso', 'App\Http\Controllers\TiposPermisosController@get_tipo_permiso');

//CAMPOS TIPOS DE PERMISOS
Route::get('/get-campo-tipo-permiso/{id}', 'App\Http\Controllers\TiposPermisosController@get_campo_tipo_permiso');
Route::post('/save-campo-tipo-permiso', 'App\Http\Controllers\TiposPermisosController@save_campo_tipo_permiso');
Route::get('/get-campo', 'App\Http\Controllers\TiposPermisosController@get_campos');

//ARTICULOS
Route::get('/get-articulo-tipo-permiso/{id}', 'App\Http\Controllers\ArticulosControllers@get_articulos');
Route::post('/save-articulo-tipo-permiso', 'App\Http\Controllers\ArticulosControllers@save_articulo_tipo_permiso');


/*VIDEOS**/
Route::get('display/municipio', 'App\Http\Controllers\VideoController@index');

/**NORMATIVAS **/
Route::get('/normativa', 'App\Http\Controllers\IndexController@normativas');

/**REQUISITOS DE MULTAS */
Route::get('/requisito', 'App\Http\Controllers\RequisitoMultaController@index');
Route::get('/requisito/{id}', 'App\Http\Controllers\RequisitoMultaController@requisito_id');

/**RTV */
Route::get('/rtv', 'App\Http\Controllers\RTVController@index');

/**CONVOCATORIAS */
Route::get('/convocatoria', 'App\Http\Controllers\ConvocatoriaController@index');


Route::get("error", function () {
    abort(404);
});

Route::get('reset-password', 'App\Http\Controllers\LoginController@reset');
Route::post('cambiar_pass', 'App\Http\Controllers\LoginController@cambiar');

/*RESEÑA HISTORICA*/
Route::get('/resena-historica', 'App\Http\Controllers\ResenaHistoricaController@index');


/**SLIDER DE LA INTRANET */
Route::get('slider', 'App\Http\Controllers\IntranetController@index');


/*MODULO DE ARCHIVOS*/
Route::prefix('bodegas')->group(function () {
    Route::GET('/', [ArchivosController::class, 'bodegaIndex']);
    Route::GET('/getbodegas', [ArchivosController::class, 'bodegaData']);
    Route::GET('/getempresas', [ArchivosController::class, 'get_empresas_active_all']);
    Route::POST('/store', [ArchivosController::class, 'bodegaStore']);
    Route::POST('/update', [ArchivosController::class, 'bodegaUpdate']);
    Route::POST('/delete/{id}', [ArchivosController::class, 'bodegaDelete']);
});

Route::prefix('tipos-contenedores')->group(function () {
    Route::GET('/', [ArchivosController::class, 'TipoCIndex']);
    Route::GET('/getAll', [ArchivosController::class, 'TipoCData']);
    Route::GET('/getNumeracion', [ArchivosController::class, 'TipoCGetNumeracion']);
    Route::POST('/store', [ArchivosController::class, 'TipoCStore']);
    Route::POST('/update', [ArchivosController::class, 'TipoCUpdate']);
    Route::POST('/delete/{id}', [ArchivosController::class, 'TipoCDelete']);
});


Route::get('contenedores', [ArchivosController::class, 'ContenedorIndex']);
Route::get('get_numeracion/{id}/{id_bodega}', [ArchivosController::class, 'get_numeracion']);
Route::get('get_contenedor/{id}', [ArchivosController::class, 'get_contenedor']);

Route::post('store_contenedor', [ArchivosController::class, 'store_contenedor']);
Route::post('open_contenedor', [ArchivosController::class, 'open_contenedor']);
Route::post('store_folder', [ArchivosController::class, 'store_folder']);
Route::post('open_carpeta_arc', [ArchivosController::class, 'open_carpeta']);
Route::post('subir_proceso', [ArchivosController::class, 'subir_proceso']);
Route::get('del_folder/{id_folder}/{v}', [ArchivosController::class, 'del_folder']);
Route::get('del_file/{id_file}/{id_folder}', [ArchivosController::class, 'del_file']);
Route::get('descargar_archivo/{ruta}', [ArchivosController::class, 'descargar_archivo']);
Route::get('get_info_f/{id}', [ArchivosController::class, 'get_info_f']);
Route::get('search_proceso/{dat}', [ArchivosController::class, 'search_proceso']);

Route::get('procesos', [ArchivosController::class, 'procesos']);

//PROCESOS
Route::GET('/admin-proceso', 'App\Http\Controllers\ProcesoController@index');
Route::GET('/get-proceso', 'App\Http\Controllers\ProcesoController@get_proceso');
Route::POST('/registrar-proceso', 'App\Http\Controllers\ProcesoController@save_proceso');
Route::GET('/descargar-archivo-proceso/{file}', 'App\Http\Controllers\ProcesoController@descargar_archivo_proceso');
Route::POST('/eliminar-proceso-id', 'App\Http\Controllers\ProcesoController@delete_proceso_id');

//WEB SERVICE ANT-MUNICIPIO
Route::GET('/webservice', 'App\Http\Controllers\WebServiceController@get_web_service');

//CAARGOS
Route::GET('/admin-cargo', 'App\Http\Controllers\CargosController@index');
Route::GET('/get-cargo', 'App\Http\Controllers\CargosController@get_cargo');
Route::POST('/registrar-cargo', 'App\Http\Controllers\CargosController@save_cargo');
Route::POST('/eliminar-cargo-id', 'App\Http\Controllers\CargosController@delete_cargo_id');
Route::GET('/get-cargo-id/{id}', 'App\Http\Controllers\CargosController@get_cargo_id');
Route::POST('/modificar-cargo', 'App\Http\Controllers\CargosController@update_cargo');

//ORGANIGRAMA INSTITUCIONAL
Route::GET('/admin-organigrama', 'App\Http\Controllers\OrganigramaInstitucionalController@index');
Route::GET('/get-organigrama', 'App\Http\Controllers\OrganigramaInstitucionalController@get_organigrama');
Route::POST('/admin-registrar-organigrama', 'App\Http\Controllers\OrganigramaInstitucionalController@save_organigrama');
Route::POST('/admin-modificar-organigrama', 'App\Http\Controllers\OrganigramaInstitucionalController@update_organigrama');
Route::POST('/eliminar-organigrama-id', 'App\Http\Controllers\OrganigramaInstitucionalController@delete_organigrama_id');
Route::GET('/get-organigrama-id/{id}', 'App\Http\Controllers\OrganigramaInstitucionalController@get_organigrama_id');
Route::get('graficar-organigrama', 'App\Http\Controllers\OrganigramaInstitucionalController@graficar');

/*FRECUECNIAS*/
Route::get('frecuencias', 'App\Http\Controllers\FrecuenciasController@index');
Route::get('f_semanal', 'App\Http\Controllers\FrecuenciasController@get_frecuencias_semanal');
Route::get('f_data/{i}/{f}', 'App\Http\Controllers\FrecuenciasController@get_resporte');

Route::get('frecuencias-detalles', 'App\Http\Controllers\FrecuenciasController@detalle_f');
Route::get('get_disco/{id}', 'App\Http\Controllers\FrecuenciasController@get_disco');
Route::post('get_detalle_f', 'App\Http\Controllers\FrecuenciasController@detalle');
Route::get('tasas_report/{i}/{f}', 'App\Http\Controllers\FrecuenciasController@gettasas');

/*CONVOCATORIAS TERMINAL*/
Route::get('TTM/convocatoria', 'App\Http\Controllers\ConvocatoriaController@tconvocatoria');

/**Rutas de Prueba*/

Route::get('/multaManta', 'App\Http\Controllers\HomeController@multas');
Route::get('/correo_empleado/{id_empleado}', 'App\Http\Controllers\EmpleadoController@enviar_correo');
Route::get('/correo_empleado_prueba', 'App\Http\Controllers\EmpleadoController@enviar_correo_prueba');

/*SISTEMA MEDICO MOVILIDAD*/

Route::get('panel-medico', [MedicoController::class, 'index']);
Route::get('tipos-enfermedades', [MedicoController::class, 'index_tipos_enfermedades']);
Route::post('store_categoria', [MedicoController::class, 'store_categoria']);
Route::post('delete_categoria', [MedicoController::class, 'delete_categoria']);
Route::post('edit_categoria', [MedicoController::class, 'edit_categoria']);
Route::get('GET_tipos_enf', [MedicoController::class, 'GET_tipos']);

Route::get('enfermedades', [MedicoController::class, 'index']);
Route::get('GET_enf', [MedicoController::class, 'lista_enf']);
Route::post('store_enfermedad', [MedicoController::class, 'store_e']);

Route::get('consulta', [MedicoController::class, 'consulta']);
Route::post('Get_paciente', [MedicoController::class, 'lista_pacientes']);
Route::get('consulta/{cedula}', [MedicoController::class, 'form_consulta']);
Route::get('/ficha_medica', [MedicoController::class, 'ficha_medica']);
Route::get('/registrar_ficha_medica', [MedicoController::class, 'registrar_ficha_medica']);
Route::get('/get_search_causa_consulta_medica/{coincidenciaTotal}/{limit}/{text?}', [MedicoController::class, 'get_causas_consulta_medicas']);
Route::get('/get_search_diagnostico_consulta_medica/{coincidenciaTotal}/{limit}/{text?}', [MedicoController::class, 'get_diagnostico_consulta_medicas']);
Route::post('/modify_causa_medica', [MedicoController::class, 'modify_causa_medica']);
Route::post('/agregar_causa_medica', [MedicoController::class, 'agregar_causa_medica']);
Route::post('/deshabilitar_causa_medica', [MedicoController::class, 'deshabilitar_causa_medica']);
Route::post('/modify_diagnostico_medico', [MedicoController::class, 'modify_diagnostico_medico']);
Route::post('/agregar_diagnostico_medico', [MedicoController::class, 'agregar_diagnostico_medico']);
Route::post('/deshabilitar_diagnostico_medico', [MedicoController::class, 'deshabilitar_diagnostico_medico']);
Route::get('/get_search_medico_consulta_ficha/{coincidenciaTotal}/{limit}/{text?}', [MedicoController::class, 'get_medicos_consulta_medicas']);
Route::post('/modify_medico_consulta_ficha', [MedicoController::class, 'modify_medico_ficha']);
Route::post('/agregar_medico_consulta_ficha', [MedicoController::class, 'agregar_medico_ficha']);
Route::post('/deshabilitar_medico_consulta_ficha', [MedicoController::class, 'deshabilitar_medico_ficha']);
Route::post('/registrar-certificado-medico', [MedicoController::class, 'agregar_certificado_medico']);
Route::GET('/show_certificado_medico/{id}/{approve?}', [MedicoController::class, 'show_certificado_medico']);
Route::GET('/get-list-certificados-medicos/{fecha_desde?}/{fecha_hasta?}/{tipo_certificado?}', [MedicoController::class, 'get_certificados_medicos_page_principal']);
Route::get('/modificar_ficha_medica/{id}', [MedicoController::class, 'modificar_ficha_medica']);
Route::post('/modificar-certificado-medico', [MedicoController::class, 'modificar_certificado_medico']);
Route::post('/aprobar-certificado-medico', [MedicoController::class, 'save_aprobacion_certificado_medico']);
Route::GET('/get_excel_certificados_medicos/{fecha_desde?}/{fecha_hasta?}/{tipo_certificado?}', [MedicoController::class, 'reporte_excel_certificados_medicos']);
Route::GET('/get_pdf_permisos_medicos/{fecha_desde?}/{fecha_hasta?}/{tipo_certificado?}', [MedicoController::class, 'reporte_pdf_certificados_medicos']);
Route::GET('/get-data-certificados-medicos/{fecha_desde?}/{fecha_hasta?}/{tipo_certificado?}', [MedicoController::class, 'get_certificados_medicos_data']);
Route::GET('/admin-reporte-certificados-medicos', [MedicoController::class, 'create_reporte_certificados']);

// MODULO LITERAL LOTAIP
Route::get('literal-lotaip', [LotaipController::class, 'literal']);

//DIRECCION ORGANIZACIONAL
Route::prefix('direccion-organizacional')->middleware(['auth.custom'])->group(function () {
    Route::GET('/', 'App\Http\Controllers\DireccionOrganigramaController@index');
    Route::GET('/getAll', 'App\Http\Controllers\DireccionOrganigramaController@get_all');
    Route::GET('/getActiveAll', 'App\Http\Controllers\DireccionOrganigramaController@get_active_all');
    Route::POST('/store', 'App\Http\Controllers\DireccionOrganigramaController@store');
    Route::POST('/update', 'App\Http\Controllers\DireccionOrganigramaController@update');
    Route::POST('/delete/{id}', 'App\Http\Controllers\DireccionOrganigramaController@destroy');
});

//JEFATURA ORGANIZACIONAL
Route::prefix('jefatura-organizacional')->middleware(['auth.custom'])->group(function () {
    Route::GET('/', 'App\Http\Controllers\JefaturaOrganigramaController@index');
    Route::GET('/getAll', 'App\Http\Controllers\JefaturaOrganigramaController@get_all');
    Route::POST('/store', 'App\Http\Controllers\JefaturaOrganigramaController@store');
    Route::POST('/update', 'App\Http\Controllers\JefaturaOrganigramaController@update');
    Route::POST('/delete/{id}', 'App\Http\Controllers\JefaturaOrganigramaController@destroy');
});

//CONFIGURACION UNIDADES DE ALMACENAMIENTO
Route::prefix('ConfiguracionUnidadesAlmacenamiento')->middleware(['auth.custom'])->group(function () {
    Route::GET('/', 'App\Http\Controllers\ArchivosController@indexConfiguracionUnidadAlmacenamiento');
    Route::GET('/get_configuracion_unidades_almacenamiento', 'App\Http\Controllers\ArchivosController@get_configuracion_unidad_almacenamiento');
    Route::POST('/store', 'App\Http\Controllers\ArchivosController@storeConfiguracionUnidadAlmacenamiento');
    Route::POST('/update', 'App\Http\Controllers\ArchivosController@updateConfiguracionUnidadAlmacenamiento');
    Route::POST('/delete/{id}', 'App\Http\Controllers\ArchivosController@destroyConfiguracionUnidadAlmacenamiento');
});

//CONFIGURACION DOCUMENTOS ARCHIVO
Route::prefix('ConfiguracionDocumentosArchivo')->middleware(['auth.custom'])->group(function () {
    Route::GET('/', 'App\Http\Controllers\ArchivosController@indexConfiguracionDocumentos');
    Route::GET('/get_configuracion_documentos', 'App\Http\Controllers\ArchivosController@get_configuracion_documentos');
    Route::GET('/get_search_active_documents/{coincidenciaTotal}/{limit}/{text?}', 'App\Http\Controllers\ArchivosController@get_search_documentos_active');
    Route::POST('/store', 'App\Http\Controllers\ArchivosController@storeConfiguracionDocumento');
    Route::POST('/update', 'App\Http\Controllers\ArchivosController@updateConfiguracionDocumento');
    Route::POST('/delete/{id}', 'App\Http\Controllers\ArchivosController@destroyConfiguracionDocumento');
});

//CONFIGURACION UNIDAD PRODUCTORA
Route::prefix('ConfiguracionUnidadProductora')->middleware(['auth.custom'])->group(function () {
    Route::GET('/', 'App\Http\Controllers\ArchivosController@indexConfiguracionUnidadProductora');
    Route::GET('/get_configuracion_unidad_productora', 'App\Http\Controllers\ArchivosController@get_configuracion_unidad_productora');
    Route::POST('/get_configuracion_serie_documento/{id}', 'App\Http\Controllers\ArchivosController@get_configuracion_series_documentos');
    Route::POST('/store', 'App\Http\Controllers\ArchivosController@storeConfiguracionUnidadProductora');
    Route::POST('/update', 'App\Http\Controllers\ArchivosController@updateConfiguracionUnidadProductora');
    Route::POST('/delete/{id}', 'App\Http\Controllers\ArchivosController@destroyConfiguracionUnidadProductra');
    Route::POST('/store_serie_documento', 'App\Http\Controllers\ArchivosController@storeConfiguracionUnidadProductoraSerieDocumento');
    Route::POST('/delete_serie_documento/{id}', 'App\Http\Controllers\ArchivosController@destroyConfiguracionUnidadProductraSerieDocumento');
});

Route::prefix('lista-bodegas')->middleware(['auth.custom'])->group(function () {
    Route::GET('/', 'App\Http\Controllers\ArchivosController@indexListaBodegas');
    Route::GET('/getMediosAlmacenamiento', 'App\Http\Controllers\ArchivosController@get_configuracion_medios_almacenamiento_all');
    Route::GET('/getUnidadProductora/{id}', 'App\Http\Controllers\ArchivosController@get_configuracion_unidad_productora_active');
    Route::GET('/getUnidadProductoraSerieDocumento/{id}', 'App\Http\Controllers\ArchivosController@get_configuracion_series_documentos_cupsd');
    Route::GET('/getUnidadProductoraDocumento/{id}', 'App\Http\Controllers\ArchivosController@get_configuracion_documentos_active');
    Route::POST('/getSecuencialMaxUnidadProductora', 'App\Http\Controllers\ArchivosController@get_secuencial_unidad_productora');
    Route::GET('/get_medios_almacenamiento/{idPadre}/{idBodega}', 'App\Http\Controllers\ArchivosController@get_medios_almacenamiento');
    Route::POST('/storeUnidadAlmacenamiento', 'App\Http\Controllers\ArchivosController@storeUnidadAlmacenamiento');
    Route::POST('/updateUnidadAlmacenamiento', 'App\Http\Controllers\ArchivosController@updateUnidadAlmacenamiento');
    Route::POST('/deleteUnidadAlmacenamiento/{id}', 'App\Http\Controllers\ArchivosController@deleteUnidadAlmacenamiento');
    Route::GET('/getDocumento/archivo/{archivo}', 'App\Http\Controllers\ArchivosController@descargar_archivo_documento');
    Route::GET('/getDocumentos/{id}', 'App\Http\Controllers\ArchivosController@get_documentos_active');
    Route::POST('/storeDocumento', 'App\Http\Controllers\ArchivosController@storeDocumento');
    Route::POST('/updateDocumento', 'App\Http\Controllers\ArchivosController@updateDocumento');
    Route::POST('/deleteDocumento/{id}', 'App\Http\Controllers\ArchivosController@deleteDocumento');
    Route::GET('/getSecuencialMaxDocumento/{id}', 'App\Http\Controllers\ArchivosController@get_secuencial_anio_documento');
    Route::GET('/{id}/{ma_id?}', 'App\Http\Controllers\ArchivosController@indexBodegasId');
});

Route::prefix('buscar-documentos')->middleware(['auth.custom'])->group(function () {
    Route::GET('/', 'App\Http\Controllers\ArchivosController@indexBuscarBodegas');
    Route::GET('/detail-document/{id}', 'App\Http\Controllers\ArchivosController@getDetailsDocument');
    Route::GET('/report', 'App\Http\Controllers\ArchivosController@indexReporteArchivo');
    Route::GET('/get_excel_reporte_archivos/{bodega}/{cup_id}/{cups_id}/{cd_id}/{text?}', 'App\Http\Controllers\ArchivosController@get_excel_reporte_archivos');
    Route::GET('/get_pdf_reporte_archivos/{bodega}/{cup_id}/{cups_id}/{cd_id}/{text?}', 'App\Http\Controllers\ArchivosController@get_pdf_reporte_archivos');
    Route::POST('/getDocumentos', 'App\Http\Controllers\ArchivosController@get_documentos_buscar_active');
});

Route::prefix('imprimir_caratula_archivo')->middleware(['auth.custom'])->group(function () {
    Route::GET('/', 'App\Http\Controllers\ArchivosController@indexImprimirCaratula');
    Route::POST('/generatePDF', 'App\Http\Controllers\ArchivosController@show_imprimir_caratula');
    Route::GET('/{id}', 'App\Http\Controllers\ArchivosController@indexImprimirCaratulaId');
});

Route::prefix('reportes_medicos')->middleware(['auth.custom'])->group(function () {
    Route::GET('/', [MedicoController::class, 'reportes_graficos']);
    Route::GET('/get_report/{tipo_reporte}/{fecha_desde}/{fecha_hasta}/{limit}/{tipo_certificado?}', [MedicoController::class, 'get_report']);
    Route::GET('/get_report_details/{tipo}/{cedula}/{tipo_reporte}/{fecha_desde}/{fecha_hasta}/{limit}/{tipo_certificado?}', [MedicoController::class, 'get_report_details']);
    Route::GET('/get_report_details_excel/{tipo}/{cedula}/{tipo_reporte}/{fecha_desde}/{fecha_hasta}/{limit}/{tipo_certificado?}', [MedicoController::class, 'get_report_details_report_excel']);
    Route::GET('/excel/{tipo_reporte}/{fecha_desde}/{fecha_hasta}/{limit}/{tipo_certificado?}', [MedicoController::class, 'get_excel_report']);
});

Route::prefix('conf_agentes_transito')->middleware(['auth.custom'])->group(function () {
    Route::GET('/', 'App\Http\Controllers\AgenteTransitoController@ConfAgentesTransitoIndex');
    Route::GET('/get_agentes_transito', 'App\Http\Controllers\AgenteTransitoController@GetAgentesTransito');
    Route::POST('/store', 'App\Http\Controllers\AgenteTransitoController@storeCodAgenteTransito');
});

Route::prefix('conf_agentes_transito_plantilla')->middleware(['auth.custom'])->group(function () {
    Route::GET('/', 'App\Http\Controllers\AgenteTransitoController@ConfPlantillaIndex');
    Route::GET('/getPlantilla', 'App\Http\Controllers\AgenteTransitoController@GetActivePlantilla');
    Route::POST('/store', 'App\Http\Controllers\AgenteTransitoController@StorePlantilla');
});

Route::prefix('orden_cuerpo')->group(function () {
    Route::GET('/show_pdf_orden_cuerpo/{id}/{at_id?}', 'App\Http\Controllers\AgenteTransitoController@get_pdf_orden_cuerpo');

    Route::middleware(['auth.custom'])->group(function () {
        Route::GET('/', 'App\Http\Controllers\AgenteTransitoController@ListaOrdenCuerpoIndex');
        Route::GET('/register/{oc_id?}/{duplicate?}', 'App\Http\Controllers\AgenteTransitoController@RegisterOrdenCuerpo');
        Route::GET('/secuencialoc', 'App\Http\Controllers\AgenteTransitoController@get_secuencial_orden_cuerpo');
        Route::POST('/store', 'App\Http\Controllers\AgenteTransitoController@StoreOrdenCuerpo');
        Route::GET('/lista_orden_cuerpo/{id?}', 'App\Http\Controllers\AgenteTransitoController@get_lista_orden_cuerpo');
        Route::GET('/get_search_agente/{limit}/{text}', 'App\Http\Controllers\AgenteTransitoController@get_agente_search');
        Route::POST('/delete/{id}', 'App\Http\Controllers\AgenteTransitoController@OrdenCuerpoDelete');
        Route::POST('/processOC', 'App\Http\Controllers\AgenteTransitoController@processOC');
        Route::POST('/enviar_code_qr', 'App\Http\Controllers\AgenteTransitoController@enviar_code_qr');
        Route::POST('/fimar_code_qr', 'App\Http\Controllers\AgenteTransitoController@storeFirmaDocumentOC');
        Route::prefix('report_dates')->group(function () {
            Route::GET('/', 'App\Http\Controllers\AgenteTransitoController@IndexReport');
            Route::GET('/get_excel/{fecha_desde}/{fecha_hasta}/{estado}', 'App\Http\Controllers\AgenteTransitoController@ExcelReportDatesOC');
            Route::GET('/get_pdf/{fecha_desde}/{fecha_hasta}/{estado}', 'App\Http\Controllers\AgenteTransitoController@PdfReportDatesOC');
            Route::GET('/{fecha_desde}/{fecha_hasta}/{estado}', 'App\Http\Controllers\AgenteTransitoController@ReportDatesOC');
        });
    });
});

Route::prefix('convocatoria_arrendamiento')->group(function () {
    Route::middleware(['auth.custom'])->group(function () {
        Route::GET('/', 'App\Http\Controllers\TTMController@index');
        Route::GET('/get_list', 'App\Http\Controllers\TTMController@get_lista_convocatorias');
        Route::POST('/store', 'App\Http\Controllers\TTMController@store_convocatoria');
        Route::POST('/update', 'App\Http\Controllers\TTMController@update_convocatoria');
        Route::POST('/delete/{id}', 'App\Http\Controllers\TTMController@delete_convocatoria');
    });

    Route::GET('/archivo/{archivo}', 'App\Http\Controllers\TTMController@descargar_archivo_convocatoria');
});

Route::prefix('garita')->middleware(['auth.custom'])->group(function () {
    Route::prefix('tipo_vehiculo')->group(function () {
        Route::GET('/', 'App\Http\Controllers\GaritaController@IndexTipoVehiculo');
        Route::GET('/list', 'App\Http\Controllers\GaritaController@get_lista_tipo_vehiculo');
        Route::POST('/store', 'App\Http\Controllers\GaritaController@store_tipo_vehiculo');
        Route::POST('/update', 'App\Http\Controllers\GaritaController@update_tipo_vehiculo');
        Route::POST('/delete/{id}', 'App\Http\Controllers\GaritaController@delete_tipo_vehiculo');
    });

    Route::prefix('tipo_ingreso_vehicular')->group(function () {
        Route::GET('/', 'App\Http\Controllers\GaritaController@IndexTipoIngresoVehicular');
        Route::GET('/list', 'App\Http\Controllers\GaritaController@get_lista_tipo_ingreso_vehicular');
        Route::GET('/list_habilitados', 'App\Http\Controllers\GaritaController@get_lista_tipo_ingreso_vehicular_habilitados');
        Route::POST('/store', 'App\Http\Controllers\GaritaController@store_tipo_ingreso_vehicular');
        Route::POST('/update', 'App\Http\Controllers\GaritaController@update_tipo_ingreso_vehicular');
        Route::POST('/delete/{id}', 'App\Http\Controllers\GaritaController@delete_tipo_ingreso_vehicular');
    });

    Route::prefix('documento_requerido')->group(function () {
        Route::GET('/', 'App\Http\Controllers\GaritaController@IndexDocumentosRequeridos');
        Route::GET('/list', 'App\Http\Controllers\GaritaController@get_lista_documentos_requeridos');
        Route::POST('/store', 'App\Http\Controllers\GaritaController@store_documento_requerido');
        Route::POST('/update', 'App\Http\Controllers\GaritaController@update_documento_requerido');
        Route::POST('/delete/{id}', 'App\Http\Controllers\GaritaController@delete_documento_requerido');
    });

    Route::prefix('inventario_vehiculo')->group(function () {
        Route::GET('/', 'App\Http\Controllers\GaritaController@IndexConfInventarioVehiculo');
        Route::GET('/list', 'App\Http\Controllers\GaritaController@get_ConfInventarioVehiculo');
        Route::POST('/store', 'App\Http\Controllers\GaritaController@storeConfInventarioVehiculo');
        Route::POST('/update', 'App\Http\Controllers\GaritaController@updateConfInventarioVehiculo');
        Route::POST('/delete/{id}', 'App\Http\Controllers\GaritaController@destroyConfInventarioVehiculo');
    });

    Route::prefix('ingreso_vehiculo_patio')->group(function () {
        Route::GET('/', 'App\Http\Controllers\GaritaController@IndexIngresoVehiculoPatio');
        Route::GET('/get/{id}', 'App\Http\Controllers\GaritaController@get_one_IngresoVehiculoPatio');
        Route::GET('/get_inventario_vehiculo/{iv_id}', 'App\Http\Controllers\GaritaController@get_DetalleInventarioVehiculo');
        Route::GET('/get_documentos_vehiculo/{tiv_id}', 'App\Http\Controllers\GaritaController@get_detalle_documentos_vehiculo');
        Route::GET('/getDocumento/{archivo}', 'App\Http\Controllers\GaritaController@descargar_documento_vehiculo');
        Route::GET('/getImagenesEvidencia/{archivo}', 'App\Http\Controllers\GaritaController@descargar_evidencias_vehiculo');
        Route::GET('/list', 'App\Http\Controllers\GaritaController@get_IngresoVehiculoPatio');
        Route::POST('/store', 'App\Http\Controllers\GaritaController@storeIngresoVehiculoPatio');
        Route::POST('/update', 'App\Http\Controllers\GaritaController@updateIngresoVehiculoPatio');
        Route::POST('/delete/{id}', 'App\Http\Controllers\GaritaController@deleteIngresoVehiculoPatio');
    });

    Route::prefix('retiro_vehiculo_patio')->group(function () {
        Route::GET('/', 'App\Http\Controllers\GaritaController@IndexRetiroVehiculoPatio');
        Route::GET('/list/{fecha_desde}/{fecha_hasta}/{tipo_ingreso}', 'App\Http\Controllers\GaritaController@get_RetiroVehiculoPatio');
    });
});

Route::prefix('orquestadorapi')->middleware(['auth.custom'])->group(function () {
    Route::prefix('users')->group(function () {
        Route::GET('/', 'App\Http\Controllers\OrquestadorApiController@viewUsers');
        Route::GET('/get_list/{e_id}', 'App\Http\Controllers\OrquestadorApiController@get_lista_users');
        Route::POST('/store', 'App\Http\Controllers\OrquestadorApiController@store_user');
        Route::POST('/update', 'App\Http\Controllers\OrquestadorApiController@update_users');
        Route::POST('/delete/{id}', 'App\Http\Controllers\OrquestadorApiController@delete_users');
        Route::GET('/get_list_control_peticiones/{u_id}', 'App\Http\Controllers\OrquestadorApiController@get_lista_control_peticiones');
        Route::POST('/storeControlPeticion', 'App\Http\Controllers\OrquestadorApiController@store_control_peticion');
        Route::POST('/deleteControlPeticion', 'App\Http\Controllers\OrquestadorApiController@delete_control_peticion');
        Route::GET('/get_list_control_ips/{u_id}', 'App\Http\Controllers\OrquestadorApiController@get_lista_control_ips');
        Route::POST('/storeControlIp', 'App\Http\Controllers\OrquestadorApiController@store_control_ip');
        Route::POST('/deleteControlIp', 'App\Http\Controllers\OrquestadorApiController@delete_control_ip');
        Route::POST('/store_empresa', 'App\Http\Controllers\OrquestadorApiController@store_empresa');
        Route::POST('/update_empresa', 'App\Http\Controllers\OrquestadorApiController@update_empresa');
        Route::POST('/delete_empresa/{id}', 'App\Http\Controllers\OrquestadorApiController@delete_empresa');
        Route::GET('/get_list_empresa', 'App\Http\Controllers\OrquestadorApiController@get_lista_empresas');
    });

    Route::prefix('peticion')->group(function () {
        Route::GET('/', 'App\Http\Controllers\OrquestadorApiController@viewPeticiones');
        Route::GET('/get_list/{id}', 'App\Http\Controllers\OrquestadorApiController@get_lista_peticiones');
        Route::GET('/get_list_search/{limit}/{text?}', 'App\Http\Controllers\OrquestadorApiController@get_search_peticiones_active');
        Route::GET('/get/{id}', 'App\Http\Controllers\OrquestadorApiController@get_peticion');
        Route::GET('/getResponses/{id}', 'App\Http\Controllers\OrquestadorApiController@get_responses_peticion');
        Route::GET('/get_proveedores_service/{id_proveedor}', 'App\Http\Controllers\OrquestadorApiController@get_proveedores_service');
        Route::GET('/get_proveedores_api', 'App\Http\Controllers\OrquestadorApiController@get_proveedores_api');
        Route::GET('/get_peticiones_service/{id}', 'App\Http\Controllers\OrquestadorApiController@get_lista_peticion_services');
        Route::POST('/store', 'App\Http\Controllers\OrquestadorApiController@store_peticion');
        Route::POST('/update', 'App\Http\Controllers\OrquestadorApiController@update_peticion');
        Route::POST('/delete/{id}', 'App\Http\Controllers\OrquestadorApiController@delete_peticion');
        Route::POST('/storeRespuesta', 'App\Http\Controllers\OrquestadorApiController@store_respuesta_peticion');
        Route::POST('/updateRespuesta', 'App\Http\Controllers\OrquestadorApiController@update_respuesta_peticion');
        Route::POST('/deleteRespuesta/{id}/{r_codigo}/{r_codigo_response}/{r_orden}', 'App\Http\Controllers\OrquestadorApiController@delete_respuesta_peticion');
        Route::POST('/storeProveedor', 'App\Http\Controllers\OrquestadorApiController@store_proveedor_api');
        Route::POST('/updateProveedor', 'App\Http\Controllers\OrquestadorApiController@update_proovedor_api');
        Route::POST('/deleteProveedor/{id}', 'App\Http\Controllers\OrquestadorApiController@delete_peticion_proveedor_api');
    });

    Route::prefix('transacciones')->group(function () {
        Route::GET('/', 'App\Http\Controllers\OrquestadorApiController@viewTransacciones');
        Route::GET('/get/{fecha_desde}/{fecha_hasta}/{username?}', 'App\Http\Controllers\OrquestadorApiController@getTransacciones');
    });
});

Route::prefix('orquestador_ordenes')->group(function () {
    Route::POST('/store', 'App\Http\Controllers\OrquestadorApiController@store_orden');
    Route::POST('/update', 'App\Http\Controllers\OrquestadorApiController@update_orden');
    Route::GET('/all', 'App\Http\Controllers\OrquestadorApiController@get_ordenes_all');
    Route::GET('/pendientes', 'App\Http\Controllers\OrquestadorApiController@get_ordenes_pendientes');
});

//PLACAS PROVISIONALES
Route::GET('/placa-provisional', 'App\Http\Controllers\PlacasControllers@index');
Route::GET('/consultar-vehiculo-placa-provisional/{placa}', 'App\Http\Controllers\PlacasControllers@get_vehiculo');
Route::get('/imprimir-placa-provisional/{placa}/{id}', 'App\Http\Controllers\PlacasControllers@impirmir_placa_provisional_pdf');
Route::get('/imprimir_placa_provisional_v2/{placa}/{id}', 'App\Http\Controllers\PlacasControllers@impirmir_placa_provisional_pdf_v2');
Route::get('/descargar-ftp/{filename}', 'App\Http\Controllers\PlacasControllers@descargar_placa_provisional');
Route::get('/descargar-ftp-v2/{filename}', 'App\Http\Controllers\PlacasControllers@descargar_placa_provisional_v2');
Route::get('/reporte-placa-provisional', 'App\Http\Controllers\PlacasControllers@index_placa_provisional_reporte');
Route::get('/get-placa-provisional/{fecha_inicio}/{fecha_fin}', 'App\Http\Controllers\PlacasControllers@get_placa_provisional');


//Route::GET('/get-placa-provisional', 'App\Http\Controllers\PlacasControllers@get_placas_provisionales');
////Route::GET('/login-api', 'App\Http\Controllers\PlacasControllers@login');
//Route::GET('/get-vehiculo-placa/{placa}', 'App\Http\Controllers\PlacasControllers@get_vehiculos_placas');
//Route::get('/imprimir-placa-provisional/{placa}/{data}', 'App\Http\Controllers\PlacasControllers@impirmir_placa_provisional_pdf');
//Route::post('/guardar-placa-provisional', 'App\Http\Controllers\PlacasControllers@save_placa_provisional');


//MATRICULACION
Route::GET('/vehiculo', 'App\Http\Controllers\VehiculosControllers@index');
Route::GET('/consultar-vehiculo/{placa}', 'App\Http\Controllers\VehiculosControllers@get_vehiculo');

//INGENIERIA DE TRÁNSITO
Route::GET('/convocatoria-it', 'App\Http\Controllers\ConvocatoriasProcesosITControllers@index');
Route::get('/descargar-ftp-convocatoriaIT/{filename}', 'App\Http\Controllers\ConvocatoriasProcesosITControllers@descargar_reformaIT');

//SISTEMA DE TEST
Route::get('/test-reporte', 'App\Http\Controllers\TestControllers@index');
Route::get('/get-test/{fecha_inicio}/{fecha_fin}', 'App\Http\Controllers\TestControllers@get_obtener_Fichas');
Route::get('/imprimir-pdf-ficha/{fecha_inicio}/{fecha_fin}', 'App\Http\Controllers\TestControllers@impirmir_pdf_fichas');

//PUBLICACIONES EN LA INTRANET
Route::get('/index', 'App\Http\Controllers\PublicacionesIntranetControllers@index');

Route::prefix('aprobacion_rtv')->middleware(['auth.custom'])->group(function () {
    Route::GET('/', 'App\Http\Controllers\ProcesosRTVController@index');
    Route::GET('/last_secuencial', 'App\Http\Controllers\ProcesosRTVController@get_last_secuencial');
    Route::POST('/aprobar_rtv', 'App\Http\Controllers\ProcesosRTVController@aprobar_vehiculo');
    Route::POST('/aprobar_numero_orden', 'App\Http\Controllers\ProcesosRTVController@aprobar_numero_orden');
    Route::POST('/anular_orden', 'App\Http\Controllers\ProcesosRTVController@anular_numero_orden');
    Route::GET('/placa/{placa}', 'App\Http\Controllers\ProcesosRTVController@get_vehiculo');
    Route::GET('/get_curent_date', 'App\Http\Controllers\ProcesosRTVController@ResultadosDiario');
    Route::GET('/report_table/{fecha_desde}/{fecha_hasta}/{estado}', 'App\Http\Controllers\ProcesosRTVController@ReportDiario');
    Route::GET('/report_excel/{fecha_desde}/{fecha_hasta}/{estado}', 'App\Http\Controllers\ProcesosRTVController@ExcelReportDiario');
    Route::GET('/report_api/{fecha_desde}/{fecha_hasta}', 'App\Http\Controllers\ProcesosRTVController@ReportApi');
    Route::GET('/report_excel_api/{fecha_desde}/{fecha_hasta}', 'App\Http\Controllers\ProcesosRTVController@ExcelReportApi');

    //Route::GET('/getPlantilla', 'App\Http\Controllers\AgenteTransitoController@GetActivePlantilla');
    //Route::POST('/store', 'App\Http\Controllers\AgenteTransitoController@StorePlantilla');
});

Route::get('/rtv_resolucion', 'App\Http\Controllers\RTVController@resolucion_rtv');
Route::get('/download_resolucion/{filename}', 'App\Http\Controllers\RTVController@descargar_archivos');

Route::prefix('conf_empleados_remoto')->middleware(['auth.custom'])->group(function () {
    Route::GET('/', 'App\Http\Controllers\MarcacionesEmpleadosRemotoController@index');
    Route::GET('/list', 'App\Http\Controllers\MarcacionesEmpleadosRemotoController@get_empleados_remotos');    
    Route::POST('/store', 'App\Http\Controllers\MarcacionesEmpleadosRemotoController@store');
    Route::POST('/update', 'App\Http\Controllers\MarcacionesEmpleadosRemotoController@update');
    Route::POST('/change_state', 'App\Http\Controllers\MarcacionesEmpleadosRemotoController@change_state');
});

Route::prefix('reporte_marcaciones_empleado_remoto')->middleware(['auth.custom'])->group(function () {
    Route::GET('/', 'App\Http\Controllers\MarcacionesEmpleadosRemotoController@indexMarcacionesEmpleadoRemoto');
    Route::GET('/reporte_general', 'App\Http\Controllers\MarcacionesEmpleadosRemotoController@indexMarcacionesGeneralEmpleadoRemoto');
    Route::GET('/get_empleados/{limit}/{text}', 'App\Http\Controllers\MarcacionesEmpleadosRemotoController@get_empleados_remotos_search');
    Route::GET('/get_imagen/{archivo}', 'App\Http\Controllers\MarcacionesEmpleadosRemotoController@descargar_evidencias_marcacion');
    Route::GET('/get_conf_marcaciones_empleados/{fecha_inicio}/{fecha_fin}/{emp_id}', 'App\Http\Controllers\MarcacionesEmpleadosRemotoController@get_conf_empleados_remoto_marcaciones');
    Route::GET('/get_marcaciones_remotas_empleados/{fecha_inicio}/{fecha_fin}/{cer_id?}', 'App\Http\Controllers\MarcacionesEmpleadosRemotoController@get_empleados_remoto_marcaciones');
    Route::GET('/get_excel_conf_remoto_empleado/{fecha_desde}/{fecha_hasta}/{emp_id}', 'App\Http\Controllers\MarcacionesEmpleadosRemotoController@get_excel_conf_remoto_empleado');
    Route::GET('/get_pdf_conf_remoto_empleado/{fecha_desde}/{fecha_hasta}/{emp_id}', 'App\Http\Controllers\MarcacionesEmpleadosRemotoController@get_pdf_conf_remoto_empleado');
    Route::GET('/get_excel_marcaciones_remotas_empleado/{fecha_desde}/{fecha_hasta}/{emp_id?}', 'App\Http\Controllers\MarcacionesEmpleadosRemotoController@get_excel_marcaciones_remotas_empleado');
    Route::GET('/get_pdf_marcaciones_remotas_empleado/{fecha_desde}/{fecha_hasta}/{emp_id?}', 'App\Http\Controllers\MarcacionesEmpleadosRemotoController@get_pdf_marcaciones_remotas_empleado');
});