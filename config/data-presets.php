<?php

return[

    // 角色
    'roles' => [
        ['name' => 'administrator', 'displayName' => '最高權限管理員'],
        ['name' => 'manager' , 'displayName' => '商店管理員'],
        ['name' => 'customer' , 'displayName' => '顧客'],
    ],

    'permissions'=>[
        [
            //進入後台
            'name'         => 'admin area',
            'displayName'  => '進入後台',
            'assignTo'     => ['manager'],
        ],
        [
            //訂單資料
            'name'         => 'admin order',
            'displayName'  => '訂單資料',
            'assignTo'     => ['manager'],
        ],
        [
            //訂單裝箱列表
            'name'         => 'admin order boxing',
            'displayName'  => '訂單裝箱列表',
            'assignTo'     => ['manager'],
        ],
        [
            //訂單列表明細
            'name'         => 'admin order detail',
            'displayName'  => '訂單列表明細',
            'assignTo'     => ['manager'],
        ],
        [
            //船班設定
            'name'         => 'admin sailing schedule',
            'displayName'  => '船班設定',
            'assignTo'     => ['manager'],
        ],
        [
            //帳務管理
            'name'         => 'admin payment',
            'displayName'  => '帳務管理',
            'assignTo'     => [],
        ],
        [
            //國家資料設定
            'name'         => 'admin country',
            'displayName'  => '國家資料設定',
            'assignTo'     => ['manager'],
        ],
        [
            //倉庫資料設定
            'name'         => 'admin warehouse',
            'displayName'  => '倉庫資料設定',
            'assignTo'     => ['manager'],
        ],
        [
            //會員管理
            'name'         => 'admin user',
            'displayName'  => '會員管理',
            'assignTo'     => ['manager'],
        ],
        [
            //權限管理
            'name'         => 'admin permission',
            'displayName'  => '權限管理',
            'assignTo'     => [],
        ],
        [
            //網站設定
            'name'         => 'admin web setting',
            'displayName'  => '網站資訊&設定',
            'assignTo'     => ['manager'],
        ],
        [
            //一般設定
            'name'         => 'admin option',
            'displayName'  => '一般設定',
            'assignTo'     => ['manager'],
        ],
        [
            //路由列表
            'name'         => 'admin route list',
            'displayName'  => '路由列表',
            'assignTo'     => [],
        ],
        [
            //網站歷史紀錄
            'name'         => 'admin web log',
            'displayName'  => '網站操作歷史紀錄',
            'assignTo'     => ['manager'],
        ],
        [
            //網站歷史紀錄
            'name'         => 'admin login log',
            'displayName'  => '登入紀錄',
            'assignTo'     => ['manager'],
        ],
        [
            //網站歷史紀錄
            'name'         => 'admin action log',
            'displayName'  => '操作紀錄',
            'assignTo'     => ['manager'],
        ],
    ],
    // 預設的設定值
    'options' => [
        'site_name' => config('app.name'),
    ],
];
