@extends('front.layouts.index', ['seo' => [
'title' => 'About us',
'description' => 'About us',
'keywords' => 'About us' ,
'image' => config('const.site_setting.logo') ,
'city' => '',
'state' => '',
'position' => ''
]
])


@section('content')

	<section id="nevigation-header">
		<h3>About us</h3>
		<p>Home <i class="fa-solid fa-angle-right"></i> About us</p>
	</section>
  
  <section id="about" class="mt-5 mb-5 pb-5">
		<div class="container">
			{!! getLagelage('AboutUs')  !!}
		</div>
	</section>
	
	
  
	

@endsection



