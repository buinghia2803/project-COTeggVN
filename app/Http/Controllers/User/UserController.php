<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\BookingRoomRequest;
use App\Models\MType;
use App\Models\Room;
use App\Models\RoomUser;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class UserController extends Controller
{
    /**
     * Index a new controller instance.
     *
     * @return  View
     */
    public function index(Request $request): View
    {
        $rooms = Room::where('status', Room::STATUS_AVAILABLE)->doesntHave('roomUsers');

        if (!empty($request->name)) {
            $rooms = $rooms->where('name', 'like', '%' . $request->name . '%');
        }
        if (!empty($request->m_type_id)) {
            $rooms = $rooms->where('m_type_id', $request->m_type_id);
        }
        if (!empty($request->first_price) && empty($request->last_price)) {
            $rooms = $rooms->where('price', '<=', $request->first_price);
        }
        if (empty($request->first_price) && !empty($request->last_price)) {
            $rooms = $rooms->where('price', '>=', $request->last_price);
        }
        if (!empty($request->first_price) && !empty($request->last_price)) {
            $rooms = $rooms->whereBetween('price', [$request->first_price, $request->last_price]);
        }

        $rooms = $rooms->orderBy('id', SORT_BY_DESC);
        $rooms = $rooms->paginate(PER_PAGE);

        $mTypes = MType::get();

        return view('user.modules.index', compact(
            'mTypes',
            'rooms'
        ));
    }

    /**
     * Booking Room.
     */
    public function bookingRoom(BookingRoomRequest $request)
    {
        $request->merge([
            'user_id' => Auth::guard('web')->user()->id,
        ]);
        $data = $request->all('user_id', 'room_id', 'checkin_date', 'checkout_date', 'price');

        try {
            DB::beginTransaction();

            RoomUser::create($data);

            DB::commit();
            $request->session()->put('message_confirm', [
                'url' => null,
                'content' => 'Congratulations on your successful booking!',
                'btn' => 'OK',
            ]);

            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollback();
            Log::error($e);

            return redirect()->back();
        }
    }

    /**
     * Bookings.
     *
     * @return  View
     */
    public function bookings(Request $request): View
    {
        $bookings = RoomUser::with('room')->where('user_id', Auth::guard('web')->user()->id)->orderBy('id', SORT_BY_DESC)->paginate(PER_PAGE);

        return view('user.modules.bookings', compact(
            'bookings'
        ));
    }
}
