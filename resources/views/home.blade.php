@extends('layouts.app')

@push('app-styles')
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@3.10.3/dist/fullcalendar.min.css" rel="stylesheet">
@endpush


@section('content')
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Rubik:wght@400;500&display=swap');
        body {
            font-family: 'Rubik', sans-serif;
            font-size: 14px;
            color: #525456;
        }
        h1, h2, h3, h4, h5, h6 {
            font-weight: 500;
        }
        h6 {
            font-size: 14px;
        }
        a {
            text-decoration: none!important;
            outline: none!important;
        }
        p {
            line-height: 1.8;
        }
        .bg-overlay {
            background-color: rgba(121, 121, 121, 0.8);
            position: absolute;
            top: 0;
            right: 0;
            left: 0;
            bottom: 0;
            width: 100%;
            height: 100%}
        .section {
            padding-top: 80px;
            padding-bottom: 80px;
            position: relative;
        }
        .vertical-content {
            display: -webkit-flex;
            display: -moz-flex;
            display: -ms-flexbox;
            display: flex;
            align-items: center;
            -webkit-align-items: center;
            justify-content: center;
            -webkit-justify-content: center;
            flex-direction: row;
            -webkit-flex-direction: row;
        }
        .btn-rounded {
            border-radius: 5px;
        }
        .btn-custom-white {
            font-size: 15px;
            transition: all .4s;
            background: #fff;
            color: #3864f3!important;
        }
        .btn-custom-white:hover, .btn-custom-white:focus, .btn-custom-white:active, .btn-custom-white.active, .btn-custom-white.focus, .btn-custom-white:active, .btn-custom-white:focus, .btn-custom-white:hover, .open>.dropdown-toggle.btn-custom-white {
            background: #f1f0f0;
            box-shadow: none!important;
        }
        .btn-custom {
            font-size: 15px;
            transition: all .4s;
            color: #fff!important;
            background: #3864f3;
        }
        .btn {
            padding: 14px 28px;
            font-size: 12px;
            letter-spacing: .9px;
            font-weight: 500;
            text-transform: uppercase;
            transition: box-shadow .25s ease, transform .25s ease, -webkit-transform .25s ease;
        }
        .btn:hover {
            transform: translate3d(0, -3px, 0);
        }
        .btn-sm {
            padding: 10px 22px;
        }
        .text-custom {
            color: #3864f3;
        }
        .bg-custom {
            background-color: #3864f3;
        }
        .f-19 {
            font-size: 17px;
        }
        .font-weight-medium {
            font-weight: 500;
        }
        .navbar-custom {
            padding: 15px 0;
            border-radius: 0;
            z-index: 999;
            margin-bottom: 0;
            transition: all .5s ease-in-out;
            background-color: white;
        }
        .navbar-custom .navbar-nav li a {
            color: #525456;
            font-size: 12px;
            transition: all .5s;
            letter-spacing: .03rem;
            background-color: transparent!important;
            padding: 6px 0;
            margin: 0 13px;
            font-weight: 500;
            text-transform: uppercase;
        }
        .navbar-custom .navbar-nav .nav-link {
            padding-right: 0;
            padding-left: 0;
        }
        .logo {
            color: #383e44!important;
            font-weight: 700;
            font-size: 18px;
            text-transform: uppercase;
            letter-spacing: 2px;
        }
        .logo i {
            color: #3864f3!important;
            font-size: 20px;
            vertical-align: middle;
        }
        .navbar-custom .navbar-nav li.active a, .navbar-custom .navbar-nav li a:hover, .navbar-custom .navbar-nav li a:active {
            color: #3864f3!important;
        }
        .navbar-toggle {
            font-size: 24px;
            margin-top: 5px;
            margin-bottom: 0;
            color: #fff;
        }
        .nav .open>a, .nav .open>a:focus, .nav .open>a:hover {
            background-color: transparent;
            border-color: #337ab7;
        }
        .navbar-custom .navbar-toggles {
            padding: .25rem .75rem;
            font-size: 18px;
            background: 0;
            border: 1px solid transparent;
            color: #fff;
            outline: 0;
        }
        .navbar-custom .navbar-toggles-icon {
            display: inline-block;
            width: 1.5em;
            height: 1.5em;
            vertical-align: middle;
        }
        .menu-toggle {
            padding: 4.5px 10px!important;
        }
        .menu-toggle span {
            line-height: 27px;
        }
        .nav-sticky.navbar-custom {
            margin-top: 0;
            padding: 15px 0;
            background-color: #FFF;
            box-shadow: 0 10px 33px rgba(0, 0, 0, .1);
            color: #000!important;
        }
        .nav-sticky.navbar-custom.sticky-light {
            background-color: #fff;
        }
        .nav-sticky.navbar-custom .navbar-nav li a {
            color: #2f3545;
        }
        .nav-sticky.navbar-custom .navbar-nav li.active a, .nav-sticky.navbar-custom .navbar-nav li a:hover, .nav-sticky.navbar-custom .navbar-nav li a:active {
            color: #3864f3!important;
        }
        .nav-sticky.navbar-custom .navbar-toggles {
            padding: .25rem .75rem;
            border: 1px solid transparent;
            outline: 0;
        }
        .nav-sticky .navbar-nav {
            margin-top: 0;
        }
        .nav-sticky .logo {
            color: #000!important;
        }
        .title-heading {
            font-size: 1.5rem;
        }
        .title h1 {
            position: absolute;
            color: rgba(0, 0, 0, 0.1);
            left: 0;
            right: 0;
            top: -45px;
        }
        .bg-home {
            background: url("{{asset('storage/image/img.png')}}") center center no-repeat;
            background-size: cover;
            background-position: center center;
            height: 100vh;
            position: relative;
        }
        .bg-home-2 {
            background: url("{{asset('storage/image/img.png')}}") center center no-repeat;
            background-size: cover;
            background-position: center center;
        }
        .home-center {
            display: table;
            width: 100%;
            height: 100%}
        .home-desc-center {
            display: table-cell;
            vertical-align: middle;
        }
        .home-small-title {
            font-size: 15px;
            letter-spacing: 8px;
        }
        .home-slider {
            position: relative;
        }
        .home-slider .carousel-control-next, .carousel-control-prev {
            width: 6%}
        .home-slider .carousel-item, .home-slider .carousel {
            height: 100vh;
            width: 100%}
        .home-slider .carousel-item {
            background-position: center center;
            background-size: cover;
        }
        .clients-img {
            position: absolute;
            top: 108px;
        }
        .clients-img img {
            max-height: 100px;
            width: auto!important;
            transition: all .5s;
        }
        .clients-img img:hover {
            opacity: .6;
        }
        .home-registration-form {
            border-radius: 3px;
        }
        .home-registration-form .registration-form label {
            font-size: 13px;
        }
        .registration-input-box {
            border-bottom: 1px solid #c5c5c5;
            box-shadow: none!important;
        }
        .registration-input-box:focus {
            border-color: #3864f3;
        }
        .subcribe-form input {
            padding: 14px 20px;
            width: 100%;
            font-size: 17px;
            color: #4c5667!important;
            border: 0;
            outline: none!important;
            padding-right: 160px;
            padding-left: 30px;
            background-color: rgba(255, 255, 255, 0.85);
            border-radius: 5px;
        }
        .subcribe-form button {
            position: absolute;
            top: 3px;
            right: 3px;
            outline: none!important;
            border-radius: 5px;
            font-size: 14px;
            padding: 12px 30px;
        }
        .subcribe-form form {
            position: relative;
            max-width: 600px;
            margin: 0 auto;
        }
        .home-dashboard {
            position: relative;
            top: 80px;
            z-index: 1;
        }
        .home-prestion {
            padding-top: 75px;
            background-color: #f8f9fa;
            position: relative;
        }
        .home-slider {
            position: relative;
        }
        .home-slider .carousel-control-next, .carousel-control-prev {
            width: 6%}
        .home-slider .carousel-item, .home-slider .carousel {
            height: 100vh;
            width: 100%}
        .home-slider .carousel-item {
            background-position: center center;
            background-size: cover;
        }
        .home-title {
            font-size: 42px;
            line-height: 60px;
            text-align: center;
            margin-bottom: 250px;
        }
        .home-desc {
            max-width: 700px;
        }
        .bg-home-half {
            background-size: cover;
            background-position: center center;
            padding: 120px 0 50px;
            position: relative;
        }
        .features h5 svg {
            height: 48px;
            width: 48px;
            fill: rgba(255, 99, 72, 0.2);
        }
        .features h4 {
            font-size: 18px;
        }
        .features-icon {
            position: relative;
            display: inline-block;
            width: 54px;
            height: 54px;
            border: 2px solid rgba(21, 101, 216, 0.1);
            border-radius: 15px;
        }
        .features-icon i {
            color: #3864f3!important;
            line-height: 54px;
            font-size: 22px;
        }
        .service h3 {
            font-size: 14px;
            letter-spacing: 3px;
        }
        .service p {
            font-size: 30px;
        }
        .services-blog svg {
            max-width: 45px;
            float: left;
            margin-right: 20px;
            height: 48px;
            width: 48px;
            fill: rgba(255, 99, 72, 0.2);
            color: #3864f3;
        }
        .service-head {
            overflow: hidden;
        }
        .services-blog {
            padding: 40px;
            background-color: #fff;
        }
        .services-blog h4 {
            font-size: 16px;
        }
        .testi-user {
            max-width: 60px;
        }
        .user-review {
            color: #667482;
            font-style: italic;
            font-size: 16px;
        }
        .testi-client-name {
            font-size: 15px;
            color: #000;
        }
        .testi-patients {
            font-size: 14px;
            color: #000;
        }
        .testi-content {
            padding: 30px;
            border-radius: 5px 30px;
            margin: 10px;
            background-color: #f8f9fa;
        }
        .owl-theme .owl-controls .owl-page span {
            display: block;
            width: 10px;
            height: 5px;
            margin: 5px 7px;
            border: 1px solid #3864f3;
            background-color: #3864f3;
            opacity: .2;
        }
        .img-max-width {
            width: 25%}
        .portfolio-title {
            font-size: 21px;
            word-spacing: 2px;
            font-weight: 700;
            letter-spacing: 1px;
        }
        .port-folio-sub-title {
            color: #585858;
            font-size: 17px;
            word-spacing: 1px;
            padding-top: 10px;
        }
        .container-filter {
            margin-top: 0;
            margin-right: 0;
            margin-left: 0;
            margin-bottom: 30px;
            padding: 0;
            text-align: center;
            display: inline!important;
        }
        .container-filter li {
            list-style: none;
            display: inline-block;
        }
        .container-filter li a {
            display: block;
            font-size: 10px;
            border: 1px solid #e0e0e0;
            padding: 0 15px;
            margin: 5px 3px;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 1px;
            cursor: pointer;
            line-height: 35px;
            border-radius: 3px;
            color: #75757d;
        }
        .small-box{
            height: 150px;
            align-items: center;
        }
        .container-filter li a.active {
            color: #fff;
            background-color: #3864f3;
            border: 1px solid #3864f3;
        }
        .container-filter li a:hover {
            color: #fff!important;
            background-color: #3864f3;
            border: 1px solid #3864f3;
        }
        .item-box {
            position: relative;
            overflow: hidden;
            display: block;
        }
        .item-box a {
            display: inline-block;
        }
        .item-box:hover .item-mask {
            opacity: 1;
            visibility: visible;
        }
        .item-box:hover .item-mask .item-caption {
            bottom: 30px;
            opacity: 1;
        }
        .item-box:hover .item-container {
            transform: scale(1.1);
            transition: all 2s cubic-bezier(0.23, 1, 0.32, 1) 0s;
            width: 100%}
        .item-container {
            transform: scale(1);
            -ms-transform: scale(1);
            -webkit-transform: scale(1);
            width: 100%;
            transition: all 2s cubic-bezier(0.23, 1, 0.32, 1) 0s;
        }
        .item-mask {
            background: none repeat scroll 0 0 rgba(255, 255, 255, 0.7);
            position: absolute;
            transition: all .5s ease-in-out 0s;
            top: 10px;
            left: 10px;
            bottom: 10px;
            right: 10px;
            opacity: 0;
            visibility: hidden;
            overflow: hidden;
        }
        .item-mask h5 {
            font-size: 16px;
        }
        .item-mask p {
            text-transform: uppercase;
            font-size: 10px;
            letter-spacing: 1.5px;
            font-weight: 500;
            margin: 0;
            text-align: left;
        }
        .item-mask .item-caption {
            position: absolute;
            bottom: -60px;
            left: 0;
            padding-left: 30px;
            padding-right: 30px;
            text-align: left;
            transition: all .5s ease-in-out 0s;
            opacity: 0;
        }
        .portfolio-head h3 {
            font-size: 14px;
            letter-spacing: 3px;
        }
        .portfolio-head p {
            font-size: 30px;
        }
        .bg-cta {
            /*background-image: url('../images/home/home-bg-3.jpg');*/
            background-size: cover;
            background-position: center center;
            position: relative;}
        .model-menu img {
            border-radius: 5px;}
        .model-menu h5 {
            font-size: 15px;
        }
        .blog-title {
            font-size: 16px;
            color: #44464f;
            margin-top: 20px;
            display: block;
        }
        .blog-title:hover {
            color: #3864f3;
            transition: all .5s;}
        .model-menu p {
            font-size: 14px;
            line-height: 1.8;
        }
        .read-btn {
            font-size: 15px;
            color: #3864f3;
            text-decoration: underline!important;
        }
        .read-btn:hover {
            color: #f70033;
        }
        .about-title h2 {
            line-height: 42px;
        }
        .about-title p {
            font-size: 17px;
            line-height: 30px;
            font-weight: 300;
        }
        .about-title {
            max-width: 800px;
        }
        .about-border-left {
            border-left: 1px solid #e7e7e7;
        }
        .team-member {
            filter: grayscale(100%);
            max-width: 165px;
        }
        .team-member:hover {
            filter: grayscale(0%);
        }
        .price {
            box-shadow: 0 40px 40px rgba(0, 0, 0, 0.05);
            border-radius: 12px;
        }
        .price .type h4 {
            font-size: 18px;
            text-transform: uppercase;
        }
        .price .value {
            position: relative;
        }
        .price .value h3 {
            display: inline-block;
            padding-right: 10px;
            font-size: 46px;
            position: relative;
        }
        .price .value h3 span {
            font-size: 14px;
            position: absolute;
            top: 5px;
        }
        .price .value .per {
            font-size: 13px;
        }
        .price .feature {
            padding: 15px 0;
        }
        .price .feature li {
            margin: 15px;
        }
        .price.active {
            background-color: rgba(255, 99, 72, 0.2);
        }
        .form-control {
            height: 46px;
            border: 1px solid #e9e6e6;
            font-size: 14px;
        }
        textarea.form-control {
            height: auto;
        }
        .form-control:focus {
            border-color: #3864f3;
            outline: 0;
            box-shadow: none;
        }
        .address-info {
            overflow: hidden;
        }
        .contact-info {
            font-size: 14px;
        }
        .error {
            margin: 8px 0;
            display: none;
            color: red;
        }
        #ajaxsuccess {
            font-size: 16px;
            width: 100%;
            display: none;
            clear: both;
            margin: 8px 0;
        }
        .error_message {
            padding: 10px;
            margin-bottom: 20px;
            text-align: center;
            border: 2px solid #ff4774;
            color: #ff4774;
            border-radius: 5px;
            font-size: 14px;
        }
        .contact-loader {
            display: none;
        }
        #success_page {
            text-align: center;
            margin-bottom: 50px;
        }
        #success_page h3 {
            color: #10b81a;
            font-size: 22px;
        }
        .footer {
            padding-top: 80px;
            padding-bottom: 40px;
            color: #818d9c;
        }
        .footer-menu h5 {
            font-size: 14px;
            color: #fff;
        }
        .footer-menu p, .footer span {
            font-size: 13px;
        }
        .footer_mdi {
            font-size: 16px;
            height: 36px;
            width: 36px;
            line-height: 36px;
            border-radius: 50%;
            text-align: center;
            display: inline-block;
            margin: 20px 2px;
        }
        .facebook {
            background-color: #4e71a8;
            color: #fff;
        }
        .twitter {
            background-color: #55acee;
            color: #fff;
        }
        .google {
            background-color: #d6492f;
            color: #fff;
        }
        .apple {
            background-color: #231f20;
            color: #fff;
        }
        .dribbble {
            background-color: #fff;
            color: #000;
        }
        .footer-menu li a {
            font-size: 14px;
            display: inline-block;
            transition: all .5s;
            line-height: 32px;
            color: #818d9c!important;
        }
        @media(max-width:768px) {
            .vertical-content {
                display: inherit;
            }
            .navbar-custom {
                margin-top: 0;
                padding: 10px 0!important;
                background-color: #000!important;
                box-shadow: 0 10px 33px rgba(0, 0, 0, .1);
                color: #fff!important;
            }
            .navbar-toggler i {
                font-size: 24px;
                margin-top: 0;
                margin-bottom: 0;
                color: #fff;
            }
            .bg-home {
                height: auto;
            }
            .nav-sticky.navbar-custom .navbar-nav li a {
                color: #fff!important;
            }
            .nav-sticky .logo {
                color: #fff!important;
            }
            .navbar-custom>.container {
                width: 90%}
            .clients-img {
                display: none;
            }
        }@media(min-width:768px) and (max-width:1024px) {
            .clients-img {
                top: 76px;
            }
        }@media(max-height:767px) {
            .clients-img {
                top: 7px;
            }
        }
        .slick-prev:before {
            color: black;
        }
        .slick-next:before {
            color: black;
        }
        .required-text{
            color: red;
            margin-left: 3px;
        }
        #notification-message{
            display: none;
        }
        .scrollToTop{
            width:50px;
            height:50px;
            line-height:50px;
            text-align:center;
            background:#F63E3E;
            color:#fff;
            position:fixed;
            bottom:20px;
            right:30px;
            border-radius:50%;
        }
        .scrollToTop:hover{
            background:#6cb2eb ;
            text-decoration:none;
        }

    </style>

    <section class="section" id="Select2">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-7">
                    <div class="text-center">
                        <h4 class="title-heading">打卡系統</h4>
                    </div>
                </div>
            </div>
            <form class="form" id="punch-form" action="{{route('punch')}}" method="post">
                @csrf
                <div class="col-lg-12 pt-5">
                    <div class="row">
                        <div class="select2-box col-12">
                            <div class="media">
                                <div class="media-body ml-4">
                                    <div class="form-inline">
                                        <div class="col-1"></div>
                                        <div class="col-2">
                                            <label for="status0">上班
                                            <input class="form-control" type="radio" name="status" value="0" id="status0"></label>
                                        </div>
                                        <div class="col-2">
                                            <label for="status1">下班
                                            <input class="form-control" type="radio" name="status" value="1" id="status1"></label>
                                        </div>
                                        <div class="col-2">
                                            <label for="status2">病假
                                            <input class="form-control" type="radio" name="status" value="2" id="status2"></label>
                                        </div>
                                        <div class="col-2">
                                            <label for="status3">事假
                                            <input class="form-control" type="radio" name="status" value="3" id="status3"></label>
                                        </div>
                                        <div class="col-2">
                                            <label for="status4">特休
                                            <input class="form-control" type="radio" name="status" value="4" id="status4"></label>
                                        </div>
                                        <div class="col-1"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12 pt-5" id="time-select" style="display: none">

                    <h5 class="text-center">日期</h5>
                    <div class="row mb-3">
                        <div class="select2-box col-12">
                            <div class="media">
                                <div class="media-body ml-4">
                                    <div class="form-inline">
                                        <div class="col-4">
                                        </div>
                                        <input class="form-control col-4" type="date" name="date" >
                                        <div class="col-4">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <h5 class="text-center">時間</h5>
                    <div class="row">
                        <div class="select2-box col-12">
                            <div class="media">
                                <div class="media-body ml-4">
                                    <div class="form-inline">
                                        <div class="col-4">
                                            <label for="time1">早上
                                            <input class="form-control" type="radio" name="time" value="1" id="time1"></label>
                                        </div>
                                        <div class="col-4">
                                            <label for="time2">下午
                                            <input class="form-control" type="radio" name="time" value="2" id="time2"></label>
                                        </div>
                                        <div class="col-4">
                                            <label for="time3">整天
                                            <input class="form-control" type="radio" name="time" value="3" id="time3"></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 mt-3">
                    <div class="row">
                        <div class="col-4">
                        </div>
                        <div class="col-4">
                            <button type="submit" class="form-control" >送出</button>
                        </div>
                        <div class="col-4">
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>

    <section class="section" id="Select2">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-7">
                    <div class="text-center">
                        <h4 class="title-heading">行事曆</h4>
                    </div>
                </div>
            </div>
            <div class="col-lg-12 pt-5">
                <div id="calendar">
                    @foreach($calendars as $calendar)
                        <div class="calendar-event" data-id="{{$calendar->id}}" data-title="{{$calendar->get_title_with_member()}}" data-show="{{$calendar->title}}" data-member="{{$calendar->member}}" data-start="{{$calendar->start_time}}" data-end="{{$calendar->end_time}}" data-description="{{$calendar->description}}" data-color="{{$calendar->color}}"></div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>


