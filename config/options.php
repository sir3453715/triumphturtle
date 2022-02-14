<?php
use App\Http\Controllers\Admin\Menu;

return [
    // 設定的項目
    'fields' => [
        'site_name' => [
            'label'     => '網站名稱',
            'validator' => 'required',
            'required'  => true
        ],
        'site_description' => [
            'label' => '網站簡介'
        ],
        'company_address' => [
            'label' => '公司地址'
        ],
        'company_tel' => [
            'label' => '公司電話'
        ],
        'company_email' => [
            'label' => '公司信箱'
        ],
        'facebook' => [
            'label' => 'FB連結'
        ],
        'line' => [
            'label' => 'Line連結'
        ],
        'faq' => [
            'label' => '常見問題',
            'type' => 'editor',
            'weight' => '300',
        ],
        'send_content' => [
            'label' => '寄送限制注意事項',
            'type' => 'editor',
            'weight' => '300',
        ],
    ],
];
