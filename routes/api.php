<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


/* Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
}); */
/* 
Route::post('/login',            'Auth\LoginController@login')->name('login');;
Route::post('/logout',            'Auth\LoginController@logout'); */


//
Route::middleware(['auth:sanctum'])->prefix('v1')->group( function() 
{
 Route::get('/data/card',          'DataController@sendCard');

 Route::get('/data/comissions',          'DataController@comissions');
 Route::get('/data/profiles',            'DataController@dataProfiles');
 Route::get('/data/profile/{profileId}', 'DataController@dataProfile');
 Route::apiResource('/data',             'DataController');
 

Route::get('/crud/schemas',   'Crud@schemas');
Route::post('/crud/tables',   'Crud@tables');
Route::post('/crud/generate', 'Crud@generate');

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


Route::put('/status/resource',                  'StatusController@updateResource');

Route::apiResource('/suscriptor',               'SuscriptorController');
Route::apiResource('/tipoSuscripcion',          'TipoSuscripcionController');
Route::apiResource('/vendedor',                 'VendedorController');


Route::get('/agency/totals',            'AgencyController@agencyTotals');
Route::apiResource('/agency',                   'AgencyController');



Route::apiResource('/agencyProgress',           'AgencyProgressController');
Route::apiResource('/bonus',                    'BonusController');
Route::apiResource('/bonusType',                'BonusTypeController');
Route::apiResource('/config',                   'ConfigController');
Route::apiResource('/failedJobs',               'FailedJobsController');
Route::apiResource('/freeDay',                  'FreeDayController');
Route::apiResource('/missedDay',                'MissedDayController');
Route::apiResource('/payment',                  'PaymentController');
Route::apiResource('/paymentClass',             'PaymentClassController');
Route::apiResource('/paymentType',              'PaymentTypeController');



Route::get('/penalty/user/{user}',      'PenaltyController@penaltyUser');
Route::apiResource('/penalty',          'PenaltyController');
Route::apiResource('/penaltyType',     'PenaltyTypeController');

Route::get('/absence/user/{user}',     'AbsenceController@absenceUser');
Route::apiResource('/absence',         'AbsenceController');
Route::apiResource('/absenceType',     'AbsenceTypeController');

// user
Route::put('/user/{user}/goals',                'UserController@goals');
Route::get('/user/list',                        'UserController@list');
Route::apiResource('/user',                     'UserController');
Route::apiResource('/userProgress',             'UserProgressController');

Route::get('/userProfile/assing/{user}/{agency}',  'UserProfileController@assing');
Route::apiResource('/userProfile',              'UserProfileController');


Route::get('/profile/user/{user}',              'ProfileController@profileUser');
Route::apiResource('/profile',                  'ProfileController');

Route::apiResource('/profileProgress',          'ProfileProgressController');


Route::apiResource('/role',                     'RoleController');
Route::apiResource('/menu',                     'MenuController');
Route::apiResource('/permission',               'PermissionController');


Route::apiResource('/status',                   'StatusController');

Route::apiResource('/writeoffType',             'WriteoffTypeController');
Route::apiResource('/spending',                 'SpendingController');
Route::apiResource('/present',                  'PresentController');
Route::apiResource('/turn',                     'TurnController');
Route::apiResource('/table',                    'TableController');
Route::apiResource('/curator',                  'CuratorController');
Route::apiResource('/spending',                 'SpendingController');



Route::apiResource('/comission',                'ComissionController');
Route::apiResource('/table',     'TableController');
Route::apiResource('/group',     'GroupController');
Route::apiResource('/country',     'CountryController');
Route::apiResource('/userAgency',     'UserAgencyController');

Route::put('/userPresence/stop',     'UserPresenceController@stop');
Route::apiResource('/userPresence',     'UserPresenceController');

//newRoutes
});