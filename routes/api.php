<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/crud/schemas',   'Crud@schemas');
Route::post('/crud/tables',   'Crud@tables');
Route::post('/crud/generate', 'Crud@generate');

Route::group(['prefix'=>'v1'], function() 
{
 Route::get('/data/profiles',            'DataController@dataProfiles');
 Route::get('/data/profile/{profileId}', 'DataController@dataProfile');
 Route::apiResource('/data',             'DataController');
 

// -- FOTOS / ARCHIVOS -- //
/* Route::apiResource('/tipoUsuario',              'TipoUsuarioController'); 
Route::get('/usuario/lote/tipo/{tipo}',         'UsuarioController@usuarioLoteTipo');
Route::put('/usuario/{usuario}/email',          'UsuarioController@updateEmail');
Route::put('/usuario/{usuario}/password',       'UsuarioController@updatePassword');
Route::apiResource('/usuario',                  'UsuarioController');


// -- USUARIO -- //
Route::apiResource('/perfil',                   'PerfilController');
Route::get('/permiso/perfil/{perfil}/asignacion', 'PermisoController@permisoPerfilAsignacion');
Route::apiResource('/permiso',                  'PermisoController');
Route::apiResource('/usuarioPerfil',            'UsuarioPerfilController');
Route::apiResource('/modulo',                   'ModuloController');
Route::get('/menu/combo',                       'MenuController@combo');
Route::apiResource('/menu',                     'MenuController');
*/
// -- FOTOS / ARCHIVOS -- //
Route::apiResource('/foto',                      'FotoController');
Route::get('/foto/tipoFoto/{tipoFoto}',          'FotoController@fotoTipo');
//Route::apiResource('/tipoFoto',                 'TipoFotoController');

Route::apiResource('/sede',                       'SedeController');

Route::put('/status/resource',                  'StatusController@updateResource');

Route::apiResource('/status',           'StatusController');
Route::apiResource('/suscripcion',     'SuscripcionController');
Route::put('/suscripcion/{suscripcion}/observaciones',     'SuscripcionController@updateObservaciones');

Route::apiResource('/suscriptor',      'SuscriptorController');
Route::apiResource('/tipoSuscripcion', 'TipoSuscripcionController');
Route::apiResource('/vendedor',        'VendedorController');
Route::apiResource('/agency',     'AgencyController');
Route::apiResource('/agencyProgress',     'AgencyProgressController');
Route::apiResource('/bonus',     'BonusController');
Route::apiResource('/bonusType',     'BonusTypeController');
Route::apiResource('/config',     'ConfigController');
Route::apiResource('/failedJobs',     'FailedJobsController');
Route::apiResource('/freeDay',     'FreeDayController');
Route::apiResource('/missedDay',     'MissedDayController');
Route::apiResource('/payment',     'PaymentController');
Route::apiResource('/paymentClass',     'PaymentClassController');
Route::apiResource('/paymentType',     'PaymentTypeController');
Route::apiResource('/penalty',     'PenaltyController');
Route::apiResource('/penaltyType',     'PenaltyTypeController');
Route::apiResource('/profile',     'ProfileController');
Route::apiResource('/profileProgress',     'ProfileProgressController');
Route::apiResource('/role',     'RoleController');
Route::apiResource('/status',     'StatusController');
Route::apiResource('/user',     'UserController');
Route::apiResource('/userProgress',     'UserProgressController');
Route::apiResource('/writeoffType',     'WriteoffTypeController');
//newRoutes
});