<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\CommonHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\User\UserUpdateRequest;
use App\Models\RoomUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $users = User::query();
        if (!empty($request->search)) {
            $users = $users->where('name', 'like', '%' . $request->search . '%')
                ->orWhere('email', 'like', '%' . $request->search . '%');
        }
        if (!empty($request->status_confirm_email)) {
            $users = $users->where('status_confirm_email', $request->status_confirm_email);
        }

        $users = $users->orderBy('id', SORT_BY_DESC);
        $users = $users->paginate(PER_PAGE);

        return view('admin.modules.users.index', compact(
            'users'
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
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        return view('admin.modules.users.edit', compact(
            'user'
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserUpdateRequest $request, User $user)
    {
        try {
            DB::beginTransaction();

            $data = $request->all('name', 'email', 'change_password', 'password');

            if ($data['change_password']) {
                $data['password'] = bcrypt($data['password']);
            } else {
                unset($data['password']);
            }
            $user->update($data);

            DB::commit();
            CommonHelper::setMessage($request, MESSAGE_SUCCESS, 'Update success.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e);
            CommonHelper::setMessage($request, MESSAGE_ERROR, 'There was an error...');
        } finally {
            return redirect()->route('admin.users.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, User $user)
    {
        try {
            $roomUsers = RoomUser::where('user_id', $user->id)->get();
            if ($roomUsers->count()) {
                CommonHelper::setMessage($request, MESSAGE_ERROR, 'Integrity constraint violation: Cannot delete or update a parent row a foreign key constraint fails.');

                return redirect()->back();
            }
            $user->delete();
            CommonHelper::setMessage($request, MESSAGE_SUCCESS, 'Delete success.');
        } catch (\Exception $e) {
            CommonHelper::setMessage($request, MESSAGE_ERROR, 'There was an error...');
            Log::error($e);
        } finally {
            return redirect()->route('admin.users.index');
        }
    }
}
