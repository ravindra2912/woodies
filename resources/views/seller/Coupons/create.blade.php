@extends('seller.layouts.index')

@section('content')
<style>
	.head_label{
		font-weight: 900;
		font-size: 20px;
		//border-bottom: 1px solid #787272;
		width: 100%;
		padding-bottom: 7px;
		margin-bottom: 12px;
	}
</style>
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
			<div class="card">
				<div class="card-header bg-primary">
					<h3 class="card-title">Add Coupon</h3>
				</div>
				<div class="card-body row">
					<div class="col-md-4 col-sm-6 row">
						<div class="form-group col-md-6 col-sm-6">
							<label class="required">Coupon Code</label>
							<input type="text"  class="form-control" value="{{old('coupon_code')}}" name="coupon_code" id="coupon_code" onchange="Check_code()" placeholder="Enter Coupon Code">
						</div>
						<div class="form-group col-md-6 col-sm-6">
							</br>
							<button type="button" onclick="generate_code()" class="btn btn-info mt-2" class="form-label" >Generate Code</button>
						</div>
					</div>
					
					<div class="form-group col-md-4 col-sm-6">
						<label class="required">Select Coupon Type</label>
						<select class="form-control" name="type" id="type" onchange="check_type(this.value)" required>
							<option value="">Please Select Coupon Type</option>
							<option value="1">Percentage</option>
							<option value="2">Free amount</option>
							<!-- option value="3">Free shipping</option -->
						</select>
					</div>
					
					<div class="form-group col-md-4 col-sm-6" id="for_amt_per" style="display:none;">
						<div id="type_coupon_amount" style="@if(old('type') == 1) display:none; @endif">
							<label class="form-label" >Amount</label>
							<input class="form-control" name="coupon_amount" value="{{old('coupon_amount')}}" id="coupon_amount" type="number" placeholder="Enter amount">
							<span class="text-danger">@error('coupon_amount') {{$message}} @enderror</span> 
						</div>
						<div id="type_coupon_percent" style="@if(old('type') == 2) display:none; @endif">
							<label class="form-label" >Percentage</label>
							<input class="form-control" name="coupon_percent" value="{{old('coupon_percent')}}" max="100" min="1" id="coupon_percent"  type="number" placeholder="Enter Percentage">
							<span class="text-danger">@error('coupon_percent') {{$message}} @enderror</span> 
						</div>
					</div>
					
					<div class="form-group col-md-4 col-sm-6">
						<label class="required">Active date</label>
						<input class="form-control " name="active_date" value="{{old('active_date')}}" type="date" >
					</div>
					
					<div class="form-group col-md-4 col-sm-6">
						<label class="required">End date</label>
						<input class="form-control" name="end_date" type="date" value="{{old('end_date')}}" >
					</div>
					
					<div class="form-group col-md-12 col-sm-12">
						<button class="btn btn-primary submit_button" for="coupon_form" style="margin-top: 20px;" type="button">Save</button>
					</div>
						
					
					
					
					
					
				</div>
			</div>
		</div>
	</section>
	
	<?php /*
    <section class="content">
      <div class="container-fluid">
            <form  method="post" enctype="multipart/form-data"> @csrf
			<div class="row g-3" style="color: black;">			  
				<!-- div class="col-md-12">
					<div class="card">
						<div class="card-header bg-primary">
							<h3 class="card-title">Add Coupon</h3>
						</div>
						<div class="card-body">
						 <label class="form-label head_label" >Discount code</label>
							<div class="row g-3">
								
								<div class="col-md-6">
									<input type="text"  class="form-control" value="{{old('coupon_code')}}" name="coupon_code" id="coupon_code" onchange="Check_code()" placeholder="Enter Coupon Code">
									 <span class="text-danger">@error('coupon_code') {{$message}} @enderror</span> 
								</div>
								<div class="col-md-6" style="text-align: end;">
									<button type="button" onclick="generate_code()" class="btn btn-info" class="form-label" >Generate Code</button>
								</div>
							</div>
						</div>
					</div>
				</div -->
									
				<!-- div class="col-md-12">					
					<div class="card" >
					  <div class="card-body">	
						<div class="row g-3" style="color: black;">			  
							<div class="col-md-12 custom-radio-ml">
							  <label class="form-label head_label" >Types</label>
								<div class="form-check radio radio-primary">
									  <input class="form-check-input" id="1" type="radio"  onchange="check_type(this.value)"  name="type" value="1" @if(old('type') == 1) checked @endif >
									  <label class="form-check-label" for="1">Percentage</span></label>
								 </div>
								 <div class="form-check radio radio-primary">
									  <input class="form-check-input" id="2" type="radio" onchange="check_type(this.value)" name="type" value="2" @if(old('type') == 2) checked @endif >
									  <label class="form-check-label" for="2">Free amount</span></label>
								 </div>
								 <!-- div class="form-check radio radio-primary">
									  <input class="form-check-input" id="3" type="radio"  onchange="check_type(this.value)"  name="type" value="3" @if(old('type') == 3) checked @endif >
									  <label class="form-check-label" for="3">Free shipping</span></label>
								 </div --> 
								<!--span class="text-danger">@error('type') {{$message}} @enderror</span> 
							</div>
							</div>
						</div>
					</div>
				</div -->
			
					<!-- div class="card col-md-12" id="for_amt_per" style=" @if(old('type') == 3 || old('type') == null) display:none; @endif ">
						<div class="card-body">
							<label class="form-label head_label" >Value</label>	
							<div class="row g-3">
								<div class="col-md-4" id="type_coupon_amount" style="@if(old('type') == 1) display:none; @endif">
									<label class="form-label" >Amount</label>
									<input class="form-control" name="coupon_amount" value="{{old('coupon_amount')}}" id="coupon_amount" type="number" placeholder="Enter amount">
									<span class="text-danger">@error('coupon_amount') {{$message}} @enderror</span> 
								</div>
								<div class="col-md-4" id="type_coupon_percent" style="@if(old('type') == 2) display:none; @endif">
									<label class="form-label" >Percentage</label>
									<input class="form-control" name="coupon_percent" value="{{old('coupon_percent')}}" max="100" min="1" id="coupon_percent"  type="number" placeholder="Enter Percentage">
									<span class="text-danger">@error('coupon_percent') {{$message}} @enderror</span> 
								</div>
							</div>
						</div>
					</div -->
							
					<!-- div class="card col-md-12" >
						<div class="card-body">	
							<label class="form-label head_label" >Minimum requirements</label>
							<div class="row g-3" >
								<div class="col-md-12 custom-radio-ml">
									<div class="form-check radio radio-primary">
										  <input class="form-check-input" id="min_1" type="radio" name="minimum_requrment_type" @if(old('minimum_requrment_type') == 0 || old('minimum_requrment_type') == '') checked @endif onchange="check_mini_req(this.value)" value="0" >
										  <label class="form-check-label" for="min_1">None</span></label>
										  
									 </div>
									 <div class="form-check radio radio-primary">
											<input class="form-check-input" id="min_2" type="radio" name="minimum_requrment_type" @if(old('minimum_requrment_type') == 1) checked @endif onchange="check_mini_req(this.value)"  value="1" >
											<label class="form-check-label" for="min_2">Minimum purchase amount (₹)</span></label>
											<input type="number" class="form-control" name="minimum_requrment_amt" value="{{old('minimum_requrment_amt')}}" id="minimum_requrment_amt" style="@if(old('minimum_requrment_type') != 1) display:none; @endif" placeholder="Enter Amount" >
											<span class="text-danger">@error('minimum_requrment_amt') {{$message}} @enderror</span>
									 </div>
									 <div class="form-check radio radio-primary">
											<input class="form-check-input" id="min_3" type="radio" name="minimum_requrment_type" @if(old('minimum_requrment_type') == 2) checked @endif onchange="check_mini_req(this.value)" value="2" >
											<label class="form-check-label" for="min_3">Minimum quantity of items</span></label>
											<input type="number" class="form-control" name="minimum_requrment_qty" value="{{old('minimum_requrment_qty')}}" id="minimum_requrment_qty" style="@if(old('minimum_requrment_type') != 2) display:none; @endif" placeholder="Enter Qauntity" >
											<span class="text-danger">@error('minimum_requrment_qty') {{$message}} @enderror</span>
									</div>
								</div>
							
							</div>
						</div>
					</div -->
					
					<!-- div class=" col-md-12">
						<div class="card">
							<div class="card-body animate-chk">
								<label class="form-label head_label" >Usage limits</label>
								<div class="form-check">
										<input class="form-check-input" id="chk-ani" name="is_coupon_limit" @if(old('is_coupon_limit') == 1) checked @endif value="1" onchange="usage_limit_show(this.checked)" type="checkbox" > <label class="form-check-label" for="chk-ani" >Limit number of times this discount can be used in total</label>
										<input type="number" class="form-control" value="{{old('coupon_limit')}}" name="coupon_limit" id="usage_limit" style="@if(old('is_coupon_limit') != 1) display:none; @endif margin: 13px 0px;" placeholder="Enter Limit" >
										<span class="text-danger">@error('coupon_limit') {{$message}} @enderror</span>
								</div>
								<div class="form-check">
									  <input class="form-check-input" id="chk-ani1" name="once_per_user" @if(old('once_per_user') == 1) checked @endif value="1" type="checkbox">
									  <label class="form-check-label" for="chk-ani1" >Limit to one use per customer</label>
								</div>
										
							</div>
						</div>
					</div -->
					
					<div class="card col-md-12" >
						<div class="card-body">	
							<label class="form-label head_label" >Active dates</label>
							<div class="row g-3" style="color: black;">			  
								<label class="col-md-2 col-form-label">Start Date</label>
								<div class="col-sm-3">
									<input class="form-control " name="active_date" value="{{old('active_date')}}" type="date" >
									<span class="text-danger">@error('active_date') {{$message}} @enderror</span>
								</div>
								<div class="col-sm-2"></div>
								<label class="col-sm-2 col-form-label">Start Time</label>
								<div class="col-sm-3">
									<input class="form-control" name="active_time" type="time" value="{{old('active_time')}}" >
									<span class="text-danger">@error('active_time') {{$message}} @enderror</span>
								</div>
						
							</div>
							
							<div class="row g-3" style="color: black;margin-top: 10px;">			  
								<label class="col-md-2 col-form-label">End Date</label>
								<div class="col-sm-3">
									<input class="form-control" name="end_date" type="date" value="{{old('end_date')}}" >
									<span class="text-danger">@error('end_date') {{$message}} @enderror</span>
								</div>
								<div class="col-sm-2"></div>
								<label class="col-sm-2 col-form-label">End Time</label>
								<div class="col-sm-3">
									<input class="form-control" name="end_time" type="time" value="{{old('end_time')}}" >
									<span class="text-danger">@error('end_time') {{$message}} @enderror</span>
								</div>
						
							</div>
							<div class="row g-3" style="color: black;margin-top: 10px;">	
								<div class="col-md-3">
									<div class="form-check">
										  <input class="form-check-input" id="chk-ani2" name="show_in_list" value="1" type="checkbox" @if(old('show_in_list') == 1) checked @endif>
										  <label class="form-check-label" for="chk-ani2" >Show In Limit</label>
									</div>
								</div>
							</div>
						   <button class="btn btn-primary submit_button" for="coupon_form" style="margin-top: 20px;" type="button">Save</button>
						</div>
						
					</div>
			</div>

		</form>
         
      </div>
    </section>
	*/ ?>
  </div>
