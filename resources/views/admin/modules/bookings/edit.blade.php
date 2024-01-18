@extends('admin.layouts.app')
@section('title-admin', 'Update Booking')
@section('css')
@endsection
@section('main-content')
    <div class="w-75 m-auto">
        <div>
            <a class="bg-green text-white fw-bold fs-5 rounded px-1" href="{{ route('admin.bookings.index') }}">
                <i class="fa-solid fa-rotate-left"></i>
            </a>
        </div>
        <form action="{{ route('admin.bookings.update', $booking->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group mb-3">
                <label for="">Checkin date</label>
                <input type="date" class="form-control" name="checkin_date"
                    value="{{ old('checkin_date') ?? $booking->checkin_date }}">
                @error('checkin_date')
                    <div class="notice">{{ $message ?? '' }}</div>
                @enderror
            </div>
            <div class="form-group mb-3">
                <label for="">Checkout date</label>
                <input type="date" class="form-control" name="checkout_date"
                    value="{{ old('checkout_date') ?? $booking->checkout_date }}">
                @error('checkout_date')
                    <div class="notice">{{ $message ?? '' }}</div>
                @enderror
            </div>
            <div class="form-group mb-3">
                <label for="">Status</label>
                <div class="radio">
                    <label for="approve">
                        <input type="radio" name="status" value="{{ STATUS_APPROVE }}" id="approve"
                            {{ (old('status') ?? $booking->status) == STATUS_APPROVE ? 'checked' : '' }}>
                        Approve
                    </label>
                    <label for="reject">
                        <input type="radio" name="status" value="{{ STATUS_REJECT }}" id="reject"
                            {{ (old('status') ?? $booking->status) == STATUS_REJECT ? 'checked' : '' }}>
                        Reject
                    </label>
                </div>
                @error('status')
                    <div class="notice">{{ $message ?? '' }}</div>
                @enderror
            </div>
            <div class="text-end">
                <input type="submit" class="bg-green text-white fw-bold fs-5 rounded p-1 text-end mt-1" value="Update">
            </div>
        </form>
    </div>
@endsection
@section('script')
@endsection
