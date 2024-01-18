@extends('user.layouts.app')
@section('css')
    <style>
        .box-container {
            display: grid;
            grid-template-columns: repeat(5, minmax(13rem, 1fr));
            gap: 0.9rem
        }

        .box {
            height: 300px;
            max-width: 241px;
        }

        .box-top {
            background-color: #cdcdcd;
        }
    </style>
@endsection
@section('main-content')
    @include('components.messages')
    <div class="box-container border border-2 p-3">
        @forelse ($rooms as $room)
            <div class="box border cursor-pointer" data-bs-toggle="modal" data-bs-target="#myModal"
                data-room_id="{{ $room->id }}" data-room_name="{{ $room->name }}" data-price="{{ $room->price }}">
                <div class="p-3 h-90 box-top d-flex flex-column justify-content-end">
                    <div class="fw-bold fs-5">{{ $room->name }}</div>
                    <div class="">Room No: {{ $room->id }}</div>
                    <div class="">Price: {{ CommonHelper::formatPrice($room->price, ' VNĐ') }}</div>
                    <div class="text-truncate">{{ $room->description }}</div>
                </div>
                <div class="d-flex justify-content-around align-items-center h-10">
                    <div><i class="fa-regular fa-circle-user"></i> <span>Balcony</span></div>
                    <div><i class="fa-regular fa-circle-user"></i> <span>AC</span></div>
                    <div><i class="fa-regular fa-circle-user"></i> <span>TB</span></div>
                </div>
            </div>
        @empty
            <div></div>
            <div></div>
            <div class="text-center">
                Not Found
            </div>
            <div></div>
            <div></div>
        @endforelse
    </div>
    <div class="d-flex justify-content-end mt-3">
        {{ $rooms->appends(request()->query())->links('pagination::bootstrap-4') }}
    </div>
@endsection
@section('modal')
    <div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('user.booking_room') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Booking room.</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group mb-3">
                            <label for="" id="room_name">Name room: {{ old('room_name') }}</label>
                            <input type="hidden" name="room_name" value="{{ old('room_name') }}">
                        </div>
                        <div class="form-group mb-3">
                            <label for="" id="price">Price room:
                                {{ CommonHelper::formatPrice(old('price'), ' VNĐ') }}
                            </label>
                            <input type="hidden" name="price" value="{{ old('price') }}">
                        </div>
                        <div class="form-group mb-3">
                            <label for="">Checkin date</label>
                            <input type="date" class="form-control" name="checkin_date"
                                value="{{ old('checkin_date') }}">
                            @error('checkin_date')
                                <div class="notice">{{ $message ?? '' }}</div>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label for="">Checkout date</label>
                            <input type="date" class="form-control" name="checkout_date"
                                value="{{ old('checkout_date') }}">
                            @error('checkout_date')
                                <div class="notice">{{ $message ?? '' }}</div>
                            @enderror
                        </div>
                        <input type="hidden" name="room_id" value="{{ old('room_id') }}">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        let errors = @json($errors->any());
        $(document).ready(function() {
            var myModal = new bootstrap.Modal($('#myModal'), {
                keyboard: false
            })
            if (errors) {
                myModal.toggle()
            }

            $('.box').on('click', function() {
                const room_id = $(this).data('room_id')
                const room_name = $(this).data('room_name')
                const price = $(this).data('price')
                $("#room_name").text(`Name room: ${room_name}`);
                $("#price").text(`Price room: ${formatCurrency(price)}`);
                $("input[name='room_id']").val(room_id);
                $("input[name='room_name']").val(room_name);
                $("input[name='price']").val(price);
            });
        });
    </script>
@endsection
