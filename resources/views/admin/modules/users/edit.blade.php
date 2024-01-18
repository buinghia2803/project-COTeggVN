@extends('admin.layouts.app')
@section('title-admin', 'Update User')
@section('css')
@endsection
@section('main-content')
    <div class="w-75 m-auto">
        <div>
            <a class="bg-green text-white fw-bold fs-5 rounded px-1" href="{{ route('admin.users.index') }}">
                <i class="fa-solid fa-rotate-left"></i>
            </a>
        </div>
        <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group mb-3">
                <label for="">Verify Email: </label>
                <td>{{ $user->status_confirm_email == TENTATIVE ? 'Tentative' : 'Enabled' }}</td>
            </div>
            <div class="form-group mb-3">
                <label for="">Name</label>
                <input type="text" class="form-control" name="name" value="{{ old('name') ?? $user->name }}">
                @error('name')
                    <div class="notice">{{ $message ?? '' }}</div>
                @enderror
            </div>
            <div class="form-group mb-3">
                <label for="">Email</label>
                <input type="text" class="form-control" name="email" value="{{ old('email') ?? $user->email }}">
                @error('email')
                    <div class="notice">{{ $message ?? '' }}</div>
                @enderror
            </div>
            <div class="form-group mb-3">
                <input type="checkbox" id="changePassword" name="change_password">
                <label for="changePassword">Change password</label>
                <br>
                <div id="password">
                    <label for="">Password</label>
                    <input type="password" class="form-control" name="password">
                    @error('password')
                        <div class="notice">{{ $message ?? '' }}</div>
                    @enderror
                </div>
            </div>
            <div class="text-end">
                <input type="submit" class="bg-green text-white fw-bold fs-5 rounded p-1 text-end" value="Update">
            </div>
        </form>
    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function() {
            const elPW = $('#password')
            if (elPW.find('.notice').length) {
                $('input[name="change_password"]').prop('checked', true);
                elPW.show()
            } else {
                elPW.hide();
            }
            $('#changePassword').on('click', function() {
                elPW.toggle();
                $('input[name="password"]').val('');
                elPW.find('.notice').remove()
            });
        });
    </script>
@endsection
