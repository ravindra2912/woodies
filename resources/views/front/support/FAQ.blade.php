@extends('front.layouts.index', ['seo' => [
'title' => 'FAQs',
'description' => 'FAQs',
'keywords' => 'FAQs' ,
'image' => config('const.site_setting.logo') ,
'city' => '',
'state' => '',
'position' => ''
]
])

@section('custom_css')
<style>
	.accordion-section .panel-default .panel-title a {
		display: block;
		color: black;
	}

	.accordion-section .panel-default .panel-title a:after {
		font-family: 'FontAwesome';
		font-style: normal;
		font-size: 1.5rem;
		content: "\f106";
		color: black;
		float: left;
		margin-top: -7px;
		margin-right: 10px;
	}

	.accordion-section .panel-default .panel-title a.collapsed:after {
		content: "\f107";
	}

	.accordion-section .panel-default .panel-body {
		font-size: 1.2rem;
	}


	.side-item {
		background: var(--primary);
		border-radius: 5px;
		text-align: center;
		margin-bottom: 4px;
	}

	.side-item a {
		color: white;
	}
</style>
@endsection

@section('content')

<section id="nevigation-header">
	<h3>FAQs</h3>
	<p>Home <i class="fa-solid fa-angle-right"></i> FAQs</p>
</section>

<section id="about" class="mt-5 mb-5 pb-5">
	<div class="container">
		<div class="row">
			<div class="col-lg-12 col-md-12 col-12 text-center">
				<p class="h3 font-weight-bold">Frequently Asked Questions</p>
				<p>Mation ullamco laboris nisi ut aliquip exea core dolor in reprehender fugiat nulla pariatur.</p>
			</div>

			<div class="col-lg-12 col-md-12 col-12 mt-4">

				<div class="row">

					<!-- Tab panels -->
					<div class="tab-content vertical">
						<!-- Panel 1 -->
						<div class="tab-pane fade active show" id="panel21" role="tabpanel">
							<div class="accordion-section clearfix mt-0" aria-label="Question Accordions">

								<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">

									@foreach (getFaqs() as $faq)

									<div class="panel panel-default">
										<div class="panel-heading p-3 mb-1" role="tab" id="heading{{ $faq->id }}">
											<div class="panel-title">
												<a class="collapsed" role="button" title="" data-toggle="collapse" data-parent="#accordion" href="#collapse{{ $faq->id }}" aria-expanded="true" aria-controls="collapse{{ $faq->id }}">
												{{ $faq->question }}
												</a>
											</div>
										</div>
										<div id="collapse{{ $faq->id }}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading{{ $faq->id }}">
											<div class="panel-body px-3 mb-4">
												<p>{{ $faq->answer }}</p>
											</div>
										</div>
									</div>

									@endforeach


								</div>

							</div>
						</div>
						<!-- Panel 1 -->

					</div>
				</div>

			</div>
			<div class="col-lg-6 col-md-6 col-12">

			</div>

		</div>

	</div>
</section>



@endsection