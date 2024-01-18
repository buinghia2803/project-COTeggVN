<?php

namespace App\Http\Controllers\User\Auth;

use App\Helpers\CommonHelper;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;


class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * @return  void
     */
    public function __construct()
    {
        $this->middleware('guest:web')->except('logout');
    }

    /**
     * Create a new controller instance.
     *
     * @return  View
     */
    public function showLoginForm(): View
    {
        return view('user.auth.login');
    }

    /**
     * Handle a login request to the application.
     *
     * @param   Request $request
     * @return  Response
     */
    public function login(Request $request)
    {
        $auth = $this->attemptLogin($request);
        if ($auth) {
            $user = Auth::guard('web')->user();
            if ($user && $user->status_confirm_email == User::TENTATIVE) {
                $this->logout($request);

                $request->session()->put('message_confirm', [
                    'url' => null,
                    'content' => 'Please, Verify email!',
                    'btn' => 'OK',
                ]);
                return redirect()->back();
            }

            return $this->sendLoginResponse($request);
        }

        CommonHelper::setMessage($request, MESSAGE_ERROR, 'Login failure.');
        return redirect()->back();
    }

    /**
     * The user has been authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function authenticated(Request $request, $user)
    {
        return redirect()->route('user.home');
    }

    /**
     * The user has logged out of the application.
     *
     * @param  Request $request
     * @return mixed
     */
    protected function loggedOut(Request $request)
    {
        return redirect()->route('auth.login');
    }

    /**
     * Get the needed authorization credentials from the request.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    protected function credentials(Request $request)
    {
        return $request->only('email', 'password');
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return  StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard('web');
    }
}
