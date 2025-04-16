<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8"/>
        <title>Signin | CMS - {{ env('APP_NAME') }}</title>
        <meta name="description" content="Responsive, Bootstrap, BS4"/>
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimal-ui"/>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <!-- for ios 7 style, multi-resolution icon of 152x152 -->
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-status-barstyle" content="black-translucent">
        <link rel="apple-touch-icon" href="{{ url('admin-assets/images/logo.svg')}}">
        <meta name="apple-mobile-web-app-title" content="Flatkit">
        <!-- for Chrome on Android, multi-resolution icon of 196x196 -->
        <meta name="mobile-web-app-capable" content="yes">
        <link rel="shortcut icon" sizes="196x196" href="{{ url('admin-assets/images/logo.svg')}}">
        <!-- style -->
        <link rel="stylesheet" href="{{ url('admin-assets/libs/font-awesome/css/font-awesome.min.css')}}"
            type="text/css"/>
        <!-- build:css ../assets/css/app.min.css -->
        <link rel="stylesheet" href="{{ url('admin-assets/libs/bootstrap/dist/css/bootstrap.min.css')}}"
            type="text/css"/>
        <link rel="stylesheet" href="{{ url('admin-assets/css/app.css')}}" type="text/css"/>
        <link rel="stylesheet" href="{{ url('admin-assets/css/style.css')}}" type="text/css"/>
        <!-- endbuild -->
    </head>
    <body>
        <div class="d-flex flex-column flex">
            <div class="navbar dark bg pos-rlt box-shadow">
                <div class="mx-auto">
                    <!-- brand -->
                    <a href="#." class="navbar-brand">

                        <img src="{{ url('admin-assets/logo.png') }}"
                             alt="{{ env('APP_NAME') }}">

                    </a>
                    <!-- / brand -->
                </div>
            </div>
            <div id="content-body">
                <div class="py-5 w-100">
                    <div class="mx-auto w-xxl w-auto-xs">
                        <div class="px-3">
                            {{ $slot }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <!-- jQuery -->

<!-- Bootstrap -->
<script src="{{ url('admin-assets/libs/popper.js/dist/umd/popper.min.js') }}"></script>
<script src="{{ url('admin-assets/libs/bootstrap/dist/js/bootstrap.min.js') }}"></script>
<!-- core -->
<script src="{{ url('admin-assets/js/nav.js') }}"></script>
<script src="{{ url('admin-assets/js/scrollto.js') }}"></script>
<script src="{{ url('admin-assets/js/theme.js') }}"></script>
<script src="{{ url('admin-assets/js/app.js') }}"></script>
<!-- endbuild -->
    </body>
</html>
