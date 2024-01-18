<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;


class AdminController extends Controller
{
    /**
     * Index a new controller instance.
     *
     * @return  View
     */
    public function index(): View
    {
        return view('admin.modules.index');
    }

}
