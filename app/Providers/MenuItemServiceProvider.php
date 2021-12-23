<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class MenuItemServiceProvider extends ServiceProvider
{
    protected $namespace = '\\';
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        /** 從Config建Admin Menu物件內容 */

        Route::group(['prefix'=>'admin', 'middleware' => ['web', 'admin.area'],'as'=>'admin.'],function (){
            //Config的Menu組態設定
            $menuItems = config('menu.menu_detail');

            foreach ($menuItems as $menuItem) {
                if($menuItem['type'] == 'item') {
                    if(isset($menuItem['controller'])&&class_exists($menuItem['controller'])) {
                        $hasChildren = !empty($menuItem['children']);
                        if(!$hasChildren) {
                            $routeName = $menuItem['func_name'];
                            //註冊Route
                            Route::resource($routeName, $menuItem['controller'], ['except' => [
                                'show'
                            ]]);
                        }
                        if($hasChildren) {
                            foreach((array)$menuItem['children'] as $childMenuItem) {
                                if(class_exists($childMenuItem['controller'])) {
                                    $routeName = $childMenuItem['func_name'];
                                    //註冊Route
                                    Route::resource($routeName, $childMenuItem['controller'], ['except' => [
                                        'show'
                                    ]]);
                                }
                            }
                        }
                    }
                }
            }
        });
    }
}
