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
    </head>
    <body class="min-h-full bg-blue-800 flex justify-center">
        <a href="https://www.google.com/search?q=peringatan+darurat" target="_blank" rel="noopener noreferrer">
            <div class="md:w-80 w-full pt-20">
                <img src="{{ asset('assets/img/garuda-pancasila-removed.webp') }}" alt="">
            </div>
            <div class="text-2xl text-white text-center mt-2 font-mono">Cari Tahu Disini</div>
        </a>
        <script>
            setTimeout(function(){
            window.location.reload();
            }, 10000);
        </script>
    </body>
</html>