<?php

use App\Http\Controllers\Admin\{AuthController, HomeController,OwnerController , CountryController};
use Illuminate\Support\Facades\Route;


Route::group(
    [
        'prefix' => LaravelLocalization::setLocale() . '/admin',
        'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath']
    ], function () {


    Route::get('login', [AuthController::class, 'loginView'])->name('admin.login');
    Route::post('login', [AuthController::class, 'postLogin'])->name('admin.postLogin');

});


Route::group(
    [
        'prefix' => LaravelLocalization::setLocale() . '/admin',
        'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath', 'admin']
    ], function () {


    Route::group(['middleware' => 'admin', 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath'], function () {
        Route::get('/', [HomeController::class, 'index'])->name('admin.index');
        Route::get('requests_calenders', [HomeController::class, 'requests_calenders'])->name('admin.requests_calenders');

        Route::get('calender', [HomeController::class, 'calender'])->name('admin.calender');

        Route::get('logout', [AuthController::class, 'logout'])->name('admin.logout');

        ### admins

        Route::resource('admins', \App\Http\Controllers\Admin\AdminController::class);
        Route::resource('owners', OwnerController::class);
        Route::resource('countries', CountryController::class);
        Route::get('activateAdmin', [App\Http\Controllers\Admin\AdminController::class, 'activate'])->name('admin.active.admin');
        Route::get('editPassword/{id}', [App\Http\Controllers\Admin\AdminController::class, 'editPassword'])->name('admin.edit.password');
        Route::post('updatePassword/{id}', [App\Http\Controllers\Admin\AdminController::class, 'updatePassword'])->name('admin.update.password');

        ### Countries


        #### Contacts

        Route::resource('contacts', \App\Http\Controllers\Admin\ContactController::class);



        ### Permissions

        Route::resource('permissions', \App\Http\Controllers\Admin\PermissionController::class);

        ## Roles

        Route::resource('roles', \App\Http\Controllers\Admin\RoleController::class);



        ### setting
        Route::get('settings/terms-of-use', [App\Http\Controllers\Admin\SettingController::class, 'termsOfUse'])->name('settings.termsOfUse.index');
        Route::post('settings/update-terms-of-use', [App\Http\Controllers\Admin\SettingController::class, 'updateTermsOfUse'])->name('settings.termsOfUse.update');
        Route::get('settings/privacy-policy', [App\Http\Controllers\Admin\SettingController::class, 'privacyPolicy'])->name('settings.privacyPolicy.index');
        Route::post('settings/update-privacy-policy', [App\Http\Controllers\Admin\SettingController::class, 'updatePrivacyPolicy'])->name('settings.privacyPolicy.update');
        Route::resource('settings', \App\Http\Controllers\Admin\SettingController::class);


        ### ckeditor

        Route::post('/pages/uploadImage', [\App\Http\Controllers\Ckeditor::class, 'uploadImage'])->name('upload.image');

    });

});
