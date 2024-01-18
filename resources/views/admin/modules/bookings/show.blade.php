@extends('admin.layouts.app')
@section('title-admin', 'Show Booking')
@section('css')
<style>
    tr > td:first-child {
        font-weight: bold;
        padding-right: 10px;
    }
</style>
@endsection
@section('main-content')
    <div class="w-75 m-auto">
        <div class="mb-3">
            <a class="bg-green text-white fw-bold fs-5 rounded px-1"
                href="{{ route('admin.bookings.index') }}">
                <i class="fa-solid fa-rotate-left"></i>
            </a>
        </div>
        {{-- -----Room User----- --}}
        <h5>Detail Boolking</h5>
        <table class="mb-3">
            <tr>
                <td>ID: </td>
                <td>{{ $booking->id }}</td>
            </tr>
            <tr>
                <td>Checkin date: </td>
                <td>{{ CommonHelper::formatTime($booking->checkin_date) }}</td>
            </tr>
            <tr>
                <td>Checkout date: </td>
                <td>{{ CommonHelper::formatTime($booking->checkout_date) }}</td>
            </tr>
            <tr>
                <td>Price: </td>
                <td>{{ $booking->price }}</td>
            </tr>
            <tr>
                <td>Status: </td>
                <td>{{ $booking->status == STATUS_APPROVE ? 'Approve' : 'Reject' }}</td>
            </tr>
        </table>
        {{-- -----User----- --}}
        <hr>
        <h5>Detail User</h5>
        <table class="mb-3">
            <tr>
                <td>Name user: </td>
                <td>{{ $booking->user->name }}</td>
            </tr>
            <tr>
                <td>Email user: </td>
                <td>{{ $booking->user->email }}</td>
            </tr>
        </table>
        {{-- -----Room----- --}}
        <hr>
        <h5>Detail Room</h5>
        <table>
            <tr>
                <td>Name room: </td>
                <td>{{ $booking->room->name }}</td>
            </tr>
            <tr>
                <td>Status room: </td>
                <td>{{ $booking->room->status == STATUS_AVAILABLE ? 'Available' : 'Not available' }}</td>
            </tr>
            <tr>
                <td>Type room: </td>
                <td>{{ $booking->room->mType->name }}</td>
            </tr>
            <tr>
                <td>Description room: </td>
                <td>{{ $booking->room->description }}</td>
            </tr>
        </table>
    </div>
@endsection
@section('script')
@endsection
