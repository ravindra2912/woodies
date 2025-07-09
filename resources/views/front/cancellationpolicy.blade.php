@extends('front.layouts.index', ['seo' => [
'title' => 'Cancellation policy',
'description' => 'Cancellation policy',
'keywords' => 'Cancellation policy' ,
'image' => config('const.site_setting.logo') ,
'city' => '',
'state' => '',
'position' => ''
]
])

@section('content')

	<section id="nevigation-header">
		<h3>Cancellation policy</h3>
		<p>Home <i class="fa-solid fa-angle-right"></i> Cancellation policy</p>
	</section>
  
  <section id="about" class="mt-5 mb-5 pb-5">
		<div class="container">
		{!! getLagelage('CancellationPolicy')  !!}
		</div>
	</section>
	
	
  
	

@endsection



