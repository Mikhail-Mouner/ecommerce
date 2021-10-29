<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{ config('app.name')."-AdminPage" }} @yield('title', '' )</title>
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--<meta name="robots" content="all,follow">-->
    <!-- Favicon-->
    <link rel="shortcut icon" href="{{ asset('favicon.png') }}">

    @include('back-end.includes._header-script')

</head>

<body class="bg-gradient-primary">

<div class="container">
    @yield('content')

</div>

@include('back-end.includes._footer-script')
</body>
</html>