@extends('admin.layouts.app')
@section('title-admin', 'User manegement')
@section('main-content')
    @include('components.messages')
    <form action="">
        <div class="mt-5 d-flex justify-content-end">
            <input type="text" placeholder="Name or Email" class="w-25 form-control" name="search"
                value="{{ Request::get('search') }}">
            <select name="status_confirm_email" class="w-25 form-select">
                <option value="">Verify email</option>
                <option value="{{ TENTATIVE }}"
                    {{ Request::get('status_confirm_email') == TENTATIVE ? 'selected' : '' }}>Tentative</option>
                <option value="{{ ENABLED }}" {{ Request::get('status_confirm_email') == ENABLED ? 'selected' : '' }}>
                    Enabled</option>
            </select>
            <input type="submit" value="Search" class="btn btn-primary">
        </div>
    </form>
    <table class="table table-hover mt-3">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Verify Email</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @forelse ($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->status_confirm_email == TENTATIVE ? 'Tentative' : 'Enabled' }}</td>
                    <td class="d-flex justify-content-evenly">
                        <a href="{{ route('admin.users.edit', $user->id) }}"><i
                                class="fa-regular fa-pen-to-square text-green"></i></a>
                        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="clickForm">
                            @csrf
                            @method('DELETE')
                            <button><i class="fa-solid fa-trash text-red"></i></button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center">Empty</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    <div class="d-flex justify-content-end mt-3">
        {{ $users->appends(request()->query())->links('pagination::bootstrap-4') }}
    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function() {
            $('.clickForm').on('click', function(e) {
                let form = $(this)
                e.preventDefault();
                $.confirm({
                    title: 'Delete user',
                    content: 'Are you sure?',
                    buttons: {
                        cancel: {
                            text: 'Cancel',
                            btnClass: 'btn-default',
                        },
                        ok: {
                            text: 'OK',
                            btnClass: 'btn-blue',
                            action: function() {
                                form.submit();
                            }
                        }
                    }
                });
            });
        });
    </script>
@endsection
