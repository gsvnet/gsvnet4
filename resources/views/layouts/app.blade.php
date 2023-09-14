<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">

        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}" defer></script>
    </head>
    <body x-data="{ darkMode: false }" x-init="
    if (!('darkMode' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches) {
      localStorage.setItem('darkMode', JSON.stringify(true));
    }
    darkMode = JSON.parse(localStorage.getItem('darkMode'));
    $watch('darkMode', value => localStorage.setItem('darkMode', JSON.stringify(value)))" x-cloak>
        <div x-bind:class="{'dark' : darkMode === true}" class="min-h-screen">
            <div class="dark:bg-[#161616] bg-[#d9e0e1] min-h-screen">
                @include('layouts.searchbar')
                @include('layouts.navigation')


                @if ($message = session('success'))
                    <x-flash-message>
                        {{ $message }}
                    </x-flash-message>
                @endif

                @if ($errors->any())
                    <x-flash-message class="bg-red-600">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </x-flash-message>
                @endif

                <!-- Page Content -->
                <!-- Take Distance from nav + searchbar 6rem==logo+mt+pt -->
                <main class="pt-24 pl-52 pb-6 scroll-smooth">
                    @yield('content')
                </main>
            </div>
        </div>
    </body>
</html>
