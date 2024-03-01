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
                    <h1 class="text-6xl font-bold"><span>4</span><span>0</span><span>4</span></h1>
                    <h2 class="mt-4">Mohon Maaf, halaman tidak tersedia atau URL yang Anda inputkan salah.</h2>
                </div>
                <div class="flex justify-center my-4 space-x-3 font-medium">
                    <a href="/wilayah" class="text-indigo-600 hover:text-indigo-800">Cari Wilayah</a>
                    <a href="/dapil" class="text-indigo-600 hover:text-indigo-800">Cari Dapil</a>
                    <a href="/calon" class="text-indigo-600 hover:text-indigo-800">Cari Calon</a>
                </div>
                <div class="items-center flex justify-center">
                    <a href="/" class="text-center text-lg lg:text-xl p-2 align-middle bg-blue-600 font-semibold text-white rounded-lg transition ease-in-out delay-150 hover:-translate-y-1 hover:scale-105 duration-300 cursor-pointer">Kembali Ke Halaman Utama</a>
                </div>
            </div>
        </div>
    </body>
</html>