<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width">
    <title>海龜集運運貨單</title>
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
.shipment-number {
    font-size: 40px;
}

.shipment-number td {
    padding: 20px;
}
        .wrapper-page {
            page-break-after: always;
        }

    </style>
</head>
<body>
    <table>
        <tr class="center-text">
            <td colspan="5"><img width="200px" src="{{url('/storage/image/triumphturtle.jpg')}}"></td>
        </tr>
        <tr>
            <td colspan="5">一個運單號貼一箱</td>
        </tr>
            @foreach($OrderBoxes as $num => $box)
            @if($num!=0 && $num%5 ==0)
                </table>
                    <div class="wrapper-page"></div>
                    <table>
                        <tr class="center-text">
                            <td colspan="5"><img width="200px" src="{{url('/storage/image/triumphturtle.jpg')}}"></td>
                        </tr>
                        <tr>
                            <td colspan="5">一個運單號貼一箱</td>
                        </tr>
                    @endif
                <tr class="center-text">
                    <td colspan="5">寄送資訊</td>
                </tr>
                <tr class="export-header center-text">
                    <td colspan="3">運單號 Shipment Code</td>
                    <td colspan="2">第{{$num+1}}箱 box{{$num+1}}/{{count($OrderBoxes)}}</span></td>
                </tr>
                <tr class="shipment-number center-text">
                    <td class="" colspan="3">{{$box['box_seccode']}}</td>
                    <td class="" colspan="2">TIT</td>
                </tr>
                <tr>
                    <td colspan="5" class="center-text">========== 裁切線 =========</td>
                </tr>
            @endforeach
    </table>
</body>
</html>
