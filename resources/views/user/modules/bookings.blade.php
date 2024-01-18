@extends('user.layouts.app')
@section('css')
@endsection
@section('main-content')
    @include('components.messages')
    <table class="table table-hover">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name room</th>
                <th>Checkin date</th>
                <th>Checkout date</th>
                <th>Price</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($bookings as $booking)
                <tr>
                    <td>{{ $booking->id }}</td>
                    <td>{{ $booking->room->name }}</td>
                    <td>{{ CommonHelper::formatTime($booking->checkin_date) }}</td>
                    <td>{{ CommonHelper::formatTime($booking->checkout_date) }}</td>
                    <td>{{ CommonHelper::formatPrice($booking->price, ' VNĐ') }}</td>
                    <td>{{ $booking->status == STATUS_APPROVE ? 'Approve' : 'Reject' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">Empty</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    <div class="d-flex justify-content-end mt-3">
        {{ $bookings->appends(request()->query())->links('pagination::bootstrap-4') }}
    </div>
@endsection
@section('modal')
@endsection
@section('script')
@endsection
