<!DOCTYPE HTML>
<html lang="en">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="UTF-8">
    <!-- Title -->
    <title>@yield('title')-{{ config('app.name', 'Laravel') }}</title>
    <!-- Font -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500" rel="stylesheet">
    <!-- Stylesheets -->
    <link href="{{url('')}}/assets/frontend/common-css/bootstrap.css" rel="stylesheet">
    <link href="{{url('')}}/assets/frontend/common-css/swiper.css" rel="stylesheet">
    <link href="{{url('')}}/assets/frontend/common-css/ionicons.css" rel="stylesheet">
    <link rel="stylesheet" href="http://cdn.bootcss.com/toastr.js/latest/css/toastr.min.css">

    @stack('css')
</head>
<body >
@include('layouts.frontend.partial._header')
@yield('content')
@include('layouts.frontend.partial._footer')
<!-- SCIPTS -->
<script src="{{asset('assets/frontend/common-js/jquery-3.1.1.min.js')}}"></script>
<script src="{{url('')}}/assets/frontend/common-js/tether.min.js"></script>
<script src="{{url('')}}/assets/frontend/common-js/bootstrap.js"></script>
@stack('js')
<script src="{{url('')}}/assets/frontend/common-js/scripts.js"></script>
<script src="http://cdn.bootcss.com/toastr.js/latest/js/toastr.min.js"></script>
{!! Toastr::message() !!}
<script>
    @if($errors->any())
    @foreach($errors->all() as $error)
    toastr.error('{{$error}}','Error',{
        closeButton:true,
        progressBar:true,
    });
    @endforeach
    @endif()
</script>
</body>
</html>
