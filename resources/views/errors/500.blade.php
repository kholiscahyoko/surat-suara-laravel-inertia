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
    <body class="min-h-full">
        <div class="flex flex-col min-h-screen justify-between">
            <div class="mt-20 p-4">
                <div class="text-xl text-center">
                    <h1 class="text-6xl font-bold"><span>5</span><span>0</span><span>0</span></h1>
                    <h2 class="mt-4">Terjadi kesalahan, silakan coba beberapa saat lagi</h2>
                </div>
            </div>
        </div>
    </body>
</html>