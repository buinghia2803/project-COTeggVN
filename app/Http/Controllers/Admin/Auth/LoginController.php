<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Helpers\CommonHelper;
use App\Models\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
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
        $this->middleware('guest:admin')->except('logout');
    }

    /**
     * Create a new controller instance.
     *
     * @return  View
     */
    public function showLoginForm(): View
    {
        return view('admin.auth.login');
    }

    /**
     * Handle a login request to the application.
     *
     * @param   Request $request
     * @return  Response
     */
    public function login(Request $request)
    {
        if ($this->attemptLogin($request)) {
            Auth::guard('admin')->user();

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
        return redirect()->route('admin.home');
    }

    /**
     * The user has logged out of the application.
     *
     * @param  Request $request
     * @return mixed
     */
    protected function loggedOut(Request $request)
    {
        return redirect()->route('admin.login');
    }

    /**
     * Get the needed authorization credentials from the request.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    protected function credentials(Request $request)
    {
        return $request->only('login_id', 'password');
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return  StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard('admin');
    }
}
