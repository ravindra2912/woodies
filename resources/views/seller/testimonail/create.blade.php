@extends('seller.layouts.index')

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
				<div class="col-md-3 col-sm-1"></div>
				<div class="col-md-6 col-sm-10">
					<div class="card card-primary">
						<div class="card-header">
							<h3 class="card-title">Add testimonail</h3>
						</div>
						<form action="{{ route('testimonail.store') }}" id="addproductform" class="formaction" data-action="redirect">
							@csrf
							<div class="card-body">
								<div class="form-group">
									<label class="required">Name</label>
									<input type="text" name="name" id="name" class="form-control required" placeholder="Name">
								</div>

								<div class="form-group">
									<label class="required">Description</label>
									<input type="text" name="description" id="description" class="form-control required" placeholder="Description">
								</div>

								<div class="form-group">
									<label class="required">Youtube link(embedded)</label>
									<input type="text" name="video_link" id="video_link" class="form-control required" placeholder="link">
								</div>

								<div class="form-group">
									<label class="required">Thumbnail image</label>
									<input type="file" name="thumbnail_image" id="thumbnail_image" class="form-control required" placeholder="Category Image" accept=".jpg, .jpeg, .png, .svg, .webp">
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
				<div class="col-md-3 col-sm-1"></div>
			</div>
		</div>
	</section>
</div>
@endsection

@section('custom_js')
<script type="text/javascript">
	$("document").ready(function() {
		
	});
</script>
@endsection