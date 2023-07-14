<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">

        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        
        <title>{{ config('app.name', 'Laravel') }}</title>
        
        <meta name="twitter:card" content="summary_large_image" />
        <meta name="twitter:site" content="@icae.polibatam" />
        <meta name="description" content="The 6TH International Conference On Applied Engineerring (ICAE)">
        <meta name="keywords" content="Conference, Journal, Mechanical Sciences, Transportation Systems, IoT Devices, Real-Time Data Communications, AI, AR, VR, Blockchain">
        <meta name="author" content="ICAE Polibatam" />
        <meta image="{{ asset('img/logo_wh.jpg') }}">
        <meta property="og:type" content="article">
        <meta property="og:image" content="{{ asset('img/logo_wh.jpg') }}">
        <meta property="og:title" content="The 6TH International Conference On Applied Engineerring (ICAE)">
        <meta property="og:site_name" content="Polibatam Cyber Team">
        <meta property="og:url" content="{{ route('home') }}">
        <meta property="og:description" content="The 6TH International Conference On Applied Engineerring (ICAE)">
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link rel="icon" type="image/png" href="{{ asset('favicon.ico') }}" />
        <link rel="apple-touch-icon" href="{{ asset('logo/apple-touch-icon.png') }}">
        <link rel="canonical" href="{{{ route('home') }}}">
        <!-- Scripts -->
        <link rel="stylesheet" href="{{ mix('css/app.css') }}">
        <link rel="stylesheet" href="https://unpkg.com/flowbite@1.5.1/dist/flowbite.min.css" />

        @livewireStyles

        <!-- Scripts -->
        <script src="{{ mix('js/app.js') }}" defer></script>
        <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
        
        
        
        <!-- Styles -->
        @livewireStyles
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100 pb-32">
            @livewire('navigation-menu')

            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>

        <x-footer/>

        @stack('modals')

        @livewireScripts

        <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

        <script>
            AOS.init();
        </script>
    </body>

    
    
</html>
