<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8"/>
        <title> @yield('title') </title>
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="description" content="Responsive, Bootstrap, BS4"/>
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimal-ui"/>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <!-- for ios 7 style, multi-resolution icon of 152x152 -->
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-status-barstyle" content="black-translucent">
        <link rel="apple-touch-icon" href="{{ url('admin-assets/images/logo.png') }}">
        <meta name="apple-mobile-web-app-title" content="Flatkit">
        <!-- for Chrome on Android, multi-resolution icon of 196x196 -->
        <meta name="mobile-web-app-capable" content="yes">
        <x-header-links />
    </head>
    <x-sidebar>
        @isset($header)
            <x-slot name="header">
                {{ $header }}
            </x-slot>
        @endisset
    </x-sidebar>
    {{ $slot }}
    <style>
        #loader {
            display: none ;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }

        .loader {
            border: 16px solid #f3f3f3; /* Light gray */
            border-top: 16px solid #3498db; /* Blue */
            border-radius: 50%;
            width: 120px;
            height: 120px;
            animation: spin 2s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
    <div id="loader">
        <div class="loader"></div>
    </div>
    <x-footer />
</html>
