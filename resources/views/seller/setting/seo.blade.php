@extends('seller.layouts.index')

@section('custom_css')
    
	
    
@endsection

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
						<h1>Site SEO</h1>
                    </div>
                </div>
            </div>
        </section>
        <section class="content">
            <div class="container-fluid">
				<form action="{{ route('update_site_seo',$Setting->id) }}" method="POST" id="updateform" class="card card-primary" enctype="multipart/form-data">
					<div class="card-header">
						<h3 class="card-title">Site SEO</h3>
					</div>
					@if(isset($Setting) && !empty($Setting))
						<div class="card-body row">
						
							
							<div class="form-group col-md-12 col-sm-12">
								<label class="required">SEO Title</label>
								<textarea name="seo_title" class="form-control" placeholder="Enter..." > {{ $Setting->seo_title }} </textarea>
							</div>
							
							<div class="form-group col-md-12 col-sm-12">
								<label class="required">SEO Tags</label>
								<textarea name="seo_tags" class="form-control" placeholder="Enter..." > {{ $Setting->seo_tags }} </textarea>
							</div>
							<div class="form-group col-md-12 col-sm-12">
								<label class="required">SEO Description</label>
								<textarea name="seo_description" class="form-control" placeholder="Enter..." > {{ $Setting->seo_description }} </textarea>
							</div>
							
						</div>
						<div class="card-footer">
							<input type="submit" class="btn btn-primary btn_action submit_button" value="Submit">
							<a href="javascript:;" class="btn btn-primary loading" style="display:none;">Loading ....</a>
						</div>
					@else
						<div class="card-body">
							<p class="text-danger">No Data Found</p>
						</div>
					@endif
				</form>
                    
            </div>
        </section>
    </div>
@endsection

@section('custom_js')
    <script type="text/javascript">

        $("#updateform").on('submit',(function(e) {
			e.preventDefault();
			  $.ajax({
				url: this.action,
				type: "POST",
				data:  new FormData(this),
				dataType: "json",
				headers: { 'X-CSRF-TOKEN': "{{ csrf_token() }}" },
				contentType: false,
				cache: false,
				processData:false,
				beforeSend : function(){ 
					$('.submit_button').hide();
					$('.loading').show();
				},
				success: function(result){
					//console.log(data);
					
					if(result.success){
					  toastr.success(result.message);
					  //setTimeout(function(){window.location.href = '{{ url()->previous() }}'; }, 1000);
					  //setTimeout(function(){ location.reload(); }, 1000);
					}
					else{
						toastr.error(result.message);
						
					}
					$('.submit_button').show();
						$('.loading').hide();
				},
				error: function(e){ 
					toastr.error('Somthing Wrong');
					console.log(e);
					$('.submit_button').show();
					$('.loading').hide();
				}           
			});
		}));
		
    </script>
@endsection