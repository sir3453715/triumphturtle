<?php

return [

//    'Debug' => 0,//正式
    'Debug' => '1',//測試

    // 商店代號
//    'MerchantID' => 330186780,//正式
    'MerchantID' => '34680280',//測試

    // HashKey
//    'HashKey' => 'v5d5bHn6760pU03W2GOYE1mvLHBlIjxS',//正式
    'HashKey' => 'Q2ppAXlSQHisuGkrQN0Qtd5eiTQb9AE3',//測試

    // HashIv
//    'HashIV' => 'PcvJEDNa2Wt0f6BC',//正式
    'HashIV' => 'CJgaprArIvbgCBUP',//測試


    // 回傳格式：JSON / String
    'RespondType' => 'JSON',

    // 開立串接版本：固定 1.4
    'Version_Create' => '1.4',

    // 作廢串接版本：固定 1.0
    'Version_Void' => '1.0',

    // 折讓串接版本：固定 1.3
    'Version_Allow' => '1.3',

    // 查詢串接版本：固定 1.1
    'Version_Search' => '1.1',

    // 查詢條版串接版本
    'Version_CheckCode' => '1.0',

    // 開立方式：1=即時 0=等待觸發 3=預約
    'Status_Create' => '1',

    // 開立方式：0=不立即確認 1=立即確認
    'Status_Allow' => '1',

    // 查詢方式：0=發票號碼&隨機碼 1=訂單編號&發票總金額
    'SearchType' => '1',

    // 查詢結果：空=回傳資料 1=form post導致該發票網站
    'DisplayFlag' => '1',

    // 預設買受人：B2B=需要統編 B2C=個人，不需要統編
    'Category' => 'B2C',

    // 課稅別：1=應稅 2=零稅率 3=免稅 9=混合應稅與免稅或零稅率（限收銀機發票無法分辨時使用）
    'TaxType' => '1',

    // 稅率：
    // 1. 課稅別為應稅時，一般稅率請帶 5，特種 稅率請帶入規定的課稅稅率(不含%，例稅率 18%則帶入 18)
    // 2. 課稅別為零稅率、免稅時，稅率請帶入 0
    'TaxRate' => '5',

    // 備註：限 71 字
    'Comment' => '',

    // 串接網址：開立
    'Url_Create' => 'https://inv.ezpay.com.tw/API/invoice_issue',
    'Url_Create_Test' => 'https://cinv.ezpay.com.tw/API/invoice_issue',

    // 作廢
    'Url_Void' => 'https://inv.ezpay.com.tw/API/invoice_invalid',
    'Url_Void_Test' => 'https://cinv.ezpay.com.tw/API/invoice_invalid',

    // 折讓
    'Url_Allow' => 'https://inv.ezpay.com.tw/API/allowance_issue',
    'Url_Allow_Test' => 'https://cinv.ezpay.com.tw/API/allowance_issue',

    // 查詢
    'Url_Search' => 'https://inv.ezpay.com.tw/API/invoice_search',
    'Url_Search_Test' => 'https://cinv.ezpay.com.tw/API/invoice_search',

    // 確認手機條碼
    'Url_Check_BarCode' => 'https://inv.ezpay.com.tw/Api_inv_application/checkBarCode',
    'Url_Check_BarCode_Test' => 'https://cinv.ezpay.com.tw/Api_inv_application/checkBarCode',

    // 確認捐贈碼
    'Url_Check_LoveCode' => 'https://inv.ezpay.com.tw/Api_inv_application/checkLoveCode',
    'Url_Check_LoveCode_Test' => 'https://cinv.ezpay.com.tw/Api_inv_application/checkLoveCode',
];
