@extends('user.layouts.app')
@section('css')
@endsection
@section('main-content')
    <div class="row">
        <div class="col p-3">
            <div class="w-75">
                <h2 class="fw-normal">Hotel Booking</h2>
                @include('components.messages')
                <h2 class="fw-bold mt-5">Login</h2>
                <div class="fs-4 mt-3 mb-4">
                    Don't have an account?
                    <a href="{{ route('auth.register') }}" class="text-green">Request account</a>
                </div>
                <form action="{{ route('auth.login') }}" method="POST">
                    @csrf
                    <div>
                        <input type="text" placeholder="Email" class="w-100 mb-3 border-bottom border-2 fs-5"
                            name="email">
                    </div>
                    <div>
                        <input type="password" placeholder="Password" name="password"
                            class="w-100 border-bottom border-2 fs-5">
                    </div>
                    <a href="{{ route('auth.forgot_password') }}">
                        <div class="text-end text-green mt-1">Forgot Password?</div>
                    </a>
                    <input type="submit" class="w-100 bg-green text-center py-2 mt-4 text-white fw-bold fs-5 rounded"
                        value="LOGIN">
                </form>
            </div>
        </div>
        <div class="col"></div>
    </div>
@endsection
@section('script')
@endsection
