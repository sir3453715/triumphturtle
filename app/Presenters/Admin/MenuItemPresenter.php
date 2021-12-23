<?php

namespace App\Presenters\Admin;

use App\Models\User;
use App\Presenters\Html\HtmlPresenter;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class MenuItemPresenter
{
    private $htmlPresenter;

    public function __construct(HtmlPresenter $htmlPresenter)
    {
        $this->htmlPresenter = $htmlPresenter;
    }
    /**
     * 檢查選單項目權限
     *
     * @param array $item
     * @return mixed
     */
    private function checkMenuItemPermission($item)
    {
        $user = Auth::user();
        $flag = false;
        if ($user->hasRole('administrator')){
            $flag = true;
        }else{
            if($user->hasPermissionTo($item['permission'])){
                $flag = true;
            }
        }
        return $flag;
    }

    /**
     * Check if any child has permission
     *
     * @param $item
     * @return bool
     */
    private function checkAnyChildPermission($item)
    {
        $user = Auth::user();
        if ($user->hasRole('administrator')){
            return true;
        }else{
            if(isset($item['children'])) {
                $anyChildHasPermission = false;
                foreach ($item['children'] as $childMenu) {
                    if($user->hasPermissionTo($childMenu['permission'])){
                        $anyChildHasPermission = true;
                    }
                }
                return $anyChildHasPermission;
            } else {
                return true;
            }
        }
    }
    private function checkNowRouteController($item){
        $route = Route::getCurrentRoute();
        $now_controller = explode('@', $route->getActionName());
        if($now_controller[0] == $item['controller'] ){
            return true;
        }else{
            return false;
        }
    }
    private function checkNowRouteChildrenController($item){
        $route = Route::getCurrentRoute();
        $now_controller = explode('@', $route->getActionName());

        if(isset($item['children'])) {
            $routeChildController = false;
            foreach ($item['children'] as $childMenu) {
                if($now_controller[0] == $childMenu['controller']){
                    $routeChildController = true;
                }
            }
            return $routeChildController;
        } else {
            return true;
        }

    }
    private function checkNowRouteChildrenOpen($item){
        $route = Route::getCurrentRoute();
        $now_controller = explode('@', $route->getActionName());

        if(isset($item['children'])) {
            $routeChildController = false;
            foreach ($item['children'] as $childMenu) {
                if($now_controller[0] == $childMenu['controller']){
                    $routeChildController = true;
                }
            }
            return $routeChildController;
        } else {
            return false;
        }

    }
    /**
     * 回傳選單項目Html
     *
     * return string
     */
    public function render()
    {
        $user = Auth::user();
        $menu = config('menu.menu_detail');
        $html = '';
        $htmlPresenter = $this->htmlPresenter;

        foreach ($menu as $parentKey => $item) {
            switch($item['type']) {
                case 'header':
                    $html .= $htmlPresenter->li([
                        'class' => 'nav-header '.'role-'.$user->roles->first()->name ,
                        'html'  => $item['title']
                    ]);
                    break;
                case 'item':
                    if($this->checkMenuItemPermission($item) && $this->checkAnyChildPermission($item)) {
                        $hasChildren = !empty($item['children']);
                        $href = "admin.{$item['func_name']}.index";
                        $active_flag = ($this->checkNowRouteController($item) && $this->checkNowRouteChildrenController($item));
                        $html .= $htmlPresenter->li([
                            'class' => [
                                'nav-item',
                                "slug-{$item['func_name']}",
                                'style' => ($this->checkNowRouteChildrenOpen($item))?'menu-is-opening menu-open' :'',
                            ],
                            'html' => [
                                $htmlPresenter->a([
                                    'class' => [
                                        'nav-link',
                                        ($active_flag)?'active':'',
                                    ],
                                    'href' => $hasChildren? '#' : route($href),
                                    'html' => [
                                        !empty($item['icon']) ? $htmlPresenter->i(['class' => ['nav-icon',$item['icon']]]) : '',
                                        $item['title'],
                                        $hasChildren ? $htmlPresenter->i(['class' => 'fas fa-angle-left right']) : ''
                                    ],
                                ]),
                                $hasChildren ? $htmlPresenter->ul([
                                    'class' => 'nav nav-treeview ml-4 ',
                                    'style' => $this->checkNowRouteChildrenController($item)?'display: block;' :'display: none;',
                                    'html'  => function() use ($hasChildren, $item, $htmlPresenter) {
                                        $html = '';
                                        if($hasChildren) {
                                            foreach ($item['children'] as $childItem) {
                                                if($this->checkMenuItemPermission($childItem)) {
                                                    $active_flag = ($this->checkNowRouteController($childItem) );
                                                    $hasController = !empty($childItem['controller']);
                                                    $html .= $htmlPresenter->li([
                                                        'class' => [
                                                            'nav-item',
                                                            "slug-{$childItem['func_name']}"
                                                        ],
                                                        'html' => $htmlPresenter->a([
                                                            'class' => [
                                                                'nav-link',
                                                                ($active_flag)?'active':'',
                                                            ],
                                                            'href' => $hasController?route("admin.{$childItem['func_name']}.index"):'#',
                                                            'html' => [
                                                                !empty($childItem['icon']) ? $htmlPresenter->i(['class' => ['nav-icon',$childItem['icon']]]) : '',
                                                                $childItem['title']
                                                            ],
                                                        ])
                                                    ]);
                                                }
                                            }
                                        }
                                        return $html;
                                    }
                                ]) : ''
                            ]
                        ]);
                    }
                    break;
                case 'title':
                    if($this->checkMenuItemPermission($item) && $this->checkAnyChildPermission($item)) {
                        $hasChildren = !empty($item['children']);
                        $href = ($item['link'])??'#';
                        $active_flag = ($this->checkNowRouteController($item) && $this->checkNowRouteChildrenController($item));
                        $html .= $htmlPresenter->li([
                            'class' => [
                                'nav-item',
                                "slug-{$item['func_name']}",
                                'style' => ($this->checkNowRouteChildrenOpen($item))?'menu-is-opening menu-open' :'',
                            ],
                            'html' => [
                                $htmlPresenter->a([
                                    'class' => [
                                        'nav-link',
                                        ($active_flag)?'active':'',
                                    ],
                                    'href' => $hasChildren? '#' : $href,
                                    'target' => ($item['target'])??'',
                                    'html' => [
                                        !empty($item['icon']) ? $htmlPresenter->i(['class' => ['nav-icon',$item['icon']]]) : '',
                                        $item['title'],
                                        $hasChildren ? $htmlPresenter->i(['class' => 'fas fa-angle-left right']) : ''
                                    ],
                                ]),
                                $hasChildren ? $htmlPresenter->ul([
                                    'class' => 'nav nav-treeview ml-4 ',
                                    'style' => $this->checkNowRouteChildrenController($item)?'display: block;' :'display: none;',
                                    'html'  => function() use ($hasChildren, $item, $htmlPresenter) {
                                        $html = '';
                                        if($hasChildren) {
                                            foreach ($item['children'] as $childItem) {
                                                if($this->checkMenuItemPermission($childItem)) {
                                                    $active_flag = ($this->checkNowRouteController($childItem) );
                                                    $hasController = !empty($childItem['controller']);
                                                    $html .= $htmlPresenter->li([
                                                        'class' => [
                                                            'nav-item',
                                                            "slug-{$childItem['func_name']}"
                                                        ],
                                                        'html' => $htmlPresenter->a([
                                                            'class' => [
                                                                'nav-link',
                                                                ($active_flag)?'active':'',
                                                            ],
                                                            'href' => $hasController?route("admin.{$childItem['func_name']}.index"):'#',
                                                            'html' => [
                                                                !empty($childItem['icon']) ? $htmlPresenter->i(['class' => ['nav-icon',$childItem['icon']]]) : '',
                                                                $childItem['title']
                                                            ],
                                                        ])
                                                    ]);
                                                }
                                            }
                                        }
                                        return $html;
                                    }
                                ]) : ''
                            ]
                        ]);
                    }
                    break;
            }
        }

        echo $html;
    }
}
