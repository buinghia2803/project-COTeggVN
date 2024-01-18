<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\CommonHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\RoomUser\RoomUserUpdateRequest;
use App\Models\RoomUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $bookings = RoomUser::with('user', 'room');

        if (!empty($request->search)) {
            $bookings = $bookings->whereHas('user', function ($query) use ($request) {
                $query->where('name', $request->search);
            })->orWhereHas('room', function ($query) use ($request) {
                $query->where('name', $request->search);
            });
        }
        if (!empty($request->status)) {
            $bookings = $bookings->where('status', $request->status);
        }
        if (!empty($request->checkin_date) && !empty($request->checkout_date)) {
            $bookings = $bookings->whereDate('checkin_date', '>=', $request->checkin_date)
                ->whereDate('checkout_date', '<=', $request->checkout_date);
        }
        if (!empty($request->price_start) && !empty($request->price_end)) {
            $bookings = $bookings->whereBetween('price', [$request->price_start, $request->price_end]);
        }

        $bookings = $bookings->orderBy('id', SORT_BY_DESC);
        $bookings = $bookings->paginate(PER_PAGE);

        return view('admin.modules.bookings.index', compact(
            'bookings'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(RoomUser $booking)
    {
        $booking = $booking->load('user', 'room.mType');

        return view('admin.modules.bookings.show', compact(
            'booking'
        ));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(RoomUser $booking)
    {
        return view('admin.modules.bookings.edit', compact(
            'booking'
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(RoomUserUpdateRequest $request, RoomUser $booking)
    {
        try {
            DB::beginTransaction();

            $data = $request->all('checkin_date', 'checkout_date', 'status');
            $booking->update($data);

            DB::commit();
            CommonHelper::setMessage($request, MESSAGE_SUCCESS, 'Update success.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e);
            CommonHelper::setMessage($request, MESSAGE_ERROR, 'There was an error...');
        } finally {
            return redirect()->route('admin.bookings.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    /**
     * Change Status Booking.
     */
    public function changeStatusBooking(Request $request, $id, $status)
    {
        try {
            DB::beginTransaction();

            $roomUser = RoomUser::findOrFail($id);
            $roomUser->update([
                'status' => $status
            ]);

            DB::commit();
            CommonHelper::setMessage($request, MESSAGE_SUCCESS, 'Update success.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e);
            CommonHelper::setMessage($request, MESSAGE_ERROR, 'There was an error...');
        } finally {
            return redirect()->route('admin.bookings.index');
        }
    }
}
