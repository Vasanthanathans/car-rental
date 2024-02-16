<?php


use App\Http\Controllers\admin\LoginController;
use App\Http\Controllers\admin\PagesController;
use App\Http\Controllers\admin\SettingsController;
use App\Http\Controllers\admin\UsersController;
use App\Http\Controllers\Admin\EmailTemplateController;
use App\Http\Controllers\Admin\FileUploadController;
use App\Http\Controllers\Admin\SubAdminController;
use App\Http\Middleware\CheckAdminLogin;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;


/** SITE CONTROLLERS */

use App\Http\Controllers\Site\LandingController;

/** SITE CONTROLLERS */


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

Route::get('/linkstorage', function () {
    Artisan::call('storage:link');
});


/** ADMIN ROUTES */

Route::get('/admin', [LoginController::class, 'login'])->name('admin');

Route::group(['prefix' => 'admin', 'middleware' => 'checkAdminLogin'], function () {

    Route::post('login', [LoginController::class, 'checklogin'])->name('admin.login');
    Route::get('index', [SettingsController::class, 'index'])->name('admin.index');
    Route::get('logout', [LoginController::class, 'logout'])->name('admin.logout');

    // SUBADMIN

    Route::get('subadmins', [SubAdminController::class, 'subadmins'])->name('admin.subadmins');
    Route::post('fetchSubAdminList', [SubAdminController::class, 'fetchSubAdminList'])->name('admin.fetchSubAdminList');
    Route::get('addSubAdmin/{id?}', [SubAdminController::class, 'addSubAdmin'])->name('admin.addSubAdmin');
    Route::post('addeditSubAdmin', [SubAdminController::class, 'addeditSubAdmin'])->name('admin.addeditSubAdmin');
    Route::get('deleteSubAdmin/{id}', [SubAdminController::class, 'deleteSubAdmin'])->name('admin.deleteSubAdmin');
    Route::get('changeSubAdminStatus/{id}', [SubAdminController::class, 'changeSubAdminStatus'])->name('admin.changeSubAdminStatus');


    // Users

    Route::get('users', [UsersController::class, 'users'])->name('admin.users');
    Route::post('fetchUsersList', [UsersController::class, 'fetchUsersList'])->name('admin.fetchUsersList');
    Route::get('blockUserFromAdmin/{id}', [UsersController::class, 'blockUserFromAdmin'])->name('admin.blockUserFromAdmin');
    Route::get('unblockUserFromAdmin/{id}', [UsersController::class, 'unblockUserFromAdmin'])->name('admin.unblockUserFromAdmin');
    Route::get('viewUserProfile/{id}', [UsersController::class, 'viewUserProfile'])->name('admin.viewUserProfile');

    // Banners
    Route::get('banners', [SettingsController::class, 'banners'])->name('admin.banners');
    Route::post('fetchBannersList', [SettingsController::class, 'fetchBannersList'])->name('admin.fetchBannersList');
    Route::post('addBanner', [SettingsController::class, 'addBanner'])->name('admin.addBanner');
    Route::post('editBannerInfo', [SettingsController::class, 'editBannerInfo'])->name('admin.editBannerInfo');
    Route::get('deleteBanner/{id}', [SettingsController::class, 'deleteBanner'])->name('admin.deleteBanner');


    // Settings
    Route::get('settings', [SettingsController::class, 'settings'])->name('admin.settings');
    Route::post('updateGlobalSettings', [SettingsController::class, 'updateGlobalSettings'])->name('admin.updateGlobalSettings');
    Route::get('changeTaxStatus/{status}', [SettingsController::class, 'changeTaxStatus'])->name('admin.changeTaxStatus');
    Route::post('changePassword', [SettingsController::class, 'changePassword'])->name('admin.changePassword');
    Route::post('updatePaymentSettings', [SettingsController::class, 'updatePaymentSettings'])->name('admin.updatePaymentSettings');
    Route::get('adminSettings', [SettingsController::class, 'adminSettings'])->name('admin.adminSettings');
    Route::post('updateAdminSettings', [SettingsController::class, 'updateAdminSettings'])->name('admin.updateAdminSettings');

    // CMS PAGES

    Route::get('cmsPages', [PagesController::class, 'cmsPages'])->name('admin.cmsPages');
    Route::post('fetchCmsPageList', [PagesController::class, 'fetchCmsPageList'])->name('admin.fetchCmsPageList');
    Route::get('addCmsPage/{id?}', [PagesController::class, 'addCmsPage'])->name('admin.addCmsPage');
    Route::post('addeditCmsPage', [PagesController::class, 'addeditCmsPage'])->name('admin.addeditcmspage');
    Route::get('deleteCmspage/{id}', [PagesController::class, 'deleteCmspage'])->name('admin.deleteCmspage');
    Route::get('changeStatus/{id}', [PagesController::class, 'changeStatus'])->name('admin.changeStatus');


    // EMAIL TEMPLATE

    Route::get('emailList', [EmailTemplateController::class, 'emailList'])->name('admin.emailList');
    Route::post('fetchEmailList', [EmailTemplateController::class, 'fetchEmailList'])->name('admin.fetchEmailList');
    Route::get('addEmail/{id?}', [EmailTemplateController::class, 'addEmail'])->name('admin.addEmail');
    Route::post('addeditEmail', [EmailTemplateController::class, 'addeditEmail'])->name('admin.addeditEmail');
    Route::get('deleteEmail/{id}', [EmailTemplateController::class, 'deleteEmail'])->name('admin.deleteEmail');
    Route::get('changeEmailStatus/{id}', [EmailTemplateController::class, 'changeEmailStatus'])->name('admin.changeEmailStatus');

    Route::get('sendEmail', [EmailTemplateController::class, 'sendEmail'])->name('amdin.sendEmail');


    // FILEUPLOADS

    Route::get('fileUploads', [FileUploadController::class, 'fileUploads'])->name('admin.fileUploads');
    Route::post('uploadFile', [FileUploadController::class, 'uploadFile'])->name('admin.uploadFile');
    Route::post('delete_fileuploads', [FileUploadController::class, 'delete_fileuploads'])->name('admin.delete_fileuploads');

    // Pages Routes
    Route::get('viewPrivacy', [PagesController::class, 'viewPrivacy'])->name('admin.viewPrivacy');
    Route::post('updatePrivacy', [PagesController::class, 'updatePrivacy'])->name('admin.updatePrivacy');
    Route::get('viewTerms', [PagesController::class, 'viewTerms'])->name('admin.viewTerms');
    Route::post('updateTerms', [PagesController::class, 'updateTerms'])->name('admin.updateTerms');
    Route::get('privacypolicy', [PagesController::class, 'privacypolicy'])->name('admin.privacypolicy');
    Route::get('termsOfUse', [PagesController::class, 'termsOfUse'])->name('admin.termsOfUse');
});


/** SITE ROUTES */

Route::get('/', [LandingController::class, 'index'])->name('home');
Route::get('/about', [LandingController::class, 'about'])->name('about');
Route::get('/services', [LandingController::class, 'services'])->name('services');
Route::get('/pricing', [LandingController::class, 'pricing'])->name('pricing');
Route::get('/vehicle', [LandingController::class, 'vehicle'])->name('vehicle');
Route::get('/vehicleinfo/{id}', [LandingController::class, 'vehicleinfo'])->name('vehicle');
Route::get('/blog', [LandingController::class, 'blog'])->name('blog');
Route::get('/contact', [LandingController::class, 'contact'])->name('contact');
