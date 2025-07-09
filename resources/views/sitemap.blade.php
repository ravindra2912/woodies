<?xml version="1.0" encoding="UTF-8"?>
@php $date = gmdate('Y-m-d\TH:i:s\Z'); @endphp
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
   <url>
      <loc>{{ url('/') }}</loc>
      <lastmod>{{ $date }}</lastmod>
      <changefreq>daily</changefreq>
      <priority>1.0</priority>
   </url>
   <url>
      <loc>{{ url('/AboutUs') }}</loc>
      <lastmod>{{ $date }}</lastmod>
      <changefreq>daily</changefreq>
      <priority>0.9</priority>
   </url>
   <url>
      <loc>{{ url('/ContactUs') }}</loc>
      <lastmod>{{ $date }}</lastmod>
      <changefreq>daily</changefreq>
      <priority>0.9</priority>
   </url>
   <url>
      <loc>{{ url('/collections') }}</loc>
      <lastmod>{{ $date }}</lastmod>
      <changefreq>daily</changefreq>
      <priority>0.9</priority>
   </url>
   @foreach($product as $val)
		<url>
		  <loc>{{ url('/products/'. $val->slug) }}</loc>
		  <lastmod>{{ $date }}</lastmod>
		  <changefreq>daily</changefreq>
		  <priority>0.8</priority>
	   </url>
   @endforeach
   @foreach($Category as $val)
		<url>
		  <loc>{{ url('/collections/'. $val->slug) }}</loc>
		  <lastmod>{{ $date }}</lastmod>
		  <changefreq>daily</changefreq>
		  <priority>0.7</priority>
	   </url>
   @endforeach
</urlset> 