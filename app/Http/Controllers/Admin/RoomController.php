<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Helpers\CommonHelper;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\Admin\Room\RoomStoreRequest;
use App\Http\Requests\Admin\Room\RoomUpdateRequest;
use App\Models\MType;
use App\Models\Room;
use App\Models\RoomUser;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $rooms = Room::with('mType');
        if (!empty($request->search)) {
            $rooms = $rooms->where('name', 'like', '%' . $request->search . '%')
                ->orWhere('description', 'like', '%' . $request->search . '%');
        }
        if (!empty($request->price_start) && !empty($request->price_end)) {
            $rooms = $rooms->whereBetween('price', [$request->price_start, $request->price_end]);
        }
        if (!empty($request->status)) {
            $rooms = $rooms->where('status', $request->status);
        }
        if (!empty($request->m_type_id)) {
            $rooms = $rooms->where('m_type_id', $request->m_type_id);
        }

        $rooms = $rooms->orderBy('id', SORT_BY_DESC);
        $rooms = $rooms->paginate(PER_PAGE);

        $mTypes = MType::get();

        return view('admin.modules.rooms.index', compact(
            'rooms',
            'mTypes'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $mTypes = MType::get();

        return view('admin.modules.rooms.create', compact(
            'mTypes'
        ));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RoomStoreRequest $request)
    {
        try {
            DB::beginTransaction();

            $data = $request->all('name', 'status', 'm_type_id', 'price', 'description');
            Room::create($data);

            DB::commit();
            CommonHelper::setMessage($request, MESSAGE_SUCCESS, 'Create success.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e);
            CommonHelper::setMessage($request, MESSAGE_ERROR, 'There was an error...');
        } finally {
            return redirect()->route('admin.rooms.index');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Room $room)
    {
        $mTypes = MType::get();

        return view('admin.modules.rooms.edit', compact(
            'room',
            'mTypes'
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(RoomUpdateRequest $request, Room $room)
    {
        try {
            DB::beginTransaction();

            $data = $request->all('name', 'status', 'm_type_id', 'price', 'description');
            $room->update($data);

            DB::commit();
            CommonHelper::setMessage($request, MESSAGE_SUCCESS, 'Update success.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e);
            CommonHelper::setMessage($request, MESSAGE_ERROR, 'There was an error...');
        } finally {
            return redirect()->route('admin.rooms.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Room $room)
    {
        try {
            $roomUsers = RoomUser::where('room_id', $room->id)->get();
            if ($roomUsers->count()) {
                CommonHelper::setMessage($request, MESSAGE_ERROR, 'Integrity constraint violation: Cannot delete or update a parent row a foreign key constraint fails.');

                return redirect()->back();
            }
            $room->delete();
            CommonHelper::setMessage($request, MESSAGE_SUCCESS, 'Delete success.');
        } catch (\Exception $e) {
            CommonHelper::setMessage($request, MESSAGE_ERROR, 'There was an error...');
            Log::error($e);
        } finally {
            return redirect()->route('admin.rooms.index');
        }
    }
}
