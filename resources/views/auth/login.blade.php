<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Bajarang | Sign in</title>

        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
        <link rel="stylesheet" href="{{ asset('admin_theme/plugins/fontawesome-free/css/all.min.css') }}">
        <link rel="stylesheet" href="{{ asset('admin_theme/dist/css/adminlte.min.css') }}">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/css/toastr.css" rel="stylesheet" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

        <script>
            toastr.options = {
                            "closeButton": true,
                            "newestOnTop": true,
                            "positionClass": "toast-top-right"
                        };
        </script>

    </head>
    <body class="hold-transition login-page">
        <div class="login-box">
            <div class="login-logo">
                <b>{{ config('const.site_setting.name') }}</b>
            </div>
            <div class="card">
                <div class="card-body login-card-body">
                    <p class="login-box-msg">Sign in to start your session</p>

                    @include('layouts.alerts')

                    <form>
                        <div class="input-group mb-3">
                            <input type="email" class="form-control" placeholder="Email" name="email" id="email" required>
                            <div class="input-group-append">
                                <div class="input-group-text"><span class="fas fa-envelope"></span></div>
                            </div>
                        </div>
                        <div class="input-group mb-3">
                            <input type="password" class="form-control" placeholder="Password" name="password" id="password" required>
                            <div class="input-group-append">
                                <div class="input-group-text"><span class="fas fa-lock"></span></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-4">
                                <input type="button" class="btn btn-primary btn-block btn_action submit_button" value="Sign In">
                                <a href="javascript:;" class="btn btn-primary loading" style="display:none;">Sign In....</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <script src="{{ asset('admin_theme/plugins/jquery/jquery.min.js') }}"></script>
        <script src="{{ asset('admin_theme/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('admin_theme/dist/js/adminlte.min.js') }}"></script>
    </body>
</html>

<script type="text/javascript">
    $("document").ready(function(){

        $(".submit_button").click(function(){

            $("body").find(".btn_action").hide();
            $("body").find(".loading").show();

            var email = $("body").find("#email").val();
            var password = $("body").find("#password").val();

            $.ajax({
                type: "POST",
                url: "{{ route('login-submit') }}",
                dataType: "json",
                headers: { 'X-CSRF-TOKEN': "{{ csrf_token() }}" },
                data : { 
                            'email': email,
                            'password': password,
                        },
                success: function(result){
                    if(result.success){
                        toastr.success(result.message);
                        setTimeout(function(){window.location.href = result.data.redirect_url}, 1000);
                    }
                    else{
                        toastr.error(result.message);
                        $("body").find(".btn_action").show();
                        $("body").find(".loading").hide();
                    }
                },
				error: function (error) {
					//console.log(error);
				}
            });
        });
    });
</script>