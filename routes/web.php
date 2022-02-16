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

Auth::routes();

Route::get('/', 'HomeController@index')->name('index');
Route::get('/about', 'HomeController@about')->name('about');
Route::get('/service', 'HomeController@service')->name('service');
Route::get('/embargo', 'HomeController@embargo')->name('embargo');
Route::get('/question', 'HomeController@question')->name('question');
Route::get('/location', 'HomeController@location')->name('location');
Route::get('/tracking', 'HomeController@tracking')->name('tracking');

//選擇個人OR團購
Route::get('/option/{id}', 'OrderController@option')->name('option');
//個人
Route::get('/individual-form/{id}', 'OrderController@individualForm')->name('individual-form');
Route::get('/individual-form-complete/{id}', 'OrderController@individualFormComplete')->name('individual-form-complete');
Route::post('/orderCreate','OrderController@orderCreate')->name('orderCreate');
//團購
Route::get('/group-form-initiator/{id}', 'HomeController@groupFormInitiator')->name('group-form-initiator');
Route::get('/group-form-member/{id}', 'HomeController@groupFormMember')->name('group-form-member');
Route::get('/group-form-edit', 'HomeController@groupFormEdit')->name('group-form-edit');
Route::get('/group-form-complet-i', 'HomeController@groupFormCompletI')->name('group-form-complet-i');
Route::get('/group-member-join', 'HomeController@groupMemberJoin')->name('group-member-join');
Route::get('/group-member-join-success', 'HomeController@groupMemberJoinSuccess')->name('group-member-join-success');
Route::get('/edit-success', 'HomeController@editSuccess')->name('edit-success');
// 運貨單
Route::get('/shipment-order', 'HomeController@shipmentOrder')->name('shipment-order');
Route::get('/delivery-order', 'HomeController@deliveryOrder')->name('delivery-order');





//Ajax
Route::get('ajaxSailingData', 'HomeController@ajaxSailingData');
Route::post('confirmToken', 'OrderController@confirmToken');


/**
 * 後台 Route
 */
Route::get('admin-login','Admin\AdminController@loginPage')->name('admin-login');//後台登入頁

Route::group(['prefix'=>'admin', 'middleware' => ['web', 'admin.area'],'as'=>'admin.'],function (){
    /** 首頁*/
    Route::get('/','Admin\AdminController@index')->name('index');
    /**
     * 快取清除
     */
    Route::get('/clear-cache', function() {
        Artisan::call('cache:clear');
        Artisan::call('route:clear');
        Artisan::call('config:clear');
        Artisan::call('view:clear');
        return redirect()->back()->with('message', '快取已清除!');
    })->name('clear-cache');


    Route::post('/uploadEditorImage', 'Admin\AdminController@uploadEditorImage')
        ->name('uploadEditorImage');

    Route::group(['prefix' => 'import-export', 'as' => 'import-export.'], function(){
        Route::post('/import', 'Admin\Menu\ImportExportController@import')
            ->name('import');
        Route::post('/export', 'Admin\Menu\ImportExportController@export')
            ->name('export');
    });
    Route::group(['prefix' => 'punch-card', 'as' => 'punch-card.'], function(){
        Route::post('/export', 'Admin\Menu\PunchCardController@export')
            ->name('export');
    });
    Route::group(['prefix' => 'payment', 'as' => 'payment.'], function(){
        Route::get('/checkPay/{id}', 'Admin\Menu\PaymentController@checkPay')
            ->name('checkPay');
    });
    Route::group(['prefix' => 'calendar', 'as' => 'calendar.'], function(){
        Route::post('/changeEventDate', 'Admin\Menu\CalendarController@changeEventDate')
            ->name('changeEventDate');
        Route::post('/EventDelete', 'Admin\Menu\CalendarController@EventDelete')
            ->name('EventDelete');
    });

});



