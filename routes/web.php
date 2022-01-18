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



