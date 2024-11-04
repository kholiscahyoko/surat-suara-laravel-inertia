<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:image="http://www.google.com/schemas/sitemap-image/1.1">
@foreach($urls as $url)
<url>
<loc>{{ $url['loc'] }}</loc>
@isset($url['lastmod'])
<lastmod>{{ $url['lastmod'] }}</lastmod>
@endisset
@isset($url['changefreq'])
<changefreq>{{ $url['changefreq'] }}</changefreq>
@endisset
@isset($url['priority'])
<priority>{{ $url['priority'] }}</priority>
@endisset
@isset($url['image_loc'])
@if($url['image_loc'])
<image:image>
<image:loc>{{ $url['image_loc'] }}</image:loc>
</image:image>
@endif
@endisset
</url>
@endforeach
</urlset>
