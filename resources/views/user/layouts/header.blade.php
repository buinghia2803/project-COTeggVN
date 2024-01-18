@if (Auth::guard('web')->check())
    <div class="banner p-4 d-flex flex-column justify-content-between position-relative">
        <div class="banner-top d-flex justify-content-between">
            <span class="fs-3">Hotel Booking</span>
            <div class="btn-group">
                <button type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fa-regular fa-circle-user fs-3"></i>
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="{{ route('user.home') }}">Home</a></li>
                    <li><a class="dropdown-item" href="{{ route('user.bookings') }}">Bookings</a></li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li><a class="dropdown-item" href="{{ route('auth.logout') }}">Logout:
                            {{ Auth::guard('web')->user()->name ?? '' }}</a></li>
                </ul>
            </div>
        </div>
        @if (Route::is([
                'user.home', // home
            ]))
            <div class="banner-bottom">
                <form action="" method="GET">
                    <div class="find d-flex">
                        <div class="w-25">
                            <input type="text" class="border-0 w-100 h-100 p-2" placeholder="Room name"
                                name="name" value="{{ Request::get('name') }}">
                        </div>
                        <div class="w-25 border-end border-start border-2">
                            <select class="border-0 w-100 h-100" name="m_type_id">
                                <option value="">Room Type</option>
                                @foreach ($mTypes ?? [] as $mType)
                                    <option value={{ $mType->id }}
                                        {{ Request::get('m_type_id') == $mType->id ? 'selected' : '' }}>
                                        {{ $mType->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="w-25">
                            <input type="button" class="border-0 w-100 h-100 p-2" placeholder="Price"
                                value="{{ Request::get('first_price') || Request::get('last_price') ? (Request::get('first_price') ? CommonHelper::formatPrice(Request::get('first_price'), ' VNĐ') : '') . ' - ' . (Request::get('last_price') ? CommonHelper::formatPrice(Request::get('last_price'), ' VNĐ') : '') : 'Money in about' }}"
                                id="money_in_about">
                            <input type="hidden" name="first_price" value="{{ Request::get('first_price') }}">
                            <input type="hidden" name="last_price" value="{{ Request::get('last_price') }}">
                        </div>
                        <button class="w-25 border-0 fw-bold fs-3 bg-green text-white">FIND</button>
                    </div>
                </form>
            </div>
        @endif

        <span class="text-white fw-bold fs-1 position-absolute top-50 start-50 translate-middle">BANNER</span>
    </div>
@endif

<script>
    $(document).ready(function() {
        $("#money_in_about").click(function() {
            $.confirm({
                columnClass: 'col-md-6 col-md-offset-3',
                title: 'Money in about!',
                content: `
                <div class="form-group d-flex align-items-center mx-4" style="height: 60px">
                    <input id="first_price" type="number" placeholder="First price" class="form-control"/>&nbsp;and&nbsp;
                    <input id="last_price" type="number" placeholder="Last price" class="form-control"/>
                </div>
            `,
                buttons: {
                    cancel: function() {
                        //close
                    },
                    ok: {
                        text: 'OK',
                        btnClass: 'btn-blue',
                        action: function() {
                            var firstPrice = $('#first_price').val();
                            var lastPrice = $('#last_price').val();
                            $('#money_in_about').val(
                                `${formatCurrency(firstPrice)} - ${formatCurrency(lastPrice)}`
                            )
                            $("input[name='first_price']").val(firstPrice);
                            $("input[name='last_price']").val(lastPrice);
                        }
                    }
                },
            });
        });
    });
</script>
