@extends('front.layouts.index', ['seo' => [
'title' => 'Shipping policy',
'description' => 'Shipping policy',
'keywords' => 'Shipping policy' ,
'image' => config('const.site_setting.logo') ,
'city' => '',
'state' => '',
'position' => ''
]
])

@section('content')

	<section id="nevigation-header">
		<h3>Shipping policy</h3>
		<p>Home <i class="fa-solid fa-angle-right"></i> Shipping policy</p>
	</section>
  
  <section id="about" class="mt-5 mb-5 pb-5">
		<div class="container">
		{!! getLagelage('ShippingPolicy')  !!}
		</div>
	</section>
	
	
  
	

@endsection



