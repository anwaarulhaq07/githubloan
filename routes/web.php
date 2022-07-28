<?php

use Illuminate\Support\Facades\Route;
use Doctrine\DBAL\Schema\Index;

Route::redirect('/', '/login');
Route::get('/home', function () { 
     
    if (session('status')) {
        return redirect()->route('admin.home')->with('status', session('status'));
    }

    return redirect()->route('admin.home');
});

//logout
Route::get('logout', 'Auth\LoginController@logout')->name('logout');

Auth::routes(['register' => false]);

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'Admin', 'middleware' => ['auth']], function () {
    Route::get('/', 'HomeController@index')->name('home');

    Route::get('transaction', 'HomeController@transaction');
    // Permissions
    Route::resource('permissions', 'PermissionsController', ['except' => ['create', 'store', 'edit', 'update', 'show', 'destroy']]);
    Route::get('permissions', 'PermissionsController@index')->name('permissions.index');

    // Roles
    Route::resource('roles', 'RolesController', ['except' => ['create', 'store', 'edit', 'update', 'show', 'destroy']]);
    Route::get('roles', 'RolesController@index')->name('roleindex');

    // Users
    Route::delete('users/destroy', 'UsersController@massDestroy')->name('users.massDestroy');
    Route::resource('users', 'UsersController');
    Route::get('users', 'UsersController@index')->name('usersindex');

    //Auth customer
    Route::get('customer_index', 'AuthCustomer@index')->name('customer_index');
    Route::get('customer_create', 'AuthCustomer@create')->name('customer_create'); 
    Route::post('customer_store', 'AuthCustomer@store')->name('customer_store'); 
    Route::get('customer_edit/{id}', 'AuthCustomer@edit')->name('customer_edit');
    Route::get('customer_history_mortage/{id}', 'AuthCustomer@customer_history_mortage')->name('customer_history_mortage');
    Route::get('customer_history_balloon/{id}', 'AuthCustomer@customer_history_balloon')->name('customer_history_balloon');
    Route::get('complete_mortage_history/{id}', 'AuthCustomer@complete_cumtomer_history_mortage')->name('complete_mortage_history');
    Route::get('complete_balloon_history/{id}', 'AuthCustomer@complete_cumtomer_history_balloon')->name('complete_balloon_history');
    Route::post('customer_update', 'AuthCustomer@update')->name('customer_update');
    Route::get('customer_destroy/{id}', 'AuthCustomer@destroy')->name('customer_destroy'); 


    // Mortage
    Route::delete('mortages/destroy', 'MortageController@massDestroy')->name('mortages.massDestroy');
    Route::resource('mortages', 'MortageController'); 
    Route::get('mortage', 'MortageController@index')->name('mortageindex');
    Route::get('report/{id}', 'MortageController@report')->name('report');
    Route::get('complete_mortage_report', 'MortageController@complete_mortage_report')->name('complete_mortage_report');

    // Detail
    Route::get('detail/{id}', 'detailController@detail')->name('summary'); 
    Route::post('paid', 'detailController@paid')->name('paid');

    //customer
    Route::get('customer', 'customerController@index')->name('customerindex'); 
    Route::post('paymentstore', 'customerController@store')->name('paymentstore');

     //Auto Loan
     Route::get('index', 'loanController@index')->name('loanindex');
     Route::get('create', 'loanController@create')->name('loancreate');
     Route::post('loanstore', 'loanController@store')->name('loanstore');
     Route::get('edit/{id}', 'loanController@edit')->name('loanedite');
     Route::post('loanUpdate', 'loanController@update')->name('loaneupdate');
     Route::get('delete/{id}', 'loanController@destroy')->name('loandelete');

     //Auto loan list
    Route::get('loandetail', 'loanlistController@index')->name('loanlist'); 
    Route::post('loan_paid', 'loanlistController@show')->name('loan_paid');


    //Auto loan customer
    Route::get('loancustomer', 'loanCustomerController@index')->name('loancustomerindex');
    Route::post('store', 'loanCustomerController@store')->name('autopaymentstore');
     Route::post('loanstore', 'loanController@store')->name('loanstore');



    // Balloon Loan routes
    Route::get('balloon_index', 'BalloonController@index')->name('balloon_index');
    Route::get('balloon_create', 'BalloonController@create')->name('balloon_create');
    Route::get('balloon_complete_report', 'BalloonController@balloon_complete_report')->name('balloon_complete_report');
    Route::post('balloonstore', 'BalloonController@store')->name('balloonstore');
    Route::get('balloon_delete/{id}', 'BalloonController@destroy')->name('balloon_delete');
    Route::get('report_balloon/{id}', 'BalloonController@report_summary')->name('report_balloon');


   //Balloon loan list
   Route::get('balloon_summary/{id}', 'BalloonInstallmentController@index')->name('balloon_summary');
   Route::post('store', 'BalloonInstallmentController@store')->name('balloonpaymentstore');
   Route::post('Balloon/Paid', 'BalloonInstallmentController@balloon_paid_installment')->name('balloon_paid_installment');


    //bank
    Route::get('bank_index', 'bankControlller@index')->name('bank_index');
    Route::get('bank_create', 'bankControlller@create')->name('bank_create');
    Route::post('bank_store', 'bankControlller@store')->name('bank_store');
    Route::get('bank_destroy/{id}', 'bankControlller@destroy')->name('bank_destroy');
    Route::get('trans_history/{id}', 'bankControlller@history');
    Route::get('complete_trans_history', 'bankControlller@complete_history')->name('complete_trans_history');
    Route::post('limit_history', 'bankControlller@limit_history')->name('limit_history');
    Route::post('bank_limit_history', 'bankControlller@bank_limit_history')->name('bank_limit_history');
    Route::post('del_history', 'bankControlller@delhistory')->name('del_history');



    //Bank transaction
    Route::get('transaction/{id}', 'bankTransacControlller@create');
    Route::post('add_balance', 'bankTransacControlller@store')->name('add_balance');
    Route::get('send_balance/{id}', 'bankTransacControlller@show')->name('send_balance');
    Route::post('share_balance', 'bankTransacControlller@share')->name('share_balance');




});
Route::group(['prefix' => 'profile', 'as' => 'profile.', 'namespace' => 'Auth', 'middleware' => ['auth']], function () {
    // Change password
    if (file_exists(app_path('Http/Controllers/Auth/ChangePasswordController.php'))) {
        Route::get('password', 'ChangePasswordController@edit')->name('password.edit');
        Route::post('password', 'ChangePasswordController@update')->name('password.update');
        Route::post('profile', 'ChangePasswordController@updateProfile')->name('password.updateProfile');
        Route::post('profile/destroy', 'ChangePasswordController@destroy')->name('password.destroyProfile');
    }
});

// Route::group(['prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'Admin', 'middleware' => ['auth']], function () {


// });

// For Excel
Route::get('importExportView', 'ExcelController@importExportView');
Route::post('complete_history_excel', 'ExcelController@complete_history_excel')->name('complete_history_excel');
Route::post('bank_history_excel', 'ExcelController@bank_history_excel')->name('bank_history_excel');
Route::get('export/{id}', 'ExcelController@export')->name('export');
Route::get('complete_export', 'ExcelController@complete_export')->name('complete_export');
Route::get('mortage_export/{id}', 'ExcelController@mortage_export')->name('mortage_export');
Route::get('complete_mortage_export', 'ExcelController@complete_mortage_export')->name('complete_mortage_export');
// Route::post('import', 'ExcelController@import')->name('import');

Route::get('install_pay/{id}', 'Admin\BalloonInstallmentController@install_pay')->name('install_pay');
Route::get('mortage_pay/{id}', 'Admin\detailController@mortage_pay')->name('mortage_pay');


// for rental properties


