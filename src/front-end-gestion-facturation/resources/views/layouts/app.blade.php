<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
        <link rel="stylesheet" href="{{ asset('fontawesome/fontawesome-free/css/all.min.css') }}">

        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}" defer></script>
        {{-- <script src="https://unpkg.com/vue@next"></script> --}}
        <script src="{{ asset('js/vue3.js') }}"></script>
        <script src="https://cdn.jsdelivr.net/npm/js-cookie@3.0.0/dist/js.cookie.min.js"></script>
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            @include('layouts.navigation')

            <!-- Page Heading -->



            <header class="shadow bg-blue-500">
                <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8 ">
                    {{ $header }}
                </div>
            </header>



            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>
        {{-- <script src="{{ asset('js/facture.js') }}"></script> --}}
    </body>
</html>
