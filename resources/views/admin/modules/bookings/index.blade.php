@extends('admin.layouts.app')
@section('title-admin', 'Booking manegement')
@section('main-content')
    @include('components.messages')
    <form action="">
        <div class="mt-5 d-flex justify-content-end">
            <input type="text" placeholder="Name user or Name room" class="w-25 form-control" name="search"
                value="{{ Request::get('search') }}">
            <div data-bs-toggle="modal" data-bs-target="#myModal"
                class="w-25 border rounded d-flex align-items-center justify-content-center cursor-pointer"
                style="height: 38px">
                <span
                    id="setValueDate">{{ Request::get('checkin_date') || Request::get('checkout_date') ? Request::get('checkin_date') . ' / ' . Request::get('checkout_date') : 'Checkin date / Checkout date' }}</span>
            </div>
            <div data-bs-toggle="modal" data-bs-target="#myModal2"
                class="w-25 border rounded d-flex align-items-center justify-content-center cursor-pointer"
                style="height: 38px">
                <span
                    id="setValuePrice">{{ Request::get('price_start') || Request::get('price_end') ? CommonHelper::formatPrice((int) Request::get('price_start'), ' VNĐ') . ' / ' . CommonHelper::formatPrice((int) Request::get('price_end'), ' VNĐ') : 'Price start / Price end' }}</span>
            </div>
            <select name="status" class="w-25 form-select">
                <option value="">Status</option>
                <option value="{{ STATUS_APPROVE }}" {{ Request::get('status') == STATUS_APPROVE ? 'selected' : '' }}>
                    Approve</option>
                <option value="{{ STATUS_REJECT }}" {{ Request::get('status') == STATUS_REJECT ? 'selected' : '' }}>
                    reject</option>
            </select>
            <input type="hidden" name="checkin_date">
            <input type="hidden" name="checkout_date">
            <input type="hidden" name="price_start">
            <input type="hidden" name="price_end">
            <input type="submit" value="Search" class="btn btn-primary">
        </div>
    </form>
    <table class="table table-hover mt-3">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name user</th>
                <th>Name room</th>
                <th>Checkin date</th>
                <th>Checkout date</th>
                <th>Price</th>
                <th>Status</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @forelse ($bookings as $booking)
                <tr>
                    <td>{{ $booking->id }}</td>
                    <td>{{ $booking->user->name }}</td>
                    <td>{{ $booking->room->name }}</td>
                    <td>{{ CommonHelper::formatTime($booking->checkin_date) }}</td>
                    <td>{{ CommonHelper::formatTime($booking->checkout_date) }}</td>
                    <td>{{ CommonHelper::formatPrice($booking->price, ' VNĐ') }}</td>
                    <td>{{ $booking->status == STATUS_APPROVE ? 'Approve' : 'Reject' }}</td>
                    <td class="d-flex justify-content-evenly">
                        <form id="form" method="POST">
                            @csrf
                            @if ($booking->status != STATUS_APPROVE)
                                <div class="clickStatus cursor-pointer" data-status="{{ STATUS_APPROVE }}"
                                    data-id="{{ $booking->id }}"><i class="fa-solid fa-repeat"></i></div>
                            @else
                                <div class="clickStatus cursor-pointer" data-status="{{ STATUS_REJECT }}"
                                    data-id="{{ $booking->id }}"><i class="fa-solid fa-repeat"></i></div>
                            @endif
                        </form>
                        <a href="{{ route('admin.bookings.show', $booking->id) }}"><i
                                class="fa-regular fa-eye text-orange"></i></a>
                        <a href="{{ route('admin.bookings.edit', $booking->id) }}"><i
                                class="fa-regular fa-pen-to-square text-green"></i></a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-center">Empty</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    <div class="d-flex justify-content-end mt-3">
        {{ $bookings->appends(request()->query())->links('pagination::bootstrap-4') }}
    </div>
@endsection
@section('modal')
    <div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Checkin date / Checkout date</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group mb-3">
                        <label for="">Checkin date</label>
                        <input type="date" class="form-control" id="checkin_date">
                    </div>
                    <div class="form-group mb-3">
                        <label for="">Checkout date</label>
                        <input type="date" class="form-control" id="checkout_date">
                    </div>
                    <input type="hidden" name="room_id" value="{{ old('room_id') }}">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" data-bs-dismiss="modal" id="ok">OK</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="myModal2" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Price stard / Price end</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group mb-3">
                        <label for="">Price stard</label>
                        <input type="number" class="form-control" id="price_start">
                    </div>
                    <div class="form-group mb-3">
                        <label for="">Price end</label>
                        <input type="number" class="form-control" id="price_end">
                    </div>
                    <input type="hidden" name="room_id" value="{{ old('room_id') }}">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" data-bs-dismiss="modal" id="ok2">OK</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        let STATUS_APPROVE = @json(STATUS_APPROVE);
        $(document).ready(function() {
            $('.clickStatus').on('click', function() {
                const status = $(this).data('status')
                const id = $(this).data('id')
                let content = ''
                if (status == STATUS_APPROVE) {
                    content = 'Want to approve?'
                } else {
                    content = 'Want to reject?'
                }

                $.confirm({
                    title: 'Update Status',
                    content,
                    buttons: {
                        cancel: {
                            text: 'Cancel',
                            btnClass: 'btn-default',
                        },
                        ok: {
                            text: 'Update',
                            btnClass: 'btn-blue',
                            action: function() {
                                const form = $('#form')
                                const newAction =
                                    `{{ route('admin.bookings.change-status-booking', ['id' => ':id', 'status' => ':status']) }}`
                                    .replace(':status', status).replace(':id', id);
                                form.attr('action', newAction);
                                form.submit();
                            }
                        },
                    }
                });
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#ok').on('click', function() {
                const checkin_date = $("#checkin_date").val() ?? null;
                const checkout_date = $("#checkout_date").val() ?? null;
                $("input[name='checkin_date']").val(checkin_date);
                $("input[name='checkout_date']").val(checkout_date);
                if (checkin_date && checkout_date) {
                    $("#setValueDate").text(`${checkin_date} / ${checkout_date}`)
                }
            });
            $('#ok2').on('click', function() {
                const price_start = $("#price_start").val() ?? null;
                const price_end = $("#price_end").val() ?? null;
                $("input[name='price_start']").val(price_start);
                $("input[name='price_end']").val(price_end);
                if (price_start && price_end) {
                    $("#setValuePrice").text(
                        `${formatCurrency(price_start)} / ${formatCurrency(price_end)}`)
                }
            });
        });
    </script>
@endsection
