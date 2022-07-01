<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', '百舸') }}</title>
    <link rel="icon" href="{{asset('logo.svg')}}" type="svg" sizes="any" />
    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/alpine.js') }}" defer></script>
</head>

<body class="bg-gray-100 font-family-karla flex">
    @include('dashboard.menu-desktop')
    <div class="w-full flex flex-col h-screen overflow-y-hidden">
        @include('dashboard.header')
        @include('dashboard.menu-mobile')
        <div class="w-full overflow-x-hidden border-t flex flex-col p-10 pb-0 mb-14">
            <main class="h-full">
                {{ $slot }}
            </main>
            
        </div>
        <footer class="fixed  w-full bottom-0 bg-gradient-to-r from-blue-700 via-blue-600 to-teal-600  py-4">
            <p class="text-center text-white">本程序由 <a target="_blank" href="https://github.com/gezhi-io" >gezhi.io</a> 创建.</p>
            
        </footer>
    </div>
    
</body>
@include('dashboard.stack')
</html>
