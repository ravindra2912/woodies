
		<h5 class="mt-2 font-weight-bold">Coupon Code</h5>
		<div class="input-group pb-2 pt-1">
			<input class="form-control me-2" type="text" id="coupan_code" name="coupon_code" value="{{ $request->coupan_code }}" placeholder="Write your coupon code" data-bs-original-title="" title="">
			<button class="btn btn-primary btn-round coupon-btn"  type="button" onclick="get_summary()">APPLY COUPON</button>
		</div>
		@if(isset($coupon) && !empty($coupon) && !empty($request->coupan_code))
			@if($coupon['status'] == false)
				<p class="text-danger">{{ $coupon['msg'] }}</p>
			@elseif($coupon['status'] == true)
				<p class="text-success">{{ $coupon['msg'] }}</p>
			@endif
		@endif
		
		<div class="row bg-secondary btn-round p-3 pl-3 mt-3">
			<div class="col-md-6 col-6 ">Product </div>
			<div class="col-md-6 col-6 text-right ">Subtotal </div>
			<div class="col-md-12 divider pb-2"></div>
			
			@foreach($carts as $val)
					<div class="col-md-6 col-6 pt-2 ">{{ (isset($val->product_data) && !empty($val->product_data->name))? $val->product_data->name :'' }} @if(!empty($val->Variant))({{ $val->Variant }})@endif </div>
					<div class="col-md-6 col-6 pt-2 text-right text-primary">Rs. {{ $val->amount * $val->quantity }} </div>
			@endforeach
			<div class="col-md-12 divider pb-2"></div>
			
			<div class="col-md-6 col-6 pt-2 ">Sub Total</div>
			<div class="col-md-6 col-6 pt-2 text-right text-primary">Rs. {{ $summary['subtotle'] }}</div>
			<div class="col-md-6 col-6 pt-2 ">Delivery</div>
			<div class="col-md-6 col-6 pt-2 text-right text-primary">Rs. {{ $summary['delivery'] }}</div>
			<div class="col-md-6 col-6 pt-2 ">Discount</div>
			<div class="col-md-6 col-6 pt-2 text-right text-primary">Rs. {{ $summary['discount'] }}</div>
			@if(isset($address) && !empty($address))
				@if($address->state == 'gujarat')
					<div class="col-md-6 col-6 pt-2 ">CGST</div>
					<div class="col-md-6 col-6 pt-2 text-right text-primary">Rs. {{ $summary['cgst'] }}</div>
					<div class="col-md-6 col-6 pt-2 ">SGST</div>
					<div class="col-md-6 col-6 pt-2 text-right text-primary">Rs. {{ $summary['sgst'] }}</div>
				@else
					<div class="col-md-6 col-6 pt-2 ">IGST</div>
					<div class="col-md-6 col-6 pt-2 text-right text-primary">Rs. {{ $summary['igst'] }}</div>
				@endif
			@endif
			<div class="col-md-12 divider pb-2"></div>
			
			<div class="col-md-6 col-6 pt-2 ">Total</div>
			<div class="col-md-6 col-6 pt-2 text-right text-primary">Rs. {{ $summary['totle'] }}</div>
			<div class="col-md-12 divider pb-2"></div>
			
			<div class="col-md-6 col-6 pt-4 mb-2 ">
				<!-- <div class="form-check">
					<input class="form-check-input" type="radio" name="payment_type" id="payment1" value="1" checked>
					<label class="form-check-label" for="payment1"> Online payments</label>
				</div>
				<div class="form-check">
					<input class="form-check-input" type="radio" name="payment_type" id="payment2" value="2">
					<label class="form-check-label" for="payment2"> Cash on delivery </label>
				</div> -->
				<!--div class="form-check">
					<input class="form-check-input" type="radio" name="payment_type" id="payment3" value="3">
					<label class="form-check-label" for="payment3"> Check payments </label>
				</div>
				<div class="form-check">
					<input class="form-check-input" type="radio" name="payment_type" id="payment4" value="4">
					<label class="form-check-label" for="payment4"> Direct bank transfer </label>
				</div -->
				
				
			</div>
		</div>
		
		<div class="text-right mt-3">
			<button class="btn btn-primary btn-block btn-round submit_button" type="submit">Place Order  </button>
			<button class="btn btn-primary btn-block btn-round loading" type="button" style="display:none;">Loading ...  </button>
		</div>

		
						