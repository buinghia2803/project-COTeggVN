<?php

namespace App\Http\Controllers\User\Auth;

use App\Helpers\CommonHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\ForgotPasswordRequest;
use App\Http\Requests\User\ResetPasswordRequest;
use App\Jobs\SendGeneralMailJob;
use App\Models\Authentication;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ForgotPasswordController extends Controller
{
    /**
     * Show forgot password form
     */
    public function showForgotPasswordForm()
    {
        if (Auth::guard('web')->check()) {
            return redirect()->route('user.home');
        }
        return view('user.auth.forgot_password');
    }

    /**
     * Send Mail Forgot Password
     *
     * @param  mixed $request
     * @return void
     */
    public function forgotPassword(ForgotPasswordRequest $request)
    {
        try {
            DB::beginTransaction();
            $user = User::where('email', $request->email)->where('status_confirm_email', User::ENABLED)->first();
            if ($user == null) {
                CommonHelper::setMessage($request, MESSAGE_ERROR, 'There was an error...');

                return redirect()->route('auth.forgot_password');
            }

            $token = Str::random(60);
            // Delete old Authentication and Create new Authentication
            Authentication::where('user_id', $user->id)->where('type', Authentication::TYPE_FORGOT_PASSWORD)->delete();
            Authentication::create([
                'user_id' => $user->id,
                'type' => Authentication::TYPE_FORGOT_PASSWORD,
                'token' => $token,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ]);

            $urlVerify = route('auth.forgot_password.reset', ['token' => $token]);
            // Send mail
            SendGeneralMailJob::dispatch('emails.user-forgot-password', [
                'to' => $user->email,
                'subject' => 'Forgot Password',
                'url' => $urlVerify,
            ]);

            DB::commit();
            $request->session()->put('message_confirm', [
                'url' => route('auth.login'),
                'content' => 'Please, check your email!',
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
     * Show Reset Password Form.
     */
    public function showResetPasswordForm(Request $request, $token)
    {
        if (Auth::guard('web')->check()) {
            return redirect()->route('user.home');
        }

        $authentication = Authentication::where('token', $token)->where('type', Authentication::TYPE_FORGOT_PASSWORD)->first();

        // Check exist $authentication
        if ($authentication == null) {
            CommonHelper::setMessage($request, MESSAGE_ERROR, 'The token does not exist!');

            return redirect()->route('auth.forgot_password');
        }

        // Validate Expired Time
        if ($authentication->hasExpiredTime()) {
            $authentication->delete();
            CommonHelper::setMessage($request, MESSAGE_ERROR, 'Expired tokens!');

            return redirect()->route('auth.forgot_password');
        }

        return view('user.auth.reset_password', compact(
            'token'
        ));
    }

    /**
     * Post Reset Password.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function resetPassword(ResetPasswordRequest $request, $token)
    {
        // dd($token, $request->all());
        try {
            DB::beginTransaction();

            $authentication = Authentication::where('token', $token)->where('type', Authentication::TYPE_FORGOT_PASSWORD)->first();

            // Check exist $authentication
            if ($authentication == null) {
                CommonHelper::setMessage($request, MESSAGE_ERROR, 'The token does not exist!');

                return redirect()->route('auth.forgot_password');
            }

            // Validate Expired Time
            if ($authentication->hasExpiredTime()) {
                $authentication->delete();
                CommonHelper::setMessage($request, MESSAGE_ERROR, 'Expired tokens!');

                return redirect()->route('auth.forgot_password');
            }

            $user = $authentication->load('user')->user;

            if ($user == null || $user->status_confirm_email == User::TENTATIVE) {
                CommonHelper::setMessage($request, MESSAGE_ERROR, 'There was an error...');

                return redirect()->route('auth.forgot_password');
            }

            $user->update([
                'password' => bcrypt($request->password),
            ]);
            $authentication->delete();

            DB::commit();
            CommonHelper::setMessage($request, MESSAGE_SUCCESS, 'Reset password success.');

            return redirect()->route('auth.login');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e);
            return redirect()->back();
        }
    }
}
