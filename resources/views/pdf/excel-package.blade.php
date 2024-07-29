<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width">
    <title>揪揪運裝箱單</title>
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
            padding: 5px 10px;
        }
        .center-text{
            text-align: center;
        }
        .export-header{
            background: #B6B5B5;
            font-weight: bold;
        }

        .font-title {
font-weight: bold;
        }

        .bg-green {
            background-color: rgb(149, 215, 193);
            font-size: 18px;
            white-space: nowrap;
        }

        .main-sender {
            height: 100px;
        }

    </style>
</head>
<body>
    <table>
        <tr class="main-sender">
            <td colspan="1" class="font-title">NAME /ADDRESS /TEL</td>
            <td colspan="7">{{$order_data['sender_name']}} / {{$order_data['sender_address']}}/ {{$order_data['sender_phone']}}</td>
        </tr>
        <tr>
            <td colspan="8" class="center-text font-title export-header">PACKING/WEIGHT LIST</td>
        </tr>
        <tr>
            <td colspan="1" class="font-title">PACKING LIST of</td>
            <td colspan="7"></td>
        </tr>
        <tr>
            <td colspan="1" class="font-title">For account and risk of Messrs</td>
            <td colspan="7">{{$order_data['for_name']}}</td>
        </tr>
        <tr>
            <td colspan="1" class="font-title">Address</td>
            <td colspan="7">{{$order_data['for_address']}}</td>
        </tr> <tr>
            <td colspan="1" class="font-title">TEL</td>
            <td colspan="7">{{$order_data['for_phone']}}</td>
        </tr>
        <tr>
            <td colspan="1" class="font-title">From</td>
            <td colspan="3">{{$order_data['fromCountry']}}</td>
            <td colspan="1" class="font-title">TO</td>
            <td colspan="3">{{$order_data['toCountry']}}</td>
        </tr>
        <tr>
            <td colspan="1" class="font-title">purpose</td>
            <td colspan="7">{{$order_data['shipment_use']}}</td>
        </tr>
        <tr class="export-header center-text">
            <td colspan="8">list detail</td>
        </tr>
        <tr class="font-title center-text">
            <td>Packing No.</td>
            <td>Description</td>
            <td>unit price</td>
            <td>Quantity</td>
            <td>Gross Weight</td>
            <td>Net Weight</td>
            <td>Measurement(CM)</td>
            <td>Value (USD)</td>
        </tr>
        @foreach($order_data['OrderBoxes'] as $orderBox)
            @foreach($orderBox['OrderBoxesItems'] as $key => $OrderBoxesItem)
                @if($key == 0)
                    <tr class="center-text">
                        <td rowspan="{{count($orderBox['OrderBoxesItems'])}}" class="bg-green">{{$orderBox['box_seccode']}}</td>
                        <td>{{$OrderBoxesItem['item_name']}}</td>
                        <td>{{ number_format($OrderBoxesItem['unit_price']) }}</td>
                        <td>{{$OrderBoxesItem['item_num']}}</td>
                        <td>{{$orderBox['box_weight']}}KG</td>
                        <td>{{($orderBox['box_weight']-2)}}KG</td>
                        <td>{{$orderBox['box_length']}}*{{$orderBox['box_width']}}*{{$orderBox['box_height']}}</td>
                        <td rowspan="{{count($orderBox['OrderBoxesItems'])}}">{{number_format($orderBox['total_value'])}}</td>
                    </tr>
                @else
                    <tr class="center-text">
                        <td>{{$OrderBoxesItem['item_name']}}</td>
                        <td>{{$OrderBoxesItem['unit_price']}}</td>
                        <td>{{$OrderBoxesItem['item_num']}}</td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                @endif
            @endforeach
        @endforeach
    </table>
</body>
</html>