@endsection

@section('custom_js')

	<script>
		// generate code	
		function generate_code()
		{
			var length = 6;
			var result           = '';
			var characters       = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
			var charactersLength = characters.length;
			for ( var i = 0; i < length; i++ ) {
			  result += characters.charAt(Math.floor(Math.random() * charactersLength));
		   }

			$('#coupon_code').val(result);
			Check_code();
		}	
		// to check code is not repeated
		function Check_code(){
			var coupon_code = $('#coupon_code').val();
		}

		// to check type 
		function check_type(type){
			//var type =  $("input:radio[name=type]: checked ").val();
			if(type == 3)
			{
				$('#for_amt_per').hide();
				
			}else
			{
				$('#for_amt_per').show();
				
				if(type == 1)
				{
					$('#type_coupon_percent').show();
					$('#type_coupon_amount').hide();
					
				}else if(type == 2)
				{
					$('#type_coupon_percent').hide();
					$('#type_coupon_amount').show();
				}else
				{
					$('#type_coupon_percent').hide();
					$('#type_coupon_amount').hide();
					$('#for_amt_per').hide();
				}	
			}
		}

		//to check minimum require
		function check_mini_req(mini_reqpe){
			//var mini_reqpe =  $("input:radio[name=minimum_requrment_type]: checked ").val();
			
			if(mini_reqpe == 0)
			{
				$('#minimum_requrment_amt').hide();
				$('#minimum_requrment_qty').hide();
			}
			else if(mini_reqpe == 2)
			{
				$('#minimum_requrment_amt').hide();
				$('#minimum_requrment_qty').show();
			}
			else if(mini_reqpe == 1)
			{
				$('#minimum_requrment_amt').show();
				$('#minimum_requrment_qty').hide();
			}
			 
		}

		function usage_limit_show(usage_type)
		{	
			//var usage_type =  $("input:checkbox[name=usage_limit_type]: checked ").val();
			if(usage_type)
			{
				$('#usage_limit').show();
			}else{
				$('#usage_limit').hide();
			}
		}
	</script>


  <script type="text/javascript">
  
  
  
  
  
    $("document").ready(function(){
      $(".submit_button").click(function(){

        var coupon_code = $("input[name=coupon_code]").val();
       var type = $("#type").val();
        
        var coupon_amount = $("input[name=coupon_amount]").val();
        var coupon_percent = $("input[name=coupon_percent]").val();
        
		/*var minimum_requrment_type = $("input[type=radio][name=minimum_requrment_type]:checked").val();
		var minimum_requrment_amt = $("input[name=minimum_requrment_amt]").val();
		var minimum_requrment_qty = $("input[name=minimum_requrment_qty]").val();
		
		
		var is_coupon_limit = $("input[type=checkbox][name=is_coupon_limit]:checked").val();
		var coupon_limit = $("input[name=coupon_limit]").val();
		var once_per_user = $("input[type=checkbox][name=once_per_user]:checked").val(); */
		
		var active_date = $("input[name=active_date]").val();
		//var active_time = $("input[name=active_time]").val();
		
		var end_date = $("input[name=end_date]").val();
		//var end_time = $("input[name=end_time]").val();
		
		//var show_in_list = $("input[type=checkbox][name=show_in_list]:checked").val();
		
		
		console.log(active_date);
		if(active_date != ''){
			console.log('true');
		}else{
			console.log('false');
		}
		//return true;
		

        var fd = new FormData();
        fd.append("coupon_code", coupon_code?coupon_code:'');
        fd.append("type", type?type:'');
        fd.append("coupon_amount", coupon_amount?coupon_amount:'');
        fd.append("coupon_percent", coupon_percent?coupon_percent:'');
        /*fd.append("minimum_requrment_type", minimum_requrment_type?minimum_requrment_type:'');
        fd.append("minimum_requrment_amt", minimum_requrment_amt?minimum_requrment_amt:'');
        fd.append("minimum_requrment_qty", minimum_requrment_qty?minimum_requrment_qty:'');
        fd.append("is_coupon_limit", is_coupon_limit?is_coupon_limit:'');
        fd.append("coupon_limit", coupon_limit?coupon_limit:'');
        fd.append("once_per_user", once_per_user?once_per_user:''); */
		fd.append("active_date", active_date?active_date:null);
       // fd.append("active_time", active_time?active_time:'');
        fd.append("end_date", end_date?end_date:'');
        //fd.append("end_time", end_time?end_time:'');
       // fd.append("show_in_list", show_in_list?show_in_list:'');
		
		

        $.ajax({
          type: "POST",
          url: "{{ route('coupons.store') }}",
          dataType: "json",
          headers: { 'X-CSRF-TOKEN': "{{ csrf_token() }}" },
          data : fd,
          cache:false,
          contentType: false,
          processData: false,
          success: function(result){
            if(result.success){
              toastr.success(result.message);
              setTimeout(function(){window.location.href = window.location.origin+'/seller/coupons'}, 1000);
            }
            else{
              toastr.error(result.message);
            }
          },
		  error: function (error) {
				console.log(error);
			}
        });
      });
    });
  </script>
@endsection