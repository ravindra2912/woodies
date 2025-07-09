<!DOCTYPE html>
<html>
    <head>

        @include('seller/layouts/header')

        @yield('custom_css')

    </head>

    @include('seller/layouts/navbar')
    
    @yield('content')

    @include('seller/layouts/footer')

    @yield('custom_js')

</html>