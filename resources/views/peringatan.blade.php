<!DOCTYPE html>
<html class="h-full bg-gray-100" lang="id">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
        @isset($meta)
        {!! $meta->generate() !!}
        @endisset
        <meta name="robots" content="noindex, nofollow" />
        @vite(['resources/css/app.css'])
        <!-- Favicon Links -->
        <link rel="icon" type="image/webp" sizes="192x192" href="{{ asset('assets/img/favicon_io/android-chrome-192x192.webp') }}">
        <link rel="icon" type="image/webp" sizes="512x512" href="{{ asset('assets/img/favicon_io/android-chrome-512x512.webp') }}">
        <link rel="apple-touch-icon" href="{{ asset('assets/img/favicon_io/apple-touch-icon.webp') }}">
        <link rel="icon" type="image/webp" sizes="32x32" href="{{ asset('assets/img/favicon_io/favicon-32x32.webp') }}">
        <link rel="icon" type="image/webp" sizes="16x16" href="{{ asset('assets/img/favicon_io/favicon-16x16.webp') }}">
        <link rel="shortcut icon" href="{{ asset('assets/img/favicon_io/favicon.ico') }}" type="image/x-icon">
        <link rel="manifest" href="{{ asset('assets/img/favicon_io/site.webmanifest') }}">

        <!-- Google tag (gtag.js) -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=G-CH7DT4270T"></script>

        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());

            gtag('config', 'G-CH7DT4270T');
        </script>

    </head>
    <body class="min-h-full bg-blue-800 flex justify-center">
        <div class="md:w-80 w-full pt-10 md:text-2xl text-xl text-white font-mono text-center">
            <div class="font-light -tracking-tighter animate-pulse">PERINGATAN DARURAT</div>
            <img class="w-40 mx-auto mt-5" src="{{ asset('assets/img/garuda-pancasila_500x542.webp') }}" alt="peringatan darurat pancasila">
            <a href="https://www.google.com/search?q=peringatan+darurat" target="_blank" rel="noopener noreferrer" class="border-2 rounded-md mt-5 p-2 block">
                Cari Tahu Disini
            </a>
            <a href="/" class="border-2 rounded-md mt-5 p-2 block">
                Muat Halaman Utama
            </a>
        </div>
        <script>
            // setTimeout(function(){
            // window.location.reload();
            // }, 10000);
        </script>
    </body>
</html>