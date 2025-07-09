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
							<h3 class="card-title">Add Main Category</h3>
						</div>
						<form method="POST" id="category_form" enctype="multipart/form-data">{{ csrf_field() }}
							<div class="card-body">

								<div class="form-group">
									<label class="required">Category Name</label>
									<select name="parent_id" class="form-control">
										<option value="">Select Perent Categoty</option>
										@foreach ($categoryLists as $cat)
										<option value="{{ $cat->id }}">{{ $cat->name }}</option>
										@endforeach
									</select>
								</div>

								<div class="form-group">
									<label class="required">Category Name</label>
									<input type="text" name="category_name" id="category_name" class="form-control" placeholder="Category Name">
								</div>

								<div class="form-group">
									<label class="required">Category Image</label>
									<input type="file" name="category_image" id="category_image" class="form-control" placeholder="Category Image" accept=".jpg, .jpeg, .png, .svg">
								</div>

								<div class="form-group">
									<label class="">Category Banner Image</label>
									<input type="file" name="banner_img" id="banner_img" class="form-control" placeholder="Category Banner Image" accept=".jpg, .jpeg, .png, .svg">
								</div>
							</div>

							<div class="card-footer">
								<input type="submit" class="btn btn-primary btn_action mt-2 submit_button">
								<a href="javascript:;" class="btn btn-primary mt-2 loading" style="display:none;">Adding....</a>
								<a href="{{ route('category.index') }}" class="btn btn-secondary mt-2 btn_action">Cancel</a>

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
		$("#category_form").on('submit', (function(e) {
			e.preventDefault();

			$.ajax({
				url: "{{ route('category.store') }}",
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
						setTimeout(function() {
							window.location.href = result.redirect
						}, 1000);
					} else {
						toastr.error(result.message);
						$('.submit_button').show();
						$('.loading').hide();
					}
				},
				error: function(e) {
					toastr.error('Somthing Wrong');
					console.log(e);
					$('.submit_button').show();
					$('.loading').hide();
				}
			});
		}));



		/*  $(".submit_button").click(function(){

        var category_name = $("body").find("#category_name").val();

        var fd = new FormData();
        fd.append("category_name", category_name);
        fd.append("category_image", $("body").find("#category_image")[0].files[0]);

        $.ajax({
          type: "POST",
          url: "{{ route('category.store') }}",
          dataType: "json",
          headers: { 'X-CSRF-TOKEN': "{{ csrf_token() }}" },
          data : fd,
          cache:false,
          contentType: false,
          processData: false,
          success: function(result){
            if(result.success){
              toastr.success(result.message);
              setTimeout(function(){window.location.href = window.location.origin+'/seller/category'}, 1000);
            }
            else{
              toastr.error(result.message);
            }
          },
		  error: function (error) {
				//console.log(error);
			}
        });
      }); */
	});
</script>
@endsection