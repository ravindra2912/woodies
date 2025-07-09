@extends('front.layouts.index', ['seo' => [
'title' => 'Privacy Policy',
'description' => 'Privacy Policy',
'keywords' => 'Privacy Policy' ,
'image' => config('const.site_setting.logo') ,
'city' => '',
'state' => '',
'position' => ''
]
])

@section('content')

	<section id="nevigation-header">
		<h3>Privacy Policy</h3>
		<p>Home <i class="fa-solid fa-angle-right"></i> Privacy Policy</p>
	</section>
  
  <section id="about" class="mt-5 mb-5 pb-5">
		<div class="container">
			{!! getLagelage('PrivacyPolicy')  !!}
		</div>
	</section>
	
	
  
	

@endsection



