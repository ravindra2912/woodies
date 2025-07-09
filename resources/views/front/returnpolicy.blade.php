@extends('front.layouts.index', ['seo' => [
'title' => 'Return policy',
'description' => 'Return policy',
'keywords' => 'Return policy' ,
'image' => config('const.site_setting.logo') ,
'city' => '',
'state' => '',
'position' => ''
]
])

@section('content')

	<section id="nevigation-header">
		<h3>Return policy</h3>
		<p>Home <i class="fa-solid fa-angle-right"></i> Return policy</p>
	</section>
  
  <section id="about" class="mt-5 mb-5 pb-5">
		<div class="container">
		{!! getLagelage('ReturnPolicy')  !!}
		</div>
	</section>
	
	
  
	

@endsection



