<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ env('APP_NAME') }}</title>
    <!-----bootstrap css link---->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" >
    <style>
        .font-12{
            font-size:12px
        }
    </style>
</head>
<body>
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <h2 class="text-center">{{ env('APP_NAME') }}</h2>
            </div>
        </div>
    </div>

    @if(Session::has('error_message'))
        <div class="container alert alert-danger alert-dismissible fade show mb-2" role="alert">
            {!! Session::get('error_message') !!}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @yield('content')


    <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
</body>
</html>
