<?php

namespace Portfolio\Http\Controllers;

use Illuminate\Http\Request;

use Portfolio\Http\Requests;
use Portfolio\Http\Controllers\Controller;

class HandlerController extends Controller
{
    /**
     * Redirect to baseUrl when hit
     *
     * @return Redirect
     */
    public function index()
    {
        return redirect()->intended('/');
    }
}
