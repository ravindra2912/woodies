@extends('seller.layouts.index')

@section('custom_css')
<!-- Select2 -->
<link rel="stylesheet" href="{{ asset('admin_theme/plugins/select2/css/select2.min.css') }}">
<style>
  .right-wrapper {
    background: #fff !important;
    background-color: #fff !important;
  }

  .note-editing-area {
    background: whitesmoke;
  }

  .select2-container--default .select2-selection--multiple .select2-selection__choice {
    background-color: #007bff !important;
    border-color: #006fe6 !important;
  }
</style>

<!-- Summernote css/js -->
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
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

      <form action="{{ route('product.store') }}" id="addform" class="card card-primary">
        <div class="card-header">
          <h3 class="card-title">Add Product</h3>
        </div>
        <div class="card-body row">
          <div class="form-group col-md-4 col-sm-6">
            <label class="required">Product Name</label>
            <input type="text" name="product_name" id="product_name" class="form-control" placeholder="Product Name">
          </div>

          <div class="form-group col-md-4 col-sm-6">
            <label class="required">Brand</label>
            <input type="text" name="brand" id="brand" class="form-control" placeholder="Brand">
          </div>

          <div class="form-group col-md-4 col-sm-6">
            <label class="required">Price</label>
            <input type="text" name="price" id="price" class="form-control" onkeypress="return isNumberKey(event,this)" placeholder="Price">
          </div>

          <div class="form-group col-md-4 col-sm-6">
            <label class="required">Manage Product variants</label>
            <select class="form-control" name="is_variants" id="is_variants">
              <option value="0">No</option>
              <option value="1">yes</option>

            </select>
          </div>

          <div class="form-group col-md-4 col-sm-6 div-quantity">
            <label class="required">Quantity</label>
            <input type="text" name="quantity" id="quantity" class="form-control" onkeypress="return isNumberKey(event,this)" placeholder="Quantity">
          </div>

          <div class="form-group col-md-4 col-sm-6">
            <label class="required">Select Category</label>
            <select class="form-control select2" style="width: 100%;" data-placeholder="Select category" name="category[]" multiple="multiple">
              @if(isset($categoryData) && !empty($categoryData))
              @foreach($categoryData as $data)
              <option value="{{ $data->id }}">{{ ucwords($data->name) }}</option>
              @endforeach
              @endif
            </select>
          </div>

          <div class="form-group col-md-12 col-sm-12">
            <label class="required">Short Description</label>
            <textarea class="form-control" name="short_description" placeholder="Short Description"></textarea>
          </div>

          <div class="form-group col-md-12 col-sm-12">
            <label class="required">Description</label>
            <textarea class="form-control" name="description" id="description" placeholder="Description"></textarea>
          </div>

          <div class="custom-control custom-checkbox col-md-3 col-sm-12">
            <input type="checkbox" class="custom-control-input is_replacement" name="is_replacement" id="is_replacement">
            <label for="is_replacement" class="custom-control-label">Is Replacement Applicable?</label>
          </div>

          <div class="form-group col-md-3 col-sm-6 show_replacement" style="display:none;">
            <label class="required">Replacement Days</label>
            <input type="text" class="form-control txt_taxes" name="replacement_days" id="replacement_days" Placeholder="Enter Replacement Days" onkeypress="return isNumberKey(event,this)">
          </div>



          <div class="custom-control custom-checkbox col-md-12 col-sm-12">
            <input type="checkbox" class="custom-control-input is_tax_applicable" name="is_tax_applicable" id="customCheckbox2">
            <label for="customCheckbox2" class="custom-control-label">Is Tax Applicable?</label>
          </div>

          <div class="show_taxes mt-2" style="display:none;">
            <div class="row mt-3">
              <div class="col-md-1 mt-2">
                <label>IGST (%)</label>
              </div>
              <div class="col-md-3 mt-2">
                <input type="text" class="form-control txt_taxes" name="igst" id="igst" onkeypress="return isNumberKey(event,this)">
              </div>

              <div class="col-md-1 mt-2">
                <label>CGST (%)</label>
              </div>
              <div class="col-md-3 mt-2">
                <input type="text" class="form-control txt_taxes" name="cgst" id="cgst" onkeypress="return isNumberKey(event,this)">
              </div>

              <div class="col-md-1 mt-2">
                <label>SGST (%)</label>
              </div>
              <div class="col-md-3 mt-2">
                <input type="text" class="form-control txt_taxes" name="sgst" id="sgst" onkeypress="return isNumberKey(event,this)">
              </div>
            </div>
          </div>


          <div class="form-group col-md-12 col-sm-12 mt-4 text-center">
            <h3>---- SEO ----</h3>
          </div>

          <div class="form-group col-md-6 col-sm-6">
            <label class="required">SEO Description</label>
            <textarea class="form-control" name="SEO_description" placeholder="SEO Description"></textarea>
          </div>

          <div class="form-group col-md-6 col-sm-6">
            <label class="required">SEO Tags (,)</label>
            <textarea class="form-control" name="SEO_tags" placeholder="SEO Tags"></textarea>
          </div>

        </div>
        <div class="card-footer">
          <input type="submit" class="btn btn-primary btn_action submit_button" value="Submit">
          <a href="{{ route('product.index') }}" class="btn btn-secondary btn_action">Cancel</a>
          <a href="javascript:;" class="btn btn-primary loading" style="display:none;">Adding....</a>
        </div>
      </form>
    </div>
  </section>
</div>
@endsection

@section('custom_js')
<!-- Select2 -->
<script src="{{ asset('admin_theme/plugins/select2/js/select2.full.min.js') }}"></script>
<script type="text/javascript">
  $(function() {
    //Initialize Select2 Elements
    $('.select2').select2()
  });

  function isNumberKey(evt, element) {
    var charCode = (evt.which) ? evt.which : event.keyCode
    if (charCode > 31 && (charCode < 48 || charCode > 57) && !(charCode == 46 || charCode == 8))
      return false;
    else {
      var len = $(element).val().length;
      var index = $(element).val().indexOf('.');
      if (index > 0 && charCode == 46) {
        return false;
      }
      if (index > 0) {
        var CharAfterdot = (len + 1) - index;
        if (CharAfterdot > 3) {
          return false;
        }
      }
    }
    return true;
  }

  $("body").find(".is_tax_applicable").click(function() {

    if ($(this).prop("checked")) {
      $("body").find(".show_taxes").show();
    } else {
      $("body").find(".show_taxes").hide();
    }
  });

  $("body").find(".is_replacement").click(function() {

    if ($(this).prop("checked")) {
      $("body").find(".show_replacement").show();
    } else {
      $("body").find(".show_replacement").hide();
    }
  });

  $("document").ready(function() {

    $("#description").summernote({
      height: 200
    });

    $("#is_variants").change(function() {
      if (this.value == 0) {
        $('.div-quantity').show();
      } else {
        $('.div-quantity').hide();
      }
    });


    $("#addform").on('submit', (function(e) {
      e.preventDefault();

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
          $('.btn_action').hide();
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
            $('.btn_action').show();
            $('.loading').hide();
          }
        },
        error: function(e) {
          toastr.error('Somthing Wrong');
          console.log(e);
          $('.btn_action').show();
          $('.loading').hide();
        }
      });
    }));


  });
</script>
@endsection