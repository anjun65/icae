<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>ICAE Polibatam</title>

        <link rel="icon" type="image/x-icon" href="img/favicon.ico">

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

        <link rel="stylesheet" href="https://unpkg.com/flowbite@1.5.1/dist/flowbite.min.css" />
        <!-- Styles -->
        <link rel="stylesheet" href="{{ mix('css/app.css') }}">

        <!-- Scripts -->
        <script src="{{ mix('js/app.js') }}" defer></script>
    </head>
    <body>
        <x-guest-menu></x-guest-menu>
        <div class="font-sans text-gray-900 antialiased">
            {{ $slot }}
        </div>

        <div style="border-radius: 50%;bottom: 0px;color: #979797;cursor: pointer;height: auto;position: fixed;text-align: center;width: 4rem;right:0px;z-index: 9;display: block;padding:0px 0px 5px 0">
          <a href="https://wa.me/6283821557379">
            <img src="img/whatsapp.png" alt="">
          </a>
        </div>
    </body>

    <x-footer></x-footer>
    @stack('addon-scripts')
</html>
