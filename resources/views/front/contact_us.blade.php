@extends('front.layouts.index', ['seo' => [
'title' => 'Contact Us',
'description' => 'Contact Us',
'keywords' => 'Contact Us' ,
'image' => config('const.site_setting.logo') ,
'city' => '',
'state' => '',
'position' => ''
]
])

<style>

</style>
@section('content')

<section id="nevigation-header">
	<h3>Contact Us</h3>
	<p>Home <i class="fa-solid fa-angle-right"></i> Contact Us</p>
</section>

<section id="contactus" class="mt-5 mb-5 pb-5">
	<div class="container">
		<div class="text-center">
			<p class="text-primary h5">NEED HELP?</p>
			<p class="h3 font-weight-bold">Haven’t found what you’re<br> looking for? Contact us</p>
		</div>

		<div class="mt-5">
			<iframe src="{{ config('const.footer.contact.map') }}" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
		</div>

		<div class="row mt-5">
			<div class="col-lg-5 col-md-5 col-12">
				<div class="row mb-4 mt-5">
					<div class="col-12">
						<p class="font-weight-bold mb-1 h5">Address</p>
						<p class="mb-0">{{ config('const.footer.contact.address') }}</p>
					</div>
				</div>
				<div class="row mb-4">
					
					<div class="col-12">
						<p class="font-weight-bold mb-1 h5">Contact</p>
						<p class="mb-0">Phone: {{ config('const.footer.contact.contact') }}</p>
						<p class="mb-0">Email: {{ config('const.footer.contact.email') }}</p>
					</div>
				</div>

			</div>
			<div class="col-lg-7 col-md-7 col-12">
				<p class="h4 font-weight-bold">Get in touch</p>
				<p class="pl-2">Your email address will not be published. Required fields are marked*</p>
				<form action="{{ route('ContactUs') }}" id="contact_form" class="row">{{ csrf_field() }}

					<div class="form-group col-lg-6 col-md-6 col-12">
						<input type="text" name="name" class="form-control" placeholder="Your name *">
					</div>

					<div class="form-group col-lg-6 col-md-6 col-12">
						<input type="email" name="email" class="form-control" placeholder="Your Email *">
					</div>

					<div class="form-group col-lg-6 col-md-6 col-12">
						<input type="number" name="phone" class="form-control" placeholder="Your Phone *">
					</div>

					<div class="form-group col-lg-6 col-md-6 col-12">
						<select class="form-control" name="subject">
							<option value="">Select Subject *</option>
							@foreach (config('const.contactus_type') as $type)
							<option value="{{ $type }}">{{ $type }}</option>
							@endforeach
						</select>
					</div>

					<div class="form-group col-lg-6 col-md-6 col-12">
						<input type="text" name="website" class="form-control" placeholder="Website">
					</div>
					<div class="form-group col-lg-12 col-md-12 col-12">
						<textarea class="form-control" placeholder="Write your messege here *" rows="7" name="messege"></textarea>
					</div>



					<button type="submit" class="btn btn-primary btn-round mt-3 ml-3 submit_button">Submit Now</button>
					<button type="button" class="btn btn-primary btn-round mt-3 ml-3 submit_button loading" style="display:none;">Loading ...</button>
				</form>

			</div>

		</div>
	</div>
</section>



@endsection

@section('custom_js')
<script>
	$("document").ready(function() {
		$("#contact_form").on('submit', (function(e) {
			e.preventDefault();
			var form = this;
			$.ajax({
				url: this.action,
				type: "POST",
				data: new FormData(this),
				dataType: "json",
				headers: {
					'X-CSRF-TOKEN': "{{ csrf_token() }}"
				},
				contentType: false,
				cache: false,
				processData: false,
				beforeSend: function() {
					$('.submit_button').hide();
					$('.loading').show();
				},
				success: function(result) {
					//console.log(data);

					if (result.success) {
						toastr.success(result.message);
						form.reset();
					} else {
						toastr.error(result.message);
					}
					$('.submit_button').show();
					$('.loading').hide();
				},
				error: function(e) {
					toastr.error('Somthing Wrong');
					console.log(e);
					$('.submit_button').show();
					$('.loading').hide();
				}
			});
		}));
	});
</script>

@endsection