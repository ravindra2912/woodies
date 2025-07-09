@extends('seller.layouts.index')

@section('custom_css')
    
	
    
@endsection

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
						<h1>Social links</h1>
                    </div>
                </div>
            </div>
        </section>
        <section class="content">
            <div class="container-fluid">
				<form action="{{ route('update_social_links',$Setting->id) }}" method="POST" id="updateform" class="card card-primary" enctype="multipart/form-data">
					<div class="card-header">
						<h3 class="card-title">Social links</h3>
					</div>
					@if(isset($Setting) && !empty($Setting))
						<div class="card-body row">
						
							
							<div class="form-group col-md-6 col-sm-12">
								<label class="">Facebook</label>
								<input type="text" name="Facebook" value="{{ $Setting->Facebook }}" placeholder="Enter Facebook URL" class="form-control" />
							</div>
							
							<div class="form-group col-md-6 col-sm-12">
								<label class="">Instagram</label>
								<input type="text" name="Instagram" value="{{ $Setting->Instagram }}" placeholder="Enter Instagram URL" class="form-control" />
							</div>
							
							<div class="form-group col-md-6 col-sm-12">
								<label class="">LinkedIn</label>
								<input type="text" name="LinkedIn" value="{{ $Setting->LinkedIn }}" placeholder="Enter LinkedIn URL" class="form-control" />
							</div>
							
							<div class="form-group col-md-6 col-sm-12">
								<label class="">YouTube</label>
								<input type="text" name="YouTube" value="{{ $Setting->YouTube }}" placeholder="Enter YouTube URL" class="form-control" />
							</div>
							
							<div class="form-group col-md-6 col-sm-12">
								<label class="">Twitter</label>
								<input type="text" name="Twitter" value="{{ $Setting->Twitter }}" placeholder="Enter Twitter URL" class="form-control" />
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