<!DOCTYPE html>
<html class="h-full bg-gray-100" lang="id">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
    @isset($meta)
    {!! $meta->generate() !!}
    @endisset
    @vite(['resources/js/app.js', 'resources/css/app.css', 'resources/css/nprogress.css'])
    @inertiaHead
    <!-- Favicon Links -->
    <link rel="icon" type="image/webp" sizes="192x192" href="{{ asset('assets/img/favicon_io/android-chrome-192x192.webp') }}">
    <link rel="icon" type="image/webp" sizes="512x512" href="{{ asset('assets/img/favicon_io/android-chrome-512x512.webp') }}">
    <link rel="apple-touch-icon" href="{{ asset('assets/img/favicon_io/apple-touch-icon.webp') }}">
    <link rel="icon" type="image/webp" sizes="32x32" href="{{ asset('assets/img/favicon_io/favicon-32x32.webp') }}">
    <link rel="icon" type="image/webp" sizes="16x16" href="{{ asset('assets/img/favicon_io/favicon-16x16.webp') }}">
    <link rel="shortcut icon" href="{{ asset('assets/img/favicon_io/favicon.ico') }}" type="image/x-icon">
    <link rel="manifest" href="{{ asset('assets/img/favicon_io/site.webmanifest') }}">

    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-3686539766588397"
     crossorigin="anonymous"></script>
     <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-CH7DT4270T"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());

      gtag('config', 'G-CH7DT4270T');
    </script>
  </head>
  <body class="min-h-full">
    @inertia
  </body>
</html>