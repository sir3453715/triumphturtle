<?php
use App\Http\Controllers\Admin\Menu;

return [
    // 設定的項目
    'fields' => [
        'site_name' => [
            'label'     => 'siteName',
            'validator' => 'required',
            'required'  => true
        ],
        'site_description' => [
            'label' => 'siteDescription'
        ],
        'service' => [
            'label' => 'service',
            'type' => 'editor',
            'weight' => '300',
        ],
    ],
];
