@extends('seller.layouts.index')

@section('custom_css')
<link rel="stylesheet" href="{{ asset('admin_theme/plugins/summernote/summernote-bs4.min.css') }}">
@endsection

@section('content')
<div class="content-wrapper">
	<section class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
				</div>
			</div>
		</div>
	</section>
	<section class="content">
		<div class="container-fluid">
			<div class="row">
				<div class="col-12">
					<div class="card card-primary">
						<div class="card-header">
							<h3 class="card-title">Add Blog</h3>
						</div>
						<form action="{{ route('blog.store') }}" id="addblogform" class="formaction" data-action="redirect">
							@csrf
							<div class="card-body row">
								<div class="form-group col-md-4 col-12">
									<label class="required">image</label>
									<input type="file" name="blog_image" class="form-control required" placeholder="Category Image" accept=".jpg, .jpeg, .png, .svg, .webp">
								</div>

								<div class="form-group col-md-4 col-12">
									<label class="required">Title</label>
									<input type="text" name="title" class="form-control required" placeholder="Title">
								</div>
								
								<div class="form-group col-md-4 col-12">
									<label class="required">Background color</label>
									<input type="color" name="background_color" class="form-control" placeholder="Background color">
								</div>

								<div class="form-group col-12">
									<label class="required">Description</label>
									<textarea name="description" id="description" class="form-control required"></textarea>
								</div>
							</div>

							<div class="card-footer">
								<div class="col-sm-12 text-right">
									<button class="btn btn-danger" type="button" onclick="history.back()">Back</button>
									<button class="btn btn-primary btn_action" type="submit">
										<span id="loader" class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
										<span id="buttonText">Submit</span>
									</button>

								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>
@endsection

@section('custom_js')
<script src="{{ asset('admin_theme/plugins/summernote/summernote-bs4.min.js') }}"></script>
<script type="text/javascript">
	$(function() {
		// Summernote
		$('#description').summernote({
			height: 350, // set editor height
			minHeight: 100, // set minimum height
			maxHeight: 400, // set maximum height
			// focus: true, // focus editor after load
			placeholder: 'Write your description here...',
			// toolbar: [
			// 	['style', ['bold', 'italic', 'underline']],
			// 	['para', ['ul', 'ol', 'paragraph']],
			// 	['insert', ['link', 'picture', 'video']]
			// ]
		});
	})
</script>
@endsection