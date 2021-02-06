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

// Route::get('/', function () {
//     return view('welcome');
// });

// Default Browser
Route::get('/', 'AuthenticationController@LoginScreen')->name('login');

//Authentication Url
Route::post('/checklogin', 'AuthenticationController@CheckLogin')->name('/checklogin');


/** Super Admin Url Start Here */

//SuperadminDashboard Url
Route::get('SuperAdmin/dashboard', 'SuperAdmin\SuperAdminController@showDashboard')->name('SuperAdmin/dashboard');

//Superadmin Client Creation Form Url
Route::get('SuperAdmin/client-creation', 'SuperAdmin\SuperAdminController@showClientCreation')->name('SuperAdmin/client-creation');

//Superadmin save  Client Creation  Url
Route::post('SuperAdmin/save-client-creation', 'SuperAdmin\SuperAdminController@saveClientCreation')->name('SuperAdmin/save-client-creation');


//Superadmin Update  Client Creation  Url
Route::post('SuperAdmin/update-client-creation', 'SuperAdmin\SuperAdminController@updateClientCreation')->name('SuperAdmin/update-client-creation');

//Superadmin all Client Created  Url
Route::get('SuperAdmin/show-clients', 'SuperAdmin\SuperAdminController@showClientCreated')->name('SuperAdmin/show-clients');

//Superadmin all Client Created Datatabel Url
Route::post('SuperAdmin/all-clients', 'SuperAdmin\SuperAdminController@getallClients')->name('SuperAdmin/all-clients');


//Superadmin Client Edit form  Url
Route::get('SuperAdmin/edit-clients/{id}', 'SuperAdmin\SuperAdminController@showEditClientCreationForm')->name('SuperAdmin/edit-clients');

//Superadmin Delete  Client   Url
Route::post('SuperAdmin/delete-client', 'SuperAdmin\SuperAdminController@deleteClient')->name('SuperAdmin/delete-client');

//Superadmin all Client Created Datatabel Url
Route::get('SuperAdmin/stop-clients', 'SuperAdmin\SuperAdminController@showClientToStop')->name('SuperAdmin/stop-clients');

//Superadmin Stop Services of   Client   Url
Route::post('SuperAdmin/stop-services', 'SuperAdmin\SuperAdminController@stopServices')->name('SuperAdmin/stop-services');

//Superadmin   Url For Update Licences
Route::get('SuperAdmin/update-clients-license', 'SuperAdmin\SuperAdminController@showUpdateLicences')->name('SuperAdmin/update-clients-license');


//Superadmin Stop Services of   Client   Url
Route::post('SuperAdmin/get-client-details', 'SuperAdmin\SuperAdminController@getClientDetails')->name('SuperAdmin/get-client-details');

//Superadmin Update License  of   Client   Url
Route::post('SuperAdmin/update-client-licienses', 'SuperAdmin\SuperAdminController@updateLicences')->name('SuperAdmin/update-client-licienses');

// Superadmin Url For Show Modules
Route::get('SuperAdmin/modules', 'CommonController@showModulePatch')->name('SuperAdmin/modules');

// SuperAdmin Save Module Data
Route::post('SuperAdmin/save-modules', 'SuperAdmin\SuperAdminController@savemodulesData')->name('SuperAdmin/save-modules');

// SuperAdmin Url To Delete Module.
Route::post('SuperAdmin/delete-modules', 'SuperAdmin\SuperAdminController@deleteModules')->name('SuperAdmin/delete-modules');


// SuperAdmin Url To Delete Module.
Route::get('SuperAdmin/show-all-clients', 'SuperAdmin\SuperAdminController@showallClients')->name('SuperAdmin/show-all-clients');


//Superadmin all Client Created Datatabel Url
Route::post('SuperAdmin/getall-clients', 'SuperAdmin\SuperAdminController@allClients')->name('SuperAdmin/getall-clients');

//Superadmin Client Edit form  Url
Route::get('SuperAdmin/asgin-modules/{id}', 'SuperAdmin\SuperAdminController@showModulesPage')->name('SuperAdmin/asgin-modules');

//Superadmin Asging Module Url
Route::post('SuperAdmin/assgin-client', 'SuperAdmin\SuperAdminController@assginClients')->name('SuperAdmin/assgin-client');

/** Super Admin Url End Here */

/** Common Controller Start Here */
Route::post('/getvaild-email', 'CommonController@getVaildEmailId')->name('/getvaild-email');

Route::post('/getvaild-email-foredit', 'CommonController@getVaildEmailIdforEdit')->name('/getvaild-email-foredit');

Route::post('/all-modules', 'CommonController@getAllmodules')->name('/all-modules');





/** Common Controller End Here */


/** Admin Url Start Here */

//Admin Dashboard Url
Route::get('Admin/dashboard', 'Admin\AdminController@showDashboard')->name('Admin/dashboard');

/** Admin Url End Here */


/** User Url Start Here */

//User Dashboard Url
Route::get('User/dashboard', 'User\UserController@showDashboard')->name('User/dashboard');

/** User Url End Here */

