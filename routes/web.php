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
Route::get('about', 'HomeController@about')->name('about');
Route::get('service', 'HomeController@service')->name('service');
Route::get('embargo', 'HomeController@embargo')->name('embargo');
Route::get('question', 'HomeController@question')->name('question');
Route::get('location', 'HomeController@location')->name('location');
Route::get('tracking', 'HomeController@tracking')->name('tracking');
Route::get('tracking-captcha/{seccode}', 'HomeController@trackingCaptcha')->name('tracking-captcha');

//選擇個人OR團購
Route::get('option/{id}', 'OrderController@option')->name('option');
//個人
Route::get('individual-form/{id}', 'OrderController@individualForm')->name('individual-form');
Route::get('individual-form-complete/{parameter}', 'OrderController@individualFormComplete')->name('individual-form-complete');
//團購主揪
Route::get('group-form-initiator/{id}', 'OrderController@groupFormInitiator')->name('group-form-initiator');
Route::get('group-form-complete-i/{parameter}', 'OrderController@groupFormCompleteI')->name('group-form-complete-i');
//團購下線
Route::get('group-form-member/{parent_id}', 'OrderController@groupFormMember')->name('group-form-member');
Route::get('group-form-edit/{seccode}', 'OrderController@groupFormEdit')->name('group-form-edit');
Route::get('group-member-join/{base64_id}', 'OrderController@groupMemberJoin')->name('group-member-join');
Route::get('group-member-join-success/{parameter}', 'OrderController@groupMemberJoinSuccess')->name('group-member-join-success');
//訂單相關動作
Route::post('group-captcha', 'OrderController@groupCaptcha')->name('group-captcha');
Route::post('order-update-captcha', 'OrderController@orderUpdateCaptcha')->name('order-update-captcha');
Route::post('orderCreate','OrderController@orderCreate')->name('orderCreate');
Route::post('orderUpdate','OrderController@orderUpdate')->name('orderUpdate');

Route::get('edit-success', 'HomeController@editSuccess')->name('edit-success');
// 運貨單HTML
Route::get('shipment-order', 'PdfExportController@shipmentOrder')->name('shipment-order');
Route::get('delivery-order', 'PdfExportController@deliveryOrder')->name('delivery-order');
Route::get('package', 'PdfExportController@package')->name('package');
Route::get('payment-billing', 'PdfExportController@paymentBilling')->name('payment-billing');
// 或運單PDF
Route::get('pdf-shipment/{id}', 'PdfExportController@pdfShipment')->name('pdf-shipment');//
Route::get('pdf-delivery/{id}', 'PdfExportController@pdfDelivery')->name('pdf-delivery');//
Route::get('pdf-package/{id}', 'PdfExportController@pdfPackage')->name('pdf-package');//
Route::get('pdf-payment/{id}', 'PdfExportController@pdfPayment')->name('pdf-payment');//




//Ajax
Route::get('ajaxSailingData', 'HomeController@ajaxSailingData');
Route::post('updateToken', 'HomeController@updateToken');
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


    Route::group(['prefix' => 'payment', 'as' => 'payment.'], function(){
        Route::get('/checkPay/{id}', 'Admin\Menu\PaymentController@checkPay')
            ->name('checkPay');
    });
    Route::group(['prefix' => 'order-detail', 'as' => 'order-detail.'], function(){
        Route::post('/bulk', 'Admin\Menu\OrderDetailController@bulk')
            ->name('bulk');
        Route::get('/importList', 'Admin\Menu\OrderDetailController@importList')
            ->name('importList');
        Route::post('/import', 'Admin\Menu\OrderDetailController@import')
            ->name('import');
    });
});



