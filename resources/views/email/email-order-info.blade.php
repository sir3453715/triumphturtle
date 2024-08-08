<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Test</title>
</head>
<body class="mainBody" style="width: 100%;max-width: 960px;margin: 0 auto;padding: 0;background: #ffffff;line-height: 24px;font-size: 16px;font-family: arial, &quot;微軟正黑體&quot;, &quot;Microsoft JhengHei&quot;;color: #333333;">
<table class="mainTable" cellspacing="0" cellpadding="0" style="width: 100%;background-color: #ffffff;font-size: 16px;height: 38px;line-height: 38px;border-collapse: collapse;">
    <tbody>
    <tr>
        <td><a href="{{route('index')}}" target="_blank"><img width="300px" src="{{url('/storage/image/NewLogo.png')}}"></a></td>
    </tr>
    <tr>
        <td style="padding: 35px 30px;">
            <table width="94%">
                <tbody>
                <tr>
                    <td style="font-size: 15px; line-height:24px;">
                        親愛的{{$for_title}}
                        <br/>
                        <br/>
                        {!! $msg !!}
                        <br/>
                        <br/>
                    </td>
                </tr>
                <tr>
                    <td>
                        揪揪運<br/>
                        <br/>
                        客服官方信箱：service@joinmeship.com<br/>
                        官方臉書專頁：https://www.facebook.com/joinmeship<br/>
                        官方LINE諮詢：@863wtrdh<br/>
                    </td>
                </tr>
                </tbody>
            </table>
        </td>
    </tr>
    </tbody>
</table>
</body>
</html>
