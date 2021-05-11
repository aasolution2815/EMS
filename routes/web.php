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

//Authentication Url
Route::post('/checkuid', 'AuthenticationController@CheckUID')->name('/checkuid');

Route::group(['middleware' => ['athuthenticate']], function () {
    Route::group(['middleware' => ['mainmiddleware']], function () {
        /** Main SuperAdmin Url Start Here */
        Route::get('SuperAdmin/superadmin-creation', 'SuperAdmin\SuperAdminController@Superadmincreation')->name('SuperAdmin/superadmin-creation');
        //Superadmin save  Client Creation  Url
        Route::post('SuperAdmin/save-superadmins-creation', 'SuperAdmin\SuperAdminController@saveSuperAdminCreation')->name('SuperAdmin/save-client-creation');
        // SuperAdmin Url To All Superadmin.
        Route::get('SuperAdmin/show-all-superadmins', 'SuperAdmin\SuperAdminController@showallSuperAdmin')->name('SuperAdmin/show-all-superadmins');
        //Superadmin all Super Admin Created Datatabel Url
        Route::post('SuperAdmin/all-superadmins', 'SuperAdmin\SuperAdminController@getallSuperadmin')->name('SuperAdmin/all-superadmins');
        //Superadmin  Edit form  Url
        Route::get('SuperAdmin/edit-superadmins/{id}', 'SuperAdmin\SuperAdminController@showEditSuperadminForm')->name('SuperAdmin/edit-superadmins');
        //Superadmin Update  Super Admin   Url
        Route::post('SuperAdmin/update-superadmins-creation', 'SuperAdmin\SuperAdminController@updateSuperAdminCreation')->name('SuperAdmin/update-client-creation');
        //Superadmin Delete  SuperAdmin   Url
        Route::post('SuperAdmin/delete-superadmin', 'SuperAdmin\SuperAdminController@deleteSuperAdmin')->name('SuperAdmin/delete-superadmin');
        /** Main SuperAdmin  End Here */
    });
    Route::group(['middleware' => ['superadmin']], function () {
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
    });
    Route::group(['middleware' => ['adminmiddleware']], function () {
        //Admin Dashboard Url
        Route::get('Admin/dashboard', 'Admin\AdminController@showDashboard')->name('Admin/dashboard');

        //Display form creation page
        Route::get('/hrisindex', 'Admin\AdminController@hrisindex')->name('/hrisindex');

        //Display form list in Datatabel
        Route::post('/hrisformlist', 'Admin\AdminController@hrisformlist')->name('/hrisformlist');

        //Form submit function
        Route::post('Admin/formsubmit', 'Admin\AdminController@formsubmit')->name('Admin/formsubmit');

        //Form Update function
        Route::post('Admin/formupdate', 'Admin\AdminController@formupdate')->name('Admin/formupdate');

        //display form-builder as per form name
        Route::get('hrisshowfield/{id}', 'Admin\AdminController@hrisshowfield')->name('hrisshowfield');

        //save fields created in form
        Route::post('hrisfield', 'Admin\AdminController@hrisfield')->name('hrisfield');

        //delete fields
        Route::post('hrisfieldsdelete', 'Admin\AdminController@hrisfieldsdelete')->name('hrisfieldsdelete');

        //to get fields count
        Route::post('/fieldautoids', 'Admin\AdminController@fieldautoids')->name('/fieldautoids');

        // get predefine_list
        Route::post('predefine_lists', 'Admin\AdminController@predefine_lists')->name('predefine_lists');
    });
    Route::group(['middleware' => ['usermiddleware']], function () {
        //User Dashboard Url
        Route::get('User/dashboard', 'User\UserController@showDashboard')->name('User/dashboard');
    });
    Route::group(['middleware' => ['commanmidleware']], function () {
        /** Common Controller Start Here */
        Route::post('/getvaild-email', 'CommonController@getVaildEmailId')->name('/getvaild-email');

        Route::post('/getvaild-email-foredit', 'CommonController@getVaildEmailIdforEdit')->name('/getvaild-email-foredit');

        Route::post('/all-modules', 'CommonController@getAllmodules')->name('/all-modules');

        Route::get('/dashboard', 'CommonController@dashboard')->name('/dashboard');
        // Logout The Users Browser
        Route::get('/logout', 'AuthenticationController@Logout')->name('logout');

        Route::get('/document-configration', 'CommonController@documentconfigration')->name('/document-configration');

        // SuperAdmin Save Doc Configration  Data
        Route::post('/save-docconfigration', 'CommonController@savedoconfigration')->name('/save-docconfigration');

        // Url For All Documents List
        Route::post('/all-documents', 'CommonController@getAllDocuments')->name('/all-documents');

        Route::post('/update-documents', 'CommonController@checkdocuments')->name('/update-documents');

        // SuperAdmin Update Doc Configration  Data
        Route::post('/update-docconfigration', 'CommonController@updateDocuments')->name('/update-docconfigration');

        /** Common Controller End Here */
    });

});

/** Admin Url Start Here */

/** Admin Url End Here */

/** User Url Start Here */

/** User Url End Here */
