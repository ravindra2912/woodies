@extends('front.layouts.index', ['seo' => [
'title' => '404 | Hereits',
'description' => 'Page not found',
'keywords' => '404, page not found',
'image' => asset('front/images/404.svg'),
'city' => '',
'state' => '',
'position' => ''
]
])
@section('content')
@section('title', '404')

<style>
    img{
        height: 400px;
    }

    @media (max-width: 991px) {
        img{
        height: 190px;
    }
    }
</style>

<section class="section-space erro-middle pb-5">
    <div class="container">
        <div class="row justify-content-center not-found">
            <div class="col-md-8 text-center">
                <div class="position-relative mb-4 mb-lg-5 pb-lg-4">
                    <img title="404" src="{{asset('front/images/404.svg')}}" class="w-100" alt="404">
                </div>
                <h1>Page not found</h1>
                <p>The page you're searching for may have been relocated, removed, renamed, or never existed.
                    You can go back and look at other pages.
                </p>
                <div class="mt-4">
                    <a href="{{route('/')}}" title="Back to Homepage" class="btn btn-primary"><span>Back to Homepage</span></a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection