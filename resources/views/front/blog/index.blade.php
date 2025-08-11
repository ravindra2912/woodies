@extends('front.layouts.index', ['seo' => [
'title' => 'Blogs',
'description' => 'Blogs',
'keywords' => 'Blogs' ,
'image' => config('const.site_setting.logo') ,
'city' => '',
'state' => '',
'position' => ''
]
])


@section('content')

<section id="nevigation-header">
	<h3>Blogs</h3>
	<p>Home <i class="fa-solid fa-angle-right"></i> Blogs</p>
</section>

<section id="blogs" class="mt-5 mb-5 pb-5">
	<div class="container">
		<div class="row">
			@foreach ($blogs as $blog)
			<a href="{{ route('blogs.details', ['slug' => $blog->slug]) }}" class="col-md-3 col-12">
				<div class="img-section" style="background: {{ $blog->background_color }};">
					<img src="{{ getImage($blog->image) }}" class="blog-img" />
				</div>
				<h4 class="mt-3">{{ $blog->title }}</h4>
				<p class="text-muted">{{ get_date($blog->created_at, 'd M Y') }}</p>
			</a>
			@endforeach
		</div>
	</div>
</section>





@endsection