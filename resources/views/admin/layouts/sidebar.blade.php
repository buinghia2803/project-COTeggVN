<div class="border-end border-2 w-100 vh-100">
    <div class="fw-medium fs-3 pt-4 ps-4">
        <a href="{{route('admin.home')}}">Hotel Booking</a>
    </div>
    <div class="sidebar-content mt-5 fs-5 p-4">
        <a href="{{ route('admin.users.index') }}"
            class="{{ Route::is(['admin.users.index', 'admin.users.edit']) ? 'text-green' : '' }}">
            <div class="border-bottom border-2 mb-3">User manegement</div>
        </a>
        <a href="{{ route('admin.rooms.index') }}"
            class="{{ Route::is(['admin.rooms.index', 'admin.rooms.create', 'admin.rooms.edit']) ? 'text-green' : '' }}">
            <div class="border-bottom border-2 mb-3">Room manegement</div>
        </a>
        <a href="{{ route('admin.bookings.index') }}"
            class="{{ Route::is(['admin.bookings.index', 'admin.bookings.show', 'admin.bookings.edit']) ? 'text-green' : '' }}">
            <div class="border-bottom border-2 mb-3">Booking manegement</div>
        </a>
        <a href="">
            <div class="border-bottom border-2">Setting</div>
        </a>
    </div>
</div>