@endsection

@push('app-scripts')

    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@3.10.3/dist/fullcalendar.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@3.10.3/dist/locale-all.js"></script>
    <script type="text/javascript">
        let events = [];
        $('.calendar-event').each(function (index) {
            var single = {
                id:$(this).data('id'),
                start:$(this).data('start')+'T00:00:00',
                end:$(this).data('end')+'T23:59:59',
                title:$(this).data('title'),
                show:$(this).data('show'),
                description:$(this).data('description'),
                member:$(this).data('member'),
                color:$(this).data('color'),
            };
            events.push(single);
        });
        $('#calendar').fullCalendar({
            locale: 'zh-tw',
            editable: false,
            displayEventTime: false,
            events: events,
            header: {
                left: 'month',
                right: 'prevYear,prev,today,next,nextYear',
                center: 'title',
            },
        });
    </script>
    <script type="text/javascript">
        $("body").on("change",$('input[name="status"]'),function () {
            if($('input[name=status]:checked').val() == 0 || $('input[name=status]:checked').val() == 1){
                $('#time-select').hide();
            }else{
                $('#time-select').show();
            }
        });

        $("#punch-form").on('submit', function() {
            let invalid = false;
            let message ='';
            if($('input[name=status]:checked').val() === '' || $('input[name=status]:checked').val() === undefined){
                invalid = true;
                message = '請選擇項目!';
            }else if($('input[name=status]:checked').val() != 0 && $('input[name=status]:checked').val() != 1){
                if($('input[name=time]:checked').val() === '' || $('input[name=time]:checked').val() === undefined){
                    invalid = true;
                    message = '請選擇時間!';
                }
            }
            if(invalid) {
                alert(message);
                return false;
            }
        });
    </script>
@endpush
