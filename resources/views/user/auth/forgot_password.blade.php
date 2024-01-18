@extends('user.layouts.app')
@section('css')
@endsection
@section('main-content')
    <div class="row">
        <div class="col p-3">
            <div class="w-75">
                <h2 class="fw-normal">Hotel Booking</h2>
                @include('components.messages')
                <h2 class="fw-bold mt-5">Forgot password</h2>
                <div class="fs-4 mt-3 mb-4">
                    Have an account?
                    <a href="{{ route('auth.login') }}" class="text-green">Login account</a>
                </div>
                <form action="{{ route('auth.forgot_password') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <input type="text" placeholder="Email" class="w-100 border-bottom border-2 fs-5" name="email"
                            value="{{ old('email', '') }}">
                        @error('email')
                            <div class="notice">{{ $message ?? '' }}</div>
                        @enderror
                    </div>
                    <input type="submit" class="w-100 bg-green text-center py-2 mt-4 text-white fw-bold fs-5 rounded"
                        value="FORGOT PASSWORD">
                </form>
            </div>
        </div>
        <div class="col"></div>
    </div>
@endsection
@section('script')
@endsection
