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
                <h3 class="card-title">Edit Banner</h3>
              </div>
              @if(isset($HomeBanner) && !empty($HomeBanner))
				<form method="POST" id="category_form" enctype="multipart/form-data" >{{ csrf_field() }}
					<input type="hidden" id="form_url" value="{{ route('homebanner.update',$HomeBanner->id) }}">
					<input type="hidden" name="_method" value="PATCH">
					<div class="card-body">
					  

					  <div class="form-group">
						<label>Image</label>
						<br/>
						<img src="{{ getImage($HomeBanner->image) }}" style="height:120px; width:300px; object-fit: contain;">
					  </div>

					  <div class="form-group mt-2">
						<label class="required">Bannery Image</label>
						<input type="file" name="image" id="image" class="form-control" placeholder="Bannery Image" accept=".jpg, .jpeg, .png, .svg">
					  </div>
					  
					  <div class="form-group">
						<label class="required">Redirect URL</label>
						<input type="text" name="redirect_url" id="redirect_url" class="form-control" placeholder="Redirect URL" value="{{ (isset($HomeBanner->redirect_url) && !empty($HomeBanner->redirect_url)) ? $HomeBanner->redirect_url : '' }}" required>
					  </div>

					  <div class="form-group">
						<label class="required">Status</label>
						<select name="status" id="status" class="form-control" id="status" required>
						  <option value='Active' {{ (isset($HomeBanner->status) && $HomeBanner->status == "Active") ? 'selected' : '' }}>Active</option>
						  <option value='Inactive' {{ (isset($HomeBanner->status) && $HomeBanner->status == "Inactive") ? 'selected' : '' }}>Inactive</option>
						</select>
					  </div>
					</div>
					<div class="card-footer">
					  <input type="submit" class="btn btn-primary btn_action mt-2 submit_button" >
						<a href="javascript:;" class="btn btn-primary mt-2 loading" style="display:none;">Adding....</a>
						<a href="{{ route('category.index') }}" class="btn btn-secondary mt-2 btn_action">Cancel</a>
					</div>
				</form>
              @else
                <div class="card-body">
                  <p class="text-danger">No Data Found</p>
                </div>
              @endif
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
    $("document").ready(function(){
		$("#category_form").on('submit',(function(e) {
			e.preventDefault();
			 
			  $.ajax({
				url: $("body").find("#form_url").val(),
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
					  setTimeout(function(){window.location.href = '{{ url()->previous() }}';}, 1000);
					}
					else{
						toastr.error(result.message);
						$('.submit_button').show();
						$('.loading').hide();
					}
				},
				error: function(e){ 
					toastr.error('Somthing Wrong');
					console.log(e);
					$('.submit_button').show();
					$('.loading').hide();
				}           
			});
		}));
		
      /* $(".submit_button").click(function(){

        // $("body").find(".btn_action").hide();
        // $("body").find(".loading").show();

        var category_name = $("body").find("#category_name").val();
        var status = $("body").find("#status").val();

        var fd = new FormData();
        fd.append("category_name", category_name);

        if($("body").find("#category_image")[0].files[0] !== undefined){
          fd.append("category_image", $("body").find("#category_image")[0].files[0]);
        }

        fd.append("status", status);
        fd.append("_method", "PATCH");

        $.ajax({
          type: "POST",
          url: $("body").find("#form_url").val(),
          dataType: "json",
          headers: { 'X-CSRF-TOKEN': "{{ csrf_token() }}" },
          // data : { 
          //           'category_name': category_name,
          //           'status': status,
          //           '_method': "PATCH",
          //         },
          data: fd,
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
              $("body").find(".btn_action").show();
              $("body").find(".loading").hide();
            }
          }
        });
      }); */
    });
  </script>
@endsection