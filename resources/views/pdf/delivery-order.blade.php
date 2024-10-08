<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width">
    <title>揪揪運運貨單</title>
    <link rel="shortcut icon" href="{{url('/storage/image/favicon.ico')}}">
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
        .wrapper-page {
            page-break-after: always;
        }
    </style>
</head>
<body>
<table>
    <tr class="center-text">
        <td colspan="4"><img width="200px" src="{{url('/storage/image/NewLogo.png')}}"></td>
    </tr>
    @foreach($OrderBoxes as $num => $box)
            @if($num!=0 && $num%3 ==0)
            </table>
            <div class="wrapper-page"></div>
            <table>
                <tr class="center-text">
                    <td colspan="4"><img width="200px" src="{{url('/storage/image/NewLogo.png')}}"></td>
                </tr>
            @endif
                <tr>
                    <td colspan="1">運單號 Shipment Code</td>
                    <td colspan="2">{{$box['box_seccode']}}</td>
                    <td colspan="1">第{{$num+1}}箱 box{{$num+1}}/{{count($OrderBoxes)}}</td>
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
                    <td colspan="1">{{$sender_name}}</td>
                    <td colspan="1">姓名 Name</td>
                    <td colspan="1" class="">{{$for_name}}</td>
                </tr>
                <tr>
                    <td>電話 Phone</td>
                    <td class="">{{$sender_phone}}</td>
                    <td>公司 Company</td>
                    <td class="">{{$for_company}}</td>
                </tr>
                <tr>
                    <td colspan="2">集運公司 Company</td>
                    <td>電話 Phone</td>
                    <td>{{$for_phone}}</td>
                </tr>
                <tr>
                    <td colspan="2" rowspan="2">奧瑞國際有限公司<br>FF SOLUTION CO LTD.</td>
                    <td colspan="2">地址 Address</td>
                </tr>
                <tr>
                    <td colspan="2" class="">{{$for_address}}</td>
                </tr>
                <tr>
                    <td colspan="4" class="center-text">========== 裁切線 =========</td>
                </tr>
    @endforeach
            </table>
</body>
</html>

