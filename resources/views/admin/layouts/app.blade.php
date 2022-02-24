<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="shortcut icon" href="{{url('/storage/image/favicon.ico')}}">
        @include('admin.component.title')
        @stack('admin-app-head-scripts')
        @section('admin-app-styles')
            <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.16/dist/summernote-bs4.min.css" rel="stylesheet">
            <link rel="dns-prefetch" href="//fonts.gstatic.com">
            <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
            <link href="{{ asset('css/admin/admin.css') }}" rel="stylesheet">
        @show
        @stack('admin-app-styles')
    </head>
    <body>
        <div id="app" class="wrapper">
            @include('admin.component.header')
            @include('admin.component.sidebar-menu')
            <div class="content-wrapper">
                @if (\Session::has('message'))
                    <div class="alert alert-success alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        {!! \Session::get('message') !!}
                    </div>
                @endif
                @if (\Session::has('error'))
                        <div class="alert alert-danger alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            {!! \Session::get('error') !!}
                        </div>
                @endif
                @yield('admin-page-content')
            </div>
            @include('admin.component.footer')
        </div>
        @section('admin-app-scripts')
            <script src="{{ asset('js/admin/admin.js') }}"></script>
            <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.16/dist/summernote-bs4.min.js"></script>
            <script src="{{ asset('js/admin/app.js') }}"></script>
        @show
        @stack('admin-app-scripts')
    </body>
</html>
