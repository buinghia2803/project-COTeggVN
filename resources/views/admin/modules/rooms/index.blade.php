@extends('admin.layouts.app')
@section('title-admin', 'Room manegement')
@section('main-content')
    @include('components.messages')
    <div class="d-flex justify-content-between mt-5">
        <span>
            <a class="bg-green text-white fw-bold fs-5 rounded px-1" href="{{ route('admin.rooms.create') }}"><i
                    class="fa-solid fa-plus"></i></a>
        </span>
        <form action="" class="w-90">
            <div class="d-flex justify-content-end">
                <input type="text" placeholder="Name or Description" class="w-25 form-control" name="search"
                    value="{{ Request::get('search') }}">
                <div data-bs-toggle="modal" data-bs-target="#myModal2"
                    class="w-25 border rounded d-flex align-items-center justify-content-center cursor-pointer"
                    style="height: 38px">
                    <span
                        id="setValuePrice">{{ Request::get('price_start') || Request::get('price_end') ? CommonHelper::formatPrice((int) Request::get('price_start'), ' VNĐ') . ' / ' . CommonHelper::formatPrice((int) Request::get('price_end'), ' VNĐ') : 'Price start / Price end' }}</span>
                </div>
                <select name="status" class="w-25 form-select">
                    <option value="">Status</option>
                    <option value="{{ STATUS_AVAILABLE }}"
                        {{ Request::get('status') == STATUS_AVAILABLE ? 'selected' : '' }}>
                        Available</option>
                    <option value="{{ STATUS_NOT_AVAILABLE }}"
                        {{ Request::get('status') == STATUS_NOT_AVAILABLE ? 'selected' : '' }}>
                        Not available</option>
                </select>
                <select name="m_type_id" class="w-25 form-select">
                    <option value="">Type room</option>
                    @foreach ($mTypes as $mType)
                        <option value={{ $mType->id }} {{ Request::get('m_type_id') == $mType->id ? 'selected' : '' }}>
                            {{ $mType->name }}</option>
                    @endforeach
                </select>
                <input type="hidden" name="price_start">
                <input type="hidden" name="price_end">
                <input type="submit" value="Search" class="btn btn-primary">
            </div>
        </form>
    </div>
    <table class="table table-hover mt-3">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Status</th>
                <th>Type</th>
                <th>Price</th>
                <th>Description</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @forelse ($rooms as $room)
                <tr>
                    <td>{{ $room->id }}</td>
                    <td>{{ $room->name }}</td>
                    <td>{{ $room->status == STATUS_AVAILABLE ? 'Available' : 'Not available' }}</td>
                    <td>{{ $room->mType->name }}</td>
                    <td>{{ CommonHelper::formatPrice($room->price, ' VNĐ') }}</td>
                    <td class="custom-text-truncate">{{ $room->description }}</td>
                    <td class="d-flex justify-content-evenly">
                        <a href="{{ route('admin.rooms.edit', $room->id) }}"><i
                                class="fa-regular fa-pen-to-square text-green"></i></a>
                        <form action="{{ route('admin.rooms.destroy', $room->id) }}" method="POST" class="clickForm">
                            @csrf
                            @method('DELETE')
                            <button><i class="fa-solid fa-trash text-red"></i></button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center">Empty</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    <div class="d-flex justify-content-end mt-3">
        {{ $rooms->appends(request()->query())->links('pagination::bootstrap-4') }}
    </div>
@endsection
@section('modal')
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
        $(document).ready(function() {
            $('.clickForm').on('click', function(e) {
                let form = $(this)
                e.preventDefault();
                $.confirm({
                    title: 'Delete room',
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
                                form.submit()
                            }
                        }
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
