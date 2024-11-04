<?xml version="1.0" encoding="UTF-8"?>
<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
@foreach($urls as $url)
<sitemap>
<loc>{{ $url['loc'] }}</loc>
@isset($url['lastmod'])
<lastmod>{{ $url['lastmod'] }}</lastmod>
@endisset
</sitemap>
@endforeach
</sitemapindex>