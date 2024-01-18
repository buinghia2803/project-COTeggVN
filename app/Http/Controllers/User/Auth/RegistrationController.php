<?php

namespace App\Http\Controllers\User\Auth;

use App\Helpers\CommonHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\RegisterRequest;
use App\Jobs\SendGeneralMailJob;
use App\Models\Authentication;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class RegistrationController extends Controller
{
    /**
     * Show register form
     */
    public function showRegisterForm()
    {
        if (Auth::guard('web')->check()) {
            return redirect()->route('user.home');
        }
        return view('user.auth.register');
    }

    /**
     * @param   RegisterRequest $request
     * @return  RedirectResponse
     */
    public function register(RegisterRequest $request): RedirectResponse
    {
        $data = $request->all('name', 'email', 'password');
        $data['password'] = bcrypt($data['password']);

        try {
            DB::beginTransaction();

            $user = User::create($data);

            $token = Str::random(60);
            // Create new Authentication
            Authentication::create([
                'user_id' => $user->id,
                'type' => Authentication::TYPE_REGISTER,
                'token' => $token,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ]);

            $urlVerify = route('auth.verify', ['token' => $token]);
            // Send Mail
            SendGeneralMailJob::dispatch('emails.user-register', [
                'to' => $data['email'],
                'subject' => 'Membership Registration',
                'url' => $urlVerify,
            ]);

            DB::commit();
            $request->session()->put('message_confirm', [
                'url' => route('auth.login'),
                'content' => 'Please, verify your email!',
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
     * @param Request $request
     * @return mixed
     */
    public function showVerifyForm(Request $request, $token)
    {
        try {
            DB::beginTransaction();

            $token = $token ?? null;
            $authentication = Authentication::where('token', $token)->where('type', Authentication::TYPE_REGISTER)->first();

            // Check exist $authentication
            if ($authentication == null) {
                CommonHelper::setMessage($request, MESSAGE_ERROR, 'The token does not exist!');

                return redirect()->route('auth.register');
            }

            // Validate Expired Time
            if ($authentication->hasExpiredTime()) {
                $authentication->delete();
                CommonHelper::setMessage($request, MESSAGE_ERROR, 'Expired tokens!');

                return redirect()->route('auth.register');
            }

            $user = $authentication->load('user')->user;
            if ($user == null) {
                CommonHelper::setMessage($request, MESSAGE_ERROR, 'There was an error...');

                return redirect()->route('auth.register');
            }

            $user->update([
                'status_confirm_email' => User::ENABLED
            ]);
            $authentication->delete();

            DB::commit();
            CommonHelper::setMessage($request, MESSAGE_SUCCESS, 'Verify success.');

            return redirect()->route('auth.login');
        } catch (\Exception $e) {
            DB::rollback();
            Log::error($e);
            return redirect()->route('auth.login');
        }
    }
}
