<!DOCTYPE html>
<html class="h-full bg-gray-100" lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
    @isset($meta)
    {!! $meta->generate() !!}
    @endisset
    @vite(['resources/js/app.js', 'resources/css/app.css', 'resources/css/nprogress.css'])
    @inertiaHead
  </head>
  <body class="min-h-full">
    @inertia
  </body>
</html>