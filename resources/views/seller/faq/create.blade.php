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
                <h3 class="card-title">Add Faq</h3>
              </div>
              <div class="card-body">
                
                <div class="form-group">
                  <label class="required">Question</label>
                  <input type="text" name="question" id="question" class="form-control" placeholder="Question" required>
                </div>
                
                <div class="form-group ">
                <label class="">Answer</label>
                <textarea class="form-control" name="answer" id="answer" placeholder="Answer"></textarea>
              </div>
              </div>
              <div class="card-footer">
                <input type="button" class="btn btn-primary btn_action submit_button" value="Submit">
                <a href="{{ route('faq.index') }}" class="btn btn-secondary btn_action">Cancel</a>
                <a href="javascript:;" class="btn btn-primary loading" style="display:none;">Adding....</a>
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
  <script type="text/javascript">
    $("document").ready(function(){
      $(".submit_button").click(function(){

        $("body").find(".btn_action").hide();
        $("body").find(".loading").show();

        var answer = $("body").find("#answer").val();
        var question = $("body").find("#question").val();

        $.ajax({
          type: "POST",
          url: "{{ route('faq.store') }}",
          dataType: "json",
          headers: { 'X-CSRF-TOKEN': "{{ csrf_token() }}" },
          data : {
                  'question': question,
                  'answer': answer,
                },
          success: function(result){
            if(result.success){
              toastr.success(result.message);
              setTimeout(function(){window.location.href = window.location.origin+'/seller/faq'}, 1000);
            }
            else{
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