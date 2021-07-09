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


Route::get('/agency/clients/top',      'AgencyController@agencyClientsTop');
Route::get('/agency/clients',          'AgencyController@agencyClients');
Route::get('/agency/totals',           'AgencyController@agencyTotals');
Route::put('/agency/{agency}/goals',  'AgencyController@agencyGoals');
Route::apiResource('/agency',          'AgencyController');



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
Route::put('/user/{user}/goals',               'UserController@goals');

Route::get('/user/pay/operator/{date}',         'UserController@payOperators');
Route::get('/user/pay/coordinator/{date}',      'UserController@payCoordinators');
Route::get('/user/list',                        'UserController@list');
Route::get('/user/list/turn',                   'UserController@listTurn');
Route::get('/user/list/table',                  'UserController@listTable');
Route::get('/user/statistics/{table}',          'UserController@statistics');
Route::apiResource('/user',                     'UserController');
Route::apiResource('/userProgress',             'UserProgressController');

Route::get('/userProfile/assing/{user}/{agency}',  'UserProfileController@assing');
Route::apiResource('/userProfile',              'UserProfileController');

Route::get('/userAgency/assing/{user}/{agency}',  'UserAgencyController@assing');
Route::apiResource('/userAgency',               'UserAgencyController');

Route::get('/profile/import/photo',             'ProfileController@importProfilePhoto');
Route::get('/profile/import/agency/{agency}',   'ProfileController@profileImport');
Route::get('/profile/table/{table}',            'ProfileController@profileTable');
Route::get('/profile/user/{user}',              'ProfileController@profileUser');
Route::get('/profile/coordinator',              'ProfileController@profileCoordinator');
Route::get('/profile/list',                    'ProfileController@list');
Route::apiResource('/profile',                  'ProfileController');


Route::get('/profileProgress/fill',             'ProfileProgressController@getProgress');
Route::apiResource('/profileProgress',          'ProfileProgressController');

Route::get('/role/list',                        'RoleController@list');
Route::apiResource('/role',                     'RoleController');
Route::apiResource('/menu',                     'MenuController');
Route::apiResource('/permission',               'PermissionController');


Route::apiResource('/status',                   'StatusController');

Route::apiResource('/writeoffType',             'WriteoffTypeController');
Route::apiResource('/spending',                 'SpendingController');
Route::apiResource('/present',                  'PresentController');
Route::apiResource('/turn',                     'TurnController');
Route::apiResource('/curator',                  'CuratorController');
Route::apiResource('/spending',                 'SpendingController');


Route::get('/comission/list',                   'ComissionController@list');
Route::get('/comission/month',                  'ComissionController@fillComissionMonth');
Route::get('/comission/detail',                 'ComissionController@comissionDetail');
Route::get('/comission/fill/agency/{agency}/{positive}',   'ComissionController@fillComissionDetail');
Route::get('/comission/presence/{presence}',    'ComissionController@comissionPresence');
Route::apiResource('/comission',                'ComissionController');


Route::get('/table/detail',                     'TableController@tablesDetails');

Route::get('/table/list/user/{user}',           'TableController@listUser');
Route::get('/table/list',                       'TableController@list');
Route::apiResource('/table',                    'TableController');

Route::apiResource('/group',                    'GroupController');
Route::apiResource('/country',                  'CountryController');




Route::put('/userPresence/rebuild',             'UserPresenceController@rebuild');
Route::get('/userPresence/estimate',            'UserPresenceController@presenceEstimate');
Route::get('/userPresence/user/{user}/profile/{profile}',    'UserPresenceController@presenceUserProfile');
Route::put('/userPresence/stop/unique',         'UserPresenceController@stopUnique');
Route::put('/userPresence/stop',                'UserPresenceController@stop');
Route::apiResource('/userPresence',             'UserPresenceController');

Route::get('/client/contacted',                 'ClientController@importClientPhoto');
Route::get('/client/all/photo',                 'ClientController@importClientPhoto');
Route::get('/client/all/detail',                'ClientController@detailClients');
Route::get('/client/contacted/agency/{agency}',           'ClientController@contactedAgency');
Route::get('/client/top/Agency/{agency}',       'ClientController@topAgency');
Route::apiResource('/client',                   'ClientController');

Route::get('/tableTurn/combo/{table}',         'TableTurnController@combo');
Route::apiResource('/tableTurn',               'TableTurnController');
Route::apiResource('/horary',                  'HoraryController');
Route::apiResource('/service',                 'ServiceController');

Route::get('/goalType/user/{user}',     'GoalTypeController@goalTypeUser');
Route::apiResource('/goalType',     'GoalTypeController');


Route::get('/agencyGoal/agency/{agency}',     'AgencyGoalController@byAgency');
Route::apiResource('/agencyGoal',     'AgencyGoalController');
//newRoutes
});