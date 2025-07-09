@extends('front.layouts.index', ['seo' => [
'title' => 'Refund policy',
'description' => 'Refund policy',
'keywords' => 'Refund policy' ,
'image' => config('const.site_setting.logo') ,
'city' => '',
'state' => '',
'position' => ''
]
])

@section('content')

	<section id="nevigation-header">
		<h3>Refund policy</h3>
		<p>Home <i class="fa-solid fa-angle-right"></i> Refund policy</p>
	</section>
  
  <section id="about" class="mt-5 mb-5 pb-5">
		<div class="container">
		{!! getLagelage('RefundPolicy')  !!}
		</div>
	</section>
	
	
  
	

@endsection



