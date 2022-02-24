<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width">
    <link rel="shortcut icon" href="{{url('/storage/image/favicon.ico')}}">
    <title>海龜集運運貨單</title>
    <link href="" rel="stylesheet">
    <style>

        @font-face {
            font-family: 'msyh';
            font-style: normal;
            font-weight: normal;
            src: url({{ storage_path('fonts/msyh.ttf') }}) format('truetype');
        }
        body {
            font-family: msyh, DejaVu Sans, sans-serif;
        }
        table {
            width: 95%;
            margin: auto;
            border: none;
            border-collapse: collapse;
            font-size: 20px;
        }
        td {
            border: 1px solid #000;
            padding: 3px;
        }
        .center-text{
            text-align: center;
        }
        .export-header{
            background: #D1D1D1;
            font-weight: bold;
        }

        .font-title {
            font-weight: bold;
        }

    </style>
</head>
<body>
<table>
    <tr class="center-text">
        <td colspan="5"><img width="200px" src="{{url('/storage/image/triumphturtle.jpg')}}"></td>
    </tr>
    <tr>
        <td colspan="1">運單號 Shipment Code</td>
        <td colspan="2">TS211001002-1-1</td>
        <td colspan="1">第1箱 box1/3</td>
    </tr>
    <tr class="center-text">
        <td colspan="4" class="font-title">寄送資訊</td>
    </tr>
    <tr class="export-header">
        <td colspan="2">寄件人 Shipper/Exporter</td>
        <td colspan="2">收件人 Consignee</td>
    </tr>
    <tr>
        <td colspan="1">姓名 Name</td>
        <td colspan="1">Leo</td>
        <td colspan="1">姓名 Name</td>
        <td colspan="1" class="">小紅</td>
    </tr>
    <tr>
        <td>電話 Phone</td>
        <td class="">02-2350091</td>
        <td>公司 Company</td>
        <td class="">有限公司</td>
    </tr>
    <tr>
        <td colspan="2">集運公司 Company</td>
        <td>電話 Phone</td>
        <td>9899999989</td>
    </tr>
    <tr>
        <td colspan="2" rowspan="2">凱漩國際有限公司<br>TRIUMPH INTERNATIONAL TRADING CO, LTD</td>
        <td colspan="2">地址 Address</td>
    </tr>
    <tr>
        <td colspan="2" class="">757 Monroe Avenue Bradenton Florida 34205</td>
    </tr>
    <tr>
        <td colspan="4" class="center-text">========== 裁切線 =========</td>
    </tr>
</table>
</body>
</html>
