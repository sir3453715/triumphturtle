<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width">
    <title>海龜集運請款單</title>
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
            line-height:1;
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
        }

        .bg-gray {
            background-color: rgb(233, 233, 233);
        }

        .main-sender {
            height: 100px;
        }

        .border-none {
            border:none;
        }

        .text-right {
            text-align: right;
        }

        .pb-30 {
            padding-bottom: 30px;
        }
        #payment-logo {
            position: relative;
    top: -40px;
    min-width:300px;
    width:100%;
}

    </style>
</head>
<body>
    <table>
        <tr>
            <td colspan="2" rowspan="5" class="font-title border-none"><img id="payment-logo" src="{{url('/storage/image/triumphturtle.jpg')}}"></td>
            <td colspan="4" class="font-title border-none text-right" style="font-size: 28px;">凱漩國際有限公司</td>
        </tr>
        <tr>
            <td colspan="4" class="border-none text-right">TRIUMPH INTERNATIONAL TRADING CO.,LTD</td>
        </tr>
        <tr>
            <td colspan="4" class="border-none text-right">2F, No. 113, Chenggong Rd., Sanchong Dist.,<br>
                New Taipei City 241012, Taiwan (R.O.C.)</td>
        </tr>
        <tr>
            <td colspan="4" class="border-none text-right">+886 2 29780058</td>
        </tr>
        <tr>
            <td colspan="4" class="border-none text-right pb-30">www.triumphturtle.com</td>
        </tr>
        <tr class="export-header center-text">
            <td colspan="6">BILL TO</td>
        </tr>
        <tr>
            <td colspan="1" class="font-title">Company: </td>
            <td colspan="2">{{$sender_company}}</td>
            <td colspan="1" class="font-title">Order No.</td>
            <td colspan="2">{{$seccode}}</td>
        </tr>
        <tr>
            <td colspan="1" class="font-title">Tax ID:</td>
            <td colspan="2">{{$sender_taxid}}</td>
            <td colspan="1" class="font-title">Payment Due</td>
            <td colspan="2">{{date('Y/m/d',strtotime('+5 days'))}}</td>
        </tr>
        <tr>
            <td colspan="1" class="font-title">Contact:</td>
            <td colspan="5">{{$sender_name}}</td>
        </tr>
        <tr>
            <td colspan="1" class="font-title">Phone:</td>
            <td colspan="5">{{$sender_phone}}</td>
        </tr>
        <tr>
            <td colspan="1" class="font-title">Email:</td>
            <td colspan="5">{{$sender_email}}</td>
        </tr>
        <tr class="export-header center-text">
            <td colspan="6">Payment detail</td>
        </tr>
        <tr class="font-title center-text">
            <td>Product</td>
            <td>Quantity</td>
            <td>Unit</td>
            <td>Country</td>
            <td>Unit Price</td>
            <td>Total Price</td>
        </tr>
        <tr class="center-text">
            <td> Delivery Fee</td>
            <td>{{$box_count}}</td>
            <td>box</td>
            <td>{{\App\Models\Country::find($sailing['to_country'])->title}}</td>
            <td>NT${{number_format($sailing['final_price'])}}</td>
            <td>NT${{number_format($sailing['final_price'] * $box_count) }}</td>
        </tr>
{{--        @if($other_price)--}}
{{--            <tr class="center-text">--}}
{{--                <td>{{$other_price['other_title']}}</td>--}}
{{--                <td>{{$other_price['other_qty']}}</td>--}}
{{--                <td></td>--}}
{{--                <td></td>--}}
{{--                <td>NT${{number_format($other_price['other_unit'])}}</td>--}}
{{--                <td>NT${{number_format($other_price['other_qty'] * $other_price['other_unit']) }}</td>--}}
{{--            </tr>--}}
{{--        @endif--}}
        <tr class="center-text">
            <td colspan="4"></td>
            <td colspan="1" class="bg-gray font-title ">Subtotal:</td>
            <td colspan="1" class="bg-gray">NT${{number_format($subtotal) }}</td>
        </tr>
        <tr class="center-text">
            <td colspan="4"></td>
            <td colspan="1" class="bg-gray font-title ">營業稅5%:</td>
            <td colspan="1" class="bg-gray">NT${{number_format($tax_value)}}</td>
        </tr>
        <tr class="center-text">
            <td colspan="4"></td>
            <td colspan="1" class="bg-green font-title ">Total:</td>
            <td colspan="1" class="bg-green">NT${{number_format($total_price)}}</td>
        </tr>
        <tr class="export-header center-text">
            <td colspan="6">匯款資訊</td>
        </tr>
        @if($invoice != 1)
            <tr>
                <td colspan="1" class="font-title">銀行:</td>
                <td colspan="5">國泰世華銀行 013</td>
            </tr>
            <tr>
                <td colspan="1" class="font-title">帳號:</td>
                <td colspan="5">220-03-500712-1</td>
            </tr>
            <tr>
                <td colspan="1" class="font-title">戶名:</td>
                <td colspan="5">凱漩國際有限公司</td>
            </tr>
        @else
            <tr>
                <td colspan="1" class="font-title">銀行:</td>
                <td colspan="5">國泰世華銀行 013</td>
            </tr>
            <tr>
                <td colspan="1" class="font-title">帳號:</td>
                <td colspan="5">017589515170</td>
            </tr>
            <tr>
                <td colspan="1" class="font-title">戶名:</td>
                <td colspan="5">蔡宜茵</td>
            </tr>
        @endif
        <tr>
            <td colspan="6" class="export-header center-text">備註說明</td>
        </tr>
        <tr>
            <td colspan="6">1. 若超過付款截止日後仍未付款，將會產生倉租費NT$100/每日由客戶自行負擔。<br>
2. 匯款時請您在備註註明訂單號碼後8碼 ( 如TS220315001-1，請備註 315001-1)，<br>以利帳務人員對帳，謝謝!</td>
        </tr>
    </table>
</body>
</html>

