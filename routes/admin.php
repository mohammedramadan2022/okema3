<?php

use App\Http\Controllers\Admin\{AuthController,
    HomeController,
    CategoryController,
    CenterController,
    ItemController,
    ProductController,
    StoreController,
    SupplierController,
    SafeController,
    ExpenseController,
    ReportController,
    CountryController,
PurchaseController,InvoiceController,ClientController,MaintenanceQuoteController,MaintenanceInvoiceController ,QuoteController , PaymentController};
use Illuminate\Support\Facades\Route;


Route::group(
    [
        'prefix' => LaravelLocalization::setLocale().'/admin',
        'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath']
    ], function () {


    Route::get('login', [AuthController::class, 'loginView'])->name('admin.login');
    Route::post('login', [AuthController::class, 'postLogin'])->name('admin.postLogin');

});


Route::group(
    [
        'prefix' => LaravelLocalization::setLocale().'/admin',
        'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath', 'admin']
    ], function () {


    Route::group(['middleware' => 'admin', 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath'],
        function () {
            Route::get('safes-transactions', [  ReportController::class, 'safesTransactions'])->name('admin.reports.safes-transactions');
            Route::get('deserved-invoices', [  ReportController::class, 'deservedInvoices'])->name('admin.reports.deserved-invoices');
            Route::get('general-expense-transactions', [  ReportController::class, 'generalExpenseTransactions'])->name('admin.reports.general-expense-transactions');
            Route::get('client-expense-transactions', [  ReportController::class, 'clientExpenseTransactions'])->name('admin.reports.client-expense-transactions');




            Route::get('/', [HomeController::class, 'index'])->name('admin.index');
            Route::get('requests_calenders',
                [HomeController::class, 'requests_calenders'])->name('admin.requests_calenders');

            Route::get('calender', [HomeController::class, 'calender'])->name('admin.calender');

            Route::get('logout', [AuthController::class, 'logout'])->name('admin.logout');

            ### admins

            Route::resource('admins', \App\Http\Controllers\Admin\AdminController::class);
            Route::resource('categories', CategoryController::class);
<<<<<<< Updated upstream
            Route::resource('countries', CountryController::class);
=======
            Route::resource('centers', CenterController::class);
            Route::resource('items', ItemController::class);
>>>>>>> Stashed changes
            Route::resource('safes', SafeController::class);
            Route::resource('expenses', ExpenseController::class);

            Route::get('add-expense-transaction', [ExpenseController::class, 'getAddExpenseTransaction'])->name('admin.expenses.get-add-expense-transaction');
            Route::post('add-expense-transaction', [ExpenseController::class, 'postAddExpenseTransaction'])->name('admin.expenses.post-add-expense-transaction');

             Route::get('add-client-expense-transaction', [ExpenseController::class, 'getAddClientExpenseTransaction'])->name('admin.expenses.get-add-client-expense-transaction');
            Route::post('add-client-expense-transaction', [ExpenseController::class, 'postAddClientExpenseTransaction'])->name('admin.expenses.post-add-client-expense-transaction');

            Route::get('activateSafe', [SafeController::class, 'activate'])->name('admin.active.safe');
            Route::get('activateExpense', [ExpenseController::class, 'activate'])->name('admin.active.expense');

            Route::get('activateCategory', [CategoryController::class, 'activate'])->name('admin.active.category');
<<<<<<< Updated upstream
            Route::get('activateCountry', [CountryController::class, 'activate'])->name('admin.active.country');
=======
            Route::get('activateCenter', [CenterController::class, 'activate'])->name('admin.active.center');
            Route::get('activateItem', [ItemController::class, 'activate'])->name('admin.active.item');
>>>>>>> Stashed changes
            Route::resource('stores', StoreController::class);
            Route::get('activateStore', [StoreController::class, 'activate'])->name('admin.active.store');
            Route::resource('suppliers', SupplierController::class);
            Route::get('activateSupplier', [SupplierController::class, 'activate'])->name('admin.active.supplier');
            Route::resource('purchase', PurchaseController::class);
            Route::resource('invoices', InvoiceController::class);
            Route::resource('clients', ClientController::class);
            Route::resource('maintenanceQuotes', MaintenanceQuoteController::class);
            Route::resource('maintenanceInvoices', MaintenanceInvoiceController::class);
            Route::resource('payments', PaymentController::class);

            Route::get('get-client-invoices', [PaymentController::class, 'getClientInvoices'])->name('admin.payments.get-client-invoices');

            Route::resource('quotes', QuoteController::class);
            Route::get('activateClient', [ClientController::class, 'activate'])->name('admin.active.client');
            Route::get('getLastQuoteId', [QuoteController::class, 'getLastQuoteId'])->name('quotes.getLastQuoteId');
            Route::get('getLastInvoiceId', [InvoiceController::class, 'getLastInvoiceId'])->name('invoices.getLastInvoiceId');
            Route::get('quotes.pdf/{quote}', [QuoteController::class, 'convertToPdf'])->name('quotes.pdf');
            Route::get('invoices.pdf/{invoice}', [InvoiceController::class, 'convertToPdf'])->name('invoices.pdf');
            Route::get('convert-to-invoice/{quoteId}', [QuoteController::class, 'convertToInvoice'])->name('quotes.convert-to-invoice');


            Route::resource('products', ProductController::class);
            Route::get('activateProduct', [ProductController::class, 'activate'])->name('admin.active.product');
            Route::get('printProductBarcode/{product}', [ProductController::class, 'printProductBarcode'])->name('admin.printProductBarcode');


            Route::get('activateAdmin',
                [App\Http\Controllers\Admin\AdminController::class, 'activate'])->name('admin.active.admin');
            Route::get('editPassword/{id}',
                [App\Http\Controllers\Admin\AdminController::class, 'editPassword'])->name('admin.edit.password');
            Route::post('updatePassword/{id}',
                [App\Http\Controllers\Admin\AdminController::class, 'updatePassword'])->name('admin.update.password');



            Route::resource('contacts', \App\Http\Controllers\Admin\ContactController::class);


            ### Permissions

            Route::resource('permissions', \App\Http\Controllers\Admin\PermissionController::class);

            ## Roles

            Route::resource('roles', \App\Http\Controllers\Admin\RoleController::class);


            ### setting
            Route::get('settings/terms-of-use',
                [App\Http\Controllers\Admin\SettingController::class, 'termsOfUse'])->name('settings.termsOfUse.index');
            Route::post('settings/update-terms-of-use', [
                App\Http\Controllers\Admin\SettingController::class, 'updateTermsOfUse'
            ])->name('settings.termsOfUse.update');
            Route::get('settings/privacy-policy', [
                App\Http\Controllers\Admin\SettingController::class, 'privacyPolicy'
            ])->name('settings.privacyPolicy.index');
            Route::post('settings/update-privacy-policy', [
                App\Http\Controllers\Admin\SettingController::class, 'updatePrivacyPolicy'
            ])->name('settings.privacyPolicy.update');
            Route::resource('settings', \App\Http\Controllers\Admin\SettingController::class);


            ### ckeditor

            Route::post('/pages/uploadImage',
                [\App\Http\Controllers\Ckeditor::class, 'uploadImage'])->name('upload.image');

        });

    Route::get('getClients', [QuoteController::class, 'getClients'])->name('getClients');


    Route::get('correct-quotes', function () {
      $clients = \App\Models\Client::get();

      foreach ($clients as $client){


          $quotes = \App\Models\Quote::where('client_id', $client->id)->get();
          $n = $client->quote_start;
          if (!$n){
              $n = 1;
          }
          foreach ($quotes as $quote) {
              $quote->update([
                  'quote_id' => $n
              ]);
              $n++;
          }
      }

    });

    return 'done';


});
