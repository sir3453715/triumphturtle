@extends('layouts.app')

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
            background-image: url("{{asset('storage/image/img.png')}}") ;
            background-size: cover;
            background-position: center center;
            padding: 250px 0 200px;
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

    <!-- HOME START-->
    <section class="bg-home-half" id="home">
        <div class="home-center">
            <div class="home-desc-center">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
                            <h2 class="home-title ">Han Demo Template</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- HOME END-->
    <!-- WELCOME START -->
    <section class="section" id="Select2">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-7">
                    <div class="text-center">
                        <h4 class="title-heading">Select2 Demo</h4>
                        <p class="title-desc text-muted mt-3">This Template Is Using Select2 For Select Element</p>
                    </div>
                </div>
            </div>
            <div class="row pt-5">
                <div class="col-lg-4">
                    <div class="select2-box mt-4">
                        <div class="media">
                            <div class="media-body ml-4">
                                <h5 class="mt-0 f-19">First: Default</h5>
                                <p class="text-muted">Default Select2</p>
                                <div class="form-group">
                                    <select class="select2 select form-control" name="select">
                                        @for($i=1;$i<=5;$i++)
                                            <option value="option{{$i}}">Option{{$i}}</option>
                                        @endfor
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="select2-box mt-4">
                        <div class="media">
                            <div class="media-body ml-4">
                                <h5 class="mt-0 f-19">Second: Multi Select</h5>
                                <p class="text-muted">Multi Select</p>
                                <div class="form-group">
                                    <select class="select2 select form-control" name="select_multi[]" multiple="multiple">
                                        @for($i=1;$i<=5;$i++)
                                            <option value="option{{$i}}">Option{{$i}}</option>
                                        @endfor
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="select2-box mt-4">
                        <div class="media">
                            <div class="media-body ml-4">
                                <h5 class="mt-0 f-19">Third: Multi Select2 Limit</h5>
                                <p class="text-muted">Limiting the number of multi select</p>
                                <div class="form-group">
                                    <select class="select2-limit select form-control" name="select_multi[]" multiple="multiple">
                                        @for($i=1;$i<=5;$i++)
                                            <option value="option{{$i}}">Option{{$i}}</option>
                                        @endfor
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row pt-3">
                <div class="col-lg-2"></div>
                <div class="col-lg-4">
                    <div class="select2-box mt-4">
                        <div class="media">
                            <div class="media-body ml-4">
                                <h5 class="mt-0 f-19">Fourth: Select2 Language</h5>
                                <p class="text-muted">Change Select2 Language</p>
                                <div class="form-group">
                                    <label>English</label>
                                    <select class="select2 select form-control" name="select_multi[]"></select>
                                    <label>繁體中文</label>
                                    <select class="select2-limit-zhTW select form-control" name="select_multi[]"></select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="select2-box mt-4">
                        <div class="media">
                            <div class="media-body ml-4">
                                <h5 class="mt-0 f-19">Fifth: Select2 limit Input Length</h5>
                                <p class="text-muted">Limit Input Length Of Select2</p>
                                <div class="form-group">
                                    <label>Min:2</label>
                                    <select class="select2-min-input-length select form-control" name="select">
                                        @for($i=1;$i<=8;$i++)
                                            <option value="option{{$i}}">Option{{$i}}</option>
                                        @endfor
                                    </select>
                                    <label>Max:4</label>
                                    <select class="select2-max-input-length select form-control" name="select">
                                        @for($i=1;$i<=8;$i++)
                                            <option value="option{{$i}}">Option{{$i}}</option>
                                        @endfor
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2"></div>
            </div>

        </div>
    </section>
    <!-- WELCOME END -->


    <!-- PORTFOLIO START-->
    <section class="section bg-white pb-0" id="Slider">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="text-center">
                        <h4 class="title-heading text-uppercase">slick slider</h4>
                        <p class="title-desc text-muted mt-3">This Template Is Using Slick Slider </p>
                    </div>
                </div>
            </div>
            <!-- portfolio menu -->
            <div class="row mt-4">
                <div class="col-lg-12">
                    <div class="text-center">
                        <ul class="nav container-filter" id="pills-tab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="pills-default-slider" data-toggle="pill" href="#pills-default" role="tab" aria-controls="pills-default" aria-selected="true">Default</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="pills-multi-item" data-toggle="pill" href="#pills-multi" role="tab" aria-controls="pills-multi" aria-selected="false">Multi Item</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="pills-fade-mode" data-toggle="pill" href="#pills-fade" role="tab" aria-controls="pills-fade" aria-selected="false">Fade</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="pills-slider-syncing" data-toggle="pill" href="#pills-syncing" role="tab" aria-controls="pills-syncing" aria-selected="false">Slider Syncing</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="pills-slider-autoplay" data-toggle="pill" href="#pills-autoplay" role="tab" aria-controls="pills-autoplay" aria-selected="false">Autoplay</a>
                            </li>
                        </ul>
                        <div class="tab-content mt-5 mb-5" id="pills-tabContent">
                            <div class="tab-pane fade show active" id="pills-default" role="tabpanel" aria-labelledby="pills-default-slider">
                                <div class="row slider">
                                    @for($i=1;$i<=5;$i++)
                                    <div class="col-lg-6">
                                        <!-- small box -->
                                        <div class="small-box bg-info">
                                            <div class="inner">
                                                <h3>{{$i}}</h3>
                                            </div>
                                        </div>
                                    </div>
                                    @endfor
                                </div>
                            </div>
                            <div class="tab-pane fade" id="pills-multi" role="tabpanel" aria-labelledby="pills-multi-item">
                                <div class="row slider-multi">
                                    @for($i=1;$i<=12;$i++)
                                        <div class="col-lg-6">
                                            <!-- small box -->
                                            <div class="small-box bg-info">
                                                <div class="inner">
                                                    <h3>{{$i}}</h3>
                                                </div>
                                            </div>
                                        </div>
                                    @endfor
                                </div>
                            </div>
                            <div class="tab-pane fade" id="pills-fade" role="tabpanel" aria-labelledby="pills-fade-mode">
                                <div class="row slider-fade">
                                    @for($i=1;$i<=14;$i++)
                                        <div class="col-lg-6">
                                            <!-- small box -->
                                            <div class="small-box bg-warning">
                                                <div class="inner">
                                                    <h3>{{$i}}</h3>
                                                </div>
                                            </div>
                                        </div>
                                    @endfor
                                </div>
                            </div>
                            <div class="tab-pane fade" id="pills-syncing" role="tabpanel" aria-labelledby="pills-slider-syncing">
                                <div class="row slider-syncing mb-3">
                                    @for($i=1;$i<=5;$i++)
                                        <div class="col-lg-6">
                                            <!-- small box -->
                                            <div class="small-box bg-secondary">
                                                <div class="inner">
                                                    <h3>{{$i}}</h3>
                                                </div>
                                            </div>
                                        </div>
                                    @endfor
                                </div>
                                <div class="row slider-nav">
                                    @for($i=1;$i<=5;$i++)
                                        <div class="col-lg-6">
                                            <!-- small box -->
                                            <div class="small-box bg-danger">
                                                <div class="inner">
                                                    <h3>{{$i}}</h3>
                                                </div>
                                            </div>
                                        </div>
                                    @endfor
                                </div>
                            </div>
                            <div class="tab-pane fade" id="pills-autoplay" role="tabpanel" aria-labelledby="pills-slider-autoplay">
                                <div class="row slider-autoplay">
                                    @for($i=1;$i<=5;$i++)
                                        <div class="col-lg-6">
                                            <!-- small box -->
                                            <div class="small-box bg-success">
                                                <div class="inner">
                                                    <h3>{{$i}}</h3>
                                                </div>
                                            </div>
                                        </div>
                                    @endfor
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End portfolio  -->
        </div>
    </section>
    <!-- PORTFOLIO END-->

    <!-- CLIENT START -->
    <section class="section" id="Editor">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-7">
                    <div class=" text-center">
                        <h4 class="title-heading text-uppercase">WYSIWYG Editor</h4>
                        <p class="title-desc text-muted mt-3">This Template Is Using Summernote For Text Editor</p>
                    </div>
                </div>
            </div>

            <div class="row justify-content-center mt-4">
                <div class="col-lg-8">
                    <div id="editor-demo" class="mt-4">
                        <div class="testi-box">
                            <div class="custom-editor" data-weight="300">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- CLIENT END -->

    <!-- BLOG START -->
    <section class="section bg-white" id="Popup">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-7">
                    <div class="text-center">
                        <h4 class="title-heading text-uppercase">POPUP WINDOWS </h4>
                        <p class="title-desc text-muted mt-3">This Template Is Using Bootstrap model For Popup Windows</p>
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-lg-3">
                    <div class="model-menu mt-4">
                        <h2>Default Modal</h2>
                        <!-- Button to Open the Modal -->
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
                            Open
                        </button>
                        <!-- The Modal -->
                        <div class="modal" id="myModal">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <!-- Modal Header -->
                                    <div class="modal-header">
                                        <h4 class="modal-title">Modal Heading</h4>
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>
                                    <!-- Modal body -->
                                    <div class="modal-body">
                                        Modal Body
                                    </div>
                                    <!-- Modal footer -->
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="model-menu mt-4">
                        <h2>Fading Modal</h2>
                        <!-- Button to Open the Modal -->
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#fadeModal">
                            Open
                        </button>
                        <!-- The Modal -->
                        <div class="modal fade" id="fadeModal">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <!-- Modal Header -->
                                    <div class="modal-header">
                                        <h4 class="modal-title">Modal Heading</h4>
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>
                                    <!-- Modal body -->
                                    <div class="modal-body">
                                        Fade Modal
                                    </div>
                                    <!-- Modal footer -->
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="model-menu mt-4">
                        <h2>Centered Modal</h2>
                        <!-- Button to Open the Modal -->
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#CentereModal">
                            Open
                        </button>
                        <!-- The Modal -->
                        <div class="modal fade" id="CentereModal">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <!-- Modal Header -->
                                    <div class="modal-header">
                                        <h4 class="modal-title">Modal Heading</h4>
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>
                                    <!-- Modal body -->
                                    <div class="modal-body">
                                        Modal body..
                                    </div>
                                    <!-- Modal footer -->
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="model-menu mt-4">
                        <h2>Scroll Modal</h2>
                        <!-- Button to Open the Modal -->
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#ScrollModal">
                            Open
                        </button>
                        <!-- The Modal -->
                        <div class="modal" id="ScrollModal">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <!-- Modal Header -->
                                    <div class="modal-header">
                                        <h1 class="modal-title">Modal Heading</h1>
                                        <button type="button" class="close" data-dismiss="modal">×</button>
                                    </div>
                                    <!-- Modal body -->
                                    <div class="modal-body">
                                        <h3>Some text to enable scrolling..</h3>
                                        @for($i=1;$i<=4;$i++)
                                           <p>Some text to enable scrolling..Some text to enable scrolling..Some text to enable scrolling..Some text to enable scrolling..Some text to enable scrolling..Some text to enable scrolling..Some text to enable scrolling..Some text to enable scrolling..Some text to enable scrolling..Some text to enable scrolling..Some text to enable scrolling..Some text to enable scrolling..Some text to enable scrolling..Some text to enable scrolling..Some text to enable scrolling..Some text to enable scrolling..Some text to enable scrolling..</p>
                                        @endfor
                                    </div>
                                    <!-- Modal footer -->
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- BLOG END -->

    <!-- CONTACT START -->
    <section class="section" id="Form">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-7">
                    <div class="contact-head text-center">
                        <h4 class="title-heading text-uppercase">FORM VALIDATION</h4>
                        <p class="title-desc text-muted mt-3">This Template Will Show Notifications That Form's Required Element</p>
                    </div>
                </div>
            </div>
            <div class="row mt-4 vertical-content">
                <div class="col-lg-12">
                    <div class="row mt-5">
                        <div class="col-lg-12">
                            <div class="custom-form">
                                <div id="notification-message" >
                                    <div class="alert alert-success alert-dismissible">
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                        Submit Success
                                    </div>
                                </div>
                                <form method="POST" action="" class="validation-form" name="contact-form" id="contact-form">
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label for="name">Name<span class="required-text">*</span></label>
                                                <input name="name" id="name" type="text" class="form-control form-required" placeholder="Your name...">
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label for="email">Email<span class="required-text">*</span></label>
                                                <input name="email" id="email" type="email" class="form-control form-required" placeholder="Your email...">
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label for="sex">SEX<span class="required-text">*</span></label>
                                                <select name="sex" id="sex" class="form-control form-required">
                                                    <option value="">Select</option>
                                                    <option value="1" >Male</option>
                                                    <option value="2" >Female</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label for="subject">Subject<span class="required-text">*</span></label>
                                                <input name="subject" id="subject" type="text" class="form-control form-required" placeholder="Your subject...">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label for="comments">Comments</label>
                                                <textarea name="comments" id="comments" rows="4" class="form-control " placeholder="Your message..."></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-lg-12">
                                            <input type="submit" id="submit" name="send" class="submitBnt btn btn-custom" value="Send Message">
                                            <div id="simple-msg">
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- CONTACT END -->
@endsection
