@extends('front.layouts.index', ['seo' => [
'title' => 'Copy right',
'description' => 'Copy right',
'keywords' => 'Copy right' ,
'image' => config('const.site_setting.logo') ,
'city' => '',
'state' => '',
'position' => ''
]
])

@section('content')

	<section id="nevigation-header">
		<h3>Copy right</h3>
		<p>Home <i class="fa-solid fa-angle-right"></i> Copy right</p>
	</section>
  
  <section id="about" class="mt-5 mb-5 pb-5">
		<div class="container">
		{!! getLagelage('CopyRight')  !!}
		</div>
	</section>
	
	
  
	

@endsection



