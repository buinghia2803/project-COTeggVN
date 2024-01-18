<!DOCTYPE html>
<html lang="{{ \App::getLocale() }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="admin_dir" content="{{ config('app.admin_dir') }}">
    @yield('headSection')

    <title>
        @if (View::hasSection('title'))
            @yield('title')
        @else
            Admin
        @endif
    </title>

    {{-- jquery js --}}
    <script type="text/JavaScript" src="{{ asset('common/js/jquery-3.7.1.min.js') }}"></script>

    {{-- bootstrap --}}
    <link rel="stylesheet" href="{{ asset('common/css/bootstrap.min.css') }}">
    <script type="text/JavaScript" src="{{ asset('common/js/popper.min.js') }}"></script>
    <script type="text/JavaScript" src="{{ asset('common/js/bootstrap.min.js') }}"></script>

    {{-- jquery-confirm --}}
    <link rel="stylesheet" href="{{ asset('common/css/jquery-confirm.css') }}">
    <script type="text/JavaScript" src="{{ asset('common/js/jquery-confirm.js') }}"></script>

    {{-- fontawesome --}}
    <link rel="stylesheet" href="{{ asset('common/css/fontawesome.min.css') }}">
    <script type="text/JavaScript" src="{{ asset('common/js/fontawesome.min.js') }}"></script>

    {{-- common --}}
    <link rel="stylesheet" href="{{ asset('common/css/common.css') }}">
    <script type="text/JavaScript" src="{{ asset('common/js/common.js') }}"></script>

    @yield('css')
</head>

<body class="Admin">
    <div class="container-fluid h-100">
        <div class="row">
            <div class="col-2 p-0">
                @include('admin.layouts.sidebar')
            </div>
            <div class="col-10">
                @include('admin.layouts.header')
                @yield('main-content')
            </div>
        </div>
    </div>
    @yield('script')
    @yield('modal')
</body>

</html>
