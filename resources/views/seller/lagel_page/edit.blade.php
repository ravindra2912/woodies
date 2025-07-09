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
        <div class="col-md-3 col-sm-1"></div>
        <div class="col-md-6 col-sm-10">
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">Edit legal page</h3>
            </div>
            <input type="hidden" id="form_url" value="{{ route('lagel-pages.update',$legalData->id) }}">
            <div class="card-body">

              <div class="form-group">
                <label class="required">Page Type</label>
                <select class="form-control" name="type" id="type">
                  <option value="">Select Page Type</option>
                  @foreach (config('const.legal_page_type') as $type)
                  <option value="{{ $type }}" {{ $legalData->page_type  == $type ? 'selected':'' }}>{{ preg_replace('/(?<!\ )[A-Z]/', ' $0', $type) }}</option>
                  @endforeach
                </select>
              </div>
              
              <div class="form-group">
                <label class="required">Status</label>
                <select class="form-control" name="status" id="status">
                  <option value="active" {{ $legalData->status == 'active' ? 'selected':'' }}>Active</option>
                  <option value="inactive" {{ $legalData->status == 'inactive' ? 'selected':'' }}>Inactive</option>
                </select>
              </div>

              <div class="form-group ">
                <label class="">Answer</label>
                <textarea class="form-control" name="description"  id="description" placeholder="Answer">{{ $legalData->description }}</textarea>
              </div>

            </div>
            <div class="card-footer">
              <input type="button" class="btn btn-primary btn_action submit_button" value="Submit">
              <a href="{{ route('lagel-pages') }}" class="btn btn-secondary btn_action">Cancel</a>
              <a href="javascript:;" class="btn btn-primary loading" style="display:none;">Editing....</a>
            </div>
          </div>
        </div>
        <div class="col-md-3 col-sm-1"></div>
      </div>
    </div>
  </section>
</div>
@endsection

@section('custom_js')
<!-- Summernote -->
<script src="{{ asset('admin_theme/plugins/summernote/summernote-bs4.min.js') }}"></script>
<script type="text/javascript">
$(function () {
    // Summernote
    $('#description').summernote()
  })

  $("document").ready(function() {
    $(".submit_button").click(function() {

      $("body").find(".btn_action").hide();
      $("body").find(".loading").show();

      $.ajax({
        type: "POST",
        url: $("body").find("#form_url").val(),
        dataType: "json",
        headers: {
          'X-CSRF-TOKEN': "{{ csrf_token() }}"
        },
        data: {
          'description': $("body").find("#description").val(),
          'type': $("body").find("#type").val(),
          'status': $("body").find("#status").val(),
          // '_method': "PATCH",
        },
        success: function(result) {
          if (result.success) {
            toastr.success(result.message);
            setTimeout(function() {
              window.location.href = window.location.origin + '/seller/lagel-pages'
            }, 2000);
          } else {
            toastr.error(result.message);
            $("body").find(".btn_action").show();
            $("body").find(".loading").hide();
          }
        }
      });
    });
  });
</script>
@endsection