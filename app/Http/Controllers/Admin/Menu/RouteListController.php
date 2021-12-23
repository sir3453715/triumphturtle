<?php

namespace App\Http\Controllers\Admin\Menu;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class RouteListController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $routes = Route::getRoutes()->getRoutes();
        $routes = collect($routes)->map(function($route){
            /** @var \Illuminate\Routing\Route $route */
            $action = explode('@', $route->getActionName());
            return [
                'methods'    => $route->methods(),
                'uri'        => $route->uri(),
                'name'       => $route->getName(),
                'action'     => [
                    'controller' => isset($action[0]) ? $action[0] : '',
                    'method'     => isset($action[1]) ? $action[1] : '',
                ],
                'middlewares' => $route->middleware(),
            ];
        })->all();
        return view('admin.setting.routeList')->with(compact('routes'));

    }
}
