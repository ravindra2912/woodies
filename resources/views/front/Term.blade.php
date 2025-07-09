@extends('front.layouts.index', ['seo' => [
'title' => 'Term and Conditions',
'description' => 'Term and Conditions',
'keywords' => 'Term and Conditions' ,
'image' => config('const.site_setting.logo') ,
'city' => '',
'state' => '',
'position' => ''
]
])

@section('content')

	<section id="nevigation-header">
		<h3>Term and Conditions</h3>
		<p>Home <i class="fa-solid fa-angle-right"></i> Term and Conditions</p>
	</section>
  
  <section id="about" class="mt-5 mb-5 pb-5">
		<div class="container">
		{!! getLagelage('TermsAndCondition')  !!}
		</div>
	</section>
	
	
  
	

@endsection



