@extends('layouts.app')

@section('content')
<div class="main-wrapper">
    <section class="confirm-page center-center">
        <div class="confirm-content container">
            <p>您的訂單:<span>{{$order->seccode}}</span></p>
            <p>已成功完成寄送!</p>
            <p>詳細資料已寄送到您的電子信箱</p>
            <p>（如需要更改資料請從訂單查詢處輸入此訂單編號）</p>
            <a class="btn-link btn-link-white mt-5" href="{{route('index')}}">回首頁</a>
        </div>
    </section>
</div>
@endsection
