<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Hotel Booking</title>
    {{-- bootstrap css --}}
    <link rel="stylesheet" href="{{ asset('common/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('common/css/common.css') }}">
</head>

<body>
    <div class="container h-100">
        <div class="row">
            <div class="col p-3">
                <div class="w-75">
                    <h2 class="fw-normal">Hotel Booking</h2>
                    @include('components.messages')
                    <h2 class="fw-bold my-5">Login</h2>
                    <form action="{{ route('admin.login') }}" method="POST">
                        @csrf
                        <div>
                            <input type="text" placeholder="Login ID" class="w-100 mb-3 border-bottom border-2 fs-5"
                                name="login_id">
                        </div>
                        <div>
                            <input type="password" placeholder="Password" name="password"
                                class="w-100 border-bottom border-2 fs-5">
                        </div>
                        <input type="submit"
                            class="w-100 bg-green text-center py-2 mt-4 text-white fw-bold fs-5 rounded" value="LOGIN">
                    </form>
                </div>
            </div>
            <div class="col"></div>
        </div>
    </div>

    {{-- jquery js --}}
    <script type="text/JavaScript" src="{{ asset('common/js/jquery-3.7.1.min.js') }}"></script>
    {{-- bootstrap js --}}
    <script type="text/JavaScript" src="{{ asset('common/js/popper.min.js') }}"></script>
    <script type="text/JavaScript" src="{{ asset('common/js/bootstrap.min.js') }}"></script>
    <script type="text/JavaScript" src="{{ asset('common/js/common.js') }}"></script>
</body>

</html>
